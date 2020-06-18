<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-11">

            <?= form_error('year', '<div class="alert alert-danger" role="alert">', '</div>') ?>

            <?php if ($user['role_id'] != 3) : ?>
                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newPriodeModal">Add New Priode</a>
            <?php else : ?>
                <a href="" class="btn btn-secondary mb-3">Add New Priode</a>
            <?php endif; ?>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Priode Clan486</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Priode</th>
                                    <th>Week I</th>
                                    <th>Week II</th>
                                    <th>Week III</th>
                                    <th>Week IV</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($priode as $p) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= date("F Y", $p['date']); ?></td>
                                        <td><a href="<?= base_url('detail/presensi/') . date("Y", $p['date']) . "/" . date("m", $p['date']) . "/1"; ?>" class="badge badge-primary">Detail</a></td>
                                        <td><a href="<?= base_url('detail/presensi/') . date("Y", $p['date']) . "/" . date("m", $p['date']) . "/2"; ?>" class="badge badge-primary">Detail</a></td>
                                        <td><a href="<?= base_url('detail/presensi/') . date("Y", $p['date']) . "/" . date("m", $p['date']) . "/3"; ?>" class="badge badge-primary">Detail</a></td>
                                        <td><a href="<?= base_url('detail/presensi/') . date("Y", $p['date']) . "/" . date("m", $p['date']) . "/4"; ?>" class="badge badge-primary">Detail</a></td>
                                        <td>
                                            <?php if ($user['role_id'] != 3) : ?>
                                                <a href="<?= base_url('presensi/edit/') . $p['id']; ?>" class="badge badge-success">Edit</a>
                                                <a href="<?= base_url('presensi/delete/') . $p['id']; ?>" class="badge badge-danger delete-button">Delete</a>
                                            <?php else : ?>
                                                <a href="#" class="badge badge-secondary">Edit</a>
                                                <a href="#" class="badge badge-secondary">Delete</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Modal Add Priode -->
<div class="modal fade" id="newPriodeModal" tabindex="-1" role="dialog" aria-labelledby="newPriodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPriodeModalLabel">Add New Priode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('presensi') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="month" id="month" class="form-control">
                            <option value="" disabled selected>Select Month</option>
                            <?php foreach ($month as $m) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['month']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="year" name="year" placeholder="Year">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>