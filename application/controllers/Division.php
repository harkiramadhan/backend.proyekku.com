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
        $var['role'] = $this->db->get_where('role', ['id' => $role])->row()->role;
        
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

    function action(){
        $iduser = $this->session('iduser');
        $type = $this->input->post('type', TRUE);
        $division = $this->input->post('division', TRUE);
        $id = $this->input->post('id', TRUE);

        if($type == "add"){
            $data = [
                'idpt' => $iduser,
                'division' => $division
            ];

            $this->db->insert('division', $data);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('sukses', "Divisi ".$division." Berhasil Di Tambahkan");
                redirect($_SERVER['HTTP_REFERER']);
            }
        }elseif($type == "edit"){
            $data = [
                'division' => $division
            ];

            $this->db->where('id', $id);
            $this->db->update('division', $data);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('sukses', "Divisi ".$division." Berhasil Di Simpan");
                redirect($_SERVER['HTTP_REFERER']);
            }            
        }elseif($type == "delete"){
            $data = [
                'status' => 'soft_delete'
            ];

            $this->db->where('id', $id);
            $this->db->update('division', $data);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('sukses', "Divisi ".$division." Berhasil Di Hapus");
                redirect($_SERVER['HTTP_REFERER']);
            }   
        }
    }
}