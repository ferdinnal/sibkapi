<?php
class Mabsensi extends CI_Model
{
    private $table      = "history_qr_code";
    private $table_absensi      = "absensi";
    private $table_kelas      = "kelas";
    private $table_jadwal_pelajaran     = "jadwal";
    private $table_mata_pelajaran_guru    = "mata_pelajaran_guru";
    private $table_mata_pelajaran   = "matpel";
    private $table_ruangan   = "ruang";
    private $table_detail_siswa   = "siswadetails";
    private $table_pengguna   = "user";
    private $table_status_absen   = "status_absen";
    private $arr_result = array();
    private $field_list = array('history_qr_code_id', 'qr_code_absensi', 'day', 'date_created'
            , 'id_jadwal_pelajaran');

    public function __construct()
    {
        parent::__construct();
    }
    /*
    Untuk melakukan pencarian data product
     */
    public function find_jadwal($id_pengguna, $id_kelas, $hari_ini, $id_jadwal_pelajaran)
    {
        $this->db->select($this->table_jadwal_pelajaran.".jam_mulai");
        $this->db->select($this->table_jadwal_pelajaran.".jam_beres");
        $this->db->select($this->table_jadwal_pelajaran.".id_kelas");
        $this->db->select($this->table_jadwal_pelajaran.".hari");
        $this->db->select($this->table_jadwal_pelajaran.".qr_code_absensi");
        $this->db->select("'$hari_ini' as hari_now");
        $this->db->select($this->table.".qr_code_absensi");
        $this->db->select($this->table.".history_qr_code_id");
        $this->db->join($this->table_mata_pelajaran_guru, $this->table_jadwal_pelajaran . '.id_mata_pelajaran_guru = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran_guru');
        $this->db->join($this->table, $this->table_jadwal_pelajaran . '.id_jadwal_pelajaran = ' . $this->table . '.id_jadwal_pelajaran');
        $this->db->where($this->table_jadwal_pelajaran . '.id_jadwal_pelajaran', $id_jadwal_pelajaran);
        $this->db->where($this->table_jadwal_pelajaran . '.hari', $hari_ini);
        $this->db->where($this->table_mata_pelajaran_guru . '.id_guru', $id_pengguna);

        $data_product = $this->db->get($this->table_jadwal_pelajaran)->row();

        //array_push($data_product,$data_image);
        //return $data_image;
        return $data_product;
    }
    public function find_jadwal_order($id_pengguna, $id_kelas, $hari_ini, $id_jadwal_pelajaran)
    {
        $this->db->select($this->table_jadwal_pelajaran.".mulai");
        $this->db->select($this->table_jadwal_pelajaran.".selesai");
        $this->db->select($this->table_jadwal_pelajaran.".id_kelas");
        $this->db->select($this->table_jadwal_pelajaran.".hari");
        $this->db->select($this->table_jadwal_pelajaran.".qrcode");
        $this->db->select("'$hari_ini' as hari_now");
        $this->db->select($this->table.".qr_code_absensi");
        $this->db->select($this->table.".history_qr_code_id");
        $this->db->join($this->table_mata_pelajaran, $this->table_jadwal_pelajaran . '.idmat = ' . $this->table_mata_pelajaran . '.idmat');
        $this->db->join($this->table, $this->table_jadwal_pelajaran . '.jadid = ' . $this->table . '.jadid');
        $this->db->where($this->table_jadwal_pelajaran . '.jadid', $id_jadwal_pelajaran);
        $this->db->where($this->table_jadwal_pelajaran . '.hari', $hari_ini);
        $this->db->where($this->table_mata_pelajaran . '.userid', $id_pengguna);
        $this->db->order_by($this->table.".date_created", 'desc');

        $data_product = $this->db->get($this->table_jadwal_pelajaran)->row();

        //array_push($data_product,$data_image);
        //return $data_image;
        return $data_product;
    }

