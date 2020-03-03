<?php

defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Materi extends REST_Controller
{
    private $arr_result = array();
    private $table                      = "materi";
    private $field_list = array('id_materi', 'nama_materi', 'deskripsi_materi', 'date_created'
            , 'id_mata_pelajaran_guru', 'jenis');
    private $exception_field            = array();
    private $primary_key                = "id_materi";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mmateri');
    }


    public function findBySiswa_post()
    {
        $id_mata_pelajaran_guru= $this->input->post('id_mata_pelajaran_guru');

        $arr_result = array();
        $data_jadwal=$this->Mmateri->findBySiswaModel($id_mata_pelajaran_guru, 'result');


        if ($id_mata_pelajaran_guru == "") {
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

    function findKomen_get($id_materi) {
        $data = $this->Mmateri->findKomenModel($id_materi,'result');
        $arr_result = array(
        'prilude' => array(
            'status' => 'success',
            'message' => 'Data Pengguna Ditemukan.',
            'data_komen'     => count($data),
        )
    );
        print json_encode($arr_result);
    }
    public function upload()
    {
        // $id_pengguna= $this->input->post('id_pengguna');
        //this is our upload folder
        $upload_path = '..img/';

        //Getting the server ip
        $server_ip = gethostbyname(gethostname());

        //creating the upload url
        $upload_url = 'http://'.$server_ip.'/AndroidPdfUpload/'.$upload_path;

        $arr_result = array();
        //getting name from the request
        $name = $_POST['file_link'];

        //getting file info from the request
        $fileinfo = pathinfo($_FILES['pdf']['file_link']);

        //getting the file extension
        $extension = $fileinfo['extension'];

        // //file url to store in the database
        // $file_url = $upload_url . getFileName() . '.' . $extension;
        //
        // //file path to upload in the server
        // $file_path = $upload_path . getFileName() . '.'. $extension;

        try {
            move_uploaded_file($_FILES['pdf']['tmp_name'], $PdfFileFinalPath);


            mysqli_query($con, $InsertTableSQLQuery);
        } catch (Exception $e) {
        }
        mysqli_close($con);


        if ($this->mmateri->uploadMateri()) {
            $arr_result = array(
                 'prilude' => array(
                     'status' => 'success',
                     'message' => 'Upload Materi Berhasil.',
                 )
             );
        } else {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'warning',
                    'message' => 'Gagal'
                )
            );
        }

        print json_encode($arr_result);
    }
    public function get_pertemuan_all()
    {
        $id_pengguna= $this->input->post('id_pengguna');

        $arr_result = array();
        $data_jadwal=$this->mmateri->findByIdNew($id_pengguna);

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
                     'message' => 'Materi Tidak Ditemukan'
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

    public function get_pertemuan_all_siswa()
    {
        $id_pengguna= $this->input->post('id_pengguna');

        $arr_result = array();
        $data_jadwal=$this->mmateri->findByIdNewSiswa($id_pengguna);

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
                     'message' => 'Materi Tidak Ditemukan'
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


    //untuk mendapatkan list dari produk, yang ada di cart
    public function materi_now_new($no_order)
    {
        $data = $this->mmateri->findCartByOrderId($no_order);
        $row = array();

        foreach ($data as $produk) {
            $row[] = $produk;
        }

        print json_encode($row);
    }

    //untuk mendapatkan list dari produk, yang ada di cart
    public function materi_now_new_siswa($no_order)
    {
        $data = $this->mmateri->findCartByOrderIdNew($no_order);
        $row = array();

        foreach ($data as $produk) {
            $row[] = $produk;
        }

        print json_encode($row);
    }
}
