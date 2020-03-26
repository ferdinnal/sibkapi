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
            , 'id_materi','is_selesai','nama_file','id_pengguna');
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
    public function find_file_materi_bysiswaid_post()
    {
        $idMateri= $this->input->post('id_materi');
        $idPengguna= $this->input->post('id_pengguna');

        $data_jadwal=$this->Mfile_materi->findBySiswaModelId($idMateri,$idPengguna, 'result');


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
    public function upload_post()
    {
        $this->load->library('upload');
        $nama_file= $this->input->post('nama_file');
        $file= $this->input->post('fileNa');
        $jenis_file= $this->input->post('jenis_file');
        $id_materi= $this->input->post('id_materi');
        $id_pengguna= $this->input->post('id_pengguna');
        $config['upload_path'] = './file/';
        $config['allowed_types'] = 'xlsx|xls|doc|docx|ppt|pptx|pdf';

        // load library upload
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('fileNa')) {
            $error = $this->upload->display_errors();
            // menampilkan pesan error
            print_r($error);
        } else {
            $result = $this->upload->data();
            $json2=json_encode($result);
            $json = json_decode($json2, true);
            $file_name = $json['file_name'];
            $data = array(
              'file' => $file_name,
              'nama_file' => $nama_file,
              'jenis_file' => $jenis_file,
              'id_materi' => $id_materi,
              'is_selesai' => '1',
              'id_pengguna' => $id_pengguna,
           );
            $simpan=$this->Mfile_materi->create($data);
            if ($simpan) {
                $arr_result = array(
               'prilude' => array(
                   'status' => 'success',
                   'message' => 'Upload Berhasil'
               )
           );
            } else {
                $arr_result = array(
            'prilude' => array(
                'status' => 'error',
                'message' => 'Upload Gagal, silahkan coba lagi.'
            )
        );
            }
            print json_encode($arr_result);
        }
    }
}
