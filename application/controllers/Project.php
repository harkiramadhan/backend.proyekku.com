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

    function modal(){
        $iduser = $this->session('iduser');
        $role = $this->session->userdata('role');

        // Data
        $type = $this->input->get('type', TRUE);
        $id = $this->input->get('selectedTaskId', TRUE);
        if($role == 2){
            $getUser = $this->M_User->get_allUserPT($iduser);
            if($type == "detailTask"){
                $getTask = $this->M_Project->get_byIdTask($id);
                if($getTask->num_rows() > 0){
                    $task = $getTask->row();
                    ?>
                        <div class="card-header bg-transparent border-0">
                            <h4 class="mb-0 text-capitalize" id="editTitle">Detail : <strong><?= $task->name ?></strong></h4>
                        </div>
                        <div class="card-body bg-secondary">
                            <div class="form-group">
                                <label for="">Task Name <small class="text-warning"><strong>*</strong></small></label>
                                <input type="text" name="task" class="form-control form-control-alternative form-control-sm" value="<?= $task->name ?>" placeholder="Task Name " required>
                            </div>
                            <div class="form-group">
                                <label for="">PIC <small class="text-warning"><strong>*</strong></small></label>
                                <select name="pic" class="form-control form-control-alternative form-control-sm" required>
                                    <option value="">- Select PIC -</option>
                                    <?php
                                        foreach($getUser->result() as $u){
                                    ?>
                                    <option value="<?= $u->id ?>" <?php if($u->id == $task->pic){echo "selected";} ?>><?= $u->name." - ".$u->username ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Start <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="start" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual Start" value="<?= $task->actualStart ?>" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">End <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="end" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual End" value="<?= $task->actualEnd ?>" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                        </div>
                    <?php
                }else{

                }
            }
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

        echo json_encode($getTask->result());
    }
}