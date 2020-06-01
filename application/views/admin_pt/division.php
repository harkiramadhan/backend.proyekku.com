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
            <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#addDiv"><strong>+</strong> Add Division</button>
        </div>
        <div class="col">
            <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
                <h3 class="text-white mb-0">Division</h3>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-dark table-flush">
                <thead class="thead-dark">
                    <tr>
                        <th width="5px">No</th>
                        <th>Division</th>
                        <th width="5px" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="list">
                    <?php 
                    $no = 1;
                    foreach($division->result() as $row){ ?>
                    <tr>
                        <th><?= $no++ ?></th>
                        <th><?= $row->division ?></th>
                        <td class="text-center">
                            <form action="<?= site_url('division/action') ?>" method="post">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-info mr-1" data-toggle="modal" data-target="#edit_<?= $row->id ?>"><i class="fas fa-pencil-alt"></i></button>
                                <input type="hidden" name="id" value="<?= $row->id ?>">
                                <input type="hidden" name="type" value="delete">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="edit_<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Division</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= site_url('division/action') ?>" method="post">
                                <input type="hidden" name="type" value="edit">
                                <input type="hidden" name="id" value="<?= $row->id ?>">
                                <div class="modal-body bg-secondary">
                                    <div class="form-group">
                                        <label for="">Division <small class="text-warning"><strong>*</strong></small></label>
                                        <input type="text" name="division" class="form-control-alternative form-control form-control-sm" value="<?= $row->division ?>" required>
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

    <div class="modal fade" id="addDiv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Division</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('division/action') ?>" method="post">
                <input type="hidden" name="type" value="add">
                <div class="modal-body bg-secondary">
                    <div class="form-group">
                        <label for="">Division <small class="text-warning"><strong>*</strong></small></label>
                        <input type="text" name="division" class="form-control-alternative form-control form-control-sm" required>
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