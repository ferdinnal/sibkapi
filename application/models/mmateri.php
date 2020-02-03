<?php
class mmateri extends CI_Model
{
  //add user and then return latest inserted id
  function uploadMateri() {
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

  function findByIdNew($id_pengguna)
  {

    $sql="SELECT p.nama_pertemuan,p.id_pertemuan FROM pertemuan p,materi m WHERE m.id_pertemuan=p.id_pertemuan AND m.id_guru='".$id_pengguna."' GROUP BY m.id_pertemuan ORDER BY p.nama_pertemuan ASC ";

    $result=$this->db->query($sql)->result();

    return $result;
  }
  function findByIdNewSiswa($id_pengguna)
  {

    $sql="SELECT p.nama_pertemuan,p.id_pertemuan FROM pertemuan p,materi m,siswa_detail s WHERE s.id_kelas=m.id_kelas AND m.id_pertemuan=p.id_pertemuan AND s.id_pengguna='".$id_pengguna."' GROUP BY m.id_pertemuan ORDER BY p.nama_pertemuan ASC ";

    $result=$this->db->query($sql)->result();

    return $result;
  }
  function findCartByOrderId($id_pengguna)
  {

    $sql="SELECT p.nama_pertemuan,mt.nama_mata_pelajaran,m.* FROM pertemuan p,materi m,mata_pelajaran mt WHERE mt.id_mata_pelajaran=m.id_mata_pelajaran AND m.id_pertemuan=p.id_pertemuan AND m.id_pertemuan='".$id_pengguna."' ORDER BY m.nama_materi ASC ";

    $result=$this->db->query($sql)->result();

    return $result;
  }
  function findCartByOrderIdNew($id_pengguna)
  {

    $sql="SELECT u.nama_pengguna,p.nama_pertemuan,mt.nama_mata_pelajaran,m.* FROM pengguna u, pertemuan p,materi m,mata_pelajaran mt WHERE u.id_pengguna=m.id_guru AND mt.id_mata_pelajaran=m.id_mata_pelajaran AND m.id_pertemuan=p.id_pertemuan AND m.id_pertemuan='".$id_pengguna."' ORDER BY m.nama_materi ASC ";

    $result=$this->db->query($sql)->result();

    return $result;
  }

}
?>
