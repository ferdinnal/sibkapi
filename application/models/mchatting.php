<?php
class mchatting extends CI_Model
{
	function findSiswaByMatapelajaran($id_pengguna)
	{
		$sql="SELECT p.* FROM pengguna p WHERE p.id_pengguna_type NOT IN('1') AND p.id_pengguna NOT IN('".$id_pengguna."')";
		$result=$this->db->query($sql)->result();
		return $result;
	}
  function addPrivateGuru($id_pengirim,$id_penerima)
  {
    $sql="SELECT * FROM group_chatting WHERE id_penerima='".$id_penerima."' AND id_pengirim='".$id_pengirim."'";
		$result=$this->db->query($sql)->row();
    if (count($result)>0)
     {
			 $sql="SELECT (SELECT p.nama_pengguna FROM pengguna p WHERE p.id_pengguna=g.id_penerima) as nama_penerima,
			 (SELECT p.foto_profile FROM pengguna p WHERE p.id_pengguna=g.id_penerima) as foto_penerima,
			 (SELECT p.nama_pengguna FROM pengguna p WHERE p.id_pengguna=g.id_pengirim) as nama_pengirim,
			 (SELECT p.foto_profile FROM pengguna p WHERE p.id_pengguna=g.id_pengirim) as foto_pengirim,
			 g.* FROM group_chatting g WHERE g.id_penerima='".$id_penerima."' AND g.id_pengirim='".$id_pengirim."'";
	     $result2=$this->db->query($sql)->row();
	     return $result2;
  }else {

		$data = array('is_group' =>'0' ,
									'id_pengirim'=>$id_pengirim,
								'id_penerima'=>$id_penerima,
							);
	if ($this->db->insert('group_chatting', $data)) {
		$sql="SELECT (SELECT p.nama_pengguna FROM pengguna p WHERE p.id_pengguna=g.id_penerima) as nama_penerima,
		(SELECT p.foto_profile FROM pengguna p WHERE p.id_pengguna=g.id_penerima) as foto_penerima,
		(SELECT p.nama_pengguna FROM pengguna p WHERE p.id_pengguna=g.id_pengirim) as nama_pengirim,
		(SELECT p.foto_profile FROM pengguna p WHERE p.id_pengguna=g.id_pengirim) as foto_pengirim,
		g.* FROM group_chatting g WHERE g.id_penerima='".$id_penerima."' AND g.id_pengirim='".$id_pengirim."'";
		$result2=$this->db->query($sql)->row();
		return $result2;
	}else {
		return false;
	}
  }
  }
}
?>
