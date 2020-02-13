<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pengumuman extends REST_Controller
{
    private $field_list = array('id_pengumuman', 'image_url', 'title', 'content'
            , 'date_created', 'is_active', 'id_pengguna_type');
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpengumuman');
    }

    public function find_post()
    {
        $id_pengguna_type = $this->input->post('id_pengguna_type');

        $arr_result = array();
        if ($id_pengguna_type == 0) {
            $arr_result = array(
            'prilude' => array(
                'status' => 'error',
                'message' => 'Silahkan Coba Lagi'
            )
        );
        } else {
          $keyword             = "";
          $order_by            = 'id_pengumuman';
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

            $data_slider=$this->Mpengumuman->finds($id_pengguna_type,$keyword, $option);
            if (count($data_slider)>0) {
                $arr_result = array(
                            'prilude' => array(
                                    'status' => 'success',
                                    'message' => 'Data berhasil ditemukan.',
                                    'data_slider'    =>  $data_slider,
                            )
                    );
            } else {
                $arr_result = array(
                            'prilude' => array(
                                    'status' => 'warning',
                                    'message' => 'Silahkan ganti kata kunci.',
                            )
                    );
            }

        }

        print json_encode($arr_result);
    }
}
