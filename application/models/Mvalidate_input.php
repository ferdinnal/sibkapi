<?php
/*
Kelas untuk melaukan beberapa validasi
*/

class Mvalidate_input extends CI_Model
{
    private $arr_result = array();
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpengaturan');
        $this->load->model('Mpengguna');
    }

    //validasi yang berhubungan dengan minimum input
    public function min_input($setting_name, $input_value)
    {
        $data_setting = $this->Mpengaturan->findByName($setting_name);

        if (count($data_setting)==0) {
            $this->arr_result = array(
        'status'  => 'error',
        'message' => 'Nilai '.$setting_name." tidak tersedia."
      );
        } else {
            if (!is_numeric($data_setting->setting_value)) {
                $this->arr_result = array(
          'status'  => 'error',
          'message' => 'Nilai pada setting '.$setting_name." bukan bernilai integer."
        );
            } else {
                if ($data_setting->setting_value>$input_value) {
                    $this->arr_result = array(
            'status'  => 'error',
            'message' => 'Nilai harus lebih besar dari '.$data_setting->setting_value
          );
                } else {
                    $this->arr_result = array(
            'status'  => 'success'
          );
                }
            }
        }

        return $this->arr_result;
    }

    //melakukan validasi terhadap data user
    public function user($user_id)
    {
        $query     = array(
      'user_id' => $user_id
    );

        $data_user = $this->Mpengguna->find($query, 'row');

        if (count($data_user)==0) {
            $this->arr_result = array(
        'status'  => 'error',
        'message' => 'Data pengguna tidak tersedia, silakan kirim ID penggun valid.'
      );
        } else {
            switch ($data_user->join_status_id) {
          case '3':
              $this->arr_result = array(
                'status'  => 'error',
                'message' => 'Keanggotaan Anda sedang disuspend'
              );
            break;
          case '4':
            $this->arr_result = array(
              'status'  => 'error',
              'message' => 'Akun Anda telah dihapus dari database kami.'
            );
            break;
          default:
            $this->arr_result = array(
              'status'  => 'success'
                      );
            break;
      }
        }

        return $this->arr_result;
    }

    /*validasi saldo pengguna
    user_id => ID pengugna yang akan di cek
    require_amount => jumlah saldo yang diminta
    */
    public function balance_amount($user_id, $require_amount)
    {
        //cek apakah saldo-nya mencukupi atau tidak
        $query_balance = array(
                      'user_id' => $user_id
                    );

        // $user_balance = $this->Mpengguna_balance->find($query_balance,'row');
        //
        // if (count($user_balance)==0)
        // {
        //   $this->arr_result = array(
        //     'status'  => 'error',
        //     'message' => 'Saldo Anda tidak mencukupi untuk melakukan transaksi ini'
        //   );
        // }else
        // {
        if ($user_balance->amount<$require_amount) {
            $this->arr_result = array(
          'status'  => 'error',
          'message' => 'Saldo Anda tidak mencukupi untuk melakukan transaksi ini'
        );
        } else {
            $this->arr_result = array(
          'status'  => 'success',
          'message' => 'Saldo mencukupi untuk transaksi ini.'
        );
        }
        // }

        return $this->arr_result;
    }
}
