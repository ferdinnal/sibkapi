<?php
class Mmateri extends CI_Model
{
    private $table   = "materi";
    private $table_kelas = "kelas";
    private $table_siswa = "detail_siswa";
    private $table_guru= "detail_guru";
    private $table_pengguna = "pengguna";
    private $table_jurusan = "jurusan";
    private $table_jadwal_pelajaran= "jadwal_pelajaran";
    private $table_mata_pelajaran_guru= "mata_pelajaran_guru";
    private $table_mata_pelajaran= "mata_pelajaran";
    private $table_materi_komen= "materi_komen";
    private $field_list = array('id_materi', 'nama_materi', 'deskripsi_materi', 'date_created'
          , 'id_mata_pelajaran_guru', 'jenis','is_upload','waktu_tenggang');
    private $exception_field = array('');
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpengaturan');
    }

    public function findBySiswaModel($id_mata_pelajaran_guru, $result_type, $jenis=null, $keyword = null, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;


        $this->db->select($this->table.".nama_materi");
        $this->db->select($this->table.".deskripsi_materi");
        $this->db->select($this->table.".date_created");
        $this->db->select($this->table.".jenis");
        $this->db->select($this->table.".id_mata_pelajaran_guru");
        $this->db->select($this->table.".id_materi");
        $this->db->select($this->table.".waktu_tenggang");
        $this->db->select($this->table.".is_upload");
        $this->db->select($this->table_pengguna.".nama_pengguna");
        $this->db->select($this->table_pengguna.".gambar_profil");
        $this->db->join($this->table_mata_pelajaran_guru, $this->table . '.id_mata_pelajaran_guru = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran_guru');
        $this->db->join($this->table_pengguna, $this->table_mata_pelajaran_guru . '.id_guru = ' . $this->table_pengguna . '.id_pengguna');
        $this->db->where($this->table . '.id_mata_pelajaran_guru', $id_mata_pelajaran_guru);
        if (trim($jenis) != "") {
          $this->db->where($this->table . '.jenis', $jenis);
        }

        if (trim($keyword) != "") {
            $this->db->like('nama_materi', $keyword);
        }
        if (array_key_exists('order', $option)) {
            $this->db->order_by($this->table . "." . $option['order']['order_by'], $option['order']['ordering']);
        }

        if ($option != null) {
            if (array_key_exists('limit', $option)) {
                $this->db->limit($this->table . "." . $option['limit']);
            }

            if (array_key_exists('order_by', $option)) {
                $this->db->order_by($this->table . "." . $option['order_by']['field'], $option['order_by']['option']);
            }

            if (array_key_exists('page', $option)) {
                $page = $option['page'] * $option['limit'];
                $this->db->limit($option['limit'], $page);
            }

            if (array_key_exists('where_in', $option)) {
                $this->db->where_in($this->table . '.' . $option['where_in']['field'], $option['where_in']['option']);
            }

            if (array_key_exists('where_not_in', $option)) {
                $this->db->where_not_in($this->table . '.' . $option['where_not_in']['field'], $option['where_not_in']['option']);
            }
        }
        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }

    public function findKomenModel($id_materi, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;
        $id_materi_kosong=0;
        $this->db->select($this->table_materi_komen.".isi");
        $this->db->select($this->table_materi_komen.".id_materi_komen");
        $this->db->select($this->table_materi_komen.".id_materi_komen_referal");
        $this->db->where($this->table_materi_komen . '.id_materi', $id_materi);
        // $this->db->where($this->table_materi_komen . '.id_materi_komen_referal', $id_materi_kosong);
        $this->db->order_by($this->table_materi_komen.".date_created", 'asc');
        if ($result_type == "row") {
            return $this->db->get($this->table_materi_komen)->row();
        } else {
            $data_category      = $this->db->get($this->table_materi_komen)->result();
            $new_data_category  = array();
            foreach ($data_category as $data) {
                $sub_category       = $this->findChilds($data->id_materi_komen);
                $parent_category_id = $this->findParent($data->id_materi_komen_referal);

                if ($parent_category_id=="0") {
                    $new_array = array(
              'komen'               => $data,
              'num_of_child_category'  => count($sub_category)
            );
                } else {
                    $query_parent     = array(
              'id_materi_komen' => $parent_category_id
            );


                    $new_array = array(
              'komen'               => $data,
              'num_of_child_category'  => count($sub_category),
            );
                }

                array_push($new_data_category, $new_array);
            }

            return $new_data_category;
        }
    }

    public function findChilds($parent_category_id=null)
    {
        $this->db->select('*');
        $this->db->from($this->table_materi_komen);

        if ($parent_category_id==null) {
            $this->db->where('id_materi_komen_referal', 0);
        } else {
            $this->db->where('id_materi_komen_referal', $parent_category_id);
        }

        $parent = $this->db->get();

        $categories = $parent->result();
        $i=0;
        $arr_biasa  = "";
        foreach ($categories as $p_cat) {
            $waw = $this->subCategories($p_cat->id_materi_komen);
            if (strlen($arr_biasa)==0) {
                $arr_biasa = $p_cat->id_materi_komen.",".$waw;
            } else {
                $arr_biasa = $arr_biasa.",".$p_cat->id_materi_komen.",".$waw;
            }
            $i++;
        }

        $clean=explode(',', $arr_biasa);
        return array_filter($clean);
    }
    public function findParent($category_id)
    {
        $where = array(
    'id_materi_komen' => $category_id
  );

        $data_category = $this->db->get_where($this->table_materi_komen, $where)->row();
        if (count($data_category)>0) {
            return $data_category->id_materi_komen_referal;
        } else {
            return "";
        }
    }

    public function subCategories($id)
    {
        $this->db->select('*');
        $this->db->from($this->table_materi_komen);
        $this->db->where('id_materi_komen_referal', $id);

        $child = $this->db->get();
        $categories = $child->result();
        $i=0;

        $arr_biasa = "";
        foreach ($categories as $p_cat) {
            $waw = $this->subCategories($p_cat->id_materi_komen);
            if (strlen($arr_biasa)==0) {
                $arr_biasa = $p_cat->id_materi_komen.",".$waw;
            } else {
                $arr_biasa = $arr_biasa.",".$p_cat->id_materi_komen.",".$waw;
            }
            $i++;
        }

        return $arr_biasa;
    }
    //add user and then return latest inserted id
    public function uploadMateri()
    {
        $date_created = date('Y-m-d H:i:s');
        $data = array(
        'nama_materi' => $this->input->post('nama_materi'),
        'id_guru' => $this->input->post('id_guru'),
        'id_kelas' => $this->input->post('id_kelas'),
        'id_mata_pelajaran' => $this->input->post('id_mata_pelajaran'),
        'file_link' => $this->input->post('file_link'),
        'id_pertemuan' => '1',
        'tanggal_dibuat' => $date_created,
      );

        if ($this->db->insert('materi', $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function findByIdNew($id_pengguna)
    {
        $sql="SELECT p.nama_pertemuan,p.id_pertemuan FROM pertemuan p,materi m WHERE m.id_pertemuan=p.id_pertemuan AND m.id_guru='".$id_pengguna."' GROUP BY m.id_pertemuan ORDER BY p.nama_pertemuan ASC ";

        $result=$this->db->query($sql)->result();

        return $result;
    }
    public function findByIdNewSiswa($id_pengguna)
    {
        $sql="SELECT p.nama_pertemuan,p.id_pertemuan FROM pertemuan p,materi m,siswa_detail s WHERE s.id_kelas=m.id_kelas AND m.id_pertemuan=p.id_pertemuan AND s.id_pengguna='".$id_pengguna."' GROUP BY m.id_pertemuan ORDER BY p.nama_pertemuan ASC ";

        $result=$this->db->query($sql)->result();

        return $result;
    }
    public function findCartByOrderId($id_pengguna)
    {
        $sql="SELECT p.nama_pertemuan,mt.nama_mata_pelajaran,m.* FROM pertemuan p,materi m,mata_pelajaran mt WHERE mt.id_mata_pelajaran=m.id_mata_pelajaran AND m.id_pertemuan=p.id_pertemuan AND m.id_pertemuan='".$id_pengguna."' ORDER BY m.nama_materi ASC ";

        $result=$this->db->query($sql)->result();

        return $result;
    }
    public function findCartByOrderIdNew($id_pengguna)
    {
        $sql="SELECT u.nama_pengguna,p.nama_pertemuan,mt.nama_mata_pelajaran,m.* FROM pengguna u, pertemuan p,materi m,mata_pelajaran mt WHERE u.id_pengguna=m.id_guru AND mt.id_mata_pelajaran=m.id_mata_pelajaran AND m.id_pertemuan=p.id_pertemuan AND m.id_pertemuan='".$id_pengguna."' ORDER BY m.nama_materi ASC ";

        $result=$this->db->query($sql)->result();

        return $result;
    }
}
