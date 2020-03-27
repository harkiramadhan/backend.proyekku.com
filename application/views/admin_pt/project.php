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
                <h3 class="mb-0">Project - <?= $project->project_name ?></h3>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th width="5px">No</th>
                        <th>Name</th>
                        <th width="5px">Email</th>
                        <th width="5px">Divisi</th>
                        <th width="5px">Role</th>
                        <th width="5px">Status</th>
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
