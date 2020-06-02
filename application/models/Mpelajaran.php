<?php

class Mpelajaran extends CI_Model
{
    private $table = "jadwal_pelajaran";
    private $table_kelas = "kelas";
    private $table_mata_pelajaran= "mata_pelajaran";
    private $table_mata_pelajaran_guru= "mata_pelajaran_guru";
    private $table_detail_siswa= "detail_siswa";
    private $table_detail_guru= "detail_guru";
    private $table_pengguna= "pengguna";
    private $table_ruangan= "ruangan";
    private $tabel_jurusan= "jurusan";
    private $field_list = array('id_jadwal_pelajaran', 'hari', 'jam_mulai', 'jam_beres'
          , 'id_mata_pelajaran', 'id_kelas');
    private $exception_field = array();
    private $key_user_id = "id_pengguna";

    public function __construct()
    {
        parent::__construct();
//        $this->load->model('Memail_template');
    }


    public function find_siswa_all($id_pengguna, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table_kelas.".id_kelas");
        $this->db->select($this->table.".id_jadwal_pelajaran");
        $this->db->select($this->table_kelas.".nama_kelas");
        $this->db->select($this->table_mata_pelajaran_guru.".id_mata_pelajaran_guru");
        $this->db->select($this->table_mata_pelajaran.".id_mata_pelajaran");
        $this->db->select($this->table_mata_pelajaran.".nama_mata_pelajaran");
        $this->db->select($this->table_mata_pelajaran.".kode_mata_pelajaran");
        $this->db->select($this->table_detail_guru.".nip");
        $this->db->select($this->table_pengguna.".nama_pengguna as nama_guru");
        $this->db->select($this->table.".id_semester");
        $this->db->join($this->table_kelas, $this->table . '.id_kelas = ' . $this->table_kelas . '.id_kelas');
        $this->db->join($this->table_mata_pelajaran_guru, $this->table . '.id_mata_pelajaran_guru = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran_guru');
        $this->db->join($this->table_mata_pelajaran, $this->table_mata_pelajaran . '.id_mata_pelajaran = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran');
        $this->db->join($this->table_detail_siswa, $this->table_kelas . '.id_kelas = ' . $this->table_detail_siswa . '.id_kelas');
        $this->db->join($this->table_detail_guru, $this->table_mata_pelajaran_guru . '.id_guru = ' . $this->table_detail_guru . '.id_pengguna');
        $this->db->join($this->table_pengguna, $this->table_detail_guru . '.id_pengguna = ' . $this->table_pengguna . '.id_pengguna');
        $this->db->where($this->table_detail_siswa . '.id_pengguna', $id_pengguna);
        $this->db->where($this->table . '.id_semester', $is_semester);
        $this->db->order_by($this->table_mata_pelajaran.".nama_mata_pelajaran", 'asc');
        $this->db->group_by($this->table_mata_pelajaran_guru.".id_mata_pelajaran_guru");
        // $this->db->group_by(array($this->table_mata_pelajaran_guru.".id_mata_pelajaran", $this->table.".id_jadwal_pelajaran"));  // Produces: GROUP BY title, date
        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    public function find_guru_all($id_pengguna, $id_kelas, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table_kelas.".id_kelas");
        $this->db->select($this->table.".id_jadwal_pelajaran");
        $this->db->select($this->table_kelas.".nama_kelas");
        $this->db->select($this->table_mata_pelajaran_guru.".id_mata_pelajaran_guru");
        $this->db->select($this->table_mata_pelajaran.".id_mata_pelajaran");
        $this->db->select($this->table_mata_pelajaran.".nama_mata_pelajaran");
        $this->db->select($this->table_mata_pelajaran.".kode_mata_pelajaran");
        $this->db->select($this->table_detail_guru.".nip");
        $this->db->select($this->table_pengguna.".nama_pengguna as nama_guru");
        $this->db->select($this->table.".id_semester");
        $this->db->join($this->table_kelas, $this->table . '.id_kelas = ' . $this->table_kelas . '.id_kelas');
        $this->db->join($this->table_mata_pelajaran_guru, $this->table . '.id_mata_pelajaran_guru = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran_guru');
        $this->db->join($this->table_mata_pelajaran, $this->table_mata_pelajaran . '.id_mata_pelajaran = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran');
        $this->db->join($this->table_detail_siswa, $this->table_kelas . '.id_kelas = ' . $this->table_detail_siswa . '.id_kelas');
        $this->db->join($this->table_detail_guru, $this->table_mata_pelajaran_guru . '.id_guru = ' . $this->table_detail_guru . '.id_pengguna');
        $this->db->join($this->table_pengguna, $this->table_detail_guru . '.id_pengguna = ' . $this->table_pengguna . '.id_pengguna');
        $this->db->where($this->table_detail_guru . '.id_pengguna', $id_pengguna);
        $this->db->where($this->table . '.id_semester', $is_semester);
        $this->db->where($this->table . '.id_kelas', $id_kelas);
        $this->db->order_by($this->table_mata_pelajaran.".nama_mata_pelajaran", 'asc');
        $this->db->group_by($this->table_mata_pelajaran_guru.".id_mata_pelajaran_guru");
        // $this->db->group_by(array($this->table_mata_pelajaran_guru.".id_mata_pelajaran", $this->table.".id_jadwal_pelajaran"));  // Produces: GROUP BY title, date
        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    public function find_guru_kelas($id_pengguna, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table_kelas.".id_kelas");
        $this->db->select($this->table.".id_jadwal_pelajaran");
        $this->db->select($this->table_kelas.".nama_kelas");
        $this->db->select($this->tabel_jurusan.".nama_jurusan");
        $this->db->select($this->table_mata_pelajaran_guru.".id_mata_pelajaran_guru");
        $this->db->select($this->table_mata_pelajaran.".id_mata_pelajaran");
        $this->db->select($this->table_mata_pelajaran.".nama_mata_pelajaran");
        $this->db->select($this->table_mata_pelajaran.".kode_mata_pelajaran");
        $this->db->select($this->table_detail_guru.".nip");
        $this->db->select($this->table_pengguna.".nama_pengguna as nama_guru");
        $this->db->select($this->table.".id_semester");
        $this->db->join($this->table_kelas, $this->table . '.id_kelas = ' . $this->table_kelas . '.id_kelas');
        $this->db->join($this->table_mata_pelajaran_guru, $this->table . '.id_mata_pelajaran_guru = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran_guru');
        $this->db->join($this->table_mata_pelajaran, $this->table_mata_pelajaran . '.id_mata_pelajaran = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran');
        $this->db->join($this->table_detail_siswa, $this->table_kelas . '.id_kelas = ' . $this->table_detail_siswa . '.id_kelas');
        $this->db->join($this->tabel_jurusan, $this->table_kelas . '.id_jurusan = ' . $this->tabel_jurusan . '.id_jurusan');
        $this->db->join($this->table_detail_guru, $this->table_mata_pelajaran_guru . '.id_guru = ' . $this->table_detail_guru . '.id_pengguna');
        $this->db->join($this->table_pengguna, $this->table_detail_guru . '.id_pengguna = ' . $this->table_pengguna . '.id_pengguna');
        $this->db->where($this->table_detail_guru . '.id_pengguna', $id_pengguna);
        $this->db->where($this->table . '.id_semester', $is_semester);
        $this->db->order_by($this->table_mata_pelajaran.".nama_mata_pelajaran", 'asc');
        $this->db->group_by($this->table.".id_kelas");
        // $this->db->group_by(array($this->table_mata_pelajaran_guru.".id_mata_pelajaran", $this->table.".id_jadwal_pelajaran"));  // Produces: GROUP BY title, date
        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    public function create($data)
    {
        if ($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data, $where)
    {
        if ($this->db->update($this->table, $data, $where)) {
            return true;
        } else {
            return false;
        }
    }
}
