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
        $this->load->model('Mmateri');
        $this->load->model('Msiswa');
        $this->load->model('Mnotifikasi');
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
        $id_pengguna= $this->input->post('id_pengguna');

        $data_jadwal=$this->Mfile_materi->findByGuru($idMateri, $id_pengguna, 'result');


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
    public function find_file_materi_byFileGuru_post()
    {
        $idMateri= $this->input->post('id_materi');
        $idPengguna= $this->input->post('id_pengguna');

        $data_jadwal=$this->Mfile_materi->findByGuru($idMateri, $idPengguna, 'result');


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

    public function tambah_materi_post()
    {
        $this->load->library('upload');
        $nama_file= $this->input->post('nama_file');
        $file= $this->input->post('fileNa');
        $jenis_file= $this->input->post('jenis_file');
        $id_pengguna= $this->input->post('id_pengguna');
        $is_upload= $this->input->post('is_upload');
        $id_kelas= $this->input->post('id_kelas');
        $dateTime = date("Y-m-d h:i:s");
        if ($is_upload == 1) {
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
                $data_materi = array(
                'nama_materi' => $this->input->post('nama_materi'),
                'deskripsi_materi' => $this->input->post('deskripsi_materi'),
                'id_mata_pelajaran_guru' => $this->input->post('id_mata_pelajaran_guru'),
                'jenis' => $this->input->post('jenis'),
                'is_upload' => $this->input->post('is_upload'),
                'waktu_tenggang' => $this->input->post('waktu_tenggang'),
                'id_kelas' => $this->input->post('id_kelas'),
                'date_created' => $dateTime,

             );
                $id_materi=$this->Mmateri->create($data_materi);
                $data = array(
                'file' => $file_name,
                'nama_file' => $nama_file,
                'jenis_file' => $jenis_file,
                'id_materi' => $id_materi,
                'is_selesai' => '1',
                'id_pengguna' => $id_pengguna,
                'is_tugas_guru' => $this->input->post('is_tugas_guru'),
             );
                $simpan=$this->Mfile_materi->create($data);
                if ($simpan) {
                    $dataNa = array('id_kelas' =>$id_kelas , );
                    $dataSiswa=$this->Msiswa->find($dataNa, 'result');
                    $i = 0;
                    $len = count($dataSiswa);
                    $jenisNa="";
                    $message="";
                    if ($this->input->post('jenis') == 1) {
                        $jenisNa="Ada Materi Baru";
                        $message="Ada Materi Baru, silahkan untuk mengeceknya!";
                    } else {
                        $jenisNa="Ada Tugas Baru";
                        $message="Ada Tugas Baru, silahkan untuk mengeceknya!";
                    }
                    foreach ($dataSiswa as $siswaNa) {
                        $notifNa = array(
                        'timestamp' =>$dateTime ,
                        'title' =>$jenisNa ,
                        'message' =>$message ,
                        'id_pengguna' =>$siswaNa->id_pengguna ,
                        'is_read' =>0 ,
                        'extra' =>$id_materi ,
                        'intent_id' =>1 ,
                        'aplikasi_id' =>5 ,
                     );
                        $this->Mnotifikasi->create($notifNa);
                        if ($i == $len - 1) {
                            $arr_result = array(
                       'prilude' => array(
                           'status' => 'success',
                           'message' => 'Upload Berhasil'
                       )
                   );
                        }
                        $i++;
                    }
                } else {
                    $arr_result = array(
              'prilude' => array(
                  'status' => 'error',
                  'message' => 'Upload Gagal, silahkan coba lagi.'
              )
          );
                }
            }
        } else {
            $data_materi = array(
          'nama_materi' => $this->input->post('nama_materi'),
          'deskripsi_materi' => $this->input->post('deskripsi_materi'),
          'id_mata_pelajaran_guru' => $this->input->post('id_mata_pelajaran_guru'),
          'jenis' => $this->input->post('jenis'),
          'is_upload' => $this->input->post('is_upload'),
          'waktu_tenggang' => $this->input->post('waktu_tenggang'),
          'date_created' => $dateTime,

       );
            $simpan=$this->Mmateri->createNew($data_materi);
            if ($simpan) {
                $dataNa = array('id_kelas' =>$id_kelas , );
                $dataSiswa=$this->Msiswa->find($dataNa, 'result');
                $i = 0;
                $len = count($dataSiswa);
                $jenisNa="";
                $message="";
                if ($this->input->post('jenis') == 1) {
                    $jenisNa="Ada Materi Baru";
                    $message="Ada Materi Baru, silahkan untuk mengeceknya!";
                } else {
                    $jenisNa="Ada Tugas Baru";
                    $message="Ada Tugas Baru, silahkan untuk mengeceknya!";
                }
                foreach ($dataSiswa as $siswaNa) {
                    $notifNa = array(
                  'timestamp' =>$dateTime ,
                  'title' =>$jenisNa ,
                  'message' =>$message ,
                  'id_pengguna' =>$siswaNa->id_pengguna ,
                  'is_read' =>0 ,
                  'extra' =>$id_materi ,
                  'intent_id' =>1 ,
                  'aplikasi_id' =>5 ,
               );
                    $this->Mnotifikasi->create($notifNa);
                    if ($i == $len - 1) {
                        $arr_result = array(
                 'prilude' => array(
                     'status' => 'success',
                     'message' => 'Upload Berhasil'
                 )
             );
                    }
                    $i++;
                }
            } else {
                $arr_result = array(
        'prilude' => array(
            'status' => 'error',
            'message' => 'Upload Gagal, silahkan coba lagi.'
        )
      );
            }
        }
        print json_encode($arr_result);
    }
}
