<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">

            <?php if ($active == NULL) : ?>
                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newActiveModal">Generate Surat Aktif</a>
            <?php else : ?>
                <a href="active/truncate" class="btn btn-danger mb-3 delete-button">Clear Data</a>
            <?php endif; ?>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <?php if ($active != NULL) : ?>
                        <h6 class="m-0 font-weight-bold text-primary">Data <?= $title . " " . date('F Y', $active[0]['from_date']) . " - " . date('F Y', $active[0]['to_date']); ?></h6>
                    <?php else : ?>
                        <h6 class="m-0 font-weight-bold text-primary">Data <?= $title; ?></h6>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Total kehadiran</th>
                                    <th>Presentase kehadiran</th>
                                    <th>Minimal kehadiran</th>
                                    <th>Surat aktif?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($active as $a) :
                                    $member = $this->db->get_where('member', ['id' => $a['id_member']])->row_array();
                                    if ($a['active'] == true) {
                                        $active = "Yes";
                                    } else {
                                        $active = "No";
                                    }
                                ?>
                                    <tr>
                                        <td><?= @$member['nim']; ?></td>
                                        <td><?= @$member['nama']; ?></td>
                                        <td><?= @$a['total']; ?></td>
                                        <td><?= @$a['presentase']; ?>%</td>
                                        <td><?= @$a['minimal']; ?>%</td>
                                        <td><?= @$active; ?></td>
                                    </tr>
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


<!-- Modal Add Active -->
<div class="modal fade" id="newActiveModal" tabindex="-1" role="dialog" aria-labelledby="newActiveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newActiveModalLabel">Generate Surat Aktif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('active/generate') ?>" method="post">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="selectFromPriode">Form priode</label>
                                <select class="form-control" id="selectFromPriode" name="selectFromPriode">
                                    <option disabled selected>Select priode</option>
                                    <?php foreach ($priode as $p) : ?>
                                        <option value="<?= $p['date']; ?>"><?= date('F Y', $p['date']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="selectToPriode">To priode</label>
                                <select class="form-control" id="selectToPriode" name="selectToPriode">
                                    <option disabled selected>Select priode</option>
                                    <?php foreach ($priode as $p) : ?>
                                        <option value="<?= $p['date']; ?>"><?= date('F Y', $p['date']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>