<?php



defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;



require APPPATH . 'libraries/REST_Controller.php';

require APPPATH . 'libraries/Format.php';



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Bimbingan extends REST_Controller

{

    private $arr_result = array();



    public function __construct()

    {

        parent::__construct();

        $this->load->model('MBimbingan');

        date_default_timezone_set("Asia/Bangkok");

    }

    public function finds_post()

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
