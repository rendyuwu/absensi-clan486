<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-4">


            <form method="post" action="<?= base_url('presensi/edit') ?>">
                <input type="hidden" name="id" value="<?= $this->uri->segment(3); ?>">
                <div class="form-group">
                    <select name="month" id="month" class="form-control">
                        <option value="" disabled selected>Select Month</option>
                        <?php foreach ($month as $m) : ?>
                            <?php $oldMonth = date("F", $priode['date']); ?>
                            <?php if ($m['month'] == $oldMonth) : ?>
                                <option value="<?= $m['id']; ?>" selected><?= $m['month']; ?></option>
                            <?php else : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['month']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="year">Edit Year</label>
                    <input required type="text" class="form-control" name="year" id="year" value="<?= date("Y", $priode['date']); ?>">
                    <?= form_error('year', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="float-right">
                    <a href="<?= base_url('presensi') ?>" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->