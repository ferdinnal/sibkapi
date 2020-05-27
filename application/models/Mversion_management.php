<?php
class Mversion_management extends CI_Model
{
    private $table = "manajemen_versi";
    private $arr_result = array();
    private $field_list = array('id_manajemen_versi', 'kode_versi', 'nama_versi', 'judul_notifikasi'
                    , 'changelog', 'tanggal_rilis','url_to_update','is_urgent','aplikasi_id');
    private $exception_field = array('');
    public function __construct()
    {
        parent::__construct();
    }

    public function isNeedUpdate($aplikasi_id, $result_type, $option = null)
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
        $this->db->order_by('id_manajemen_versi', 'DESC');
        $this->db->limit('1');
        $this->db->where($this->table . '.aplikasi_id', $aplikasi_id);

        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    //untuk mendaptkaan informasi tentang changelog
    public function findCurrentRelease()
    {
        $sql="select*from version_management order by id desc limit 1";
        $result=$this->db->query($sql)->result();
        return $result;
    }
}
