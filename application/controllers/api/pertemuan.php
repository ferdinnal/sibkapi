<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pertemuan extends CI_Controller {

    private $arr_result = array();

    function __construct() {
        parent::__construct();
        $this->load->model('mpertemuan');
    }

    function finds() {

        $arr_result = array();
        $data_pertemuan=$this->mpertemuan->finds();

          if (count($data_pertemuan)==0)
           {
             $arr_result = array(
                 'prilude' => array(
                     'status' => 'warning',
                     'message' => 'Data Tidak Ditemukan'
                 )
             );
          }else {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'success',
                    'message' => 'Data Ditemukan.',
                   'data_pertemuan'     => $data_pertemuan,
                )
            );
          }

        print json_encode($arr_result);
    }
}

?>
