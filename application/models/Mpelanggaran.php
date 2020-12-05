<?php

class Mpelanggaran extends CI_Model
{
    private $table_pp= "pp";
    private $table_tt= "tt";
    private $field_list = array('ppid', 'userid', 'tg', 'ttid', 'pp');
    private $exception_field = array('');
    private $key_user_id = "ppid";

    public function __construct()
    {
        parent::__construct();
//        $this->load->model('Memail_template');
    }

    /*
      $query = array(
      'id_pengguna' =>  '1'
      )
      $result_type = String
      $option = array()
     */

    public function find($query, $result_type, $option = null)
    {
        $select = "";

        for ($i = 0; $i < count($this->field_list); $i++) {
            if (array_key_exists($this->field_list[$i], $query)) {
                $this->db->where($this->field_list[$i], $query[$this->field_list[$i]]);
            }
        }

        for ($i = 0; $i < count($this->field_list); $i++) {
            if (!in_array($this->field_list[$i], $this->exception_field)) {
                $select.=$this->field_list[$i] . ",";
            }
        }
        $this->db->join($this->table_tt, $this->table_pp . '.ttid = ' . $this->table_tt . '.ttid');
        $this->db->order_by($this->table_pp.".tg",'desc');
        if ($option != null) {
            if (array_key_exists('limit', $option)) {
                $this->db->limit($option['limit']);
            }

            if (array_key_exists('order_by', $option)) {
                $this->db->order_by($option['order_by']['field'], $option['order_by']['option']);
            }
        }

        if ($result_type == "row") {
            return $this->db->get($this->table_pp)->row();
        } else {
            return $this->db->get($this->table_pp)->result();
        }
    }


}
