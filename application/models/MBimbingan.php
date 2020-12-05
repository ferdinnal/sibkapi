<?php
class MBimbingan extends CI_Model
{
    private $table = "bimbingan";
    private $field_list = array('bimid', 'subject', 'tg', 'wk'
            , 'st');
    private $exception_field = array('');

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('Mpengaturan');
    }

    public function find_siswa_all($result_type, $option = null)
    {
        $select = "";


        $this->db->order_by($this->table.".bimid",'desc');
        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }

}
