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
            <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#addUser"><strong>+</strong> Add User</button>
        </div>
        <div class="col">
            <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
                <h3 class="text-white mb-0">User - Perusahaan</h3>
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
                    <div class="modal fade" id="edit_<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= site_url('user/action') ?>" method="post">
                                <input type="hidden" name="type" value="edit">
                                <input type="hidden" name="iduser" value="<?= $row->id ?>">
                                <div class="modal-body bg-secondary">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Name <small class="text-warning"><strong>*</strong></small></label>
                                                <input type="text" name="name" class="form-control form-control-sm form-control-alternative" placeholder="Name " value="<?= $row->name ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email <small class="text-warning"><strong>*</strong></small></label>
                                                <input type="email" name="username" class="form-control form-control-sm form-control-alternative" placeholder="Email " value="<?= $row->username ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Password <small class="text-warning"><strong>*</strong></small></label>
                                                <input type="password" name="password" class="form-control form-control-sm form-control-alternative" placeholder="Password ">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Division <small class="text-warning"><strong>*</strong></small></label>
                                                <select name="iddiv" class="form-control form-control-sm form-control-alternative" required>
                                                    <option value="">- Select Division -</option>
                                                    <?php foreach($division->result() as $dive){ ?>
                                                        <option value="<?= $dive->id ?>" <?php if($row->iddiv == $dive->id){echo "selected";} ?> ><?= $dive->division ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>                
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
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
    </div>

    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('user/action') ?>" method="post">
                <input type="hidden" name="type" value="add">
                <div class="modal-body bg-secondary">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Name <small class="text-warning"><strong>*</strong></small></label>
                                <input type="text" name="name" class="form-control form-control-sm form-control-alternative" placeholder="Name " required>
                            </div>
                            <div class="form-group">
                                <label for="">Email <small class="text-warning"><strong>*</strong></small></label>
                                <input type="email" name="username" class="form-control form-control-sm form-control-alternative" placeholder="Email " required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Password <small class="text-warning"><strong>*</strong></small></label>
                                <input type="password" name="password" class="form-control form-control-sm form-control-alternative" placeholder="Password " required>
                            </div>
                            <div class="form-group">
                                <label for="">Division <small class="text-warning"><strong>*</strong></small></label>
                                <select name="iddiv" class="form-control form-control-sm form-control-alternative" required>
                                    <option value="">- Select Division -</option>
                                    <?php foreach($division->result() as $div){ ?>
                                        <option value="<?= $div->id ?>"><?= $div->division ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>