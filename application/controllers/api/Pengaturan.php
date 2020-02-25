<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pengaturan extends REST_Controller
{
    private $field_list = array('id_pengaturan', 'nama_pengaturan', 'nilai_pengaturan', 'deskripsi');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpengaturan');
    }

    public function find_get($nama_pengaturan)
    {
            $data_slider=$this->Mpengaturan->findByName($nama_pengaturan);
            if (count($data_slider)>0) {
                $arr_result = array(
                            'prilude' => array(
                                    'status' => 'success',
                                    'message' => 'Data berhasil ditemukan.',
                                    'data_pengaturan'    =>  $data_slider,
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
            print json_encode($arr_result);

        }



}