    public function findJadwalAll($id_pengguna)
    {
        $this->db->select($this->table_jadwal_pelajaran.".mulai");
        $this->db->select($this->table_jadwal_pelajaran.".selesai");
        $this->db->select($this->table_jadwal_pelajaran.".id_kelas");
        $this->db->select($this->table_jadwal_pelajaran.".hari");
        $this->db->select($this->table_jadwal_pelajaran.".qrcode");
        $this->db->select($this->table_jadwal_pelajaran.".jadid");
        $this->db->select($this->table_pengguna.".fullname as nama_guru");
        $this->db->select($this->table_mata_pelajaran.".kodemat");
        $this->db->select($this->table_mata_pelajaran.".matpel");
        $this->db->select($this->table_mata_pelajaran.".idmat");
        $this->db->join($this->table_mata_pelajaran, $this->table_jadwal_pelajaran . '.idmat = ' . $this->table_mata_pelajaran . '.idmat');
        $this->db->join($this->table_kelas, $this->table_jadwal_pelajaran . '.id_kelas = ' . $this->table_kelas . '.id_kelas');
        $this->db->join($this->table_ruangan, $this->table_jadwal_pelajaran . '.ruangid = ' . $this->table_ruangan . '.ruangid');
        $this->db->join($this->table_pengguna, $this->table_mata_pelajaran . '.userid = ' . $this->table_pengguna . '.userid');
        $this->db->join($this->table_detail_siswa, $this->table_kelas . '.id_kelas = ' . $this->table_detail_siswa . '.id_kelas');
        $this->db->where($this->table_detail_siswa . '.userid', $id_pengguna);

        $data_product = $this->db->get($this->table_jadwal_pelajaran)->result();

        //array_push($data_product,$data_image);
        //return $data_image;
        return $data_product;
    }
    public function findJadwalAllGuru($id_pengguna)
    {
        $this->db->select($this->table_jadwal_pelajaran.".mulai");
        $this->db->select($this->table_jadwal_pelajaran.".selesai");
        $this->db->select($this->table_jadwal_pelajaran.".id_kelas");
        $this->db->select($this->table_jadwal_pelajaran.".hari");
        $this->db->select($this->table_jadwal_pelajaran.".qrcode");
        $this->db->select($this->table_jadwal_pelajaran.".jadid");
        $this->db->select($this->table_pengguna.".fullname as nama_guru");
        $this->db->select($this->table_mata_pelajaran.".kodemat");
        $this->db->select($this->table_mata_pelajaran.".matpel");
        $this->db->select($this->table_mata_pelajaran.".idmat");
        $this->db->join($this->table_mata_pelajaran, $this->table_jadwal_pelajaran . '.idmat = ' . $this->table_mata_pelajaran . '.idmat');
        $this->db->join($this->table_kelas, $this->table_jadwal_pelajaran . '.id_kelas = ' . $this->table_kelas . '.id_kelas');
        $this->db->join($this->table_ruangan, $this->table_jadwal_pelajaran . '.ruangid = ' . $this->table_ruangan . '.ruangid');
        $this->db->join($this->table_pengguna, $this->table_mata_pelajaran . '.userid = ' . $this->table_pengguna . '.userid');
        $this->db->where($this->table_mata_pelajaran . '.userid', $id_pengguna);

        $data_product = $this->db->get($this->table_jadwal_pelajaran)->result();

        //array_push($data_product,$data_image);
        //return $data_image;
        return $data_product;
    }
    public function find_absensi_siswa($history_qr_code_id)
    {
        $this->db->select($this->table_absensi.".id_siswa");
        $this->db->select($this->table_absensi.".status_absen_id");
        $this->db->select($this->table_absensi.".id_jadwal_pelajaran");
        $this->db->select($this->table_absensi.".absensi_id");
        $this->db->select($this->table_status_absen.".status_absen");
        $this->db->select($this->table_detail_siswa.".nisn");
        $this->db->select($this->table_pengguna.".fullname");
        $this->db->join($this->table_detail_siswa, $this->table_absensi . '.id_siswa = ' . $this->table_detail_siswa . '.userid');
        $this->db->join($this->table_pengguna, $this->table_absensi . '.id_siswa = ' . $this->table_pengguna . '.userid');
        $this->db->join($this->table_status_absen, $this->table_absensi . '.status_absen_id = ' . $this->table_status_absen . '.status_absen_id');
        $this->db->where($this->table_absensi . '.history_qr_code_id', $history_qr_code_id);
        $this->db->order_by($this->table_pengguna.".fullname", 'asc');

        $data_product = $this->db->get($this->table_absensi)->result();

        //array_push($data_product,$data_image);
        //return $data_image;
        return $data_product;
    }

