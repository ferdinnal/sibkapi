<?php



class Bimbingan extends CI_Controller

{

    private $arr_result = array();



    public function __construct()

    {

        parent::__construct();

        $this->load->model('MBimbingan');

        date_default_timezone_set("Asia/Bangkok");

    }

    public function finds()

  {

      $arr_result = array();

      $data_jadwal=$this->MBimbingan->find_siswa_all('result');
          if (count($data_jadwal)==0) {

              $arr_result = array(

               'sibk' => array(

                   'status' => 'warning',

                   'message' => 'Bimbingan Tidak Ditemukan'
               )

           );
          } else {

              $arr_result = array(

              'sibk' => array(

                  'status' => 'success',

                  'message' => 'Data Pengguna Ditemukan.',

                   'data_bimbingan'     => $data_jadwal,

              )

          );

          }



      print json_encode($arr_result);

  }



}
