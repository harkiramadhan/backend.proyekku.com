<?php
class Login extends CI_Controller{

  function __construct(){
    parent::__construct();
    $this->load->model('M_Auth');
  }

  function index(){
    $var['title'] = "Login";
    $this->load->view('login', $var);
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
        $this->session->set_flashdata('msg', "User Yang Anda Masukkan Tidak/Belum Aktif");
        redirect('login');
      }
      
    }else{
      $this->session->set_flashdata('msg', "Email atau Password Salah");
      redirect('login');
    }
  }

  function register(){
    $var['title'] = "Register";
    $this->load->view('register_form', $var);
  }

  function register_submit(){
    $text = $this->input->post('text', TRUE);
    $name = $this->input->post('name', TRUE);
    $username = $this->input->post('email', TRUE);
    $password = $this->input->post('password', TRUE);
    $agree = $this->input->post('agree', TRUE);

    if($text == NULL){
      if($agree == "on"){
        if($name == TRUE && $username == TRUE && $password == TRUE){
          $cek = $this->M_Auth->cek_user($username);
          if($cek->num_rows() > 0){
            $this->session->set_flashdata('msg', "The Email You Entered Already Exists");
            redirect($_SERVER['HTTP_REFERER']);
          }else{
            $data = [
              'name' => $name,
              'username' => $username,
              'password' => md5($password),
              'status' => 'pending',
              'idrole' => 2
            ];
  
            $this->db->insert('user', $data);
  
            if($this->db->affected_rows() > 0){
              $this->session->set_flashdata('msg', "Please Wait For Approval");
              redirect($_SERVER['HTTP_REFERER']);
            }
          }
        }else{
          $this->session->set_flashdata('msg', "Please Complete The Form");
          redirect($_SERVER['HTTP_REFERER']);
        }
      }else{
        $this->session->set_flashdata('msg', "Please Check The Agreement");
        redirect($_SERVER['HTTP_REFERER']);
      }
    }else{
      redirect($_SERVER['HTTP_REFERER']);
    }
  }

  function logout(){
    $this->session->sess_destroy();
    $url = base_url();
    redirect($url);
  }
}
