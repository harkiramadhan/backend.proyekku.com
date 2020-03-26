<?php
class User extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_Auth');
        $this->load->model('M_User');

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

        $var['title'] = "User";
        
        if($role == 1){
            $var['user'] = $this->M_User->get_allUser();

            $this->load->view('admin_super/layout/header', $var);
            $this->load->view('admin_super/user', $var);
            $this->load->view('admin_super/layout/footer', $var);           
        }elseif($role == 2){

        }elseif($role == 3){

        }elseif($role == 4){

        }
    }

    function action(){
        $role = $this->session->userdata('role');
        $type = $this->input->post('type', TRUE);
        $iduser = $this->input->post('iduser', TRUE);
        $username = $this->input->post('username', TRUE);

        if($role == 1){
            if($type == "active"){
                $data = [
                    'status' => "active"
                ];
                $this->db->where('id', $iduser);
                $this->db->update('user', $data);

                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sukses', "User ".$username." Berhasil Di Aktifkan");
                    redirect('user');
                }
            }elseif($type == "non"){
                $data = [
                    'status' => ""
                ];
                $this->db->where('id', $iduser);
                $this->db->update('user', $data);

                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sukses', "User ".$username." Berhasil Di Non Aktifkan");
                    redirect('user');
                }
            }



        }elseif($role == 2){

        }elseif($role == 3){

        }elseif($role == 4){

        }
    }
}