    public function find_hari_siswa($id_pengguna, $id_kelas, $hari_ini, $id_jadwal_pelajaran)
    {
        $this->db->select($this->table_jadwal_pelajaran.".mulai");
        $this->db->select($this->table_jadwal_pelajaran.".selesai");
        $this->db->select($this->table_jadwal_pelajaran.".id_kelas");
        $this->db->select($this->table_jadwal_pelajaran.".hari");
        $this->db->select($this->table_jadwal_pelajaran.".qrcode");
        $this->db->select($this->table_jadwal_pelajaran.".jadid");
        $this->db->select($this->table.".qr_code_absensi");
        $this->db->select($this->table.".history_qr_code_id");
        $this->db->select($this->table.".date_created");
        $this->db->select($this->table_kelas.".nama_kelas");
        $this->db->select($this->table_mata_pelajaran.".kodemat");
        $this->db->select($this->table_mata_pelajaran.".matpel");
        $this->db->select($this->table_mata_pelajaran.".idmat");
        $this->db->join($this->table_mata_pelajaran, $this->table_jadwal_pelajaran . '.idmat = ' . $this->table_mata_pelajaran . '.idmat');
        $this->db->join($this->table_kelas, $this->table_jadwal_pelajaran . '.id_kelas = ' . $this->table_kelas . '.id_kelas');
        $this->db->join($this->table_ruangan, $this->table_jadwal_pelajaran . '.ruangid = ' . $this->table_ruangan . '.ruangid');
        $this->db->join($this->table_pengguna, $this->table_mata_pelajaran . '.userid = ' . $this->table_pengguna . '.userid');
        $this->db->join($this->table, $this->table_jadwal_pelajaran . '.jadid = ' . $this->table . '.jadid');
        $this->db->where($this->table_jadwal_pelajaran . '.jadid', $id_jadwal_pelajaran);
        $this->db->where($this->table_jadwal_pelajaran . '.hari', $hari_ini);
        $this->db->where($this->table_kelas . '.id_kelas', $id_kelas);
        $this->db->order_by($this->table.".date_created", 'desc');
        $this->db->group_by($this->table.".history_qr_code_id");

        $data_product = $this->db->get($this->table_jadwal_pelajaran)->result();

        //array_push($data_product,$data_image);
        //return $data_image;
        return $data_product;
    }

    public function find_hari_siswaNew($id_pengguna, $id_kelas, $hari_ini, $id_jadwal_pelajaran)
    {
        $this->db->select($this->table_jadwal_pelajaran.".mulai");
        $this->db->select($this->table_jadwal_pelajaran.".selesai");
        $this->db->select($this->table_jadwal_pelajaran.".id_kelas");
        $this->db->select($this->table_jadwal_pelajaran.".hari");
        $this->db->select($this->table_jadwal_pelajaran.".qrcode");
        $this->db->select($this->table_jadwal_pelajaran.".jadid");
        $this->db->select($this->table.".qr_code_absensi");
        $this->db->select($this->table.".history_qr_code_id");
        $this->db->select($this->table.".date_created");
        $this->db->select($this->table_kelas.".nama_kelas");
        $this->db->select($this->table_mata_pelajaran.".kodemat");
        $this->db->select($this->table_mata_pelajaran.".matpel");
        $this->db->select($this->table_mata_pelajaran.".idmat");
        $this->db->join($this->table_mata_pelajaran, $this->table_jadwal_pelajaran . '.idmat = ' . $this->table_mata_pelajaran . '.idmat');
        $this->db->join($this->table_kelas, $this->table_jadwal_pelajaran . '.id_kelas = ' . $this->table_kelas . '.id_kelas');
        $this->db->join($this->table_ruangan, $this->table_jadwal_pelajaran . '.ruangid = ' . $this->table_ruangan . '.ruangid');
        $this->db->join($this->table_pengguna, $this->table_mata_pelajaran . '.userid = ' . $this->table_pengguna . '.userid');
        $this->db->join($this->table, $this->table_jadwal_pelajaran . '.jadid = ' . $this->table . '.jadid');
        $this->db->where($this->table_jadwal_pelajaran . '.jadid', $id_jadwal_pelajaran);
        $this->db->where($this->table_kelas . '.id_kelas', $id_kelas);
        $this->db->order_by($this->table.".date_created", 'desc');
        $this->db->group_by($this->table.".history_qr_code_id");

        $data_product = $this->db->get($this->table_jadwal_pelajaran)->result();

        //array_push($data_product,$data_image);
        //return $data_image;
        return $data_product;
    }
    public function find_jadwal_now($id_pengguna, $id_kelas, $hari_ini, $nowTime, $id_jadwal_pelajaran)
    {
        $query = "SELECT tj.id_kelas,tj.mulai,tj.selesai,tj.hari,tj.qrcode,hq.qr_code_absensi,hq.history_qr_code_id,$hari_ini as hari_now
         FROM jadwal tj, matpel tpg, history_qr_code hq
        WHERE tj.idmat=tpg.idmat AND tj.jadid=hq.jadid
        AND tj.jadid='".$id_jadwal_pelajaran."' AND tj.hari='".$hari_ini."' AND date(hq.date_created)='".$nowTime."' AND tpg.userid='".$id_pengguna."'";

        $result = $this->db->query($query)->row();

        return $result;
    }
    public function find_jadwal3($id_pengguna, $id_kelas, $hari_ini, $id_jadwal_pelajaran)
    {
        $this->db->select($this->table_jadwal_pelajaran.".jam_mulai");
        $this->db->select($this->table_jadwal_pelajaran.".jam_beres");
        $this->db->select($this->table_jadwal_pelajaran.".id_kelas");
        $this->db->select($this->table_jadwal_pelajaran.".hari");
        $this->db->select($this->table_jadwal_pelajaran.".qr_code_absensi");
        $this->db->select("'$hari_ini' as hari_now");
        $this->db->join($this->table_mata_pelajaran_guru, $this->table_jadwal_pelajaran . '.id_mata_pelajaran_guru = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran_guru');
        $this->db->where($this->table_jadwal_pelajaran . '.id_jadwal_pelajaran', $id_jadwal_pelajaran);
        $this->db->where($this->table_mata_pelajaran_guru . '.id_guru', $id_pengguna);

        $data_product = $this->db->get($this->table_jadwal_pelajaran)->row();

        //array_push($data_product,$data_image);
        //return $data_image;
        return $data_product;
    }

