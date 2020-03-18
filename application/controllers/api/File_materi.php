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

    public function upload_post()
    {
        $this->load->library('upload');
        $nama_file= $this->input->post('nama_file');
        $file= $this->input->post('file');

        $config['upload_path'] = '../file/';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 100000;
        $config['file_name'] = "masuk";

        $this->upload->initialize($config);
         $certificateflag = $this->upload->do_upload("file");
         if ($this->upload->do_upload("file"))
         {
            echo "New record created successfully";
        } else {
            echo "Gagal";
        }

        // $extension= $this->input->post('extension');
        // header('Content-Type: bitmap; charset=utf-8');
        //
        // $fileUpload = '../file/';
        //
        // $ServerURL = 'http://192.168.18.9/nambahilmusukaresikapi/'.$fileUpload;
        // echo $fileInfo = pathinfo($_FILES['ext']['nama_file']);
        // $fileExtension = $fileInfo['extension'];

        // $PdfFileURL = $this->GenerateFileNameUsingID() . '.' . $fileExtension;
        // $PdfFileFinalPath = $fileUpload . $this->GenerateFileNameUsingID() . '.'. $fileExtension;
        //
        //
        //  try{
        //  move_uploaded_file($_FILES['ext']['tmp_name'],$PdfFileFinalPath);
        //  // $InsertTableSQLQuery = "INSERT INTO materi (id_materi,file_link, nama_materi,id_guru,id_kelas,id_mata_pelajaran,id_pertemuan) VALUES (null,'$PdfFileURL', '$nama_materiNa','$id_guru','$id_kelas','$id_mata_pelajaran','$id_pertemuan') ";
        //  echo "New record created successfully";
        //  // mysqli_query($con,$InsertTableSQLQuery);
        //  }catch(Exception $e){
        //    echo "Gagal";
        //  }
         // mysqli_close($con);
    }

    public function GenerateFileNameUsingID()
    {
        $GenerateFileSQL = "SELECT max(id_file_materi) as id FROM file_materi";
        $result=$this->db->query($GenerateFileSQL)->row()->id;

        if ($result==null) {
            return 1;
        } else {
            return ++$result;
        }
    }
}
