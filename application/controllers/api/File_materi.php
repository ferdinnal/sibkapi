<?php

defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class File_materi extends REST_Controller
{
    private $arr_result = array();
    private $table                      = "file_materi";
    private $field_list = array('id_file_materi', 'file', 'jenis_file'
            , 'id_materi','is_selesai','nama_file');
    private $exception_field            = array();
    private $primary_key                = "id_file_materi";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mfile_materi');
    }


    public function find_file_materi_bysiswa_post()
    {
        $idMateri= $this->input->post('id_materi');

        $data_jadwal=$this->Mfile_materi->findBySiswaModel($idMateri, 'result');


        if ($idMateri == "") {
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
                     'message' => 'Materi Tidak Ditemukan'
                 )
             );
            } else {
                $arr_result = array(
                'prilude' => array(
                    'status' => 'success',
                    'message' => 'Data Pengguna Ditemukan.',
                    'data_materi'     => $data_jadwal,
                )
            );
            }
        }

        print json_encode($arr_result);
    }
}
