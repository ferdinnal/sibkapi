<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pelajaran extends REST_Controller
{
    private $field_list = array('id_mata_pelajaran', 'kode_mata_pelajaran', 'nama_mata_pelajaran', 'gambar_mata_pelajaran');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpelajaran');
    }

    public function findBySiswa_post()
    {
        $id_pengguna=$this->input->post('id_pengguna');
        $data_slider=$this->Mpelajaran->find_siswa_all($id_pengguna, 'result');
        if (count($data_slider)>0) {
            $arr_result = array(
                            'prilude' => array(
                                    'status' => 'success',
                                    'message' => 'Data berhasil ditemukan.',
                                    'data_pelajaran'    =>  $data_slider,
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
