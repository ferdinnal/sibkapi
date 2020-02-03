<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class kelas extends CI_Controller {

    private $arr_result = array();

    function __construct() {
        parent::__construct();
        $this->load->model('mkelas');
    }

    function find_by_id() {
        $id_kelas= $this->input->post('id_kelas');
        $id_pengguna= $this->input->post('id_pengguna');

        $arr_result = array();
        $data_kelas=$this->mkelas->findById($id_pengguna,$id_kelas);
        $data_wali_kelas=$this->mkelas->findWaliKelas($data_kelas->id_wali_kelas);
        $count_siswa=$this->mkelas->findCountSiswa($id_kelas);
        $data_siswa=$this->mkelas->findSiswa($id_kelas);

        if ($id_pengguna == "") {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'error',
                    'message' => 'Coba Ulangi Lagi'
                )
            );
        } else {
          if (count($data_kelas)==0)
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
                    'data_kelas'     => $data_kelas,
                    'data_wali_kelas'     => $data_wali_kelas,
                    'data_jumlah_siswa'     => $count_siswa,
                   'data_siswa'     => $data_siswa,
                )
            );
          }
          }

        print json_encode($arr_result);
    }
    function find_by_id_siswa() {
        $id_kelas= $this->input->post('id_kelas');
        $id_pengguna= $this->input->post('id_pengguna');

        $arr_result = array();
        $data_kelas=$this->mkelas->findByIdSiswa($id_pengguna,$id_kelas);
        $data_wali_kelas=$this->mkelas->findWaliKelas($data_kelas->id_wali_kelas);
        $count_siswa=$this->mkelas->findCountSiswa($id_kelas);
        $data_siswa=$this->mkelas->findSiswa($id_kelas);

        if ($id_pengguna == "") {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'error',
                    'message' => 'Coba Ulangi Lagi'
                )
            );
        } else {
          if (count($data_kelas)==0)
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
                    'data_kelas'     => $data_kelas,
                    'data_wali_kelas'     => $data_wali_kelas,
                    'data_jumlah_siswa'     => $count_siswa,
                   'data_siswa'     => $data_siswa,
                )
            );
          }
          }

        print json_encode($arr_result);
    }
}

?>
