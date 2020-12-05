<?php
class Mkonseling extends CI_Model
{
    private $table = "konseling";
    private $field_list = array('konid', 'subject', 'tg', 'wk','userid'
            , 'st');
    private $exception_field = array('');

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('Mpengaturan');
    }

    public function find_siswa_all($status,$userid,$result_type, $option = null)
    {
        $select = "";


        $this->db->where_not_in($this->table . '.st', $status);
        $this->db->where($this->table . '.userid', $userid);
        $this->db->order_by($this->table.".konid",'desc');
        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    public function find_siswa_all2($status,$userid,$result_type, $option = null)
    {
        $select = "";


        $this->db->where($this->table . '.st', $status);
        $this->db->where($this->table . '.userid', $userid);
        $this->db->order_by($this->table.".konid",'desc');
        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    function create($data)
{
  if ($this->db->insert($this->table,$data))
  {
    return true;
  }else
  {
    return false;
  }
}
}
