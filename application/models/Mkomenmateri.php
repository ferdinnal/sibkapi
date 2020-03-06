<?php
class Mkomenmateri extends CI_Model
{
    private $table                      = "materi_komen";
    private $table_pengguna = "pengguna";
    private $field_list = array('id_materi_komen', 'isi', 'date_created', 'id_pengguna'
          , 'id_materi_komen_referal', 'id_materi');
    private $exception_field = array('');
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpengaturan');
    }

    public function findBySiswaModel($id_materi, $result_type, $keyword = null, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;


        $this->db->select($this->table.".*");
        $this->db->select($this->table_pengguna.".nama_pengguna");
        $this->db->select($this->table_pengguna.".gambar_profil");
        $this->db->join($this->table_pengguna, $this->table . '.id_pengguna = ' . $this->table_pengguna . '.id_pengguna');
        $this->db->where($this->table . '.id_materi', $id_materi);
        $this->db->where($this->table . '.id_materi_komen_referal', '0');

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
          $data_product = $this->db->get($this->table)->result();
          $array_data   = array();
      foreach ($data_product as $product) {
          $query        = array(
      'id_materi_komen_referal'=>  $product->id_materi_komen
            );

            $data_image   = $this->findBalas($product->id_materi_komen, 'result');

          if (count($data_image)==0) {
              $new_array  = array(
        'data_komen' => $product
      );
          } else {
              $new_array  = array(
        'data_komen' => $product,
        'data_balas'   => $data_image,
      );
          }

          array_push($array_data, $new_array);
      }

      //array_push($data_product,$data_image);
      //return $data_image;
      return $array_data;
  }
        }
    public function findBalas($id_materi, $result_type)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $query="SELECT COUNT(id_materi_komen) as total_komen FROM materi_komen WHERE id_materi_komen_referal='".$id_materi."'";
        return $this->db->query($query)->row();
    }
    public function create($data)
    {
        if ($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }
}
