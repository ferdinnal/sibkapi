<?php


class Jadwal_pelajaran extends CI_Controller

{

    private $arr_result = array();



    public function __construct()

    {

        parent::__construct();

        $this->load->model('Mjadwal_pelajaran');

        date_default_timezone_set("Asia/Bangkok");

    }

    public function jadwal_pelajaran_all_siswa()

  {

      $userid= $this->input->post('userid');

      $arr_result = array();

      $data_jadwal=$this->Mjadwal_pelajaran->find_siswa_all($userid, 'result');



          if (count($data_jadwal)==0) {

              $arr_result = array(

               'sibk' => array(

                   'status' => 'warning',

                   'message' => 'Jadwal Tidak Ditemukan'

               )

           );

          } else {

              $arr_result = array(

              'sibk' => array(

                  'status' => 'success',

                  'message' => 'Data Pengguna Ditemukan.',

                 'data_jadwal'     => $data_jadwal,

              )

          );

          }



      print json_encode($arr_result);

  }

  public function jadwal_pelajaran_all_guru()

{

    $userid= $this->input->post('userid');

    $arr_result = array();

    $data_jadwal=$this->Mjadwal_pelajaran->find_guru_all($userid, 'result');



        if (count($data_jadwal)==0) {

            $arr_result = array(

             'sibk' => array(

                 'status' => 'warning',

                 'message' => 'Jadwal Tidak Ditemukan'

             )

         );

        } else {

            $arr_result = array(

            'sibk' => array(

                'status' => 'success',

                'message' => 'Data Pengguna Ditemukan.',

               'data_jadwal'     => $data_jadwal,

            )

        );

        }



    print json_encode($arr_result);

}
  function jadwal_pelajaran_detail_list($hari) {

      $data = $this->Mjadwal_pelajaran->find_siswa_detail_2($hari,'result');

      $row = array();



      foreach ($data as $produk) {

          $row[] = $produk;

      }



      print json_encode($row);

  }








}
