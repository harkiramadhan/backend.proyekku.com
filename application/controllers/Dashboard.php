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
        
        if($role == 1){

        }elseif($role == 2){

        }elseif($role == 3){

        }elseif($role == 4){

        }
    }
}