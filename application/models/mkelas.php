<?php
class mkelas extends CI_Model
{
	function findById($id_pengguna,$id_kelas)
	{
		$sql="SELECT k.*,m.* FROM kelas k,mata_pelajaran m WHERE m.id_kelas=k.id_kelas AND m.id_guru='".$id_pengguna."' AND k.id_kelas='".$id_kelas."'";
		$result=$this->db->query($sql)->row();
		return $result;
	}
	function findByIdSiswa($id_pengguna,$id_kelas)
	{
		$sql="SELECT k.*,m.* FROM kelas k,mata_pelajaran m WHERE m.id_kelas=k.id_kelas AND k.id_kelas='".$id_kelas."'";
		$result=$this->db->query($sql)->row();
		return $result;
	}
  function findWaliKelas($id_wali_kelas)
  {
    $sql="SELECT p.*,g.* FROM kelas k,pengguna p,guru_detail g WHERE k.id_wali_kelas='".$id_wali_kelas."' AND k.id_wali_kelas=p.id_pengguna AND p.id_pengguna=g.id_pengguna";
    $result=$this->db->query($sql)->row();
    return $result;
  }
  function findCountSiswa($id_kelas)
  {
    $sql="SELECT COUNT(id_siswa) as jumlah_siswa FROM siswa_detail WHERE id_kelas='".$id_kelas."'";
    $result=$this->db->query($sql)->result();
    return $result;
  }
  function findSiswa($id_kelas)
  {
    $sql="SELECT p.*,s.* FROM siswa_detail s,pengguna p WHERE p.id_pengguna=s.id_pengguna AND s.id_kelas='".$id_kelas."' ORDER BY p.nama_pengguna ASC";
    $result=$this->db->query($sql)->result();
    return $result;
  }
}
?>
