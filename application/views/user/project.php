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
        <h2 class="text-white">Project Date&nbsp;&nbsp;&nbsp;: <strong><?= date('d F Y', strtotime($project->start))." - ".date('d F Y', strtotime($project->end)) ?></strong></h2>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
            <!-- Dark table -->
            <div class="row">
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
                                        <th>PIC</th>
                                        <th width="5px" class="text-center">Start <br> (d-m-Y)</th>
                                        <th width="5px" class="text-center">Due <br> (d-m-Y)</th>
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
                                        <td><?= $row->name_user?></td>
                                        <td class="text-center"><?= date('d-m-Y', strtotime($row->actualStart)) ?></td>
                                        <td class="text-center"><?= date('d-m-Y', strtotime($row->actualEnd)) ?></td>
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
                                            <?php if($row->status == "Pending"): ?>
                                                <i class="bg-warning"></i>
                                                <span class="status">pending</span>
                                            <?php elseif($row->status == "Done"): ?>
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
                <div class="col-md-12">
                    <div class="card shadow dt-1">
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
                    <div class="card shadow dt-2">
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
                <div class="col-12 text-right mb-3">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#addReport"><i class="fas fa-plus-circle"></i> &nbsp;Add Report</button>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-transparent border-0">
                            <div class="row">
                                <div class="col-md-9">
                                    <h3 class="mb-0">Report</h3>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="myInput3" class="form-control form-control-alternative form-control-sm" placeholder="Search Report ...">                                            
                                </div>
                            </div>  
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush table-sm table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5px">No</th>
                                        <th>Description</th>
                                        <th width="5px" class="text-center">Date</th>
                                        <th width="5px" class="text-center">Document</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable3">
                                <?php 
                                    $nor = 1;
                                    foreach($report->result() as $r){
                                ?>
                                <tr>
                                    <td width="5px"><?= $nor++ ?></td>
                                    <td><?= $r->desc ?></td>
                                    <td width="5px"><?= $r->date ?></td>
                                    <td class="text-center">
                                    <?php if($r->doc == TRUE){
                                        echo "<a href=".base_url('./uploads/reports/' . $r->doc)." target='__blank' class='btn btn-block btn-sm btn-default'><i class='fas fa-download'></i> ".$r->doc."</a>";
                                    } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="detailReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl isiReport" role="document">
                        
                    </div>
                </div>
                
                <div class="modal fade" id="addReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Report</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="<?= site_url('project/action') ?>" method="post" enctype="multipart/form-data">
                            
                            <input type="hidden" name="type" value="addReport">
                            <input type="hidden" name="idproject" value="<?= $project->id ?>">
                            <input type="hidden" name="iddiv" value="<?= $project->iddiv ?>">

                            <div class="modal-body bg-secondary">
                                <div class="row">
                                    <div class="col-lg-12 mt-2">
                                        <label for="">Description <small class="text-warning">*</small></label>
                                        <textarea name="desc" cols="30" rows="5" class="form-control form-control-alternative form-control-sm" placeholder="Description" required></textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label for="">Date <small class="text-warning">*</small></label>
                                        <input type="date" name="date" placeholder="Date" class="form-control form-control-sm form-control-alternative" required>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label for="">Document <small class="text-warning">*</small></label>
                                        <input type="file" name="doc" class="form-control form-control-alternative form-control-sm" required>
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
            </div>
        </div>
        <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
            <div class="row">
                <div class="col-12 text-right mb-3">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#addIssue"><i class="fas fa-plus-circle"></i> &nbsp;Add Issue</button>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-transparent border-0">
                            <div class="row">
                                <div class="col-md-9">
                                    <h3 class="mb-0">Issues</h3>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="myInput2" class="form-control form-control-alternative form-control-sm" placeholder="Search Issue ...">                                            
                                </div>
                            </div>   
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush table-sm table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5px">No</th>
                                        <th width="5px">Priority</th>
                                        <th width="5px">Task</th>
                                        <th>Problem Description</th>
                                        <th>Request</th>
                                        <th width="5px">Time</th>
                                        <th width="5px">Deadline</th>
                                        <th width="5px">Status</th>
                                        <th width="5px" class="text-center">Document</th>
                                        <th width="5px" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable2">
                                    <?php 
                                    $noi = 1;
                                    foreach($issue->result() as $i){ ?>
                                    <tr>
                                        <td><?= $noi++ ?></td>
                                        <td>
                                        <?php
                                            if($i->priority == "I"){
                                                echo "<span class='badge badge-danger'>Level I</span>";
                                            }elseif($i->priority == "II"){
                                                echo "<span class='badge badge-warning'>Level II</span>";
                                            }elseif($i->priority == "III"){
                                                echo "<span class='badge badge-default'>Level III</span>";
                                            }elseif($i->priority == "IV"){
                                                echo "<span class='badge badge-info'>Level IV</span>";
                                            }
                                        ?>
                                        </td>
                                        <td><?= $i->name ?></td>
                                        <td><?= $i->desc ?></td>
                                        <td><?= $i->request ?></td>
                                        <td><?= $i->time ?></td>
                                        <td><?= $i->deadline ?></td>
                                        <td>
                                        <span class="badge badge-dot mr-4">
                                            <?php if($i->status == "Delay"): ?>
                                                <i class="bg-warning"></i>
                                                <span class="status">Delay</span>
                                            <?php elseif($i->status == "Done"): ?>
                                                <i class="bg-success"></i>
                                                <span class="status">Done</span>
                                            <?php else: ?>
                                                <i class="bg-info"></i>
                                                <span class="status">On Progress</span>
                                            <?php endif; ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                        <?php if($i->doc == TRUE){
                                            echo "<a href=".base_url('./uploads/' . $i->doc)." target='__blank' class='btn btn-block btn-sm btn-default'><i class='fas fa-download'></i> ".$i->doc."</a>";
                                        } ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-primary editIssue" data-id="<?= $i->id ?>"><i class="fas fa-pencil-alt"></i></button>
                                                <a href="<?= site_url('project/deleteIssue/'. $i->id) ?>" class="btn btn-sm btn-danger ml-1"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="detailIssue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl isiIssue" role="document">
                        
                    </div>
                </div>

                <div class="modal fade" id="addIssue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Issue</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="<?= site_url('project/action') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="addIssue">
                            <input type="hidden" name="idproject" value="<?= $project->id ?>">
                            <input type="hidden" name="iddiv" value="<?= $project->iddiv ?>">
                            <div class="modal-body bg-secondary">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label for="">Priority <small class="text-warning">*</small></label>
                                        <select name="priority" class="form-control form-control-sm form-control-alternative" required>
                                            <option value="">- Select Priority -</option>
                                            <option value="I">Level I</option>
                                            <option value="II">Level II</option>
                                            <option value="III">Level III</option>
                                            <option value="IV">Level IV</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-10">
                                        <label for="">Task</label>
                                        <select name="idtask" class="form-control form-control-sm form-control-alternative">
                                            <option value="">- Select Task -</option>
                                            <?php 
                                            foreach($task->result() as $t){ 
                                                echo "<option value=".$t->id.">".$t->name." - ".$t->name_user."</option>";
                                            }?>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label for="">Problem Description <small class="text-warning">*</small></label>
                                        <textarea name="problem" cols="30" rows="5" class="form-control form-control-alternative form-control-sm" placeholder="Problem Desc" required></textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label for="">Request <small class="text-warning">*</small></label>
                                        <textarea name="request" cols="30" rows="5" class="form-control form-control-alternative form-control-sm" placeholder="Request" required></textarea>
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label for="">Time <small class="text-warning">*</small></label>
                                        <input type="date" name="time" placeholder="Time" class="form-control form-control-sm form-control-alternative" required>
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label for="">Deadline <small class="text-warning">*</small></label>
                                        <input type="date" name="deadline" placeholder="Deadline" class="form-control form-control-sm form-control-alternative" required>
                                    </div>
                                    <div class="col-lg-2 mt-2">
                                        <label for="">Status <small class="text-warning">*</small></label>
                                        <select name="status" class="form-control form-control-sm form-control-alternative" required>
                                            <option value="">- Select Status -</option>
                                            <option value="Delay">Delay</option>
                                            <option value="On Progress">On Progress</option>
                                            <option value="Done">Done</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-10 mt-2">
                                        <label for="">Document</label>
                                        <input type="file" name="doc" class="form-control form-control-alternative form-control-sm">
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
            </div>
        </div>
    </div>