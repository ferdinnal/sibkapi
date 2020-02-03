<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pengguna extends REST_Controller
{
    private $field_list = array('id_pengguna', 'nama_pengguna', 'alamat_email', 'password'
        , 'no_handphone', 'gambar_profil', 'tanggal_lahir', 'jenis_kelamin', 'id_pengguna_type', 'id_status_pengguna'
        , 'id_status_pengguna');
    private $required_field = array('alamat_email', 'nama_pengguna', 'password');
    private $md5_field = 'password';
    private $primary_key = 'id_pengguna';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpengguna');
        $this->load->model('Msiswa');
        $this->load->model('Mguru');
    }


    public function find_post()
    {
        $id_pengguna  = $this->input->post('id_pengguna');
        $id_pengguna_type = $this->input->post('id_pengguna_type');

        $arr_result = array();
        if ($id_pengguna == 0) {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'error',
                    'message' => 'Silahkan Coba Lagi'
                )
            );
        } elseif ($id_pengguna_type == 0) {
            $arr_result = array(
            'prilude' => array(
                'status' => 'error',
                'message' => 'Silahkan Coba Lagi'
            )
        );
        } else {
            $query = array(
              'id_pengguna' =>$id_pengguna ,
              'id_pengguna_type' =>$id_pengguna_type ,
            );
            $data_user=$this->Mpengguna->find($query, 'row');
            if ($id_pengguna_type == 2) {
                $query_siswa = array(
                'id_pengguna' =>$id_pengguna ,
               );
                $data_siswa=$this->Msiswa->find($query_siswa, 'row');
                $arr_result = array(
              'prilude' => array(
                  'status' => 'success',
                  'message' => 'Data berhasil ditemukan.',
                  'data_user'    =>  $data_user,
                  'data_siswa'    =>  $data_siswa,
              )
          );
            } elseif ($id_pengguna_type == 3) {
                $query_guru = array(
              'id_pengguna' =>$id_pengguna ,
             );
                $data_guru=$this->Mguru->find($query_guru, 'row');
                $arr_result = array(
                'prilude' => array(
                    'status' => 'success',
                    'message' => 'Data berhasil ditemukan.',
                    'data_user'    =>  $data_user,
                    'data_guru'    =>  $data_guru,
                )
            );
            } else {
                $arr_result = array(
            'prilude' => array(
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses.'
            )
        );
            }
        }

        print json_encode($arr_result);
    }

    public function login_post()
    {
        $nisn  = $this->input->post('nisn');
        $password = md5($this->input->post('password'));

        $arr_result = array();
        if ($nisn == "") {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'error',
                    'message' => 'Silahkan Coba Lagi'
                )
            );
        } elseif ($password == "") {
            $arr_result = array(
            'prilude' => array(
                'status' => 'error',
                'message' => 'Silahkan Coba Lagi'
            )
        );
        } else {
            $query_siswa = array(
              'nisn' =>$nisn,
            );
            $data_siswa=$this->Msiswa->find($query_siswa, 'row');
            $query_guru = array(
              'nip' =>$nisn,
            );
            $data_guru=$this->Mguru->find($query_guru, 'row');
            if (count($data_siswa)>0) {
                $query_user = array(
                 'password' =>$password,
                 'id_pengguna' =>$data_siswa->id_pengguna,
               );
                $data_user=$this->Mpengguna->find($query_user, 'row');
                if (count($data_user)>0) {
                    $arr_result = array(
                       'prilude' => array(
                           'status' => 'success',
                           'message' => 'Data berhasil ditambahkan.',
                           'data_user'    =>  $data_user,
                           'data_siswa'    =>  $data_siswa,
                       )
                   );
                } else {
                    $arr_result = array(
                 'prilude' => array(
                     'status' => 'error',
                     'message' => 'Kata sandi dan NISN/NIP salah, silahkan coba lagi.'
                 )
             );
                }
            } elseif (count($data_guru) > 0) {
                $query_user = array(
                'password' =>$password,
                'id_pengguna' =>$data_guru->id_pengguna,
              );
                $data_user=$this->Mpengguna->find($query_user, 'row');
                if (count($data_user)>0) {
                    $arr_result = array(
                      'prilude' => array(
                          'status' => 'success',
                          'message' => 'Data berhasil ditambahkan.',
                          'data_user'    =>  $data_user,
                          'data_guru'    =>  $data_guru,
                      )
                  );
                } else {
                    $arr_result = array(
              'prilude' => array(
                  'status' => 'error',
                  'message' => 'NISN/NIP salah, silahkan coba lagi.'
              )
          );
                }
            }
        }
        print json_encode($arr_result);
    }
}
