<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title . " " . date("F Y", $date); ?></h1>
    <div class="row">
        <div class="col-lg">
            <?php if ($lastPriode == 0) : ?>
                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMemberModal">Add Member</a>
            <?php endif; ?>
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
                                <a class="dropdown-item" href="<?= base_url('detail/presensi/') . $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/1" ?>">Minggu pertama</a>
                            <?php endif; ?>
                            <?php if (2 != $this->uri->segment(5)) : ?>
                                <a class="dropdown-item" href="<?= base_url('detail/presensi/') . $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/2" ?>">Minggu kedua</a>
                            <?php endif; ?>
                            <?php if (3 != $this->uri->segment(5)) : ?>
                                <a class="dropdown-item" href="<?= base_url('detail/presensi/') . $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/3" ?>">Minggu ketiga</a>
                            <?php endif; ?>
                            <?php if (4 != $this->uri->segment(5)) : ?>
                                <a class="dropdown-item" href="<?= base_url('detail/presensi/') . $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/4" ?>">Minggu keempat</a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <form action="<?= base_url('detail/update') ?>" method="post">
                    <input type="hidden" name="year" value="<?= $this->uri->segment(3); ?>">
                    <input type="hidden" name="month" value="<?= $this->uri->segment(4); ?>">
                    <input type="hidden" name="week" value="<?= $this->uri->segment(5); ?>">
                    <input type="hidden" name="lastPriode" value="<?= $lastPriode; ?>">
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
                                        if ($lastPriode == 0) {
                                            $member = $this->db->get_where('member', ['id' => $p['id_member']])->row_array();
                                            $status = $this->db->get_where('status', ['id' => $member['id_status']])->row_array();

                                            $status = $status['status'];
                                            $nim = $member['nim'];
                                            $nama = $member['nama'];
                                            $id_member = $p['id_member'];
                                            $week = $p['week_' . $this->uri->segment(5)];
                                        } elseif ($lastPriode == 3) {
                                            $status = $p['id_status'];
                                            $nim = $p['nim'];
                                            $nama = $p['nama'];
                                            $id_member = $p['id'];

                                            $this->db->where('date', $date);
                                            $this->db->where('id_member', $id_member);
                                            $dataPresensi = $this->db->get('presensi')->row_array();
                                            $week = $dataPresensi['week_' . $this->uri->segment(5)];

                                            $status = $this->db->get_where('status', ['id' => $status])->row_array();
                                            $status = $status['status'];
                                        } else {
                                            $status = $p['id_status'];
                                            $nim = $p['nim'];
                                            $nama = $p['nama'];
                                            $id_member = $p['id'];

                                            $status = $this->db->get_where('status', ['id' => $status])->row_array();
                                            $status = $status['status'];
                                        }
                                    ?>
                                        <?php
                                        echo "<br>";
                                        var_dump($id_member);
                                        echo "<br>";
                                        ?>
                                        <tr>
                                            <td><?= $status; ?></td>
                                            <td><?= $nim; ?></td>
                                            <td>
                                                <?= $nama; ?>
                                                <input type="hidden" name="id_member-<?= $id_member; ?>" value="<?= $id_member; ?>">
                                                <?php if ($lastPriode == 0) : ?>
                                                    <input type="hidden" name="id_presensi-<?= $id_member; ?>" value="<?= $p['id']; ?>">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <label for="hadir-<?= $id_member; ?>">
                                                    <?php if ($week == 1) : ?>
                                                        <input type="radio" name="id_absen-<?= $id_member; ?>" id="hadir-<?= $id_member; ?>" value="1" checked>Yes
                                                    <?php else : ?>
                                                        <input type="radio" name="id_absen-<?= $id_member; ?>" id="hadir-<?= $id_member; ?>" value="1">Yes
                                                    <?php endif; ?>
                                                </label>
                                            </td>
                                            <td>
                                                <label for="izin-<?= $id_member; ?>">
                                                    <?php if ($week == 2) : ?>
                                                        <input type="radio" name="id_absen-<?= $id_member; ?>" id="izin-<?= $id_member; ?>" value="2" checked>Yes
                                                    <?php else : ?>
                                                        <input type="radio" name="id_absen-<?= $id_member; ?>" id="izin-<?= $id_member; ?>" value="2">Yes
                                                    <?php endif; ?>
                                                </label>
                                            </td>
                                            <td>
                                                <label for="absen-<?= $id_member; ?>">
                                                    <?php if ($week == 3) : ?>
                                                        <input type="radio" name="id_absen-<?= $id_member; ?>" id="absen-<?= $id_member; ?>" value="3" checked>Yes
                                                    <?php else : ?>
                                                        <input type="radio" name="id_absen-<?= $id_member; ?>" id="absen-<?= $id_member; ?>" value="3">Yes
                                                    <?php endif; ?>
                                                </label>
                                            </td>
                                            <td>
                                                <label for="kosong-<?= $id_member; ?>">
                                                    <?php if ($week == 0) : ?>
                                                        <input type="radio" name="id_absen-<?= $id_member; ?>" id="kosong-<?= $id_member; ?>" value="0" checked>Yes
                                                    <?php else : ?>
                                                        <input type="radio" name="id_absen-<?= $id_member; ?>" id="kosong-<?= $id_member; ?>" value="0">Yes
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
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?php if ($presensi != NULL) : ?>
                <button type="submit" class="btn btn-primary btn-block"><?= $button; ?></button>
            <?php endif; ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    </form>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Modal Add Priode -->
<div class="modal fade" id="newMemberModal" tabindex="-1" role="dialog" aria-labelledby="newMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMemberModalLabel">Add Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('detail/add') ?>" method="post">
                <input type="hidden" name="year" value="<?= $this->uri->segment(3); ?>">
                <input type="hidden" name="month" value="<?= $this->uri->segment(4); ?>">
                <input type="hidden" name="week" value="<?= $this->uri->segment(5); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="newNim">NIM :</label>
                        <input type="text" class="form-control" id="newNim" name="newNim" placeholder="Ex : 18.31.0001">
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