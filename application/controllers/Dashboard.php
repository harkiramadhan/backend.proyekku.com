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
        $var['role'] = $this->db->get_where('role', ['id' => $role])->row()->role;
        
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
            $iduser = $this->session('iduser');
            $iddiv = $this->session('iddiv');
            $var['user'] = $this->M_User->get_allUserDiv($iddiv)->num_rows();
            $var['userPending'] = $this->M_User->get_userDivPending($iddiv)->num_rows();

            $this->load->view('admin_div/layout/header', $var);
            $this->load->view('admin_div/dashboard', $var);
            $this->load->view('admin_div/layout/footer', $var);   
        }elseif($role == 4){
            $iduser = $this->session('iduser');
            $iddiv = $this->session('iddiv');

            $this->load->view('user/layout/header', $var);
            $this->load->view('user/dashboard', $var);
            $this->load->view('user/layout/footer', $var);   
        }
    }
}