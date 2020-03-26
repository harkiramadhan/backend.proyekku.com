<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
    <!-- Dark table -->
    <div class="row">
        <div class="col">
            <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
                <h3 class="text-white mb-0">User - Admin Perusahaan</h3>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-dark table-flush">
                <thead class="thead-dark">
                    <tr>
                        <th width="5px">No</th>
                        <th>Username</th>
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
                        <th><?= $row->username ?></th>
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
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-success"><i class="fas fa-check"></i> Active</button>
                                <button class="btn btn-sm btn-info mx-1"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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