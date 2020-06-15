<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Backup Clan486</h6>
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
                                    <th>Automatic delete</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($backup as $b) :
                                    $curentDate = time();
                                    $expire = strtotime(date('Y-m-d H:i:s', $b['expire']));
                                    $diff = $expire - $curentDate;
                                    $day = floor($diff / (60 * 60 * 24));
                                    $hour = floor($diff / (60 * 60));
                                    $minute = floor($diff / 60);
                                    $second = $diff;
                                ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= date("F Y", $b['date']); ?></td>
                                        <td><a href="<?= base_url('detail/backup/') . date("Y", $b['date']) . "/" . date("m", $b['date']) . "/1"; ?>" class="badge badge-primary">Detail</a></td>
                                        <td><a href="<?= base_url('detail/backup/') . date("Y", $b['date']) . "/" . date("m", $b['date']) . "/2"; ?>" class="badge badge-primary">Detail</a></td>
                                        <td><a href="<?= base_url('detail/backup/') . date("Y", $b['date']) . "/" . date("m", $b['date']) . "/3"; ?>" class="badge badge-primary">Detail</a></td>
                                        <td><a href="<?= base_url('detail/backup/') . date("Y", $b['date']) . "/" . date("m", $b['date']) . "/4"; ?>" class="badge badge-primary">Detail</a></td>
                                        <?php if ($day > 0) : ?>
                                            <td><?= $day; ?> days left</td>
                                        <?php elseif ($hour > 0) : ?>
                                            <td><?= $hour; ?> hour left</td>
                                        <?php elseif ($minute > 0) : ?>
                                            <td><?= $minute; ?> minute left</td>
                                        <?php elseif ($second > 0) : ?>
                                            <td><?= $second; ?> second left</td>
                                        <?php endif; ?>
                                        <td>
                                            <a href="<?= base_url('backup/restore/') . $b['id']; ?>" class="badge badge-success">Restore</a>
                                            <a href="<?= base_url('backup/delete/') . $b['id']; ?>" class="badge badge-danger delete-button">Delete</a>
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