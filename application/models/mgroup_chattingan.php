<?php

class mgroup_chattingan extends CI_Model {

    private $table = "group_chatting";
    private $field_list = array('id_group', 'nama_group', 'foto_group', 'deskripsi_group'
        , 'is_group', 'id_pengirim','id_penerima');
    private $exception_field = array('');
    private $key_user_id = "id_group";

    function __construct() {
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

    function find($query, $result_type, $option = null) {
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

    function create($data) {
        if ($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function update($data, $where) {
        if ($this->db->update($this->table, $data, $where)) {
            return true;
        } else {
            return false;
        }
    }

    function find_group_chat($id_pengirim)
    {
      $sql="SELECT group_chatting.*,
      (SELECT p.nama_pengguna FROM pengguna p where p.id_pengguna=group_chatting.id_penerima) as nama_penerima,
      (SELECT p.foto_profile FROM pengguna p where p.id_pengguna=group_chatting.id_penerima) as foto_penerima,
      (SELECT p.nama_pengguna FROM pengguna p where p.id_pengguna=group_chatting.id_pengirim) as nama_pengirim,
      (SELECT p.foto_profile FROM pengguna p where p.id_pengguna=group_chatting.id_pengirim) as foto_pengirim
      FROM group_chatting  where group_chatting.id_pengirim='".$id_pengirim."' OR group_chatting.id_penerima='".$id_pengirim."' ";
      $result=$this->db->query($sql)->result();
  		return $result;
    }
    function count_group_chat($id_pengirim)
    {
      $sql="SELECT COUNT(c.id_chatting) as not_read FROM group_chatting g, chatting c WHERE g.id_group=c.id_group AND c.id_status_chat IN ('3') AND g.id_pengirim='".$id_pengirim."' OR g.id_penerima='".$id_pengirim."' ";
      $result=$this->db->query($sql)->result();
  		return $result;
    }
    function last_group_chat($id_pengirim,$id_group)
    {
      $sql="SELECT c.isi_chat,c.id_chatting FROM  chatting c WHERE  c.id_group='".$id_group."'";
      $result=$this->db->query($sql)->result();
      return $result;
    }
}

?>
