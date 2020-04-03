<?php
class Project extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_Auth');
        $this->load->model('M_User');
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

    function detail($idproject){
        $role = $this->session->userdata('role');

        $var['title'] = "Project";
        $var['username'] = $this->session('username');
    
        if($role == 2){
            $iduser = $this->session('iduser');
            $var['project'] = $this->M_Project->get_byId($idproject);
            $var['getUser'] = $this->M_User->get_allUserPT($iduser);
            $var['task'] = $this->M_Project->get_taskByIdProject($idproject, $iduser);
 
            $this->load->view('admin_pt/layout/header', $var);
            $this->load->view('admin_pt/project', $var);
            $this->load->view('admin_pt/layout/footer', $var);   
        }elseif($role == 3){
            
        }elseif($role == 4){

        }else{
            $url = base_url();
            redirect($url, 'refresh');
        }
    }

    function action(){
        $type = $this->input->post('type', TRUE);
        $iduser = $this->session('iduser');
        $role = $this->session('role');

        if($role == 2){
            if($type == "add"){
                $data = [
                    'idpt' => $iduser,
                    'iddiv' => $this->input->post('iddiv', TRUE),
                    'project_name' => $this->input->post('project_name', TRUE)
                ];
                $this->db->insert('project', $data);
    
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sukses', "Project ".$this->input->post('project_name', TRUE)." Berhasil Di Tambahkan");
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }elseif($type == "addTask"){
                $data = [
                    'idpt' => $iduser,
                    'iddiv' => $this->input->post('iddiv', TRUE),
                    'idproject' => $this->input->post('idproject', TRUE),
                    'name' => $this->input->post('task', TRUE),
                    'pic' => $this->input->post('pic', TRUE),
                    'actualStart' => $this->input->post('start', TRUE),
                    'actualEnd' => $this->input->post('end', TRUE)
                ];

                $this->db->insert('task', $data);

                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sukses', "Task ".$this->input->post('task', TRUE)." Berhasil Di Tambahkan");
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }elseif($type == "editTask"){
                $iidtask = $this->input->post('idtask', TRUE);
                $data = [
                    'name' => $this->input->post('task', TRUE),
                    'pic' => $this->input->post('pic', TRUE),
                    'actualStart' => $this->input->post('start', TRUE),
                    'actualEnd' => $this->input->post('end', TRUE)
                ];
                $this->db->where('id', $iidtask);
                $this->db->update('task', $data);

                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sukses', "Task ".$this->input->post('task', TRUE)." Berhasil Di Simpan");
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }elseif($type == "delTask"){
                $iidtask = $this->input->post('idtask', TRUE);
                $this->db->where('id', $iidtask);
                $this->db->delete('task');

                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sukses', "Task ".$this->input->post('task', TRUE)." Berhasil Di Hapus");
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }
    }

    function get($q){
        $iduser = $this->session('iduser');
        $role = $this->session('role');

        // Data
        $explode = explode("_", $q);
        $idproject = $explode[0];
        $iddiv = $explode[1];
        $idpt = $explode[2];

        if($role == 2){
            $getTask = $this->M_Project->get_taskByIdProject($idproject, $idpt);
        }

        // $query = $this->db->query("SELECT * FROM anygantt_db.tasks");
        // // print_r($query->result());
        // // while ($tasks[] = $query->result()) {}

        // // // remove last null
        // // array_pop($tasks);
        echo json_encode($getTask->result());
        // // mysqli_free_result($result);
    }
}