    public function find_jadwal2($id_pengguna, $id_kelas, $hari_ini, $id_jadwal_pelajaran)
    {
        $this->db->select($this->table_jadwal_pelajaran.".jam_mulai");
        $this->db->select($this->table_jadwal_pelajaran.".jam_beres");
        $this->db->select($this->table_jadwal_pelajaran.".id_kelas");
        $this->db->select($this->table_jadwal_pelajaran.".hari");
        $this->db->select("'$hari_ini' as hari_now");
        $this->db->select($this->table_jadwal_pelajaran.".qr_code_absensi");
        $this->db->select($this->table_jadwal_pelajaran.".id_jadwal_pelajaran");
        $this->db->join($this->table_mata_pelajaran_guru, $this->table_jadwal_pelajaran . '.id_mata_pelajaran_guru = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran_guru');
        $this->db->where($this->table_jadwal_pelajaran . '.id_jadwal_pelajaran', $id_jadwal_pelajaran);
        $this->db->where($this->table_jadwal_pelajaran . '.hari', $hari_ini);
        $this->db->where($this->table_mata_pelajaran_guru . '.id_guru', $id_pengguna);

        $data_product = $this->db->get($this->table_jadwal_pelajaran)->row();

        //array_push($data_product,$data_image);
        //return $data_image;
        return $data_product;
    }

    public function find_hari($id_pengguna, $id_kelas, $hari_ini, $id_jadwal_pelajaran)
    {
        $this->db->select($this->table_jadwal_pelajaran.".mulai");
        $this->db->select($this->table_jadwal_pelajaran.".selesai");
        $this->db->select($this->table_jadwal_pelajaran.".id_kelas");
        $this->db->select($this->table_jadwal_pelajaran.".hari");
        $this->db->select($this->table_jadwal_pelajaran.".qrcode");
        $this->db->select($this->table_jadwal_pelajaran.".jadid");
        $this->db->select($this->table.".qr_code_absensi");
        $this->db->select($this->table.".history_qr_code_id");
        $this->db->select($this->table.".date_created");
        $this->db->select($this->table_kelas.".nama_kelas");
        $this->db->select("'$hari_ini' as hari_now");
        $this->db->select($this->table_mata_pelajaran.".matpel");
        $this->db->select($this->table_mata_pelajaran.".kodemat");
        $this->db->join($this->table_mata_pelajaran, $this->table_jadwal_pelajaran . '.idmat = ' . $this->table_mata_pelajaran . '.idmat');
        $this->db->join($this->table, $this->table_jadwal_pelajaran . '.jadid = ' . $this->table . '.jadid');
        $this->db->join($this->table_kelas, $this->table_jadwal_pelajaran . '.id_kelas = ' . $this->table_kelas . '.id_kelas');
        $this->db->where($this->table_jadwal_pelajaran . '.jadid', $id_jadwal_pelajaran);
        // $this->db->where($this->table_jadwal_pelajaran . '.hari', $hari_ini);
        $this->db->where($this->table_mata_pelajaran . '.userid', $id_pengguna);
        $this->db->order_by($this->table.".date_created", 'desc');
        $this->db->group_by($this->table.".history_qr_code_id");

        $data_product = $this->db->get($this->table_jadwal_pelajaran)->result();

        //array_push($data_product,$data_image);
        //return $data_image;
        return $data_product;
    }


