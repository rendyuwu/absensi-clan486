<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <div class="row">
        <div class="col-lg-4">


            <form action="<?= base_url('menu/submenuedit') ?>" method="post">
                <input type="hidden" name="id" value=<?= $this->uri->segment(3) ?>>
                <div class="form-group">
                    <label for="title">Submenu title</label>
                    <input type="text" class="form-control" name="title" id="title" neme="title" value="<?= $subMenu['title']; ?>">
                    <?= form_error('title', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="menu_id">Menu</label>
                    <select name="menu_id" id="menu_id" class="form-control">
                        <?php foreach ($menu as $m) : ?>
                            <?php if ($subMenu['menu_id'] == $m['id']) : ?>
                                <option value="<?= $m['id'] ?>" selected><?= $m['menu'] ?></option>
                            <?php else : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="url">Submenu url</label>
                    <input type="text" class="form-control" id="url" name="url" value="<?= $subMenu['url']; ?>">
                    <?= form_error('url', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="icon">Submenu icon</label>
                    <input type="text" class="form-control" id="icon" name="icon" value="<?= $subMenu['icon']; ?>">
                    <?= form_error('icon', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <?php if ($subMenu['is_active'] == 1) : ?>
                            <input class="form-check-input" type="checkbox" value="1" name="is_active" checked id="is_active">
                        <?php else : ?>
                            <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active">
                        <?php endif; ?>
                        <label class="form-check-label" for="is_active">
                            Active?
                        </label>
                    </div>
                </div>
                <div class="float-right">
                    <a href="<?= base_url('menu/submenu') ?>" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->