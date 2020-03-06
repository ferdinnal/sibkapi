<?php

defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Komen_materi extends REST_Controller
{
    private $arr_result = array();
    private $table                      = "materi_komen";
    private $field_list = array('id_materi_komen', 'isi', 'date_created', 'id_pengguna'
            , 'id_materi_komen_referal', 'id_materi');
    private $exception_field            = array();
    private $primary_key                = "id_materi_komen";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mkomenmateri');
        date_default_timezone_set("Asia/Bangkok");
    }


    public function findBySiswa_post()
    {
        $id_materi= $this->input->post('id_materi');

        $arr_result = array();
        $keyword             = "";
        $order_by            = 'id_materi_komen';
        $ordering            = "desc";
        $limit               = 100;
        $page                = 0;

        if (isset($_POST['keyword'])) {
            $keyword = $this->input->post('keyword');
        }

        if (isset($_POST['order_by'])) {
            $order_by = $this->input->post('order_by');
        }

        if (isset($_POST['ordering'])) {
            $ordering = $this->input->post('ordering');
        }

        if (isset($_POST['limit'])) {
            $limit = $this->input->post('limit');
        }

        if (isset($_POST['page'])) {
            $page = $this->input->post('page');
        }

        $option = array(
            'limit' => $limit,
            'page'  => $page,
            'order' => array(
                'order_by' => $order_by,
                'ordering' => $ordering,
            ),
        );
        $data_jadwal=$this->Mkomenmateri->findBySiswaModel($id_materi, 'result', $keyword, $option);
  


        if ($id_materi == "") {
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

    function create_post() {
      $date_created=date('Y-m-d H:i:s');

      if ($this->input->post('id_materi_komen') == null) {
        $data = array(
          'id_pengguna' => $this->input->post('id_pengguna'),
          'isi' => $this->input->post('isi'),
          'id_materi' => $this->input->post('id_materi'),
          'date_created' => $date_created,
       );
      }else {
        $data = array(
          'id_pengguna' => $this->input->post('id_pengguna'),
          'isi' => $this->input->post('isi'),
          'id_materi' => $this->input->post('id_materi'),
          'id_materi_komen_referal' => $this->input->post('id_materi_komen'),
          'date_created' => $date_created,
       );
      }

        $arr_result = array();

          if ($this->Mkomenmateri->create($data))
           {

             $arr_result = array(
                 'prilude' => array(
                     'status' => 'success',
                     'message' => 'Data diupdate.',
                 )
             );
          }else {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'warning',
                    'message' => 'Data Tidak diupdate.'
                )
            );
          }

        print json_encode($arr_result);
    }

}
