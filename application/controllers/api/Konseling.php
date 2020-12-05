<?php



defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;



require APPPATH . 'libraries/REST_Controller.php';

require APPPATH . 'libraries/Format.php';



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Konseling extends REST_Controller

{

    private $arr_result = array();



    public function __construct()

    {

        parent::__construct();

        $this->load->model('Mkonseling');

        date_default_timezone_set("Asia/Bangkok");

    }

    public function finds_post()

  {
      $status= $this->input->post('status');
      $userid= $this->input->post('userid');

      $arr_result = array();

      $data_jadwal=$this->Mkonseling->find_siswa_all($status,$userid,'result');
          if (count($data_jadwal)==0) {

              $arr_result = array(

               'sibk' => array(

                   'status' => 'warning',

                   'message' => 'Konseling Tidak Ditemukan'
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
  public function finds2_post()

{
    $status= $this->input->post('status');
    $userid= $this->input->post('userid');

    $arr_result = array();

    $data_jadwal=$this->Mkonseling->find_siswa_all2($status,$userid,'result');
        if (count($data_jadwal)==0) {

            $arr_result = array(

             'sibk' => array(

                 'status' => 'warning',

                 'message' => 'Konseling Tidak Ditemukan'
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
public function tambah_post()

{
  $subject= $this->input->post('subject');
  $userid= $this->input->post('userid');
  $waktu= $this->input->post('waktu');
  $tanggal= $this->input->post('tanggal');

    $arr_result = array();
    $data = array(
      'subject' =>$subject ,
      'tg' =>$tanggal ,
      'wk' =>$waktu ,
      'userid' =>$userid ,
      'st' =>"Pending" ,
  );

    $save = $this->Mkonseling->create($data);
      if ($save) {
        $arr_result = array(

        'sibk' => array(

            'status' => 'success',

            'message' => 'Data Pengguna Ditemukan.',

        )

    );

      } else {

        $arr_result = array(

         'sibk' => array(

             'status' => 'warning',

             'message' => 'Pengajuan gagal di simpan'
         )

     );

      }



  print json_encode($arr_result);

}



}
