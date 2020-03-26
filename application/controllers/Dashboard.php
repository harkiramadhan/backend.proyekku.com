<?php
class Dashboard extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_Auth');
        if($this->session->userdata('masuk') != TRUE){
            $url = base_url();
            redirect('$url','refresh');
        }
    }

    function session($sess){
        $get = $this->session->userdata($sess);
        return $get;
    }

    function index(){
        $role = $this->session->userdata('role');

        $var['title'] = "Dashboard";
        
        if($role == 1){

            $this->load->view('admin_super/layout/header', $var);
            $this->load->view('admin_super/dashboard', $var);
            $this->load->view('admin_super/layout/footer', $var);           
        }elseif($role == 2){

        }elseif($role == 3){

        }elseif($role == 4){

        }
    }
}