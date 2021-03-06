<?php
class Mversion_management extends CI_Model
{
    private $table = "manajemen_versi";
    private $arr_result = array();
    private $field_list = array('id_manajemen_versi', 'kode_versi', 'nama_versi', 'judul_notifikasi'
                    , 'changelog', 'tanggal_rilis','url_to_update','is_urgent');
    private $exception_field = array('');
    public function __construct()
    {
        parent::__construct();
    }

    public function isNeedUpdate($result_type, $option = null)
    {
        $select = "";

        $this->db->select($select);
        $this->db->order_by('id_manajemen_versi', 'DESC');
        $this->db->limit('1');

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
