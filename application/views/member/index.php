<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg">
            <div class="row">
                <div class="col-lg-5">
                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMemberModal">Add New Member</a>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Member Clan486</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Prodi</th>
                                    <th>No Telp</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($member as $m) :
                                    $jabatan = $this->db->get_where('jabatan', ['id' => $m['id_jabatan']])->row_array();
                                    $prodi = $this->db->get_where('prodi', ['id' => $m['id_prodi']])->row_array();
                                    $status = $this->db->get_where('status', ['id' => $m['id_status']])->row_array();
                                ?>
                                    <tr>
                                        <td><?= $status['status']; ?></td>
                                        <td><?= $m['nim']; ?></td>
                                        <td><?= $m['nama']; ?></td>
                                        <td><?= $jabatan['jabatan']; ?></td>
                                        <td><?= $prodi['prodi']; ?></td>
                                        <td><?= $m['telp']; ?></td>
                                        <td>
                                            <a href="<?= base_url('member/edit/') . $m['id']; ?>" class="badge badge-success">Edit</a>
                                            <a href="<?= base_url('member/delete/') . $m['id']; ?>" class="badge badge-danger delete-button">Delete</a>
                                        </td>
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


<!-- Modal Add Member -->
<div class="modal fade" id="newMemberModal" tabindex="-1" role="dialog" aria-labelledby="newMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMemberModalLabel">Add New Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('member') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="NIM">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Full name">
                    </div>
                    <div class="form-group">
                        <select name="id_jabatan" id="id_jabatan" class="form-control">
                            <option value="" disabled selected>Select Jabatan</option>
                            <?php foreach ($jb as $j) : ?>
                                <option value="<?= $j['id'] ?>"><?= $j['jabatan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="id_prodi" id="id_prodi" class="form-control">
                            <option value="" disabled selected>Select Prodi</option>
                            <?php foreach ($pr as $p) : ?>
                                <option value="<?= $p['id'] ?>"><?= $p['prodi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="telp" name="telp" placeholder="No Telp">
                    </div>
                    <div class="form-group">
                        <select name="id_status" id="id_status" class="form-control">
                            <option value="" disabled selected>Select Status</option>
                            <?php foreach ($st as $s) : ?>
                                <option value="<?= $s['id'] ?>"><?= $s['status'] ?></option>
                            <?php endforeach; ?>
                        </select>
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