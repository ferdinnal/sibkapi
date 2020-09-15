<?php

class Mguru extends CI_Model
{
    private $table = "gurudetails";
    private $field_list = array('gurudetailid', 'userid');
    private $exception_field = array('');
    private $key_user_id = "gurudetailid";

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

        $this->db->select($select);
        if ($option != null) {
            if (array_key_exists('limit', $option)) {
                $this->db->limit($option['limit']);
            }

            if (array_key_exists('order_by', $option)) {
                $this->db->order_by($option['order_by']['field'], $option['order_by']['option']);
            }
        }

        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
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
    public function findPelajaran($id_pengguna)
    {
        $sql="SELECT m.* FROM mata_pelajaran m WHERE m.id_guru='".$id_pengguna."' order by nama_mata_pelajaran ASC";

        $result=$this->db->query($sql)->result();

        return $result;
    }
    public function findKelas($id_pengguna, $id_mata_pelajaran)
    {
        $sql="SELECT k.* FROM mata_pelajaran m,kelas k WHERE m.id_guru='".$id_pengguna."' and m.id_mata_pelajaran='".$id_mata_pelajaran."' and m.id_kelas=m.id_kelas order by nama_mata_pelajaran ASC";

        $result=$this->db->query($sql)->result();

        return $result;
    }
}
