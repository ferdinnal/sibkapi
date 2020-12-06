<?php

class Notifikasi extends CI_Controller
{
    private $arr_result = array();

    private $table                      = "notifikasi";
    private $field_list = array('id_notifikasi', 'timestamp', 'judul', 'pesan'
            , 'userid', 'is_read','usertypeid');
    private $exception_field            = array();
    private $primary_key                = "id_notifikasi";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mnotifikasi');
    }

    public function finds_interval()
    {
        $query  = array();
        $option = array();

        for ($i=0;$i<count($this->field_list);$i++) {
            if (isset($_REQUEST[$this->field_list[$i]])) {
                $query[$this->field_list[$i]]=$this->input->post($this->field_list[$i]);
            }
        }

        if (isset($_POST['where_in'])) {
            $where_in       = $this->input->post('where_in');
            $where_in_value = $this->input->post('where_in_value');
            $option['where_in']=$where_in;
            $option['where_in_value']=$where_in_value;
        }

        if (isset($_POST['limit'])) {
            $limit           = $this->input->post('limit');
            $option['limit'] = $limit;
        }

        if (isset($_POST['page'])) {
            $page            = $this->input->post('page');
            $option['page']  = $page;
        }

        if (isset($_POST['order_by'])) {
            $order_by                       = $this->input->post('order_by');
            $ordering                       = $this->input->post('ordering');
            $option['order_by']['field']    = $order_by;
            $option['order_by']['option']   = $ordering;
        }

        $id_pengguna=$this->input->post('id_pengguna');


        $data_notifikasi = $this->Mnotifikasi->finds_interval($id_pengguna, 'result', $option);

        if (count($data_notifikasi)==0) {
            $this->arr_result = array(
        'prilude' =>  array(
          'status'  =>  'warning',
          'message' =>  'Anda belum memiliki notifikasi terbaru.'
        )
      );
        } else {
            $this->arr_result = array(
        'prilude' =>  array(
          'status'  =>  'success',
          'message' =>  'Notifikasi tersedia',
          'data'    =>  $data_notifikasi
        )
      );
        }

        $this->response($this->arr_result);
    }

    public function update()
      {
          $data  = array();
          $where = array();

          for ($i=0;$i<count($this->field_list);$i++) {
              if (isset($_REQUEST[$this->field_list[$i]])) {
                  $data[$this->field_list[$i]]=$this->input->post($this->field_list[$i]);

                  if ($this->field_list[$i]==$this->primary_key) {
                      $where[$this->field_list[$i]]=$this->input->post($this->field_list[$i]);
                  }
              }
          }

          if (count($where)==0) {
              $this->arr_result = array(
          'prilude' => array(
            'status'  =>  'error',
            'message' =>  'Anda harus mengirim field kunci utama.'
          )
        );
          } else {
              if ($this->Mnotifikasi->update($data, $where)) {
                  $this->arr_result = array(
            'prilude' => array(
              'status'  =>  'success',
              'message' =>  'Data berhasil diperbaharui',
            )
          );
              } else {
                  $this->arr_result = array(
            'prilude' => array(
              'status'  =>  'error',
              'message' =>  'Ada masalah saat melakukan perubahan notifikasi'
            )
          );
              }
          }

          $this->response($this->arr_result);
      }





}
