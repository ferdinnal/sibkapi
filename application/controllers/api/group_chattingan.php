<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class group_chattingan extends CI_Controller {

    private $key_id_group = "id_group";
    private $key_nama_group = "nama_group";
    private $key_foto_group = "foto_group";
    private $key_deskripsi_group = "deskripsi_group";
    private $key_is_group = "is_group";
    private $key_id_pengirim = "id_pengirim";
    private $key_id_penerima = "id_penerima";
    private $arr_result = array();
    private $field_list = array('id_group', 'nama_group', 'foto_group', 'deskripsi_group'
        , 'is_group', 'id_pengirim','id_penerima');
    private $required_field = array('');
    private $primary_key = 'id_group';
    private $id_group = "";

    function __construct() {
        parent::__construct();
        $this->load->model('mpengguna');
        $this->load->model('mgroup_chattingan');
    }

    function list_chatting() {
        $id_pengirim= $this->input->post('id_pengguna');

        $arr_result = array();

        if ($id_pengirim == "") {
            $arr_result = array(
                'prilude' => array(
                    'status' => 'error',
                    'message' => 'Coba Ulangi Lagi'
                )
            );
        } else {
            $group_chat = $this->mgroup_chattingan->find_group_chat($id_pengirim);
            $count_chat = $this->mgroup_chattingan->count_group_chat($id_pengirim);
            foreach ($group_chat as $group_chatNa) {
              $id_group=$group_chatNa->id_group;
              $last_chat   = $this->mgroup_chattingan->last_group_chat($id_pengirim,$id_group);
            }
               if (count($group_chat) > 0) {
                 $arr_result = array(
                     'prilude' => array(
                         'status' => 'success',
                         'message' => 'Data Chatting Ditemukan.',
                         'group_chat' => $group_chat,
                         'count_chat' => $count_chat,
                         'last_chat' => $last_chat,
                     )
                 );
               } else {
                   $arr_result = array(
                       'prilude' => array(
                           'status' => 'error',
                           'message' => 'Belum ada Chat.'
                       )
                   );
               }


        }
        print json_encode($arr_result);
    }
}

?>
