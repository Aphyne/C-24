<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../../login/index.php'</script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Poli Klinik | Data Master - Poli</title>
    <link href="../../assets/css/styles.css" rel="stylesheet" />
    <link href="../../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="../../assets/js/all.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="../../index.php">Poli Klinik</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-light" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="../../login/logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
<div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Poli Klinik</div>
                        <a class="nav-link " href="../../index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <!-- SIDEBAR -->
                        <?php if ($_SESSION["jabatan"] == 'admin') : ?>
                            <a class="nav-link collapsed" href="../../index.php" data-toggle="collapse" data-target="#data-master" aria-expanded="false" aria-controls="data-master">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Data Master
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="data-master" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../data-pasien/pasien.php">Data Pasien</a>
                                    <a class="nav-link" href="../data-dokter/dokter.php">Data Dokter</a>
                                    <a class="nav-link" href="../data-obat/obat.php">Data Obat</a>
                                    <a class="nav-link active" href="data-staff/staff.php">Data Staff</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="../../data-pendaftaran/pendaftaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Data Pendaftaran
                            </a>
                            <a class="nav-link" href="../../data-pemeriksaan/pemeriksaan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Data Pemeriksaan
                            </a>
                            <a class="nav-link" href="../../keuntungan/keuntungan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                                Keuntungan
                            </a>
                            <a class="nav-link" href="../../data-pembayaran/pembayaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Pengeluaran
                            </a>
                            <div class="sb-sidenav-menu-heading">Admin</div>
                            <a class="nav-link" href="user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Data User
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pendaftaran') : ?>
                            <a class="nav-link" href="data-master/data-pasien/pasien.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                                
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" class="bg-white text-dark">
            <main>
                <div class="container-fluid">
                      <!-- ===================== Row 1: Ringkasan Data Staff ===================== -->
                    <h1 class="mt-4">Ringkasan Data Staff</h1>
                    <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card bg-primary text-white shadow">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <h5>Total Staff Aktif</h5>
                            <h3>18 Orang</h3>
                            </div>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-info text-white shadow">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <h5>Rata-rata Kehadiran</h5>
                            <h3>92%</h3>
                            </div>
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-danger text-white shadow">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <h5>Staff Cuti / Nonaktif</h5>
                            <h3>2 Orang</h3>
                            </div>
                            <i class="fas fa-user-slash fa-2x"></i>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-warning text-white shadow">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <h5>Jam Kerja / Minggu</h5>
                            <h3>38 Jam</h3>
                            </div>
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        </div>
                    </div>
                    </div>

                    <!-- Script Data Summary (Hardcode Array) -->
                    <script>
                    const dataSummaryStaff = {
                    totalStaffAktif: 18,
                    rataKehadiran: 92,
                    nonAktif: 2,
                    jamKerjaMinggu: 38
                    };
                    </script>

                    <!-- ===================== Row 2: Review Performa Staff ===================== -->
                    <?php
                    $staffPerformance = [
                        [
                            "nama" => "Suster Ayu",
                            "posisi" => "Admin Apotik",
                            "jam_kerja" => 160,
                            "target_jam" => 176,
                            "kehadiran" => 95,
                            "shift" => 22,
                            "lembur" => 4,
                            "rating" => 4.9,
                            "rating_bintang" => "★★★★★",
                            "status" => "Sangat Baik",
                            "badge" => "success",
                            "catatan" => "Performa stabil dan disiplin."
                        ],
                        [
                            "nama" => "Dita",
                            "posisi" => "Kasir",
                            "jam_kerja" => 150,
                            "target_jam" => 176,
                            "kehadiran" => 82,
                            "shift" => 20,
                            "lembur" => 2,
                            "rating" => 4.3,
                            "rating_bintang" => "★★★★☆",
                            "status" => "Cukup",
                            "badge" => "warning",
                            "catatan" => "Perlu peningkatan kehadiran."
                        ],
                        [
                            "nama" => "Andre",
                            "posisi" => "Apoteker",
                            "jam_kerja" => 140,
                            "target_jam" => 176,
                            "kehadiran" => 80,
                            "shift" => 18,
                            "lembur" => 1,
                            "rating" => 3.8,
                            "rating_bintang" => "★★★☆☆",
                            "status" => "Perlu Monitoring",
                            "badge" => "danger",
                            "catatan" => "Kehadiran dan jam kerja di bawah rata-rata."
                        ],
                        [
                            "nama" => "Sinta",
                            "posisi" => "Suster",
                            "jam_kerja" => 170,
                            "target_jam" => 176,
                            "kehadiran" => 98,
                            "shift" => 24,
                            "lembur" => 5,
                            "rating" => 4.7,
                            "rating_bintang" => "★★★★☆",
                            "status" => "Sangat Baik",
                            "badge" => "success",
                            "catatan" => "Performa sangat baik, selalu tepat waktu."
                        ],
                        [
                            "nama" => "Budi",
                            "posisi" => "Cleaning Service",
                            "jam_kerja" => 160,
                            "target_jam" => 176,
                            "kehadiran" => 90,
                            "shift" => 20,
                            "lembur" => 3,
                            "rating" => 4.0,
                            "rating_bintang" => "★★★☆☆",
                            "status" => "Cukup",
                            "badge" => "warning",
                            "catatan" => "Kehadiran baik, perlu peningkatan jam kerja."
                        ],
                        [
                            "nama" => "Rina",
                            "posisi" => "Admin",
                            "jam_kerja" => 155,
                            "target_jam" => 176,
                            "kehadiran" => 85,
                            "shift" => 21,
                            "lembur" => 2,
                            "rating" => 4.1,
                            "rating_bintang" => "★★★★☆",
                            "status" => "Cukup",
                            "badge" => "warning",
                            "catatan" => "Perlu peningkatan disiplin."
                        ],
                        [
                            "nama" => "Fajar",
                            "posisi" => "Kasir",
                            "jam_kerja" => 145,
                            "target_jam" => 176,
                            "kehadiran" => 78,
                            "shift" => 19,
                            "lembur" => 1,
                            "rating" => 3.5,
                            "rating_bintang" => "★★★☆☆",
                            "status" => "Perlu Monitoring",
                            "badge" => "danger",
                            "catatan" => "Kehadiran dan jam kerja di bawah standar."
                        ],
                        [
                            "nama" => "Dewi",
                            "posisi" => "Apoteker",
                            "jam_kerja" => 180,
                            "target_jam" => 176,
                            "kehadiran" => 100,
                            "shift" => 25,
                            "lembur" => 6,
                            "rating" => 5.0,
                            "rating_bintang" => "★★★★★",
                            "status" => "Sangat Baik",
                            "badge" => "success",
                            "catatan" => "Performa luar biasa, selalu melebihi target."
                        ],
                        [
                            "nama" => "Yusuf",
                            "posisi" => "Suster",
                            "jam_kerja" => 175,
                            "target_jam" => 176,
                            "kehadiran" => 95,
                            "shift" => 23,
                            "lembur" => 4,
                            "rating" => 4.8,
                            "rating_bintang" => "★★★★☆",
                            "status" => "Baik",
                            "badge" => "success",
                            "catatan" => "Performa baik, selalu tepat waktu."
                        ],
                        [
                            "nama" => "Lina",
                            "posisi" => "Admin",
                            "jam_kerja" => 165,
                            "target_jam" => 176,
                            "kehadiran" => 90,
                            "shift" => 22,
                            "lembur" => 3,
                            "rating" => 4.2,
                            "rating_bintang" => "★★★★☆",
                            "status" => "Baik",
                            "badge" => "success",
                            "catatan" => "Performa baik, selalu tepat waktu."
                        ]
                    ];
                    ?>

                    <h4 class="mb-4 font-weight-bold text-secondary">Review Performa Staff</h4>
                    <div class="d-flex justify-content-between mb-3">
                    <div>
                        <input type="text" id="searchInput" class="form-control d-inline-block mr-2" style="width: 200px;" placeholder="Cari nama atau posisi">
                        <select id="filterStatus" class="form-control d-inline-block mr-2" style="width: 150px;">
                        <option value="">Semua Status</option>
                        <option value="Sangat Baik">Sangat Baik</option>
                        <option value="Cukup">Cukup</option>
                        <option value="Perlu Monitoring">Perlu Monitoring</option>
                        </select>
                        <select id="filterPosisi" class="form-control d-inline-block mr-2" style="width: 150px;">
                        <option value="">Semua Posisi</option>
                        <option value="Admin Apotik">Admin Apotik</option>
                        <option value="Kasir">Kasir</option>
                        <option value="Apoteker">Apoteker</option>
                        </select>
                        <button class="btn btn-secondary btn-sm" id="resetFilter">Reset</button>
                    </div>
                    <button class="btn btn-outline-primary" data-toggle="modal" data-target="#topStaffModal">
                        <i class="fas fa-trophy mr-2"></i>Lihat Top 3 Staff Terbaik
                    </button>
                    </div>

                    <!-- Modal Popup - Top 3 Staff Terbaik -->
                    <div class="modal fade" id="topStaffModal" tabindex="-1" role="dialog" aria-labelledby="topStaffModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="topStaffModalLabel"><i class="fas fa-trophy mr-2"></i>Top 3 Staff Terbaik Bulan Ini</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php
                            $topStaff = [
                            ["rank" => 1, "nama" => "Ayu", "posisi" => "Admin Apotik", "jam" => 176, "kehadiran" => 98, "rating" => 4.9, "badge" => "Teladan"],
                            ["rank" => 2, "nama" => "Budi", "posisi" => "Apoteker", "jam" => 170, "kehadiran" => 95, "rating" => 4.7, "badge" => "Sangat Baik"],
                            ["rank" => 3, "nama" => "Sinta", "posisi" => "Kasir", "jam" => 168, "kehadiran" => 94, "rating" => 4.6, "badge" => "Konsisten"]
                            ];
                            ?>
                            <div class="row">
                            <?php foreach ($topStaff as $staff) { ?>
                                <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0"><i class="fas fa-trophy mr-1"></i> Peringkat <?= $staff['rank'] ?></h5>
                                    </div>
                                    <div class="card-body">
                                    <h6><strong><?= $staff['nama'] ?></strong></h6>
                                    <p class="text-muted mb-1">Posisi: <?= $staff['posisi'] ?></p>
                                    <p class="mb-1"><i class="fas fa-clock mr-1"></i> Jam Kerja: <?= $staff['jam'] ?> jam</p>
                                    <p class="mb-1"><i class="fas fa-calendar-check mr-1"></i> Kehadiran: <?= $staff['kehadiran'] ?>%</p>
                                    <p class="mb-1"><i class="fas fa-star text-warning mr-1"></i> Rating: <?= $staff['rating'] ?>/5.0</p>
                                    </div>
                                    <div class="card-footer text-center">
                                    <span class="badge badge-success px-3 py-1"><?= $staff['badge'] ?></span>
                                    </div>
                                </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>


                    <div class="row" id="staffCards">
                        <?php foreach ($staffPerformance as $staff) { ?>
                            <div class="col-md-4 mb-4 staff-card" 
                                data-nama="<?= strtolower($staff['nama']) ?>"
                                data-posisi="<?= strtolower($staff['posisi']) ?>"
                                data-status="<?= strtolower($staff['status']) ?>">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header bg-primary text-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div><?= $staff['nama'] ?> (<?= $staff['posisi'] ?>)</div>
                                            <i class="fas fa-user fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <p><b>Jam Kerja:</b>
                                            <span class="counter" data-count="<?= $staff['jam_kerja'] ?>">0</span> Jam / Target <?= $staff['target_jam'] ?> Jam
                                        </p>
                                        <div class="progress mb-2" style="height: 10px;">
                                            <div class="progress-bar bg-success" data-width="<?= round(($staff['jam_kerja'] / $staff['target_jam']) * 100) ?>"></div>
                                        </div>

                                        <p><b>Kehadiran:</b> <span class="badge badge-<?= $staff['kehadiran'] >= 90 ? 'success' : ($staff['kehadiran'] >= 85 ? 'warning' : 'danger') ?>"><?= $staff['kehadiran'] ?>%</span></p>

                                        <p><b>Shift & Lembur:</b> <?= $staff['shift'] ?> Shift (<?= $staff['lembur'] ?> Lembur)</p>

                                        <p><b>Rating Kepuasan:</b> <span class="text-warning"><?= $staff['rating_bintang'] ?></span> (<?= $staff['rating'] ?>)</p>

                                        <p><b>Catatan:</b> <?= $staff['catatan'] ?></p>
                                    </div>
                                    <div class="card-footer text-center">
                                        <span class="badge badge-<?= $staff['badge'] ?>">Status: <?= $staff['status'] ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Pagination Control -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button id="prevPage" class="btn btn-outline-secondary btn-sm"><i class="fas fa-angle-left mr-1"></i> Previous</button>
                        <button id="nextPage" class="btn btn-outline-secondary btn-sm">Next <i class="fas fa-angle-right ml-1"></i></button>
                    </div>


                    <!-- Script for Counter, Progress & Filter -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $('.counter').each(function () {
                            var $this = $(this);
                            var countTo = parseInt($this.attr('data-count'));
                            $({ countNum: 0 }).animate(
                                { countNum: countTo },
                                {
                                    duration: 1500,
                                    easing: 'swing',
                                    step: function () {
                                        $this.text(Math.floor(this.countNum));
                                    },
                                    complete: function () {
                                        $this.text(this.countNum);
                                    }
                                }
                            );
                        });

                        $('.progress-bar').each(function () {
                            var $this = $(this);
                            var targetWidth = $this.data('width');
                            $this.animate({ width: targetWidth + '%' }, 1500);
                        });

                        $('#searchInput, #filterStatus, #filterPosisi').on('input change', function () {
                            var keyword = $('#searchInput').val().toLowerCase();
                            var status = $('#filterStatus').val().toLowerCase();
                            var posisi = $('#filterPosisi').val().toLowerCase();

                            $('.staff-card').each(function () {
                                var nama = $(this).data('nama');
                                var posisiCard = $(this).data('posisi');
                                var statusCard = $(this).data('status');

                                var match = true;
                                if (keyword && !(nama.includes(keyword) || posisiCard.includes(keyword))) match = false;
                                if (status && statusCard !== status) match = false;
                                if (posisi && posisiCard !== posisi) match = false;

                                $(this).toggle(match);
                            });
                        });

                        $('#resetFilter').on('click', function () {
                            $('#searchInput').val('');
                            $('#filterStatus').val('');
                            $('#filterPosisi').val('');
                            $('.staff-card').show();
                        });
                    </script>
                    <script>
                    let currentPage = 1;
                    const itemsPerPage = 6;

                    function showPage(page) {
                        const cards = $('.staff-card');
                        const totalPages = Math.ceil(cards.length / itemsPerPage);
                        cards.hide();
                        const start = (page - 1) * itemsPerPage;
                        const end = start + itemsPerPage;
                        cards.slice(start, end).show();
                        currentPage = page;
                        $('#prevPage').prop('disabled', currentPage === 1);
                        $('#nextPage').prop('disabled', currentPage === totalPages);
                    }

                    $('#prevPage').click(() => {
                        if (currentPage > 1) showPage(currentPage - 1);
                    });

                    $('#nextPage').click(() => {
                        const totalPages = Math.ceil($('.staff-card').length / itemsPerPage);
                        if (currentPage < totalPages) showPage(currentPage + 1);
                    });

                    $(document).ready(() => {
                        showPage(1); // Show first page on load
                    });
                    </script>

                    <!-- Visualisasi Staff Row 3 - Versi Modern (Donut + Bar per Staff) -->
                    <h4 class="mt-5 mb-3 font-weight-bold text-secondary">Visualisasi Tenaga Kerja Berdasarkan Posisi</h4>
                    <div class="row">
                    <!-- Donut Chart Komposisi Staff -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">📊 Distribusi Jumlah Staff per Posisi</h6>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center" style="height: 350px;">
                            <canvas id="donutChart"></canvas>
                        </div>
                        </div>
                    </div>

                    <!-- Bar Chart Rata-rata Kehadiran per Staff dengan Filter Posisi -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">📉 Rata-rata Kehadiran per Staff</h6>
                            <select id="posisiFilter" class="form-control form-control-sm w-auto">
                            <option value="all">Semua Posisi</option>
                            <option value="Admin">Admin</option>
                            <option value="Apoteker">Apoteker</option>
                            <option value="Kasir">Kasir</option>
                            <option value="Suster">Suster</option>
                            <option value="Cleaning Service">Cleaning Service</option>
                            </select>
                        </div>
                        <div class="card-body" style="height: 350px;">
                            <canvas id="barChartStaff"></canvas>
                        </div>
                        </div>
                    </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                    // Donut Chart Data
                    const posisiLabels = ["Admin", "Apoteker", "Kasir", "Suster", "Cleaning Service"];
                    const posisiJumlah = [5, 2, 3, 4, 2];
                    const donutColors = ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#dc3545'];

                    const donutChart = new Chart(document.getElementById('donutChart'), {
                        type: 'doughnut',
                        data: {
                        labels: posisiLabels,
                        datasets: [{
                            data: posisiJumlah,
                            backgroundColor: donutColors
                        }]
                        },
                        options: {
                        cutout: '70%',
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                const total = posisiJumlah.reduce((a, b) => a + b);
                                const val = posisiJumlah[ctx.dataIndex];
                                const percent = ((val / total) * 100).toFixed(1);
                                return `${ctx.label}: ${val} staff (${percent}%)`;
                                }
                            }
                            }
                        }
                        }
                    });

                    // Data Kehadiran per Staff
                    const staffData = [
                        { nama: "Suster Ayu", posisi: "Admin", hadir: 92 },
                        { nama: "Dita", posisi: "Kasir", hadir: 80 },
                        { nama: "Andre", posisi: "Apoteker", hadir: 88 },
                        { nama: "Budi", posisi: "Apoteker", hadir: 90 },
                        { nama: "Sinta", posisi: "Kasir", hadir: 83 },
                        { nama: "Rina", posisi: "Suster", hadir: 95 },
                        { nama: "Maya", posisi: "Cleaning Service", hadir: 89 },
                        { nama: "Lina", posisi: "Admin", hadir: 91 }
                    ];

                    let barChart;

                    function renderBarChart(posisi) {
                        const filtered = posisi === 'all' ? staffData : staffData.filter(s => s.posisi === posisi);
                        const labels = filtered.map(s => s.nama);
                        const data = filtered.map(s => s.hadir);

                        if (barChart) barChart.destroy();

                        barChart = new Chart(document.getElementById('barChartStaff'), {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                            label: 'Kehadiran (%)',
                            data: data,
                            backgroundColor: '#17a2b8'
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                title: { display: true, text: 'Persentase (%)' }
                            }
                            },
                            plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                label: (ctx) => `Kehadiran: ${ctx.raw}%`
                                }
                            }
                            }
                        }
                        });
                    }

                    document.getElementById('posisiFilter').addEventListener('change', function () {
                        renderBarChart(this.value);
                    });

                    // Initial render
                    renderBarChart('all');
                    </script>

                    <!-- ROW 5 – SMART SUGGESTION (INSIGHT) -->
                    <h4 class="mb-4 font-weight-bold text-secondary">💡 Insight Saran Cerdas</h4>
                    <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card shadow-sm border-left-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                            <i class="fas fa-lightbulb fa-2x text-info mr-3"></i>
                            <div>
                                <h6 class="text-info font-weight-bold">Insight Otomatis</h6>
                                <ul class="mb-0">
                                <li>3 staff dengan kehadiran kurang dari 85%</li>
                                <li>2 staff bekerja lebih dari 180 jam dalam sebulan</li>
                                <li>Saran: Evaluasi beban kerja & pertimbangkan rekrut part-time</li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <!-- ROW 6 – TABEL DETAIL STAFF (PAGINASI) -->
                    <h4 class="mt-5 mb-4 font-weight-bold text-secondary">📋 Tabel Detail Staff</h4>
                    <table id="staffTable" class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>Jam Kerja</th>
                        <th>Kehadiran</th>
                        <th>Izin</th>
                        <th>Terlambat</th>
                        <th>Sakit</th>
                        <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $staffDetail = [
                        ["nama" => "Suster Ayu", "posisi" => "Admin Apotik", "jam" => 160, "kehadiran" => 20, "izin" => 2, "terlambat" => 1, "sakit" => 1, "status" => "Sangat Baik"],
                        ["nama" => "Dita", "posisi" => "Kasir", "jam" => 150, "kehadiran" => 18, "izin" => 3, "terlambat" => 2, "sakit" => 1, "status" => "Cukup"],
                        ["nama" => "Andre", "posisi" => "Apoteker", "jam" => 140, "kehadiran" => 16, "izin" => 4, "terlambat" => 3, "sakit" => 2, "status" => "Perlu Monitoring"],
                        ["nama" => "Sinta", "posisi" => "Suster", "jam" => 170, "kehadiran" => 21, "izin" => 1, "terlambat" => 0, "sakit" => 1, "status" => "Sangat Baik"],
                        ["nama" => "Budi", "posisi" => "Cleaning Service", "jam" => 160, "kehadiran" => 19, "izin" => 2, "terlambat" => 2, "sakit" => 1, "status" => "Cukup"],
                        ["nama" => "Rina", "posisi" => "Admin", "jam" => 155, "kehadiran" => 18, "izin" => 2, "terlambat" => 1, "sakit" => 1, "status" => "Cukup"],
                        ["nama" => "Fajar", "posisi" => "Kasir", "jam" => 145, "kehadiran" => 17, "izin" => 3, "terlambat" => 2, "sakit" => 1, "status" => "Perlu Monitoring"],
                        ["nama" => "Dewi", "posisi" => "Apoteker", "jam" => 180, "kehadiran" => 22, "izin" => 0, "terlambat" => 0, "sakit" => 0, "status" => "Sangat Baik"],
                        ["nama" => "Yusuf", "posisi" => "Suster", "jam" => 175, "kehadiran" => 20, "izin" => 1, "terlambat" => 1, "sakit" => 1, "status" => "Baik"],
                        ["nama" => "Lina", "posisi" => "Admin", "jam" => 165, "kehadiran" => 19, "izin" => 1, "terlambat" => 1, "sakit" => 1, "status" => "Baik"]
                        ];
                        $no = 1;
                        foreach ($staffDetail as $staff) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$staff['nama']}</td>
                            <td>{$staff['posisi']}</td>
                            <td>{$staff['jam']} Jam</td>
                            <td>{$staff['kehadiran']} Hari</td>
                            <td>{$staff['izin']}</td>
                            <td>{$staff['terlambat']}</td>
                            <td>{$staff['sakit']}</td>
                            <td>{$staff['status']}</td>
                        </tr>";
                        $no++;
                        }
                        ?>
                    </tbody>
                    </table>

                    <!-- DataTables Script -->
                    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
                    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
                    <script>
                    $(document).ready(function() {
                        $('#staffTable').DataTable({
                        "pageLength": 10,
                        "lengthChange": false,
                        "ordering": true,
                        "info": false
                        });
                    });
                    </script>



                    <h1 class="mt-4">Data Poli</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../../index.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Master</li>
                        <li class="breadcrumb-item active">Data Poli</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Tabel Data Poli
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Poli</th>
                                            <th>Nama Poli</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $nomor = 1; ?>
                                        <?php $ambil = $koneksi->query("SELECT * FROM tb_poli"); ?>
                                        <?php while ($pecah = $ambil->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $nomor; ?></td>
                                                <td><?php echo $pecah['kd_poli']; ?></td>
                                                <td><?php echo $pecah['nm_poli']; ?></td>
                                                <td>
                                                    <a href="poli_hapus.php?&id_poli=<?php echo $pecah['id_poli']; ?>" class="btn-danger btn-sm btn">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $nomor++; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="poli_tambah.php" class="btn-success btn px-3 font-weight-bold"><i class="fas fa-plus"></i> Tambah Data Poli</a>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Poli Klinik 2021</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>
    <script src="../../assets/js/Chart.min.js"></script>
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <script src="../../assets/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/demo/datatables-demo.js"></script>
</body>

</html>