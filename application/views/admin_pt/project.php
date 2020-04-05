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
            <div class="btn-group">
                <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#addTask"><i class="fas fa-plus-circle"></i> &nbsp;Add Task</button>
                <button class="btn btn-sm btn-danger ml-1" data-toggle="modal" data-target="#deleteProject"><i class="fas fa-trash"></i> &nbsp;Remove Project</button>
            </div>
        </div>
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-0">Project Name : <strong><?= $project->project_name ?></strong> &nbsp;&nbsp; - &nbsp;&nbsp;Division: <strong><?= $project->division ?></strong></h3>
                            <input type="hidden" id="idproject" value="<?= $project->id ?>">
                            <input type="hidden" id="iddiv" value="<?= $project->iddiv ?>">
                            <input type="hidden" id="idpt" value="<?= $project->idpt ?>">
                        </div>
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
                                        <span class="completion mr-2"><strong><?= $row->progressValue ?></strong></span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar <?php if($row->status == "pending"){echo "bg-warning";}elseif($row->status == "done"){echo "bg-success";}else{echo "bg-info";} ?>" role="progressbar" aria-valuenow="<?= $row->progressValue ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $row->progressValue ?>;"></div>
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
                            </tr>
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
                    <h4 class="mb-0">Gantt Chart &nbsp;:&nbsp; <strong><?= $project->project_name ?></strong></h4>
                </div>
                <div class="card-body mb-2 p-0" style="width: 100%; height: 300px;" id="chartContainer">
                
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow isiDetailTask">
                <div class="card-header bg-transparent border-0">
                    <h4 class="mb-0 text-capitalize" id="editTitle">Detail Task</h4>
                </div>
                <div class="card-body bg-secondary">
                    <button type="button" class="btn btn-block btn-sm btn-default">Click The Task For Detail</button>
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
    
    <div class="modal fade" id="deleteProject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content bg-gradient-danger">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Delete Project <?= $project->project_name ?></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4">Are You Sure To Delete <br> Project <strong><u><?= $project->project_name ?></u></strong> With The Tasks ? </h4>
                        <p>You Won't Be Able To Revert This!</p>
                    </div>
                </div>
                <form action="<?= site_url('project/action') ?>" method="post">
                <input type="hidden" name="type" value="deleteProject">
                <input type="hidden" name="project_name" value="<?= $project->project_name ?>">
                <input type="hidden" name="idproject" value="<?= $project->id ?>">
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-link text-white" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-white ml-auto">Yes, Delete It!</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>