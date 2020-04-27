<?php
class Issue extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_Auth');
        $this->load->model('M_User');
        if($this->session->userdata('masuk') != TRUE){
            $url = base_url();
            redirect($url);
        }

    }

    function session($sess){
        $get = $this->session->userdata($sess);
        return $get;
    }

    function table(){
        $idproject = $this->input->get('idproject', TRUE);
        $role = $this->session('role');
        
    }

    function modal(){
        $role = $this->session('role');
        $type = $this->input->get('type', TRUE);
        $idproject = $this->input->get('idproject', TRUE);
        $idtask = $this->input->get('idtask', TRUE);

        if($type == "add"){

        }
    }
}