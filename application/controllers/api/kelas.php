<?php

defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Kelas extends REST_Controller {

    private $arr_result = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Mkelas');
    }

    function findById_post() {
        $id_pengguna= $this->input->post('id_pengguna');

        $arr_result = array();
        $get_id_kelas=$this->Mkelas->findById($id_pengguna,'row');
        if (count($get_id_kelas) > 0) {
          $data_siswa=$this->Mkelas->find_siswa_all($get_id_kelas->id_kelas,'result');
          $data_wali_kelas=$this->Mkelas->findWaliKelas($get_id_kelas->id_wali_kelas,'row');
          $data_jurusan=$this->Mkelas->findJurusan($get_id_kelas->id_jurusan,'row');
          $data_kelas=$this->Mkelas->findKelas($get_id_kelas->id_kelas,'row');

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
                      'data_jurusan'     => $data_jurusan,
                      'data_jumlah_siswa'     => count($data_siswa),
                      'data_siswa'     => $data_siswa,
                  )
              );
            }
            }
        }else {
          $arr_result = array(
              'prilude' => array(
                  'status' => 'error',
                  'message' => 'Mohon maaf untuk perkelasan belum ada'
              )
          );
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
