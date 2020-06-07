<?php
class Mkelas extends CI_Model
{
    private $table = "kelas";
    private $table_siswa = "detail_siswa";
    private $table_guru= "detail_guru";
    private $table_pengguna = "pengguna";
    private $table_jurusan = "jurusan";
    private $table_jadwal_pelajaran= "jadwal_pelajaran";
    private $table_mata_pelajaran_guru= "mata_pelajaran_guru";
    private $table_mata_pelajaran= "mata_pelajaran";

    private $field_list = array('id_kelas', 'nama_kelas', 'latitude', 'longitude'
                    , 'id_wali_kelas', 'id_jurusan');
    private $exception_field = array('');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpengaturan');
    }

    public function find_siswa_all($id_kelas, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table.".id_kelas");
        $this->db->select($this->table_siswa.".id_pengguna");
        $this->db->select($this->table_siswa.".nisn");
        $this->db->select($this->table_pengguna.".nama_pengguna");
        $this->db->select($this->table_pengguna.".gambar_profil");
        $this->db->select($this->table_pengguna.".jenis_kelamin");
        $this->db->select($this->table_pengguna.".tanggal_lahir");
        $this->db->select($this->table_pengguna.".alamat_email");
        $this->db->select($this->table_pengguna.".no_handphone");
        $this->db->join($this->table_siswa, $this->table . '.id_kelas = ' . $this->table_siswa . '.id_kelas');
        $this->db->join($this->table_pengguna, $this->table_siswa . '.id_pengguna = ' . $this->table_pengguna . '.id_pengguna');
        $this->db->where($this->table . '.id_kelas', $id_kelas);
        $this->db->order_by($this->table_pengguna.".nama_pengguna", 'asc');

        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }

    public function findWaliKelas($id_wali_kelas, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table.".id_kelas");
        $this->db->select($this->table_guru.".id_pengguna");
        $this->db->select($this->table_guru.".nip");
        $this->db->select($this->table_pengguna.".nama_pengguna");
        $this->db->select($this->table_pengguna.".gambar_profil");
        $this->db->select($this->table_pengguna.".jenis_kelamin");
        $this->db->select($this->table_pengguna.".tanggal_lahir");
        $this->db->join($this->table_guru, $this->table . '.id_wali_kelas = ' . $this->table_guru . '.id_pengguna');
        $this->db->join($this->table_pengguna, $this->table_guru . '.id_pengguna = ' . $this->table_pengguna . '.id_pengguna');
        $this->db->where($this->table . '.id_wali_kelas', $id_wali_kelas);

        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }

    public function findJurusan($id_jurusan, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table_jurusan.".nama_jurusan");
        $this->db->join($this->table_jurusan, $this->table . '.id_jurusan = ' . $this->table_jurusan . '.id_jurusan');
        $this->db->where($this->table . '.id_jurusan', $id_jurusan);

        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    public function findKelas($id_kelas, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select('*');
        $this->db->where($this->table . '.id_kelas', $id_kelas);

        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    public function findById($id_pengguna, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table_siswa.".id_kelas");
        $this->db->select($this->table.".id_wali_kelas");
        $this->db->select($this->table.".id_jurusan");
        $this->db->join($this->table, $this->table_siswa . '.id_kelas = ' . $this->table . '.id_kelas');
        $this->db->where($this->table_siswa . '.id_pengguna', $id_pengguna);

        if ($result_type == "row") {
            return $this->db->get($this->table_siswa)->row();
        } else {
            return $this->db->get($this->table_siswa)->result();
        }
    }
    public function findByIdGuru($id_pengguna, $id_kelas, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table.".id_wali_kelas");
        $this->db->select($this->table.".id_jurusan");
        $this->db->where($this->table . '.id_kelas', $id_kelas);

        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    public function findGuruByKelas($id_pengguna, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table_siswa.".id_kelas");
        $this->db->select($this->table_mata_pelajaran_guru.".id_guru");
        $this->db->select($this->table_pengguna.".nama_pengguna");
        $this->db->select($this->table_pengguna.".alamat_email");
        $this->db->select($this->table_pengguna.".no_handphone");
        $this->db->select($this->table_pengguna.".gambar_profil");
        $this->db->select($this->table_pengguna.".jenis_kelamin");
        $this->db->select($this->table_guru.".nip");
        $this->db->join($this->table_jadwal_pelajaran, $this->table_siswa . '.id_kelas = ' . $this->table_jadwal_pelajaran . '.id_kelas');
        $this->db->join($this->table_mata_pelajaran_guru, $this->table_jadwal_pelajaran . '.id_mata_pelajaran_guru = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran_guru');
        $this->db->join($this->table_pengguna, $this->table_mata_pelajaran_guru . '.id_guru = ' . $this->table_pengguna . '.id_pengguna');
        $this->db->join($this->table_guru, $this->table_mata_pelajaran_guru . '.id_guru = ' . $this->table_guru . '.id_pengguna');
        $this->db->where($this->table_siswa . '.id_pengguna', $id_pengguna);
        $this->db->where($this->table_jadwal_pelajaran . '.id_semester', $is_semester);
        $this->db->order_by($this->table_pengguna.".nama_pengguna", 'asc');
        $this->db->group_by($this->table_mata_pelajaran_guru.".id_guru");

        if ($result_type == "row") {
            return $this->db->get($this->table_siswa)->row();
        } else {
            return $this->db->get($this->table_siswa)->result();
        }
    }
		public function findGuruByAll($result_type, $option = null)
		{
				$select = "";

				$this->db->select($this->table_pengguna.".nama_pengguna");
				$this->db->select($this->table_pengguna.".alamat_email");
				$this->db->select($this->table_pengguna.".no_handphone");
				$this->db->select($this->table_pengguna.".gambar_profil");
				$this->db->select($this->table_pengguna.".jenis_kelamin");
				$this->db->select($this->table_pengguna.".jenis_kelamin");
				$this->db->select($this->table_guru.".nip");
				$this->db->join($this->table_pengguna, $this->table_guru . '.id_pengguna = ' . $this->table_pengguna . '.id_pengguna');
				$this->db->where($this->table_pengguna . '.id_pengguna_type', 3);


				if ($result_type == "row") {
						return $this->db->get($this->table_guru)->row();
				} else {
						return $this->db->get($this->table_guru)->result();
				}
		}

    public function find_guru_detail($id_guru, $result_type, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table_mata_pelajaran_guru.".id_guru");
        $this->db->select($this->table_mata_pelajaran.".nama_mata_pelajaran");
        $this->db->select($this->table_mata_pelajaran.".kode_mata_pelajaran");
        $this->db->join($this->table_mata_pelajaran, $this->table_mata_pelajaran_guru . '.id_mata_pelajaran = ' . $this->table_mata_pelajaran . '.id_mata_pelajaran');
        $this->db->where($this->table_mata_pelajaran_guru . '.id_guru', $id_guru);

        if ($result_type == "row") {
            return $this->db->get($this->table_mata_pelajaran_guru)->row();
        } else {
            return $this->db->get($this->table_mata_pelajaran_guru)->result();
        }
    }
}
