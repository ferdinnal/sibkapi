<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mnotifikasi extends CI_Model
{
    private $table              = "notifikasi";

    private $field_list = array('id_notifikasi', 'timestamp', 'judul', 'pesan'
            , 'userid', 'is_read','usertypeid');
    private $exception_field    = array('');

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");


    }

    //untuk mendaptakan data notifikasi
    public function finds_interval($id_pengguna, $result_type, $option=null)
    {
        $select = "";

        for ($i=0;$i<count($this->field_list);$i++) {
            if (!in_array($this->field_list[$i], $this->exception_field)) {
                $select.=$this->table.".".$this->field_list[$i].",";
            }
        }
        $beforeTime = date("Y-m-d h:i:s", strtotime("-60 minutes"));

        $this->db->select($select);
        $this->db->where($this->table . '.timestamp  >=', $beforeTime);
        $this->db->where($this->table . '.userid ', $id_pengguna);
        $this->db->where($this->table . '.is_read ', 0);

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
          return $hasil;
        }
    }
    public function finds($query, $result_type, $option=null)
      {
          $select = "";

          $select = "";

          for ($i=0;$i<count($this->field_list);$i++) {
              if (array_key_exists($this->field_list[$i], $query)) {
                  $this->db->where($this->table.".".$this->field_list[$i], $query[$this->field_list[$i]]);
              }
          }

          for ($i=0;$i<count($this->field_list);$i++) {
              if (!in_array($this->field_list[$i], $this->exception_field)) {
                  $select.=$this->table.".".$this->field_list[$i].",";
              }
          }

          $this->db->select($select);
          $this->db->where($this->table . '.timestamp  >=', $beforeTime);
          $this->db->where($this->table . '.userid ', $id_pengguna);

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
            return $hasil;
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
