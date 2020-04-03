<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
    <!-- Dark table -->
    <div class="row">
        <div class="col-12 text-right mb-3">
            <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#addTask"><strong>+</strong> Add Task</button>
        </div>
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h3 class="mb-0">Project Name : <strong><?= $project->project_name ?></strong></h3>
                            <input type="hidden" id="idproject" value="<?= $project->id ?>">
                        </div>
                        <div class="col-md-3">
                            <h3 class="mb-0">Division: <strong><?= $project->division ?></strong></h3>
                            <input type="hidden" id="iddiv" value="<?= $project->iddiv ?>">
                            <input type="hidden" id="idpt" value="<?= $project->idpt ?>">
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <input type="text" id="myInput" placeholder="Search Task ...." class="mb-0 form-control-sm form-control-alternative form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" style="max-height: 240px">
                    <table class="table align-items-center table-flush table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th width="5px">No</th>
                                <th width="5px">Task Name</th>
                                <th>PIC</th>
                                <th width="5px">Start</th>
                                <th width="5px">Due</th>
                                <th width="5px">Progress</th>
                                <th width="5px">Status</th>
                                <th width="5px" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php 
                            $no = 1;
                            foreach($task->result() as $row){ ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row->name ?></td>
                                <td><?= $row->name_user?></td>
                                <td><?= $row->actualStart ?></td>
                                <td><?= $row->actualEnd ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="completion mr-2"><strong><?= $row->progressValue ?></strong>%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar <?php if($row->status == "pending"){echo "bg-warning";}elseif($row->status == "done"){echo "bg-success";}else{echo "bg-info";} ?>" role="progressbar" aria-valuenow="<?= $row->progressValue ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $row->progressValue ?>%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-dot mr-4">
                                    <?php if($row->status == "pending"): ?>
                                        <i class="bg-warning"></i>
                                        <span class="status">pending</span>
                                    <?php elseif($row->status == "done"): ?>
                                        <i class="bg-success"></i>
                                        <span class="status">completed</span>
                                    <?php else: ?>
                                        <i class="bg-info"></i>
                                        <span class="status">on schedule</span>
                                    <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <form action="<?= site_url('project/action') ?>" method="post">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#edit_<?= $row->id ?>"><i class="fas fa-pencil-alt"></i></button>
                                        <input type="hidden" name="type" value="delTask">
                                        <input type="hidden" name="idtask" value="<?= $row->id ?>">
                                        <button type="submit" class="btn btn-sm btn-warning ml-1"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit Task -->
                            <div class="modal fade" id="edit_<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?= site_url('project/action') ?>" method="post">
                                        <input type="hidden" name="type" value="editTask">
                                        <input type="hidden" name="idtask" value="<?= $row->id ?>">
                                        
                                        <div class="modal-body bg-secondary">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Task Name <small class="text-warning"><strong>*</strong></small></label>
                                                        <input type="text" name="task" class="form-control form-control-alternative form-control-sm" placeholder="Task Name " value="<?= $row->name ?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">PIC <small class="text-warning"><strong>*</strong></small></label>
                                                        <select name="pic" class="form-control form-control-alternative form-control-sm" required>
                                                            <option value="">- Select PIC -</option>
                                                            <?php
                                                                foreach($getUser->result() as $us){
                                                            ?>
                                                            <option value="<?= $us->id ?>" <?php if($us->id == $row->pic){echo "selected";} ?>><?= $us->name." - ".$us->username ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Start <small class="text-warning"><strong>*</strong></small></label>
                                                        <div class='input-group date datetimepicker'>
                                                            <input name="start" type="text" class="form-control form-control-alternative form-control-sm" value="<?= $row->actualStart ?>" placeholder="Actual Start" required>
                                                            <span class="input-group-addon input-group-append">
                                                                <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">End <small class="text-warning"><strong>*</strong></small></label>
                                                        <div class='input-group date datetimepicker'>
                                                            <input name="end" type="text" class="form-control form-control-alternative form-control-sm" value="<?= $row->actualEnd ?>" placeholder="Actual End" required>
                                                            <span class="input-group-addon input-group-append">
                                                                <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 mb-2">
        
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Gantt Chart</h5>
                </div>
                <div class="card-body mb-2 p-0" style="width: 100%; height: 300px;" id="chartContainer">
                
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Detail</h5>
                </div>
                <div class="card-body bg-secondary">
                
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('project/action') ?>" method="post">
                <input type="hidden" name="type" value="addTask">
                <input type="hidden" name="idproject" value="<?= $project->id ?>">
                <input type="hidden" name="iddiv" value="<?= $project->iddiv ?>">
                <input type="hidden" name="idpt" value="<?= $project->idpt ?>">
                
                <div class="modal-body bg-secondary">
                    <div class="row">
                        <div class="col-md-6">
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Start <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="start" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual Start" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">End <small class="text-warning"><strong>*</strong></small></label>
                                <div class='input-group date datetimepicker'>
                                    <input name="end" type="text" class="form-control form-control-alternative form-control-sm" placeholder="Actual End" required>
                                    <span class="input-group-addon input-group-append">
                                        <button class="btn btn-sm btn-primary ml-1" type="button" id="button-addon2">  <span class="fa fa-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
