<?php

class mpertemuan extends CI_Model {


    function __construct() {
        parent::__construct();
    }


    function finds() {
      $sql="SELECT * FROM pertemuan order by id_pertemuan ASC";
  		$result=$this->db->query($sql)->result();
  		return $result;
    }



}

?>
