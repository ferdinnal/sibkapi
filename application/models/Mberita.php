<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mberita extends CI_Model
{
    private $table      = "berita";
    private $arr_result = array();
    private $field_list = array('id_berita', 'image_url', 'title', 'content'
            , 'date_created', 'is_active', 'id_pengguna_type');

    public function __construct()
    {
        parent::__construct();
    }

    //mendaptakan semua data produk tanpa filter apapun.
    public function findAll()
    {
        return $this->db->get('informasi')->result();
    }
    /*
    Untuk melakukan pencarian data product
     */
    public function finds($id_pengguna_type,$keyword, $option)
    {
        $this->db->select($this->table . '.*');

        $this->db->where($this->table . '.is_active', '1');
        $this->db->where($this->table . '.id_pengguna_type', $id_pengguna_type);

        if (trim($keyword) != "") {
            $this->db->like('title', $keyword);
        }


        if (array_key_exists('order', $option)) {
            $this->db->order_by($this->table . "." . $option['order']['order_by'], $option['order']['ordering']);
        }

        if ($option != null) {
            if (array_key_exists('limit', $option)) {
                $this->db->limit($this->table . "." . $option['limit']);
            }

            if (array_key_exists('order_by', $option)) {
                $this->db->order_by($this->table . "." . $option['order_by']['field'], $option['order_by']['option']);
            }

            if (array_key_exists('page', $option)) {
                $page = $option['page'] * $option['limit'];
                $this->db->limit($option['limit'], $page);
            }

            if (array_key_exists('where_in', $option)) {
                $this->db->where_in($this->table . '.' . $option['where_in']['field'], $option['where_in']['option']);
            }

            if (array_key_exists('where_not_in', $option)) {
                $this->db->where_not_in($this->table . '.' . $option['where_not_in']['field'], $option['where_not_in']['option']);
            }
        }


        $data_product = $this->db->get($this->table)->result();

        //array_push($data_product,$data_image);
        //return $data_image;
        return $data_product;
    }




}
