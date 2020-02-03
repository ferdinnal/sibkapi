<?php

defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Jadwal_pelajaran extends REST_Controller
{
    private $arr_result = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mjadwal_pelajaran');
    }

    public function jadwal_pelajaran_now_post()
    {
        $id_pengguna= $this->input->post('id_pengguna');
        $arr_result = array();
        $hari_ini=date('N');
        $data_jadwal=$this->Mjadwal_pelajaran->find_siswa($id_pengguna, 'result', $hari_ini);

        if ($id_pengguna == "") {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'error',
                    'message' => 'Coba Ulangi Lagi'
                )
            );
        } else {
            if (count($data_jadwal)==0) {
                $arr_result = array(
                 'prilude' => array(
                     'status' => 'warning',
                     'message' => 'Jadwal Tidak Ditemukan'
                 )
             );
            } else {
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
    public function jadwal_pelajaran_bymp_now_post()
    {
        $hari= $this->input->post('hari');
        $arr_result = array();
        $data_jadwal=$this->Mjadwal_pelajaran->find_siswa_detail($hari, 'result');

        if ($hari == "") {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'error',
                    'message' => 'Coba Ulangi Lagi'
                )
            );
        } else {
            if (count($data_jadwal)==0) {
                $arr_result = array(
                 'prilude' => array(
                     'status' => 'warning',
                     'message' => 'Jadwal Tidak Ditemukan'
                 )
             );
            } else {
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

    public function jadwal_pelajaran_tomorrow_post()
    {
        $id_pengguna= $this->input->post('id_pengguna');
        $arr_result = array();
        $hari_ini=date('N', strtotime(' +1 day'));
        $data_jadwal=$this->Mjadwal_pelajaran->find_siswa($id_pengguna, 'result', $hari_ini);

        if ($id_pengguna == "") {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'error',
                    'message' => 'Coba Ulangi Lagi'
                )
            );
        } else {
            if (count($data_jadwal)==0) {
                $arr_result = array(
                 'prilude' => array(
                     'status' => 'warning',
                     'message' => 'Jadwal Tidak Ditemukan'
                 )
             );
            } else {
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
