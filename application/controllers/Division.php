<?php
class Division extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_Division');
        if($this->session->userdata('masuk') != TRUE){
            $url = base_url();
            redirect($url, 'refresh');
        }
    }

    function session($sess){
        $get = $this->session->userdata($sess);
        return $get;
    }

    function index(){
        $role = $this->session->userdata('role');

        $var['title'] = "Division";
        $var['username'] = $this->session('username');
        
        if($role == 1){

        }elseif($role == 2){
            $iduser = $this->session('iduser');
            $var['division'] = $this->M_Division->get_all($iduser);
            // $var['user'] = $this->M_User->get_allUserPT($iduser);

            $this->load->view('admin_pt/layout/header', $var);
            $this->load->view('admin_pt/division', $var);
            $this->load->view('admin_pt/layout/footer', $var);   

        }elseif($role == 3){

        }elseif($role == 4){

        }
    }
}