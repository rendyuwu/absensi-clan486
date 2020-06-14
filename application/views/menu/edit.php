<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-4">


            <form method="post" action="<?= base_url('menu/edit') ?>">
                <div class="form-group">
                    <label for="menu">Edit Menu</label>
                    <input type="hidden" name="id" value="<?= $this->uri->segment(3); ?>">
                    <input type="text" class="form-control" name="menu" id="menu" value="<?= $menu['menu'] ?>">
                    <?= form_error('menu', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="float-right">
                    <a href="<?= base_url('menu') ?>" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->