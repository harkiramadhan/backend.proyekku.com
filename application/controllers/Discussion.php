<?php
class Discussion extends CI_Controller{
    function index(){
        $var['menu'] = "Diskusi";
        $this->load->view('under_maintenance', $var);
    }
}