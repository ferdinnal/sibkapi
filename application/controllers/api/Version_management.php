<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Version_management extends CI_Controller
{
    private $arr_result = array();
    private $field_list = array('id_manajemen_versi', 'kode_versi', 'nama_versi', 'judul_notifikasi'
            , 'changelog', 'tanggal_rilis','url_to_update','is_urgent');
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mversion_management');
    }


    public function is_need_update()
    {
        $current_version=$this->input->post('current_version');
        $data=$this->Mversion_management->isNeedUpdate('row');
        if ($data->nama_versi > $current_version) {
            $arr_result = array(
                            'sibk' => array(
                                    'status' => 'ada',
                                    'message' => 'Ada Pembaruan.',
                                    'data' => $data,
                            )
                    );
        } else {
            $arr_result = array(
                         'sibk' => array(
                                 'status' => 'success',
                                 'message' => 'Pembaruan tidak ditemukan.',
                                 'data' => $data,
                         )
                 );
        }
        print json_encode($arr_result);
    }

    //untuk mendaptakan data tentang update (menampilkan changelog)
    public function current_release_info()
    {
        $data=$this->Mversion_management->findCurrentRelease();
        $row=array();
        foreach ($data as $update) {
            $row[]=$update;
        }

        print json_encode($row);
    }
}
