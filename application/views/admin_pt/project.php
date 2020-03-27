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
                    </div>
                    <div class="col-md-3">
                        <h3 class="mb-0">Division: <strong><?= $project->division ?></strong></h3>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <input type="text" id="myInput" placeholder="Search Task ...." class="mb-0 form-control-sm form-control-alternative form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive" style="max-height: 250px">
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
                            <td><?= $row->task ?></td>
                            <td><?= $row->name." - ".$row->username ?></td>
                            <td><?= $row->start ?></td>
                            <td><?= $row->end ?></td>
                            <td class="text-center"><strong><?= $row->progress ?></strong>%</td>
                            <td><?= $row->status ?></td>
                            <td>
                            
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
                                <input type="date" name="start" class="form-control form-control-alternative form-control-sm" required>
                            </div>
                            <div class="form-group">
                                <label for="">End <small class="text-warning"><strong>*</strong></small></label>
                                <input type="date" name="end" class="form-control form-control-alternative form-control-sm" required>
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
