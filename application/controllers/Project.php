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
            $var['task'] = $this->M_Project->get_taskByIdProject($idproject, $iduser);
            
            $project = $var['project'];
            $var['getUser'] = $this->M_User->get_allUserDiv($project->iddiv);
            
            $this->load->view('admin_pt/layout/header', $var);
            $this->load->view('admin_pt/project', $var);
            $this->load->view('admin_pt/layout/footer', $var);   
        }elseif($role == 3){
            $iddiv = $this->session('iddiv');
            $idpt = $this->session('idpt');

            $var['project'] = $this->M_Project->get_byId($idproject);
            $var['getUser'] = $this->M_User->get_allUserDiv($iddiv);
            $var['task'] = $this->M_Project->get_taskByIdProjectDiv($idproject, $idpt, $iddiv);
 
            $this->load->view('admin_div/layout/header', $var);
            $this->load->view('admin_div/project', $var);
            $this->load->view('admin_div/layout/footer', $var);   
        }elseif($role == 4){
            $iduser = $this->session('iduser');
            $idpt = $this->session('idpt');

            $var['project'] = $this->M_Project->get_byId($idproject);
            $var['task'] = $this->M_Project->get_taskByIdProjectUser($idproject, $idpt, $iduser);
            
            $this->load->view('user/layout/header', $var);
            $this->load->view('user/project', $var);
            $this->load->view('user/layout/footer', $var);   
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
                        <div class="card-header bg-transparent border-0 pb-2">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="mb-0 text-capitalize" id="editTitle">Detail : <strong><?= $task->name ?></strong> &nbsp;
                                        <?php if($task->status == ""): ?>
                                            <span class="badge badge-info">On Schedule</span>
                                        <?php elseif($task->status == "Done"): ?>
                                            <span class="badge badge-success"><?= $task->status ?></span>
                                        <?php elseif($task->status == "Pending"): ?>
                                            <span class="badge badge-warning"><?= $task->status ?></span>
                                        <?php endif; ?>
                                    </h4>
                                    <div class="btn-group">
                                        <?php if($task->status == "Pending"): ?>
                                            <button class="btn mt-1 btn-sm btn-default mark" data-type="markUnPending"><i class="fas fa-clock"></i> &nbsp;Remove Mark Pending</button>
                                            <button class="btn mt-1 btn-sm btn-success ml-1 mark" data-type="markDone"><i class="fas fa-check-circle"></i> &nbsp;Mark As Done</button>
                                        <?php elseif($task->status == "Done"): ?>
                                            <button class="btn mt-1 btn-sm btn-default mark" data-type="markPending"><i class="fas fa-clock"></i> &nbsp;Mark As Pending</button>
                                            <button class="btn mt-1 btn-sm btn-success ml-1 mark" data-type="markUnDone"><i class="fas fa-check-circle"></i> &nbsp;Remove Mark Done</button>
                                        <?php else: ?>
                                            <button class="btn mt-1 btn-sm btn-default mark" data-type="markPending"><i class="fas fa-clock"></i> &nbsp;Mark As Pending</button>
                                            <button class="btn mt-1 btn-sm btn-success ml-1 mark" data-type="markDone"><i class="fas fa-check-circle"></i> &nbsp;Mark As Done</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-2 p-0 text-center mt-2">
                                    <span><strong><?= $task->progressValue ?></strong></span>
                                </div>
                                <div class="col-10 mt-3 p-0">
                                    <div class="progress">
                                        <div class="progress-bar <?php if($task->status == "pending"){echo "bg-warning";}elseif($task->status == "done"){echo "bg-success";}else{echo "bg-info";} ?>" role="progressbar" aria-valuenow="<?= $task->progressValue ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $task->progressValue ?>;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="<?= site_url('project/action') ?>" method="post">
                        <input type="hidden" name="type" value="editTask">
                        <input type="hidden" name="idtask" value="<?= $task->id ?>">
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
                                    <input name="start" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual Start" value="<?= $task->actualStart ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">End <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="end" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual End" value="<?= $task->actualEnd ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Progress <small class="text-warning"><strong>*</strong></small></label>
                                <select name="progressValue" class="form-control form-control-alternative form-control-sm">
                                    <option value="0%" <?php if($task->progressValue == "0%"){echo "selected";} ?>>0%</option>
                                    <option value="10%" <?php if($task->progressValue == "10%"){echo "selected";} ?>>10%</option>
                                    <option value="20%" <?php if($task->progressValue == "20%"){echo "selected";} ?>>20%</option>
                                    <option value="30%" <?php if($task->progressValue == "30%"){echo "selected";} ?>>30%</option>
                                    <option value="40%" <?php if($task->progressValue == "40%"){echo "selected";} ?>>40%</option>
                                    <option value="50%" <?php if($task->progressValue == "50%"){echo "selected";} ?>>50%</option>
                                    <option value="60%" <?php if($task->progressValue == "60%"){echo "selected";} ?>>60%</option>
                                    <option value="70%" <?php if($task->progressValue == "70%"){echo "selected";} ?>>70%</option>
                                    <option value="80%" <?php if($task->progressValue == "80%"){echo "selected";} ?>>80%</option>
                                    <option value="90%" <?php if($task->progressValue == "90%"){echo "selected";} ?>>90%</option>
                                    <option value="100%" <?php if($task->progressValue == "100%"){echo "selected";} ?>>100%</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save"></i> &nbsp; Save</button>
                                </form>
                                <button type="button" class="btn btn-sm btn-primary mx-1 addSubTask"><i class="fas fa-plus-circle"></i> &nbsp; Add Sub Task</button>
                            </div>
                            <div class="btn-group">
                                <form action="<?= site_url('project/action') ?>" method="post">
                                    <input type="hidden" name="type" value="delTask">
                                    <input type="hidden" name="idtask" value="<?= $task->id ?>">
                                    <button type="submit" class="btn btn-sm btn-danger ml-1"><i class="fas fa-trash"></i> Remove</button>
                                </form>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $('.mark').click(function(){
                                var type = "mark";
                                var dataType = $(this).attr('data-type');
                                var selectedTaskId = <?= $task->id ?>;

                                $.ajax({
                                    url: '<?= site_url('project/action') ?>',
                                    type: 'post',
                                    data: {type : type, selectedTaskId : selectedTaskId, dataType : dataType},
                                    success: function(){
                                        var type = "detailTask";
                                        $.ajax({
                                            url:  "<?= site_url('project/modal') ?>",
                                            type: 'get',
                                            data: {selectedTaskId : selectedTaskId, type : type},
                                            success: function(data){
                                                $('.isiDetailTask').html(data);   
                                            }
                                        });
                                    }
                                });
                            });
                            $('.addSubTask').click(function(){
                                var type = "addSubTask";
                                var selectedTaskId = <?= $task->id ?>;
                                $.ajax({
                                    url: '<?= site_url('project/modal') ?>',
                                    type: 'get',
                                    data: {type : type, selectedTaskId : selectedTaskId},
                                    beforeSend: function(){

                                    },
                                    success: function(data){
                                        $('.isiDetailTask').html(data);
                                    }
                                });
                            });
                            $(function() {
                                $('.datetimepicker').datetimepicker({
                                    format: 'YYYY-MM-DD HH:mm',
                                    // format: 'MM-DD-YYYY',
                                    icons: {
                                    time: "fa fa-clock",
                                    date: "fa fa-calendar-day",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
                                    },
                                    minDate: '<?= date('m-d-Y', strtotime($task->project_start)) ?>',
                                    maxDate: '<?= date('m-d-Y', strtotime("1 day", strtotime($task->project_end)) ) ?>'
                                });
                            });
                        </script>
                    <?php
                }
            }elseif($type == "addSubTask"){
                $getTask = $this->M_Project->get_byIdTask($id);
                if($getTask->num_rows() > 0){
                    $task = $getTask->row();
                    ?>
                        <div class="card-header bg-transparent border-0">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="mb-0 text-capitalize" id="editTitle">Add Sub Task : <strong><?= $task->name ?></strong></h4>
                                </div>
                            </div>
                        </div>
                        <form action="<?= site_url('project/action') ?>" method="post">
                        <input type="hidden" name="type" value="addTask">
                        <input type="hidden" name="parent" value="<?= $task->id ?>">
                        <input type="hidden" name="iddiv" value="<?= $task->iddiv ?>">
                        <input type="hidden" name="idproject" value="<?= $task->idproject ?>">

                        <div class="card-body bg-secondary">
                            <div class="form-group">
                                <label for="">Task Name <small class="text-warning"><strong>*</strong></small></label>
                                <input type="text" name="task" class="form-control form-control-alternative form-control-sm" placeholder="Task Name " required>
                            </div>
                            <div class="form-group">
                                <label for="">PIC <small class="text-warning"><strong>*</strong></small></label>
                                <select name="pic" class="form-control form-control-alternative form-control-sm" required>
                                    <option value="">- Select PIC -</option>
                                    <?php
                                        foreach($getUser->result() as $u){
                                    ?>
                                    <option value="<?= $u->id ?>"><?= $u->name." - ".$u->username ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Start <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="start" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual Start" value="<?= $task->actualStart ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">End <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="end" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual End" value="<?= $task->actualEnd ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Progress <small class="text-warning"><strong>*</strong></small></label>
                                <select name="progressValue" class="form-control form-control-alternative form-control-sm">
                                    <option value="0%">0%</option>
                                    <option value="10%">10%</option>
                                    <option value="20%">20%</option>
                                    <option value="30%">30%</option>
                                    <option value="40%">40%</option>
                                    <option value="50%">50%</option>
                                    <option value="60%">60%</option>
                                    <option value="70%">70%</option>
                                    <option value="80%">80%</option>
                                    <option value="90%">90%</option>
                                    <option value="100%">100%</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save"></i> &nbsp; Save Sub Task</button>
                                </form>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $('.addSubTask').click(function(){
                                var type = "addSubTask";
                                var selectedTaskId = <?= $task->id ?>;
                                $.ajax({
                                    url: '<?= site_url('project/modal') ?>',
                                    type: 'get',
                                    data: {type : type, selectedTaskId : selectedTaskId},
                                    beforeSend: function(){

                                    },
                                    success: function(data){
                                        $('.isiDetailTask').html(data);
                                    }
                                });
                            });
                            $(function() {
                                $('.datetimepicker').datetimepicker({
                                    format: 'YYYY-MM-DD HH:mm',
                                    // format: 'MM-DD-YYYY',
                                    icons: {
                                    time: "fa fa-clock",
                                    date: "fa fa-calendar-day",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
                                    },
                                    minDate: '<?= date('m-d-Y', strtotime($task->project_start)) ?>',
                                    maxDate: '<?= date('m-d-Y', strtotime("1 day", strtotime($task->project_end)) ) ?>'
                                });
                            });
                        </script>
                    <?php
                }else{
                    echo " TEST";
                }
            }
        }elseif($role == 3){
            $idpt = $this->session('idpt');
            $iddiv = $this->session('iddiv');
            $getUser = $this->M_User->get_allUserDiv($iddiv);
            if($type == "detailTask"){
                $getTask = $this->M_Project->get_byIdTask($id);
                if($getTask->num_rows() > 0){
                    $task = $getTask->row();
                    ?>
                        <div class="card-header bg-transparent border-0 pb-2">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="mb-0 text-capitalize" id="editTitle">Detail : <strong><?= $task->name ?></strong> &nbsp;
                                        <?php if($task->status == ""): ?>
                                            <span class="badge badge-info">On Schedule</span>
                                        <?php elseif($task->status == "Done"): ?>
                                            <span class="badge badge-success"><?= $task->status ?></span>
                                        <?php elseif($task->status == "Pending"): ?>
                                            <span class="badge badge-warning"><?= $task->status ?></span>
                                        <?php endif; ?>
                                    </h4>
                                    <div class="btn-group">
                                        <?php if($task->status == "Pending"): ?>
                                            <button class="btn mt-1 btn-sm btn-default mark" data-type="markUnPending"><i class="fas fa-clock"></i> &nbsp;Remove Mark Pending</button>
                                            <button class="btn mt-1 btn-sm btn-success ml-1 mark" data-type="markDone"><i class="fas fa-check-circle"></i> &nbsp;Mark As Done</button>
                                        <?php elseif($task->status == "Done"): ?>
                                            <button class="btn mt-1 btn-sm btn-default mark" data-type="markPending"><i class="fas fa-clock"></i> &nbsp;Mark As Pending</button>
                                            <button class="btn mt-1 btn-sm btn-success ml-1 mark" data-type="markUnDone"><i class="fas fa-check-circle"></i> &nbsp;Remove Mark Done</button>
                                        <?php else: ?>
                                            <button class="btn mt-1 btn-sm btn-default mark" data-type="markPending"><i class="fas fa-clock"></i> &nbsp;Mark As Pending</button>
                                            <button class="btn mt-1 btn-sm btn-success ml-1 mark" data-type="markDone"><i class="fas fa-check-circle"></i> &nbsp;Mark As Done</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-2 p-0 text-center mt-2">
                                    <span><strong><?= $task->progressValue ?></strong></span>
                                </div>
                                <div class="col-10 mt-3 p-0">
                                    <div class="progress">
                                        <div class="progress-bar <?php if($task->status == "pending"){echo "bg-warning";}elseif($task->status == "done"){echo "bg-success";}else{echo "bg-info";} ?>" role="progressbar" aria-valuenow="<?= $task->progressValue ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $task->progressValue ?>;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="<?= site_url('project/action') ?>" method="post">
                        <input type="hidden" name="type" value="editTask">
                        <input type="hidden" name="idtask" value="<?= $task->id ?>">
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
                                    <input name="start" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual Start" value="<?= $task->actualStart ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">End <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="end" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual End" value="<?= $task->actualEnd ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Progress <small class="text-warning"><strong>*</strong></small></label>
                                <select name="progressValue" class="form-control form-control-alternative form-control-sm">
                                    <option value="0%" <?php if($task->progressValue == "0%"){echo "selected";} ?>>0%</option>
                                    <option value="10%" <?php if($task->progressValue == "10%"){echo "selected";} ?>>10%</option>
                                    <option value="20%" <?php if($task->progressValue == "20%"){echo "selected";} ?>>20%</option>
                                    <option value="30%" <?php if($task->progressValue == "30%"){echo "selected";} ?>>30%</option>
                                    <option value="40%" <?php if($task->progressValue == "40%"){echo "selected";} ?>>40%</option>
                                    <option value="50%" <?php if($task->progressValue == "50%"){echo "selected";} ?>>50%</option>
                                    <option value="60%" <?php if($task->progressValue == "60%"){echo "selected";} ?>>60%</option>
                                    <option value="70%" <?php if($task->progressValue == "70%"){echo "selected";} ?>>70%</option>
                                    <option value="80%" <?php if($task->progressValue == "80%"){echo "selected";} ?>>80%</option>
                                    <option value="90%" <?php if($task->progressValue == "90%"){echo "selected";} ?>>90%</option>
                                    <option value="100%" <?php if($task->progressValue == "100%"){echo "selected";} ?>>100%</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save"></i> &nbsp; Save</button>
                                </form>
                                <button type="button" class="btn btn-sm btn-primary mx-1 addSubTask"><i class="fas fa-plus-circle"></i> &nbsp; Add Sub Task</button>
                            </div>
                            <div class="btn-group">
                                <form action="<?= site_url('project/action') ?>" method="post">
                                    <input type="hidden" name="type" value="delTask">
                                    <input type="hidden" name="idtask" value="<?= $task->id ?>">
                                    <button type="submit" class="btn btn-sm btn-danger ml-1"><i class="fas fa-trash"></i> Remove</button>
                                </form>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $('.mark').click(function(){
                                var type = "mark";
                                var dataType = $(this).attr('data-type');
                                var selectedTaskId = <?= $task->id ?>;

                                $.ajax({
                                    url: '<?= site_url('project/action') ?>',
                                    type: 'post',
                                    data: {type : type, selectedTaskId : selectedTaskId, dataType : dataType},
                                    success: function(){
                                        var type = "detailTask";
                                        $.ajax({
                                            url:  "<?= site_url('project/modal') ?>",
                                            type: 'get',
                                            data: {selectedTaskId : selectedTaskId, type : type},
                                            success: function(data){
                                                $('.isiDetailTask').html(data);   
                                            }
                                        });
                                    }
                                });
                            });
                            $('.addSubTask').click(function(){
                                var type = "addSubTask";
                                var selectedTaskId = <?= $task->id ?>;
                                $.ajax({
                                    url: '<?= site_url('project/modal') ?>',
                                    type: 'get',
                                    data: {type : type, selectedTaskId : selectedTaskId},
                                    beforeSend: function(){

                                    },
                                    success: function(data){
                                        $('.isiDetailTask').html(data);
                                    }
                                });
                            });
                            $(function() {
                                $('.datetimepicker').datetimepicker({
                                    format: 'YYYY-MM-DD HH:mm',
                                    // format: 'MM-DD-YYYY',
                                    icons: {
                                    time: "fa fa-clock",
                                    date: "fa fa-calendar-day",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
                                    },
                                    minDate: '<?= date('m-d-Y', strtotime($task->project_start)) ?>',
                                    maxDate: '<?= date('m-d-Y', strtotime("1 day", strtotime($task->project_end)) ) ?>'
                                });
                            });
                        </script>
                    <?php
                }
            }elseif($type == "addSubTask"){
                $getTask = $this->M_Project->get_byIdTask($id);
                if($getTask->num_rows() > 0){
                    $task = $getTask->row();
                    ?>
                        <div class="card-header bg-transparent border-0">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="mb-0 text-capitalize" id="editTitle">Add Sub Task : <strong><?= $task->name ?></strong></h4>
                                </div>
                            </div>
                        </div>
                        <form action="<?= site_url('project/action') ?>" method="post">
                        <input type="hidden" name="type" value="addTask">
                        <input type="hidden" name="parent" value="<?= $task->id ?>">
                        <input type="hidden" name="iddiv" value="<?= $task->iddiv ?>">
                        <input type="hidden" name="idproject" value="<?= $task->idproject ?>">

                        <div class="card-body bg-secondary">
                            <div class="form-group">
                                <label for="">Task Name <small class="text-warning"><strong>*</strong></small></label>
                                <input type="text" name="task" class="form-control form-control-alternative form-control-sm" placeholder="Task Name " required>
                            </div>
                            <div class="form-group">
                                <label for="">PIC <small class="text-warning"><strong>*</strong></small></label>
                                <select name="pic" class="form-control form-control-alternative form-control-sm" required>
                                    <option value="">- Select PIC -</option>
                                    <?php
                                        foreach($getUser->result() as $u){
                                    ?>
                                    <option value="<?= $u->id ?>"><?= $u->name." - ".$u->username ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Start <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="start" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual Start" value="<?= $task->actualStart ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">End <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="end" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual End" value="<?= $task->actualEnd ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Progress <small class="text-warning"><strong>*</strong></small></label>
                                <select name="progressValue" class="form-control form-control-alternative form-control-sm">
                                    <option value="0%">0%</option>
                                    <option value="10%">10%</option>
                                    <option value="20%">20%</option>
                                    <option value="30%">30%</option>
                                    <option value="40%">40%</option>
                                    <option value="50%">50%</option>
                                    <option value="60%">60%</option>
                                    <option value="70%">70%</option>
                                    <option value="80%">80%</option>
                                    <option value="90%">90%</option>
                                    <option value="100%">100%</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save"></i> &nbsp; Save Sub Task</button>
                                </form>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $('.addSubTask').click(function(){
                                var type = "addSubTask";
                                var selectedTaskId = <?= $task->id ?>;
                                $.ajax({
                                    url: '<?= site_url('project/modal') ?>',
                                    type: 'get',
                                    data: {type : type, selectedTaskId : selectedTaskId},
                                    beforeSend: function(){

                                    },
                                    success: function(data){
                                        $('.isiDetailTask').html(data);
                                    }
                                });
                            });
                            $(function() {
                                $('.datetimepicker').datetimepicker({
                                    format: 'YYYY-MM-DD HH:mm',
                                    // format: 'MM-DD-YYYY',
                                    icons: {
                                    time: "fa fa-clock",
                                    date: "fa fa-calendar-day",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
                                    },
                                    minDate: '<?= date('m-d-Y', strtotime($task->project_start)) ?>',
                                    maxDate: '<?= date('m-d-Y', strtotime("1 day", strtotime($task->project_end)) ) ?>'
                                });
                            });
                        </script>
                    <?php
                }
            }
        }elseif($role == 4){
            if($type == "detailTask"){
                $getTask = $this->M_Project->get_byIdTask($id);
                if($getTask->num_rows() > 0){
                    $task = $getTask->row();
                    ?>
                        <div class="card-header bg-transparent border-0 pb-2">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="mb-0 text-capitalize" id="editTitle">Detail : <strong><?= $task->name ?></strong> &nbsp;
                                        <?php if($task->status == ""): ?>
                                            <span class="badge badge-info">On Schedule</span>
                                        <?php elseif($task->status == "Done"): ?>
                                            <span class="badge badge-success"><?= $task->status ?></span>
                                        <?php elseif($task->status == "Pending"): ?>
                                            <span class="badge badge-warning"><?= $task->status ?></span>
                                        <?php endif; ?>
                                    </h4>
                                    <div class="btn-group">
                                        <?php if($task->status == "Pending"): ?>
                                            <button class="btn mt-1 btn-sm btn-default mark" data-type="markUnPending"><i class="fas fa-clock"></i> &nbsp;Remove Mark Pending</button>
                                            <button class="btn mt-1 btn-sm btn-success ml-1 mark" data-type="markDone"><i class="fas fa-check-circle"></i> &nbsp;Mark As Done</button>
                                        <?php elseif($task->status == "Done"): ?>
                                            <button class="btn mt-1 btn-sm btn-default mark" data-type="markPending"><i class="fas fa-clock"></i> &nbsp;Mark As Pending</button>
                                            <button class="btn mt-1 btn-sm btn-success ml-1 mark" data-type="markUnDone"><i class="fas fa-check-circle"></i> &nbsp;Remove Mark Done</button>
                                        <?php else: ?>
                                            <button class="btn mt-1 btn-sm btn-default mark" data-type="markPending"><i class="fas fa-clock"></i> &nbsp;Mark As Pending</button>
                                            <button class="btn mt-1 btn-sm btn-success ml-1 mark" data-type="markDone"><i class="fas fa-check-circle"></i> &nbsp;Mark As Done</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-2 p-0 text-center mt-2">
                                    <span><strong><?= $task->progressValue ?></strong></span>
                                </div>
                                <div class="col-10 mt-3 p-0">
                                    <div class="progress">
                                        <div class="progress-bar <?php if($task->status == "pending"){echo "bg-warning";}elseif($task->status == "done"){echo "bg-success";}else{echo "bg-info";} ?>" role="progressbar" aria-valuenow="<?= $task->progressValue ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $task->progressValue ?>;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="<?= site_url('project/action') ?>" method="post">
                        <input type="hidden" name="type" value="editTask">
                        <input type="hidden" name="idtask" value="<?= $task->id ?>">
                        <div class="card-body bg-secondary">
                            <div class="form-group">
                                <label for="">Task Name <small class="text-warning"><strong>*</strong></small></label>
                                <input type="text" name="task" class="form-control form-control-alternative form-control-sm" value="<?= $task->name ?>" placeholder="Task Name " required>
                            </div>
                            <div class="form-group">
                                <label for="">Start <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="start" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual Start" value="<?= $task->actualStart ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">End <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="end" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual End" value="<?= $task->actualEnd ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Progress <small class="text-warning"><strong>*</strong></small></label>
                                <select name="progressValue" class="form-control form-control-alternative form-control-sm">
                                    <option value="0%" <?php if($task->progressValue == "0%"){echo "selected";} ?>>0%</option>
                                    <option value="10%" <?php if($task->progressValue == "10%"){echo "selected";} ?>>10%</option>
                                    <option value="20%" <?php if($task->progressValue == "20%"){echo "selected";} ?>>20%</option>
                                    <option value="30%" <?php if($task->progressValue == "30%"){echo "selected";} ?>>30%</option>
                                    <option value="40%" <?php if($task->progressValue == "40%"){echo "selected";} ?>>40%</option>
                                    <option value="50%" <?php if($task->progressValue == "50%"){echo "selected";} ?>>50%</option>
                                    <option value="60%" <?php if($task->progressValue == "60%"){echo "selected";} ?>>60%</option>
                                    <option value="70%" <?php if($task->progressValue == "70%"){echo "selected";} ?>>70%</option>
                                    <option value="80%" <?php if($task->progressValue == "80%"){echo "selected";} ?>>80%</option>
                                    <option value="90%" <?php if($task->progressValue == "90%"){echo "selected";} ?>>90%</option>
                                    <option value="100%" <?php if($task->progressValue == "100%"){echo "selected";} ?>>100%</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save"></i> &nbsp; Save</button>
                                </form>
                                <button type="button" class="btn btn-sm btn-primary mx-1 addSubTask"><i class="fas fa-plus-circle"></i> &nbsp; Add Sub Task</button>
                            </div>
                            <div class="btn-group">
                                <form action="<?= site_url('project/action') ?>" method="post">
                                    <input type="hidden" name="type" value="delTask">
                                    <input type="hidden" name="idtask" value="<?= $task->id ?>">
                                    <button type="submit" class="btn btn-sm btn-danger ml-1"><i class="fas fa-trash"></i> Remove</button>
                                </form>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $('.mark').click(function(){
                                var type = "mark";
                                var dataType = $(this).attr('data-type');
                                var selectedTaskId = <?= $task->id ?>;

                                $.ajax({
                                    url: '<?= site_url('project/action') ?>',
                                    type: 'post',
                                    data: {type : type, selectedTaskId : selectedTaskId, dataType : dataType},
                                    success: function(){
                                        var type = "detailTask";
                                        $.ajax({
                                            url:  "<?= site_url('project/modal') ?>",
                                            type: 'get',
                                            data: {selectedTaskId : selectedTaskId, type : type},
                                            success: function(data){
                                                $('.isiDetailTask').html(data);   
                                            }
                                        });
                                    }
                                });
                            });
                            $('.addSubTask').click(function(){
                                var type = "addSubTask";
                                var selectedTaskId = <?= $task->id ?>;
                                $.ajax({
                                    url: '<?= site_url('project/modal') ?>',
                                    type: 'get',
                                    data: {type : type, selectedTaskId : selectedTaskId},
                                    beforeSend: function(){

                                    },
                                    success: function(data){
                                        $('.isiDetailTask').html(data);
                                    }
                                });
                            });
                            $(function() {
                                $('.datetimepicker').datetimepicker({
                                    format: 'YYYY-MM-DD HH:mm',
                                    // format: 'MM-DD-YYYY',
                                    icons: {
                                    time: "fa fa-clock",
                                    date: "fa fa-calendar-day",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
                                    },
                                    minDate: '<?= date('m-d-Y', strtotime($task->project_start)) ?>',
                                    maxDate: '<?= date('m-d-Y', strtotime("1 day", strtotime($task->project_end)) ) ?>'
                                });
                            });
                        </script>
                    <?php
                }
            }elseif($type == "addSubTask"){
                $getTask = $this->M_Project->get_byIdTask($id);
                if($getTask->num_rows() > 0){
                    $task = $getTask->row();
                    ?>
                        <div class="card-header bg-transparent border-0">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="mb-0 text-capitalize" id="editTitle">Add Sub Task : <strong><?= $task->name ?></strong></h4>
                                </div>
                            </div>
                        </div>
                        <form action="<?= site_url('project/action') ?>" method="post">
                        <input type="hidden" name="type" value="addTask">
                        <input type="hidden" name="parent" value="<?= $task->id ?>">
                        <input type="hidden" name="iddiv" value="<?= $task->iddiv ?>">
                        <input type="hidden" name="idproject" value="<?= $task->idproject ?>">

                        <div class="card-body bg-secondary">
                            <div class="form-group">
                                <label for="">Task Name <small class="text-warning"><strong>*</strong></small></label>
                                <input type="text" name="task" class="form-control form-control-alternative form-control-sm" placeholder="Task Name " required>
                            </div>
                            <div class="form-group">
                                <label for="">Start <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="start" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual Start" value="<?= $task->actualStart ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">End <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="end" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual End" value="<?= $task->actualEnd ?>" onkeydown="return false" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Progress <small class="text-warning"><strong>*</strong></small></label>
                                <select name="progressValue" class="form-control form-control-alternative form-control-sm">
                                    <option value="0%">0%</option>
                                    <option value="10%">10%</option>
                                    <option value="20%">20%</option>
                                    <option value="30%">30%</option>
                                    <option value="40%">40%</option>
                                    <option value="50%">50%</option>
                                    <option value="60%">60%</option>
                                    <option value="70%">70%</option>
                                    <option value="80%">80%</option>
                                    <option value="90%">90%</option>
                                    <option value="100%">100%</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save"></i> &nbsp; Save Sub Task</button>
                                </form>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $('.addSubTask').click(function(){
                                var type = "addSubTask";
                                var selectedTaskId = <?= $task->id ?>;
                                $.ajax({
                                    url: '<?= site_url('project/modal') ?>',
                                    type: 'get',
                                    data: {type : type, selectedTaskId : selectedTaskId},
                                    beforeSend: function(){

                                    },
                                    success: function(data){
                                        $('.isiDetailTask').html(data);
                                    }
                                });
                            });
                            $(function() {
                                $('.datetimepicker').datetimepicker({
                                    format: 'YYYY-MM-DD HH:mm',
                                    // format: 'MM-DD-YYYY',
                                    icons: {
                                    time: "fa fa-clock",
                                    date: "fa fa-calendar-day",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
                                    },
                                    minDate: '<?= date('m-d-Y', strtotime($task->project_start)) ?>',
                                    maxDate: '<?= date('m-d-Y', strtotime("1 day", strtotime($task->project_end)) ) ?>'
                                });
                            });
                        </script>
                    <?php
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
                    'project_name' => $this->input->post('project_name', TRUE),
                    'start' => $this->input->post('start', TRUE),
                    'end' => $this->input->post('end', TRUE)
                ];
                $this->db->insert('project', $data);
    
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sukses', "Project ".$this->input->post('project_name', TRUE)." Berhasil Di Tambahkan");
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }elseif($type == "editProject"){
                $idproject = $this->input->post('idproject', TRUE);
                $data = [
                    'iddiv' => $this->input->post('iddiv', TRUE), 
                    'project_name' => $this->input->post('project_name', TRUE),
                    'start' => $this->input->post('start', TRUE),
                    'end' => $this->input->post('end', TRUE)
                ];

                $this->db->where('id', $idproject);
                $this->db->update('project', $data);

                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sukses', "Project ".$this->input->post('project_name', TRUE)." Berhasil Di Simpan");
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }elseif($type == "deleteProject"){
                $idproject = $this->input->post('idproject', TRUE);
                $this->db->where('id', $idproject);
                $this->db->delete('project');

                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sukses', "Project ".$this->input->post('project_name', TRUE)." Berhasil Di Hapus");
                    redirect('dashboard', "refresh");
                }
            }elseif($type == "addTask"){
                $data = [
                    'idpt' => $iduser,
                    'iddiv' => $this->input->post('iddiv', TRUE),
                    'idproject' => $this->input->post('idproject', TRUE),
                    'name' => $this->input->post('task', TRUE),
                    'pic' => $this->input->post('pic', TRUE),
                    'actualStart' => $this->input->post('start', TRUE),
                    'actualEnd' => $this->input->post('end', TRUE),
                    'parent' => $this->input->post('parent', TRUE)
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
                    'actualEnd' => $this->input->post('end', TRUE),
                    'progressValue' => $this->input->post('progressValue', TRUE)
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
            }elseif($type == "updateTask"){
                if($this->input->post('field', TRUE) == "progressValue"){
                    $val = $this->input->post('value', TRUE);
                    $hasil = str_replace("0.", "",$val);
                    $data = [
                        'progressValue' => $hasil."%"
                    ];
                }elseif($this->input->post('field', TRUE) == "connector"){
                    $value = $this->input->post('value[]', TRUE);
                    $connectTo = $value['connectTo']; 
                    $connectorType = $value['connectorType'];
                    $data = [
                        'connectTo' => $connectTo,
                        'connectorType' => $connectorType
                    ];
                }else{
                    $data = [
                        $this->input->post('field', TRUE) => $this->input->post('value', TRUE)
                    ];
                }

                $this->db->where('id', $this->input->post('id', TRUE));
                $this->db->update('task', $data);

                if($this->db->affected_rows() > 0){
                    echo "Success";
                }else{
                    echo "Error";
                }
            }elseif($type == "mark"){
                $mark = $this->input->post('dataType', TRUE);
                if($mark == "markPending"){
                    $data = [
                        'status' => "Pending"
                    ];
                }elseif($mark == "markDone"){
                    $data = [
                        'status' => "Done"
                    ];
                }else{
                    $data = [
                        'status' => ""
                    ];
                }

                $this->db->where('id', $this->input->post('selectedTaskId', TRUE));
                $this->db->update('task', $data);

                if($this->db->affected_rows() > 0){
                    echo "Sukses";
                }else{
                    echo $this->db->error(); 
                }
            }
        }elseif($role == 3){
            $idpt = $this->session('idpt');
            $iddiv = $this->session('iddiv');
            if($type == "add"){
                $data = [
                    'idpt' => $idpt,
                    'iddiv' => $iddiv,
                    'project_name' => $this->input->post('project_name', TRUE),
                    'start' => $this->input->post('start', TRUE),
                    'end' => $this->input->post('end', TRUE)
                ];
                $this->db->insert('project', $data);
    
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sukses', "Project ".$this->input->post('project_name', TRUE)." Berhasil Di Tambahkan");
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }elseif($type == "addTask"){
                $data = [
                    'idpt' => $idpt,
                    'iddiv' => $iddiv,
                    'idproject' => $this->input->post('idproject', TRUE),
                    'name' => $this->input->post('task', TRUE),
                    'pic' => $this->input->post('pic', TRUE),
                    'actualStart' => $this->input->post('start', TRUE),
                    'actualEnd' => $this->input->post('end', TRUE),
                    'parent' => $this->input->post('parent', TRUE)
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
                    'actualEnd' => $this->input->post('end', TRUE),
                    'progressValue' => $this->input->post('progressValue', TRUE)
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
            }elseif($type == "updateTask"){
                if($this->input->post('field', TRUE) == "progressValue"){
                    $val = $this->input->post('value', TRUE);
                    $hasil = str_replace("0.", "",$val);
                    $data = [
                        'progressValue' => $hasil."%"
                    ];
                }elseif($this->input->post('field', TRUE) == "connector"){
                    $value = $this->input->post('value[]', TRUE);
                    $connectTo = $value['connectTo']; 
                    $connectorType = $value['connectorType'];
                    $data = [
                        'connectTo' => $connectTo,
                        'connectorType' => $connectorType
                    ];
                }else{
                    $data = [
                        $this->input->post('field', TRUE) => $this->input->post('value', TRUE)
                    ];
                }

                $this->db->where('id', $this->input->post('id', TRUE));
                $this->db->update('task', $data);

                if($this->db->affected_rows() > 0){
                    echo "Success";
                }else{
                    echo "Error";
                }
            }elseif($type == "mark"){
                $mark = $this->input->post('dataType', TRUE);
                if($mark == "markPending"){
                    $data = [
                        'status' => "Pending"
                    ];
                }elseif($mark == "markDone"){
                    $data = [
                        'status' => "Done"
                    ];
                }else{
                    $data = [
                        'status' => ""
                    ];
                }

                $this->db->where('id', $this->input->post('selectedTaskId', TRUE));
                $this->db->update('task', $data);

                if($this->db->affected_rows() > 0){
                    echo "Sukses";
                }else{
                    echo $this->db->error(); 
                }
            }
        }elseif($role == 4){
            $idpt = $this->session('idpt');
            $iddiv = $this->session('iddiv');
            if($type == "addTask"){
                $data = [
                    'idpt' => $idpt,
                    'iddiv' => $iddiv,
                    'idproject' => $this->input->post('idproject', TRUE),
                    'name' => $this->input->post('task', TRUE),
                    'pic' => $iduser,
                    'actualStart' => $this->input->post('start', TRUE),
                    'actualEnd' => $this->input->post('end', TRUE),
                    'parent' => $this->input->post('parent', TRUE)
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
                    'actualStart' => $this->input->post('start', TRUE),
                    'actualEnd' => $this->input->post('end', TRUE),
                    'progressValue' => $this->input->post('progressValue', TRUE)
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
            }elseif($type == "updateTask"){
                if($this->input->post('field', TRUE) == "progressValue"){
                    $val = $this->input->post('value', TRUE);
                    $hasil = str_replace("0.", "",$val);
                    $data = [
                        'progressValue' => $hasil."%"
                    ];
                }elseif($this->input->post('field', TRUE) == "connector"){
                    $value = $this->input->post('value[]', TRUE);
                    $connectTo = $value['connectTo']; 
                    $connectorType = $value['connectorType'];
                    $data = [
                        'connectTo' => $connectTo,
                        'connectorType' => $connectorType
                    ];
                }else{
                    $data = [
                        $this->input->post('field', TRUE) => $this->input->post('value', TRUE)
                    ];
                }

                $this->db->where('id', $this->input->post('id', TRUE));
                $this->db->update('task', $data);

                if($this->db->affected_rows() > 0){
                    echo "Success";
                }else{
                    echo "Error";
                }
            }elseif($type == "mark"){
                $mark = $this->input->post('dataType', TRUE);
                if($mark == "markPending"){
                    $data = [
                        'status' => "Pending"
                    ];
                }elseif($mark == "markDone"){
                    $data = [
                        'status' => "Done"
                    ];
                }else{
                    $data = [
                        'status' => ""
                    ];
                }

                $this->db->where('id', $this->input->post('selectedTaskId', TRUE));
                $this->db->update('task', $data);

                if($this->db->affected_rows() > 0){
                    echo "Sukses";
                }else{
                    echo $this->db->error(); 
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
        }elseif($role == 3){
            $getTask = $this->M_Project->get_taskByIdProjectDiv($idproject, $idpt, $iddiv);
        }elseif($role == 4){
            $getTask = $this->M_Project->get_taskByIdProjectUser($idproject, $idpt, $iduser);
        }

        echo json_encode($getTask->result());
    }

}