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
    function index(){
        $this->output->enable_profiler(TRUE);
        
    }
}