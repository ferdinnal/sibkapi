<?php

class pelanggaran extends CI_Controller
{
    private $field_list = array('ppid', 'userid', 'tg', 'ttid', 'pp');
    private $required_field = array();
    private $primary_key = 'ppid';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpelanggaran');
    }


    public function find()
    {
        $userid  = $this->input->post('userid');

        $arr_result = array();
        if ($userid == 0) {
            $arr_result = array(
                'sibk' => array(
                    'status' => 'error',
                    'message' => 'Silahkan Coba Lagi'
                )
            );
        } else {
            $query = array(
              'userid' =>$userid ,
            );
            $data_user=$this->Mpelanggaran->find($query, 'result');
            if (COUNT($data_user) > 0) {
              $arr_result = array(
              'sibk' => array(
                  'status' => 'success',
                  'message' => 'Data berhasil ditemukan.',
                  'data_user'    =>  $data_user,
              )
          );
            }else {
              $arr_result = array(
                  'sibk' => array(
                      'status' => 'error',
                      'message' => 'Data tidak ditemukan'
                  )
              );
            }
        }

        print json_encode($arr_result);
    }


}
