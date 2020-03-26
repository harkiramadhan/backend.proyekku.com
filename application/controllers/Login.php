<?php
class Login extends CI_Controller{

  function __construct(){
    parent::__construct();
    $this->load->model('M_Auth');
  }

  function index(){
    $this->load->view('login');
  }

  function auth(){
    $username = $this->input->post('username', TRUE);
    $password = $this->input->post('password', TRUE);

    $cek = $this->M_Auth->userLogin($username, $password);

    if($cek->num_rows() > 0){
      $data = $cek->row();

      if($data->status == "active"){
        $this->session->set_userdata('masuk', TRUE);
        $this->session->set_userdata('role', $data->idrole);
        $this->session->set_userdata('username', $data->username);

        
        redirect('dashboard','refresh');
      }else{
        $this->session->set_flashdata('error', "User Yang Anda Masukkan Tidak/Belum Aktif");
        redirect('login');
      }
      
    }else{
      $this->session->set_flashdata('error', "Email atau Password Salah");
      redirect('login');
    }
  }

  function logout(){
    $this->session->sess_destroy();
    $url = base_url();
    redirect($url);
  }
}
