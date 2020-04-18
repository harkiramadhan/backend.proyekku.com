<button class="btn btn-sm btn-default" onclick="topFunction()" id="myBtn"><i class="ni ni-bold-up"></i></button>
<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="nav-wrapper">
            <ul class="nav nav-pills flex-row flex-md-row" id="tabs-icons-text" role="tablist">
              <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-2 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="false"><i class="ni ni-bullet-list-67"></i> &nbsp;Progress Detail</a>
              </li>
              <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-2" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="ni ni-calendar-grid-58"></i> &nbsp;Schedule</a>
              </li>
              <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-2" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="ni ni-folder-17"></i> &nbsp;Report</a>
              </li>
              <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-2" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false"><i class="ni ni-sound-wave"></i> &nbsp;Issues</a>
              </li>
            </ul>
        </div>
        <h2 class="text-white">Project Name : <strong><?= $project->project_name ?></strong> &nbsp;&nbsp; - &nbsp;&nbsp;Division: <strong><?= $project->division ?></strong></h2>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
            <!-- Dark table -->
            <div class="row">
                <div class="col-12 text-right mb-3">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#addTask"><i class="fas fa-plus-circle"></i> &nbsp;Add Task</button>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-transparent border-0">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                <h3 class="mb-0">Progress Detail</h3>
                                    <input type="hidden" id="idproject" value="<?= $project->id ?>">
                                    <input type="hidden" id="iddiv" value="<?= $project->iddiv ?>">
                                    <input type="hidden" id="idpt" value="<?= $project->idpt ?>">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <input type="text" id="myInput" placeholder="Search Task ...." class="mb-0 form-control-sm form-control-alternative form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush table-sm table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5px">No</th>
                                        <th width="5px">Task Name</th>
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
                                    <tr class="taskList" id="<?= $row->id ?>" style="cursor: pointer">
                                        <td><?= $no++ ?></td>
                                        <td><?= $row->name ?></td>
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
                            <table class="table align-items-center table-flush table-sm bg-secondary">
                                <tbody>
                                    <tr>
                                        <td width="5px"><i class="fas fa-plus-circle"></i></td>
                                        <td><input type="text" id="nameTaskAdd" name="task" class="form-control form-control-sm" placeholder="Create A New Task " required></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-2">
                
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow isiDetailTask">
                        <div class="card-header bg-transparent border-0">
                            <h4 class="mb-0 text-capitalize" id="editTitle">Detail Task</h4>
                        </div>
                        <div class="card-body bg-secondary">
                            <button type="button" class="btn btn-block btn-sm btn-default" style="cursor: default">Click The Task For Detail</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= site_url('project/action') ?>" method="post">
                        <input type="hidden" name="type" value="addTask">
                        <input type="hidden" name="idproject" value="<?= $project->id ?>">
                        
                        <div class="modal-body bg-secondary">
                            <div class="form-group">
                                <label for="">Task Name <small class="text-warning"><strong>*</strong></small></label>
                                <input type="text" name="task" class="form-control form-control-alternative form-control-sm" placeholder="Task Name " required>
                            </div>
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
                        <input type="hidden" name="parent" value="0">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-transparent border-0">
                            <h3 class="mb-0">Schedule</h3>   
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-body mb-2 p-0" style="width: 100%; height: 500px;" id="chartContainer">
                        
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow isiDetailTask">
                        <div class="card-header bg-transparent border-0">
                            <h4 class="mb-0 text-capitalize" id="editTitle">Detail Task</h4>
                        </div>
                        <div class="card-body bg-secondary">
                            <button type="button" class="btn btn-block btn-sm btn-default" style="cursor: default">Click The Task For Detail</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-transparent border-0">
                            <h3 class="mb-0">Report</h3>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-transparent border-0">
                            <h3 class="mb-0">Issues</h3>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    