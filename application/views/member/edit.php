<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">

            <form action="<?= base_url('member/edit') ?>" method="post">
                <input type="hidden" name="id" value="<?= $member['id']; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?= $member['nim']; ?>">
                        <?= form_error('nim', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="nama">Full Name</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $member['nama']; ?>">
                        <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="id_jabatan">Jabatan</label>
                        <select name="id_jabatan" id="id_jabatan" class="form-control">
                            <option value="" disabled selected>Select Jabatan</option>
                            <?php foreach ($jb as $j) : ?>
                                <?php if ($member['id_jabatan'] == $j['id']) : ?>
                                    <option value="<?= $j['id'] ?>" selected><?= $j['jabatan'] ?></option>
                                <?php else : ?>
                                    <option value="<?= $j['id'] ?>"><?= $j['jabatan'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_prodi">Prodi</label>
                        <select name="id_prodi" id="id_prodi" class="form-control">
                            <option value="" disabled selected>Select Prodi</option>
                            <?php foreach ($pr as $p) : ?>
                                <?php if ($member['id_prodi'] == $p['id']) : ?>
                                    <option value="<?= $p['id'] ?>" selected><?= $p['prodi'] ?></option>
                                <?php else : ?>
                                    <option value="<?= $p['id'] ?>"><?= $p['prodi'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="telp">No Telp</label>
                        <input type="text" class="form-control" id="telp" name="telp" value="<?= $member['telp']; ?>">
                        <?= form_error('telp', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="id_status">Status</label>
                        <select name="id_status" id="id_status" class="form-control">
                            <option value="" disabled selected>Select Status</option>
                            <?php foreach ($st as $s) : ?>
                                <?php if ($member['id_status'] == $s['id']) : ?>
                                    <option value="<?= $s['id'] ?>" selected><?= $s['status'] ?></option>
                                <?php else : ?>
                                    <option value="<?= $s['id'] ?>"><?= $s['status'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url('member'); ?>" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->