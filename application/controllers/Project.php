<?php
class Project extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_Auth');
        $this->load->model('M_Project');
        if($this->session->userdata('masuk') != TRUE){
            $url = base_url();
            redirect($url,'refresh');
        }
    }

    function session($sess){
        $get = $this->session->userdata($sess);
        return $get;
    }

    function index(){
        $role = $this->session->userdata('role');

        $var['title'] = "Project";
        $var['username'] = $this->session('username');
        
        if($role == 1){    
        }elseif($role == 2){
            $iduser = $this->session('iduser');

            $this->load->view('admin_pt/layout/header', $var);
            $this->load->view('admin_pt/project', $var);
            $this->load->view('admin_pt/layout/footer', $var);   
        }elseif($role == 3){
            
        }elseif($role == 4){

        }
    }
}