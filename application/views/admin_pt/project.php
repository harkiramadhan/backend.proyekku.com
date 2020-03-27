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
            <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#addUser"><strong>+</strong> Add Task</button>
        </div>
        <div class="col">
            <div class="card shadow">
            <div class="card-header bg-transparent border-0">
                <div class="row">
                    <div class="col-md-3">
                        <h3 class="mb-0">Project Name : <strong><?= $project->project_name ?></strong></h3>
                    </div>
                    <div class="col-md-3">
                        <h3 class="mb-0">Division: <strong><?= $project->division ?></strong></h3>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th width="5px">No</th>
                        <th width="5px">Task Name</th>
                        <th>Assignee</th>
                        <th width="5px">Start</th>
                        <th width="5px">Due</th>
                        <th width="5px" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="list">
                   
                </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
