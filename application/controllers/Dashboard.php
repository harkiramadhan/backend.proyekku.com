<?php
class Dashboard extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_Auth');
        $this->load->model('M_User');
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

        $var['title'] = "Dashboard";
        $var['username'] = $this->session('username');
        
        if($role == 1){
            $var['user'] = $this->M_User->get_allUser()->num_rows();
            $var['userPending'] = $this->M_User->get_userPending()->num_rows();

            $this->load->view('admin_super/layout/header', $var);
            $this->load->view('admin_super/dashboard', $var);
            $this->load->view('admin_super/layout/footer', $var);           
        }elseif($role == 2){
            $iduser = $this->session('iduser');
            $var['user'] = $this->M_User->get_allUserPT($iduser)->num_rows();

            $this->load->view('admin_pt/layout/header', $var);
            $this->load->view('admin_pt/dashboard', $var);
            $this->load->view('admin_pt/layout/footer', $var);   
        }elseif($role == 3){

        }elseif($role == 4){

        }
    }
}