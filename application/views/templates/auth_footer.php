<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

<!-- JavaScript for sweetalert -->
<script src="<?= base_url('assets/') ?>js/sweetalert2.all.min.js"></script>

<?php if ($this->session->flashdata('message')) : ?>
    <script>
        Swal.fire({
            title: "<?= $this->session->flashdata('title');  ?>",
            text: "<?= $this->session->flashdata('message');  ?>",
            icon: "<?= $this->session->flashdata('icon');  ?>",
        });
    </script>

<?php endif; ?>

</body>

</html>