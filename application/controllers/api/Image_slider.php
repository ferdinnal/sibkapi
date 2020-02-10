<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Image_slider extends REST_Controller
{
    private $field_list = array('id_slider_image', 'image_url', 'title', 'content'
            , 'date_created', 'is_active', 'id_pengguna_type');
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mslider_image');
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
            $query = array(
                        'is_active' =>'1' ,
                        'id_pengguna_type' =>$id_pengguna_type ,
                    );
            $data_slider=$this->Mslider_image->find($query, 'result');
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
                                    'status' => 'error',
                                    'message' => 'Data slider tidak ditemukan.',
                            )
                    );
            }
        }

        print json_encode($arr_result);
    }
}
