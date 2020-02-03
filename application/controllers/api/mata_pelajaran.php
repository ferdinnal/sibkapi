<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mata_pelajaran extends CI_Controller {

    private $arr_result = array();

    function __construct() {
        parent::__construct();
        $this->load->model('mjadwal_pelajaran');
    }

    function find_by_id() {
        $id_pengguna= $this->input->post('id_pengguna');

        $arr_result = array();
        $data_jadwal=$this->mjadwal_pelajaran->findById($id_pengguna);

        if ($id_pengguna == "") {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'error',
                    'message' => 'Coba Ulangi Lagi'
                )
            );
        } else {
          if (count($data_jadwal)==0)
           {
             $arr_result = array(
                 'prilude' => array(
                     'status' => 'warning',
                     'message' => 'Jadwal Tidak Ditemukan'
                 )
             );
          }else {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'success',
                    'message' => 'Data Pengguna Ditemukan.',
                   'data_jadwal'     => $data_jadwal,
                )
            );
          }
          }

        print json_encode($arr_result);
    }
}

?>