    public function absensi_siswa_check($latitude, $longitude, $nowTime, $id_kelas, $history_qr_code_id, $hari_ini, $qr_code_absensi)
    {
        $query = "SELECT tj.id_kelas,tj.mulai,tj.selesai,tj.hari,tj.qrcode,hq.qr_code_absensi,hq.history_qr_code_id,$hari_ini as hari_now
       FROM jadwal tj, matpel tpg, history_qr_code hq,ruang r
      WHERE tj.idmat=tpg.idmat AND tj.jadid=hq.jadid AND tj.ruangid=r.ruangid
      AND hq.day='".$hari_ini."' AND date(hq.date_created)='".$nowTime."'
      AND hq.history_qr_code_id='".$history_qr_code_id."' AND hq.qr_code_absensi='".$qr_code_absensi."'";

        $result = $this->db->query($query)->row();

        return $result;
    }



    public function find_total_siswa($id_kelas)
    {
        $sql="SELECT COUNT(siswadetailid) as total_siswa FROM siswadetails WHERE id_kelas='".$id_kelas."' ";
        $result=$this->db->query($sql)->row();
        return $result;
    }
    public function find_total_hadir($history_qr_code_id)
    {
        $sql="SELECT COUNT(id_siswa) as total_siswa FROM absensi WHERE history_qr_code_id='".$history_qr_code_id."' AND status_absen_id=1";
        $result=$this->db->query($sql)->row();
        return $result;
    }
    public function find_total_sakit($history_qr_code_id)
    {
        $sql="SELECT COUNT(id_siswa) as total_siswa FROM absensi WHERE history_qr_code_id='".$history_qr_code_id."' AND status_absen_id=2";
        $result=$this->db->query($sql)->row();
        return $result;
    }
    public function find_total_ijin($history_qr_code_id)
    {
        $sql="SELECT COUNT(id_siswa) as total_siswa FROM absensi WHERE history_qr_code_id='".$history_qr_code_id."' AND status_absen_id=3";
        $result=$this->db->query($sql)->row();
        return $result;
    }
    public function find_total_alfa($history_qr_code_id)
    {
        $sql="SELECT COUNT(id_siswa) as total_siswa FROM absensi WHERE history_qr_code_id='".$history_qr_code_id."' AND status_absen_id=4";
        $result=$this->db->query($sql)->row();
        return $result;
    }
    public function find_total_belum($history_qr_code_id)
    {
        $sql="SELECT COUNT(id_siswa) as total_siswa FROM absensi WHERE history_qr_code_id='".$history_qr_code_id."' AND status_absen_id=5";
        $result=$this->db->query($sql)->row();
        return $result;
    }
    public function create($data)
    {
        if ($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function createAbsensiAll($id_kelas, $id_jadwal_pelajaran, $history_qr_code_id)
    {
        $sql="SELECT userid FROM siswadetails WHERE id_kelas='".$id_kelas."' ";
        $result=$this->db->query($sql)->result();
        $nowTime = date("Y-m-d h:i:s");
        $i = 0;
        $len = count($result);
        foreach ($result as $key) {
            $data = array(
          'tanggal_absen' =>$nowTime ,
          'status_absen_id' =>5 ,
          'id_jadwal_pelajaran' =>$id_jadwal_pelajaran ,
          'id_siswa' =>$key->userid ,
          'history_qr_code_id' =>$history_qr_code_id ,
      );
            if ($this->db->insert($this->table_absensi, $data)) {
                if ($i == $len - 1) {
                    return true;
                }
            } else {
                return false;
            }
            $i++;
        }
    }
    public function update($data, $where)
    {
        if ($this->db->update($this->table_absensi, $data, $where)) {
            return true;
        } else {
            return false;
        }
    }
}
