<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mnotifikasi extends CI_Model
{
    private $table              = "notifikasi";
    private $table_intent       = "intent";
    private $key_intent_id      = "intent_id";
    private $field_list         = array('id_notifikasi', 'timestamp', 'title', 'message'
                                  , 'id_pengguna', 'is_read','extra','intent_id','aplikasi_id');
    private $exception_field    = array('');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpengaturan');
    }

    //untuk mendaptakan data notifikasi
    public function finds_interval($id_pengguna, $aplikasi_id, $result_type, $option=null)
    {
        $select = "";

        for ($i=0;$i<count($this->field_list);$i++) {
            if (!in_array($this->field_list[$i], $this->exception_field)) {
                $select.=$this->table.".".$this->field_list[$i].",";
            }
        }
        $beforeTime = date("Y-m-d h:i:s", strtotime("-60 minutes"));

        $this->db->select($select);
        $this->db->select($this->table_intent.".aplikasi_id");
        $this->db->where($this->table . '.timestamp  >=', $beforeTime);
        $this->db->where($this->table . '.id_pengguna ', $id_pengguna);
        $this->db->where($this->table . '.aplikasi_id ', $aplikasi_id);
        $this->db->where_in('is_read', ['0','1']);
        $this->db->join($this->table_intent, $this->table."."
                  .$this->key_intent_id."="
                  .$this->table_intent.".".$this->key_intent_id, 'left');

        if ($option!=null) {
            if (array_key_exists('limit', $option)) {
                $this->db->limit($option['limit']);
            }

            if (array_key_exists('order_by', $option)) {
                $this->db->order_by($option['order_by']['field'], $option['order_by']['option']);
            }

            if (array_key_exists('where_in', $option)) {
                $where_in_field = explode(',', $option['where_in_value']);
                $this->db->where_in($option['where_in'], $where_in_field);
            }

            if (array_key_exists('page', $option)) {
                $page = $option['page']*$option['limit'];
                $this->db->limit($option['limit'], $page);
            }
        }


        if ($result_type=="row") {
            $hasil=$this->db->get($this->table)->row();
            return $hasil;
        } else {
            $hasil=$this->db->get($this->table)->result();
            $new_hasil=array();
            $new_data=array();
            foreach ($hasil as $hasil) {
                $new_hasil['id_notifikasi']=$hasil->id_notifikasi;
                $new_hasil['id_pengguna']=$hasil->id_pengguna;
                $new_hasil['is_read']=$hasil->is_read;
                $new_hasil['aplikasi_id']=$hasil->aplikasi_id;
                $new_hasil['intent_id']=$hasil->intent_id;
                $new_hasil['timestamp']=$hasil->timestamp;
                $new_hasil['title']=$hasil->title;
                $new_hasil['message']=$hasil->message;
                $new_hasil['extra']=$hasil->extra;
                array_push($new_data, $new_hasil);
            }
            return $new_data;
        }
    }
    //untuk mendaptakan data notifikasi
    public function finds($query, $result_type, $option=null)
    {
        $select = "";

        $select = "";

        for ($i=0;$i<count($this->field_list);$i++)
        {
          if (array_key_exists($this->field_list[$i],$query))
          {
            $this->db->where($this->table.".".$this->field_list[$i],$query[$this->field_list[$i]]);
          }
        }

        for ($i=0;$i<count($this->field_list);$i++)
        {
          if (!in_array($this->field_list[$i],$this->exception_field))
          {
            $select.=$this->table.".".$this->field_list[$i].",";
          }
        }

        $this->db->select($select);
        $this->db->select($this->table_intent.".aplikasi_id");
        $this->db->join($this->table_intent, $this->table."."
                  .$this->key_intent_id."="
                  .$this->table_intent.".".$this->key_intent_id, 'left');

        if ($option!=null) {
            if (array_key_exists('limit', $option)) {
                $this->db->limit($option['limit']);
            }

            if (array_key_exists('order_by', $option)) {
                $this->db->order_by($option['order_by']['field'], $option['order_by']['option']);
            }


            if (array_key_exists('page', $option)) {
                $page = $option['page']*$option['limit'];
                $this->db->limit($option['limit'], $page);
            }
        }


        if ($result_type=="row") {
            $hasil=$this->db->get($this->table)->row();
            return $hasil;
        } else {
            $hasil=$this->db->get($this->table)->result();
            $new_hasil=array();
            $new_data=array();
            foreach ($hasil as $hasil) {
                $new_hasil['id_notifikasi']=$hasil->id_notifikasi;
                $new_hasil['id_pengguna']=$hasil->id_pengguna;
                $new_hasil['is_read']=$hasil->is_read;
                $new_hasil['aplikasi_id']=$hasil->aplikasi_id;
                $new_hasil['intent_id']=$hasil->intent_id;
                $new_hasil['timestamp']=$hasil->timestamp;
                $new_hasil['title']=$hasil->title;
                $new_hasil['message']=$hasil->message;
                $new_hasil['extra']=$hasil->extra;
                array_push($new_data, $new_hasil);
            }
            return $new_data;
        }
    }
    public function create($data)
    {
        if ($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data, $where)
    {
        if ($this->db->update($this->table, $data, $where)) {
            return true;
        } else {
            return false;
        }
    }
}
