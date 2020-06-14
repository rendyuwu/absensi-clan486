<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Clan486 <?= date('Y') ?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

<!-- JavaScript for sweetalert -->
<script src="<?= base_url('assets/') ?>js/sweetalert2.all.min.js"></script>

<!-- My Javascript -->
<script src="<?= base_url('assets/') ?>js/admin.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/') ?>vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url('assets/') ?>js/demo/chart-bar-demo.js"></script>
<script src="<?= base_url('assets/') ?>js/demo/chart-pie-demo.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url('assets/') ?>js/demo/datatables-demo.js"></script>

<?php if ($this->session->flashdata('message')) : ?>
    <script>
        Swal.fire({
            title: "<?= $this->session->flashdata('title');  ?>",
            text: "<?= $this->session->flashdata('message');  ?>",
            icon: "<?= $this->session->flashdata('icon');  ?>",
        });
    </script>

<?php endif; ?>


<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });


    $('.role-access').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('admin/changeaccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
            }
        });
    });

    $('.other-access').on('click', function() {
        const other = $(this).data('other');

        $.ajax({
            url: "<?= base_url('admin/otheraccess'); ?>",
            type: 'post',
            data: {
                other: other
            },
            success: function() {
                document.location.href = "<?= base_url('admin/otheraccess') ?>";
            }
        });
    });
</script>

<?php if ($this->session->flashdata('message_other_access') or $this->session->flashdata('message_role_access')) : ?>
    <script>
        Swal.fire({
            title: "Congratulation!",
            text: "Access changed!",
            icon: "success",
        });
    </script>
<?php endif; ?>

</body>

</html>