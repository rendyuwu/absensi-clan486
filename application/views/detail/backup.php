<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Data <?= $title . " " . date("F Y", $date); ?></h1>
    <div class="row">
        <div class="col-lg">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Presensi <?= $week; ?></h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Pindah minggu:</div>
                            <?php if (1 != $this->uri->segment(5)) : ?>
                                <a class="dropdown-item" href="<?= base_url('detail/backup/') . $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/1" ?>">Minggu pertama</a>
                            <?php endif; ?>
                            <?php if (2 != $this->uri->segment(5)) : ?>
                                <a class="dropdown-item" href="<?= base_url('detail/backup/') . $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/2" ?>">Minggu kedua</a>
                            <?php endif; ?>
                            <?php if (3 != $this->uri->segment(5)) : ?>
                                <a class="dropdown-item" href="<?= base_url('detail/backup/') . $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/3" ?>">Minggu ketiga</a>
                            <?php endif; ?>
                            <?php if (4 != $this->uri->segment(5)) : ?>
                                <a class="dropdown-item" href="<?= base_url('detail/backup/') . $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/4" ?>">Minggu keempat</a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Hadir</th>
                                    <th>Izin</th>
                                    <th>Tanpa keterangan</th>
                                    <th>Kosong</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($presensi as $p) :
                                    $member = $this->db->get_where('member', ['id' => $p['id_member']])->row_array();
                                    $status = $this->db->get_where('status', ['id' => $member['id_status']])->row_array();
                                ?>
                                    <tr>
                                        <td><?= $status['status']; ?></td>
                                        <td><?= $member['nim']; ?></td>
                                        <td>
                                            <?= $member['nama']; ?>
                                        </td>
                                        <td>
                                            <label for="hadir-<?= $p['id_member']; ?>">
                                                <?php if ($p['week_' . $this->uri->segment(5)] == 1) : ?>
                                                    <input type="radio" name="id_absen-<?= $p['id_member']; ?>" id="hadir-<?= $p['id_member']; ?>" value="1" checked>Yes
                                                <?php else : ?>
                                                    <input type="radio" name="id_absen-<?= $p['id_member']; ?>" id="hadir-<?= $p['id_member']; ?>" value="1">Yes
                                                <?php endif; ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label for="izin-<?= $p['id_member']; ?>">
                                                <?php if ($p['week_' . $this->uri->segment(5)] == 2) : ?>
                                                    <input type="radio" name="id_absen-<?= $p['id_member']; ?>" id="izin-<?= $p['id_member']; ?>" value="2" checked>Yes
                                                <?php else : ?>
                                                    <input type="radio" name="id_absen-<?= $p['id_member']; ?>" id="izin-<?= $p['id_member']; ?>" value="2">Yes
                                                <?php endif; ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label for="absen-<?= $p['id_member']; ?>">
                                                <?php if ($p['week_' . $this->uri->segment(5)] == 3) : ?>
                                                    <input type="radio" name="id_absen-<?= $p['id_member']; ?>" id="absen-<?= $p['id_member']; ?>" value="3" checked>Yes
                                                <?php else : ?>
                                                    <input type="radio" name="id_absen-<?= $p['id_member']; ?>" id="absen-<?= $p['id_member']; ?>" value="3">Yes
                                                <?php endif; ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label for="kosong-<?= $p['id_member']; ?>">
                                                <?php if ($p['week_' . $this->uri->segment(5)] == 0) : ?>
                                                    <input type="radio" name="id_absen-<?= $p['id_member']; ?>" id="kosong-<?= $p['id_member']; ?>" value="0" checked>Yes
                                                <?php else : ?>
                                                    <input type="radio" name="id_absen-<?= $p['id_member']; ?>" id="kosong-<?= $p['id_member']; ?>" value="0">Yes
                                                <?php endif; ?>
                                            </label>
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