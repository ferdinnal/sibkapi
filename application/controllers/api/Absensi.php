<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Absensi extends REST_Controller
{
    private $field_list = array('history_qr_code_id', 'qr_code_absensi', 'day', 'date_created'
            , 'id_jadwal_pelajaran');
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mabsensi');
        $this->load->model('Mjadwal_pelajaran');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function generate_qr_post()
    {
        $id_pengguna= $this->input->post('id_pengguna');
        $id_kelas= $this->input->post('id_kelas');
        $id_jadwal_pelajaran= $this->input->post('id_jadwal_pelajaran');
        $hari_ini=date('N');
        $nowTime = date("Y-m-d h:i:s");
        $nowTimeNa = date("Y-m-d");
        $arr_result = array();
        // $data_siswa=$this->Mabsensi->find_jadwal_now($id_pengguna, $id_kelas, $hari_ini, $nowTimeNa, $id_jadwal_pelajaran);
        //
        // if (count($data_siswa)==0) {
            $data_siswa2=$this->Mabsensi->find_jadwal_now($id_pengguna, $id_kelas, $hari_ini, $nowTimeNa, $id_jadwal_pelajaran);
            if (count($data_siswa2)==0) {
                // $data_jadwal=$this->Mabsensi->find_jadwal2($id_pengguna, $id_kelas, $hari_ini, $id_jadwal_pelajaran);
                $qrCodeAbsensi=$id_kelas.$id_jadwal_pelajaran.$id_pengguna.$hari_ini;
                $data = array(
                'day' =>$hari_ini ,
                'date_created' =>$nowTime ,
                'id_jadwal_pelajaran' =>$id_jadwal_pelajaran ,
                'qr_code_absensi' =>md5($qrCodeAbsensi) ,
            );
                if ($this->Mabsensi->create($data)) {
                    $dataUpdate = array('qr_code_absensi' =>md5($qrCodeAbsensi)  , );
                    $where = array('id_jadwal_pelajaran' =>$id_jadwal_pelajaran  , );
                    if ($this->Mjadwal_pelajaran->update($dataUpdate, $where)) {
                        $data_siswaNa=$this->Mabsensi->find_jadwal_order($id_pengguna, $id_kelas, $hari_ini, $id_jadwal_pelajaran);
                        if ($this->Mabsensi->createAbsensiAll($id_kelas, $id_jadwal_pelajaran, $data_siswaNa->history_qr_code_id)) {
                            $arr_result = array(
                    'prilude' => array(
                        'status' => 'success',
                        'message' => 'Data Pengguna Ditemukan.',
                       'data_siswa'     => $data_siswaNa,
                    )
                );
                        } else {
                            $arr_result = array(
                     'prilude' => array(
                         'status' => 'warning',
                         'message' => 'QrCode Tidak Di Temukan.'
                     )
                 );
                        }
                    } else {
                        $arr_result = array(
                     'prilude' => array(
                         'status' => 'warning',
                         'message' => 'QrCode Tidak Di Temukan.'
                     )
                 );
                    }
                } else {
                    $arr_result = array(
                   'prilude' => array(
                       'status' => 'warning',
                       'message' => 'QrCode Tidak Di Temukan.'
                   )
               );
                }
            } else {
                $arr_result = array(
                'prilude' => array(
                    'status' => 'successNya',
                    'message' => 'Data Pengguna Ditemukan.',
                   'data_siswa'     => $data_siswa2,
                )
            );
            }
        // } else {
        //     $arr_result = array(
        //         'prilude' => array(
        //             'status' => 'success',
        //             'message' => 'Data Pengguna Ditemukan.',
        //            'data_siswa'     => $data_siswa,
        //         )
        //     );
        // }

        print json_encode($arr_result);
    }

    public function find_hari_post()
    {
        $id_pengguna= $this->input->post('id_pengguna');
        $id_kelas= $this->input->post('id_kelas');
        $id_jadwal_pelajaran= $this->input->post('id_jadwal_pelajaran');
        $hari_ini=date('N');

        $arr_result = array();
        $data_siswa=$this->Mabsensi->find_hari($id_pengguna, $id_kelas, $hari_ini, $id_jadwal_pelajaran);

        if (count($data_siswa)==0) {
            $arr_result = array(
             'prilude' => array(
                 'status' => 'warning',
                 'message' => 'Data Tidak Di Temukan.'
             )
         );
        } else {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'success',
                    'message' => 'Data Pengguna Ditemukan.',
                   'data_siswa'     => $data_siswa,
                )
            );
        }

        print json_encode($arr_result);
    }
    public function find_hari_siswa_post()
    {
        $id_pengguna= $this->input->post('id_pengguna');
        $id_kelas= $this->input->post('id_kelas');
        $id_jadwal_pelajaran= $this->input->post('id_jadwal_pelajaran');
        $hari_ini=date('N');

        $arr_result = array();
        $data_siswa=$this->Mabsensi->find_hari_siswa($id_pengguna, $id_kelas, $hari_ini, $id_jadwal_pelajaran);

        if (count($data_siswa)==0) {
            $arr_result = array(
             'prilude' => array(
                 'status' => 'warning',
                 'message' => 'Data Tidak Di Temukan.'
             )
         );
        } else {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'success',
                    'message' => 'Data Pengguna Ditemukan.',
                   'data_siswa'     => $data_siswa,
                )
            );
        }

        print json_encode($arr_result);
    }

    public function absensi_siswa_post()
    {
        $id_kelas= $this->input->post('id_kelas');
        $history_qr_code_id= $this->input->post('history_qr_code_id');
        $qr_code_absensi= $this->input->post('qr_code_absensi');
        $id_pengguna= $this->input->post('id_pengguna');
        $latitude= $this->input->post('latitude');
        $longitude= $this->input->post('longitude');
        $hari_ini=date('N');
        $dateTime = date("Y-m-d h:i:s");
        $date = date("Y-m-d");

        $arr_result = array();
        $data_siswa=$this->Mabsensi->absensi_siswa_check($latitude,$longitude,$date, $id_kelas, $history_qr_code_id, $hari_ini, $qr_code_absensi);

        if (count($data_siswa)==0) {
            $arr_result = array(
             'prilude' => array(
                 'status' => 'warning',
                 'message' => 'Lokasi anda tidak berada dekat dengan qr-code.'
             )
         );
        } else {
            $data = array(
            'status_absen_id' =>'1' ,
            'tanggal_absen' =>$dateTime ,
        );
            $where = array(
          'id_siswa' =>$id_pengguna ,
          'history_qr_code_id' =>$history_qr_code_id ,
      );
            if ($this->Mabsensi->update($data, $where)) {
                $arr_result = array(
                  'prilude' => array(
                      'status' => 'success',
                      'message' => 'Data Pengguna Ditemukan.',
                     'data_siswa'     => $data_siswa,
                  )
              );
            } else {
                $arr_result = array(
               'prilude' => array(
                   'status' => 'warning',
                   'message' => 'Data Tidak Di Temukan.'
               )
           );
            }
        }

        print json_encode($arr_result);
    }
    public function find_absensi_siswa_post()
    {
        $history_qr_code_id= $this->input->post('history_qr_code_id');
        $id_kelas= $this->input->post('id_kelas');

        $arr_result = array();
        $data_siswa=$this->Mabsensi->find_absensi_siswa($history_qr_code_id);
        $total_siswa=$this->Mabsensi->find_total_siswa($id_kelas);
        $hadir=$this->Mabsensi->find_total_hadir($history_qr_code_id);
        $sakit=$this->Mabsensi->find_total_sakit($history_qr_code_id);
        $ijin=$this->Mabsensi->find_total_ijin($history_qr_code_id);
        $alfa=$this->Mabsensi->find_total_alfa($history_qr_code_id);
        $belum=$this->Mabsensi->find_total_belum($history_qr_code_id);

        if (count($data_siswa)==0) {
            $arr_result = array(
             'prilude' => array(
                 'status' => 'warning',
                 'message' => 'Absensi Tidak Di Temukan.'
             )
         );
        } else {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'success',
                    'message' => 'Data Pengguna Ditemukan.',
                    'data_siswa'     => $data_siswa,
                    'total_siswa'     => $total_siswa,
                    'total_hadir'     => $hadir,
                    'total_ijin'     => $ijin,
                    'total_alfa'     => $alfa,
                    'total_belum'     => $belum,
                    'total_sakit'     => $sakit,
                )
            );
        }

        print json_encode($arr_result);
    }

    public function update_by_guru_post()
    {
        $absensi_id= $this->input->post('absensi_id');
        $status_absen_id= $this->input->post('status_absen_id');

        $data = array('status_absen_id' =>$status_absen_id , );
        $where = array('absensi_id' =>$absensi_id , );

        $arr_result = array();

        if ($this->Mabsensi->update($data, $where)) {
            $arr_result = array(
             'prilude' => array(
                 'status' => 'success',
                 'message' => 'Absensi Tidak Di Temukan.'
             )
         );
        } else {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'warning',
                    'message' => 'Gagal.',
                )
            );
        }

        print json_encode($arr_result);
    }
}
