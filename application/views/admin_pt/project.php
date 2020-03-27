<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--5">
    <!-- Dark table -->
    <div class="row">
        <div class="col-12 text-right mb-3">
            <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#addUser"><strong>+</strong> Add Task</button>
        </div>
        <div class="col">
            <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
                <h3 class="text-white mb-0">Project - <?= $project->project_name ?></h3>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-dark table-flush">
                <thead class="thead-dark">
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
                    <?php 
                    $no = 1;
                    foreach($user->result() as $row){ ?>
                    <tr>
                        <th><?= $no++ ?></th>
                        <th><?= $row->name ?></th>
                        <th><?= $row->username ?></th>
                        <th><?= $row->division ?></th>
                        <th><?= $row->role ?></th>
                        <th>
                            <span class="badge badge-dot mr-4">
                                <?php if($row->status == "active"): ?>
                                    <i class="bg-success"></i>
                                    <span class="status">active</span>
                                <?php elseif($row->status == "pending"): ?>
                                    <i class="bg-warning"></i>
                                    <span class="status">pending</span>
                                <?php else: ?>
                                    <i class="bg-warning"></i>
                                    <span class="status">Non Active</span>
                                <?php endif; ?>
                            </span>
                        </th>
                        <td class="text-right">
                            <div class="btn-group">
                                <form action="<?= site_url('user/action') ?>" method="post">
                                    <input type="hidden" name="iduser" value="<?= $row->id ?>">
                                    <input type="hidden" name="username" value="<?= $row->username ?>">
                                    
                                    <?php if($row->status == "active"): ?>
                                        <input type="hidden" name="type" value="non">
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Non Active</button>
                                    <?php else: ?>
                                        <input type="hidden" name="type" value="active">
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Active</button>
                                    <?php endif; ?>
                                </form>
                                <button class="btn btn-sm btn-info ml-3 mr-1 rounded" data-toggle="modal" data-target="#edit_<?= $row->id ?>"><i class="fas fa-pencil-alt"></i></button>
                                <form action="<?= site_url('user/action') ?>" method="post">
                                    <input type="hidden" name="iduser" value="<?= $row->id ?>">
                                    <input type="hidden" name="username" value="<?= $row->username ?>">
                                    <input type="hidden" name="type" value="del">
                                    <button type="submit" class="btn btn-sm btn-danger rounded"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
