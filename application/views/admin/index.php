<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        <?php if ($get_report == false) : ?>
            <a href="" class="mb-3 d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#newReportModal"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        <?php else : ?>
            <a href="admin/resetreport" class="mb-3 d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm delete-button"><i class="fas fa-download fa-sm text-white-50"></i> Reset Report</a>
        <?php endif; ?>
    </div>


    <!-- Content Row -->
    <div class="row">

        <!-- Anggota (Aktif) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Anggota (Aktif)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $anggota_aktif; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anggota (Alumni) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Anggota (Alumni)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $anggota_alumni; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengurus Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pengurus</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $pengurus; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Anggota Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Anggota</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_anggota; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Content Row -->

    <div class="row">

        <!-- Bar Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Total kehadiran Mey 2021</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Rata - rata</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Hadir
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Izin
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Tanpa Keterangan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Modal Add Report -->
<div class="modal fade" id="newReportModal" tabindex="-1" role="dialog" aria-labelledby="newReportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newReportModalLabel">Generate Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/report') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="selectPriode">Select priode</label>
                        <select class="form-control" id="selectPriode" name="selectPriode">
                            <option selected disabled>Select priode</option>
                            <?php foreach ($priode as $p) : ?>
                                <option value="<?= $p['date']; ?>"><?= date('F Y', $p['date']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <p>OR :</p>
                    <div class="form-row">
                        <div class="col">
                            <select class="form-control" id="inputMonth" name="inputMonth">
                                <option selected disabled>Select month</option>
                                <?php foreach ($month as $m) : ?>
                                    <option value="<?= $m['id']; ?>"><?= $m['month']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="inputYear" placeholder="Year">
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