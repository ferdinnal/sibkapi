<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class chatting extends CI_Controller {

    private $arr_result = array();

    function __construct() {
        parent::__construct();
        $this->load->model('mchatting');
    }

    function find_on_guru() {
        $id_pengguna= $this->input->post('id_pengguna');

        $arr_result = array();
        $data_siswa=$this->mchatting->findSiswaByMatapelajaran($id_pengguna);

        if ($id_pengguna == "") {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'error',
                    'message' => 'Coba Ulangi Lagi'
                )
            );
        } else {
          if (count($data_siswa)==0)
           {
             $arr_result = array(
                 'prilude' => array(
                     'status' => 'warning',
                     'message' => 'Siswa Tidak Di Temukan.'
                 )
             );
          }else {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'success',
                    'message' => 'Data Pengguna Ditemukan.',
                   'data_siswa'     => $data_siswa,
                )
            );
          }
          }

        print json_encode($arr_result);
    }
    function addPrivateGuru() {
        $id_pengirim= $this->input->post('id_pengirim');
        $id_penerima= $this->input->post('id_penerima');

        $arr_result = array();
        $data_siswa=$this->mchatting->addPrivateGuru($id_pengirim,$id_penerima);

        if ($id_penerima == "" || $id_pengirim="") {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'error',
                    'message' => 'Coba Ulangi Lagi'
                )
            );
        } else {
          if (count($data_siswa)==0)
           {
             $arr_result = array(
                 'prilude' => array(
                     'status' => 'warning',
                     'message' => 'Siswa Tidak Di Temukan.'
                 )
             );
          }else {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'success',
                    'message' => 'Berhasil Menambahkan Chat.',
                    'data_chat' => $data_siswa,
                )
            );
          }
          }

        print json_encode($arr_result);
    }
}

?>
