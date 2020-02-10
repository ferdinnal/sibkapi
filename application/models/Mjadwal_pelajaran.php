<?php
class Mjadwal_pelajaran extends CI_Model
{
    private $table = "jadwal_pelajaran";
    private $table_kelas = "kelas";
    private $table_mata_pelajaran= "mata_pelajaran";
    private $table_mata_pelajaran_guru= "mata_pelajaran_guru";
    private $table_detail_siswa= "detail_siswa";
    private $table_detail_guru= "detail_guru";
    private $table_pengguna= "pengguna";
    private $table_ruangan= "ruangan";
    private $field_list = array('id_jadwal_pelajaran', 'hari', 'jam_mulai', 'jam_beres'
            , 'id_mata_pelajaran', 'id_kelas');
    private $exception_field = array('');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpengaturan');
    }
    public function find_siswa($id_pengguna, $result_type, $hari_ini, $option = null)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table_kelas.".id_kelas");
        $this->db->select($this->table.".id_jadwal_pelajaran");
        $this->db->select($this->table_kelas.".nama_kelas");
        $this->db->select($this->table_mata_pelajaran_guru.".id_mata_pelajaran_guru");
        $this->db->select($this->table_mata_pelajaran.".id_mata_pelajaran");
        $this->db->select($this->table_mata_pelajaran.".nama_mata_pelajaran");
        $this->db->select($this->table_detail_guru.".nip");
        $this->db->select($this->table_pengguna.".nama_pengguna as nama_guru");
        $this->db->select($this->table.".jam_mulai as mulai");
        $this->db->select($this->table.".jam_beres as beres");
        $this->db->select($this->table.".hari as hari");
        $this->db->select($this->table.".id_semester");
        $this->db->join($this->table_kelas, $this->table . '.id_kelas = ' . $this->table_kelas . '.id_kelas');
        $this->db->join($this->table_mata_pelajaran_guru, $this->table . '.id_mata_pelajaran_guru = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran_guru');
        $this->db->join($this->table_mata_pelajaran, $this->table_mata_pelajaran . '.id_mata_pelajaran = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran');
        $this->db->join($this->table_detail_siswa, $this->table_kelas . '.id_kelas = ' . $this->table_detail_siswa . '.id_kelas');
        $this->db->join($this->table_detail_guru, $this->table_mata_pelajaran_guru . '.id_guru = ' . $this->table_detail_guru . '.id_pengguna');
        $this->db->join($this->table_pengguna, $this->table_detail_guru . '.id_pengguna = ' . $this->table_pengguna . '.id_pengguna');
        $this->db->where($this->table_detail_siswa . '.id_pengguna', $id_pengguna);
        $this->db->where($this->table . '.hari', $hari_ini);
        $this->db->where($this->table . '.id_semester', $is_semester);
        $this->db->order_by($this->table.".hari");
        $this->db->limit(1);

        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    public function find_siswa_detail($hari, $result_type, $option = null)
    {
        $select = "";

        $hari_ini=date('N');
        $date=date('Y-m-d');

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table_kelas.".id_kelas");
        $this->db->select($this->table_mata_pelajaran_guru.".id_mata_pelajaran_guru");
        $this->db->select($this->table_mata_pelajaran.".id_mata_pelajaran");
        $this->db->select($this->table.".id_jadwal_pelajaran");
        $this->db->select($this->table_kelas.".nama_kelas");
        $this->db->select($this->table_mata_pelajaran.".nama_mata_pelajaran");
        $this->db->select($this->table_detail_guru.".nip");
        $this->db->select($this->table_pengguna.".nama_pengguna as nama_guru");
        $this->db->select($this->table_ruangan.".nama_ruangan");
        $this->db->select($this->table.".jam_mulai as mulai");
        $this->db->select($this->table.".jam_beres as beres");
        $this->db->select($this->table.".hari as hari");
        $this->db->select("'$date' as tanggal");
        $this->db->select($this->table.".id_semester");
        $this->db->join($this->table_kelas, $this->table . '.id_kelas = ' . $this->table_kelas . '.id_kelas');
        $this->db->join($this->table_mata_pelajaran_guru, $this->table . '.id_mata_pelajaran_guru = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran_guru');
        $this->db->join($this->table_mata_pelajaran, $this->table_mata_pelajaran . '.id_mata_pelajaran = ' . $this->table_mata_pelajaran_guru . '.id_mata_pelajaran');
        $this->db->join($this->table_detail_siswa, $this->table_kelas . '.id_kelas = ' . $this->table_detail_siswa . '.id_kelas');
        $this->db->join($this->table_detail_guru, $this->table_mata_pelajaran_guru . '.id_guru = ' . $this->table_detail_guru . '.id_pengguna');
        $this->db->join($this->table_pengguna, $this->table_detail_guru . '.id_pengguna = ' . $this->table_pengguna . '.id_pengguna');
        $this->db->join($this->table_ruangan, $this->table . '.id_ruangan = ' . $this->table_ruangan . '.id_ruangan');
        $this->db->where($this->table . '.hari', $hari);
        $this->db->where($this->table . '.id_semester', $is_semester);
        $this->db->order_by($this->table.".jam_mulai", 'ASC');

        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    public function findByIdNewSiswa($id_pengguna)
    {
        $hari_ini=date('N');

        $sql="SELECT p.id_pengguna,j.hari
		 FROM kelas k,pengguna p,mata_pelajaran m,jadwal_pelajaran j,guru_detail g,siswa_detail s  WHERE s.id_pengguna='".$id_pengguna."'
		 AND m.id_kelas=s.id_kelas AND p.id_pengguna=g.id_pengguna AND m.id_kelas=k.id_kelas AND m.id_guru=p.id_pengguna AND j.id_mata_pelajaran=m.id_mata_pelajaran group by j.hari";

        $result=$this->db->query($sql)->result();

        return $result;
    }
    public function findById($id_pengguna)
    {
        $hari_ini=date('N');

        $sql="SELECT k.id_kelas,p.id_pengguna,g.nip,k.nama_kelas,p.nama_pengguna,m.nama_mata_pelajaran,
				(SELECT j.jam_mulai FROM jadwal_pelajaran j WHERE j.hari='".$hari_ini."' AND j.id_mata_pelajaran=m.id_mata_pelajaran) as mulai,
    (SELECT j.jam_beres FROM jadwal_pelajaran j WHERE j.hari='".$hari_ini."' AND j.id_mata_pelajaran=m.id_mata_pelajaran) as beres,
    (SELECT j.hari FROM jadwal_pelajaran j WHERE j.hari='".$hari_ini."' AND j.id_mata_pelajaran=m.id_mata_pelajaran) as hari
     FROM kelas k,pengguna p,mata_pelajaran m,jadwal_pelajaran j,guru_detail g WHERE m.id_guru='".$id_pengguna."' AND p.id_pengguna=g.id_pengguna AND m.id_kelas=k.id_kelas AND m.id_guru=p.id_pengguna and j.hari='".$hari_ini."' AND j.id_mata_pelajaran=m.id_mata_pelajaran";

        $result=$this->db->query($sql)->result();

        return $result;
    }

    public function findByIdSiswa($id_pengguna)
    {
        $hari_ini=date('N');

        $sql="SELECT k.id_kelas,p.id_pengguna,g.nip,k.nama_kelas,p.nama_pengguna,m.nama_mata_pelajaran,(SELECT j.jam_mulai FROM jadwal_pelajaran j WHERE j.hari='".$hari_ini."' AND j.id_mata_pelajaran=m.id_mata_pelajaran) as mulai,
    (SELECT j.jam_beres FROM jadwal_pelajaran j WHERE j.hari='".$hari_ini."' AND j.id_mata_pelajaran=m.id_mata_pelajaran) as beres,
    (SELECT j.hari FROM jadwal_pelajaran j WHERE j.hari='".$hari_ini."' AND j.id_mata_pelajaran=m.id_mata_pelajaran) as hari
     FROM kelas k,pengguna p,mata_pelajaran m,jadwal_pelajaran j,guru_detail g,siswa_detail s WHERE s.id_pengguna='".$id_pengguna."' AND m.id_kelas=s.id_kelas AND p.id_pengguna=g.id_pengguna AND m.id_kelas=k.id_kelas AND m.id_guru=p.id_pengguna and j.hari='".$hari_ini."' AND j.id_mata_pelajaran=m.id_mata_pelajaran";

        $result=$this->db->query($sql)->result();

        return $result;
    }

    public function findCartByOrderId($id_pengguna)
    {
        $hari_ini=date('N');

        $sql="SELECT k.id_kelas,g.nip,k.nama_kelas,p.nama_pengguna,m.nama_mata_pelajaran,j.jam_mulai,
		j.jam_beres,
		j.hari FROM kelas k,pengguna p,mata_pelajaran m,jadwal_pelajaran j,guru_detail g WHERE j.hari='".$id_pengguna."' AND p.id_pengguna=g.id_pengguna AND m.id_kelas=k.id_kelas AND m.id_guru=p.id_pengguna AND j.id_mata_pelajaran=m.id_mata_pelajaran order by j.jam_mulai ASC";

        $result=$this->db->query($sql)->result();

        return $result;
    }

    public function findByIdNew($id_pengguna)
    {
        $hari_ini=date('N');

        $sql="SELECT p.id_pengguna,j.hari
		 FROM kelas k,pengguna p,mata_pelajaran m,jadwal_pelajaran j,guru_detail g WHERE m.id_guru='".$id_pengguna."' AND p.id_pengguna=g.id_pengguna AND m.id_kelas=k.id_kelas AND m.id_guru=p.id_pengguna AND j.id_mata_pelajaran=m.id_mata_pelajaran group by j.hari";

        $result=$this->db->query($sql)->result();

        return $result;
    }


    public function findCartByOrderIdSiswa($id_pengguna)
    {
        $hari_ini=date('N');

        $sql="SELECT k.id_kelas,g.nip,k.nama_kelas,p.nama_pengguna,m.nama_mata_pelajaran,j.jam_mulai,
		j.jam_beres,
		j.hari FROM kelas k,pengguna p,mata_pelajaran m,jadwal_pelajaran j,guru_detail g WHERE j.hari='".$id_pengguna."' AND p.id_pengguna=g.id_pengguna AND m.id_kelas=k.id_kelas AND m.id_guru=p.id_pengguna AND j.id_mata_pelajaran=m.id_mata_pelajaran order by j.jam_mulai ASC";

        $result=$this->db->query($sql)->result();

        return $result;
    }
}
