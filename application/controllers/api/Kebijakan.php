<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kebijakan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mpengaturan');
  }

  function by_name($setting_name)
  {
    $setting=$this->Mpengaturan->findByName($setting_name);
    print $setting->nilai_pengaturan;
  }
}
?>
