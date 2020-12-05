<?php

class user extends CI_Controller
{
    private $field_list = array('userid', 'username', 'email', 'password', 'fullname');
    private $required_field = array('username', 'password');
    private $md5_field = 'password';
    private $primary_key = 'userid';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Muser');
        $this->load->model('Msiswa');
        $this->load->model('Mguru');
    }


    public function find()
    {
        $userid  = $this->input->post('userid');
        $usertypeid = $this->input->post('usertypeid');

        $arr_result = array();
        if ($userid == 0) {
            $arr_result = array(
                'sibk' => array(
                    'status' => 'error',
                    'message' => 'Silahkan Coba Lagi'
                )
            );
        } elseif ($usertypeid == 0) {
            $arr_result = array(
            'sibk' => array(
                'status' => 'error',
                'message' => 'Silahkan Coba Lagi'
            )
        );
        } else {
            $query = array(
              'userid' =>$userid ,
              'usertypeid' =>$usertypeid ,
            );
            $data_user=$this->Muser->find($query, 'row');
            if ($usertypeid == 2) {
                $query_guru = array(
                'userid' =>$userid ,
               );
                $data_guru=$this->Mguru->find($query_guru, 'row');
                $arr_result = array(
              'sibk' => array(
                  'status' => 'success',
                  'message' => 'Data berhasil ditemukan.',
                  'data_user'    =>  $data_user,
                  'data_guru'    =>  $data_guru,
              )
          );
            } elseif ($usertypeid == 3) {
                $query_siswa = array(
              'userid' =>$userid ,
             );
                $data_siswa=$this->Msiswa->find($query_siswa, 'row');
                $data_pp=$this->Msiswa->findPP($query_siswa, 'result');
                $total=$this->Msiswa->findSUM($query_siswa, 'row');
                $arr_result = array(
                'sibk' => array(
                    'status' => 'success',
                    'message' => 'Data berhasil ditemukan.',
                    'data_user'    =>  $data_user,
                    'data_siswa'    =>  $data_siswa,
                    'data_pp'    =>  $data_pp,
                    'total_pp'    =>  $total,
                )
            );
            } else {
                $arr_result = array(
            'sibk' => array(
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses.'
            )
        );
            }
        }

        print json_encode($arr_result);
    }

    public function login()
    {
        $username  = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $arr_result = array();
        if ($username == "") {
            $arr_result = array(
                'sibk' => array(
                    'status' => 'error',
                    'message' => 'Silahkan Coba Lagi'
                )
            );
        } elseif ($password == "") {
            $arr_result = array(
            'sibk' => array(
                'status' => 'error',
                'message' => 'Silahkan Coba Lagi'
            )
        );
        } else {
            $query_login = array(
              'username' =>$username,
            );
            $data=$this->Muser->find($query_login, 'row');
            if (count($data)>0) {
                $query_user = array(
                 'password' =>$password,
                 'userid' =>$data->userid,
                 'usertypeid'=>$data->usertypeid,
               );
                $data_user=$this->Muser->find($query_user, 'row');
                $usertypeid = $data_user->usertypeid;
                if ($usertypeid == 2) {
                    $arr_result = array(
                       'sibk' => array(
                           'status' => 'success',
                           'message' => 'Data berhasil ditambahkan.',
                           'data_user'    =>  $data_user,
                           'data_guru'    =>  $this->Mguru->find($query_user, 'row'),
                       )
                   );
                }elseif ($usertypeid == 3) {
                    $arr_result = array(
                      'sibk' => array(
                          'status' => 'success',
                          'message' => 'Data berhasil ditambahkan.',
                          'data_user'    =>  $data_user,
                          'data_siswa'    =>  $this->Msiswa->find($query_user, 'row'),
                      )
                  );
                } else {
                    $arr_result = array(
              'sibk' => array(
                  'status' => 'error',
                  'message' => 'nama pengguna atau password salah, silahkan coba lagi.'
              )
          );
                }
            }
        }
        print json_encode($arr_result);
    }

    function update_email() {

      $data = array('email' => $this->input->post('email'), );
      $where = array('userid' => $this->input->post('userid'), );

        $arr_result = array();

          if ($this->Muser->update($data,$where))
           {

             $arr_result = array(
                 'sibk' => array(
                     'status' => 'success',
                     'message' => 'Data diupdate.',
                 )
             );
          }else {
            $arr_result = array(
                'sibk' => array(
                    'status' => 'warning',
                    'message' => 'Data Tidak diupdate.'
                )
            );
          }

        print json_encode($arr_result);
    }

    function update_handphone() {

      $data = array('no_user' => $this->input->post('no_user'), );
      $where = array('userid' => $this->input->post('userid'), );

        $arr_result = array();

          if ($this->Muser->update($data,$where))
           {

             $arr_result = array(
                 'sibk' => array(
                     'status' => 'success',
                     'message' => 'Data diupdate.',
                 )
             );
          }else {
            $arr_result = array(
                'sibk' => array(
                    'status' => 'warning',
                    'message' => 'Data Tidak diupdate.'
                )
            );
          }

        print json_encode($arr_result);
    }
    function update_handphone_ortu() {

      $data = array('no_ortu' => $this->input->post('no_ortu'), );
      $where = array('userid' => $this->input->post('userid'), );

        $arr_result = array();

          if ($this->Muser->update($data,$where))
           {

             $arr_result = array(
                 'sibk' => array(
                     'status' => 'success',
                     'message' => 'Data diupdate.',
                 )
             );
          }else {
            $arr_result = array(
                'sibk' => array(
                    'status' => 'warning',
                    'message' => 'Data Tidak diupdate.'
                )
            );
          }

        print json_encode($arr_result);
    }
    function update_password_post() {

      $data = array(
        'password' => md5($this->input->post('password'))
      , );
      $where = array('userid' => $this->input->post('userid'), );

        $arr_result = array();

          if ($this->Muser->update($data,$where))
           {

             $arr_result = array(
                 'sibk' => array(
                     'status' => 'success',
                     'message' => 'Data diupdate.',
                 )
             );
          }else {
            $arr_result = array(
                'sibk' => array(
                    'status' => 'warning',
                    'message' => 'Data Tidak diupdate.'
                )
            );
          }

        print json_encode($arr_result);
    }

}
