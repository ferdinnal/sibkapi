<?php
class Mfile_materi extends CI_Model
{
    private $table                      = "file_materi";
    private $table_materi                      = "materi";
    private $field_list = array('id_file_materi', 'file', 'jenis_file'
          , 'id_materi','is_selesai','nama_file','id_pengguna');
    private $exception_field = array('');
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpengaturan');
    }

    public function findBySiswaModel($id_materi, $result_type)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table.".*");
        $this->db->where($this->table . '.id_materi', $id_materi);


        if ($result_type == "row") {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get($this->table)->result();
        }
    }
    public function findBySiswaModelId($id_materi,$idPengguna, $result_type)
    {
        $select = "";

        $is_semester=$this->Mpengaturan->findByName('IS_SEMESTER')->nilai_pengaturan;

        $this->db->select($this->table.".*");
        $this->db->where($this->table . '.id_materi', $id_materi);
        $this->db->where($this->table . '.id_pengguna', $idPengguna);


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
}
