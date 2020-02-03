<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Mpengaturan extends CI_Model
{
    private $table            = "setting";

    public function __construct()
    {
        parent::__construct();
    }

    //untuk mendapatkan setting berdasarakan pada namanya
    public function findByName($nama_pengaturan)
    {
        $where=array(
            'nama_pengaturan'=>$nama_pengaturan
        );

        $row=$this->db->get_where('pengaturan', $where)->row();
        return $row;
    }
}
