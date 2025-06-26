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
    <title>Poli Klinik | Data Master - Pasien</title>
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
                                    <a class="nav-link active" href="data-pasien/pasien.php">Data Pasien</a>
                                    <a class="nav-link" href="../data-dokter/dokter.php">Data Dokter</a>
                                    <a class="nav-link" href="../data-obat/obat.php">Data Obat</a>
                                    <a class="nav-link" href="../data-staff/staff.php">Data Staff</a>
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
                    <h1 class="mt-4">Data Pasien</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../../index.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Master</li>
                        <li class="breadcrumb-item active">Data Pasien</li>
                    </ol>
                    <?php
                    // Hardcode Data Pasien (Contoh)
                    $dataPasien = [
                        [
                            "nama" => "Andi Wijaya",
                            "usia" => 25,
                            "gender" => "Laki-laki",
                            "kunjungan" => "Baru",
                            "rating" => 4.8,
                            "ulasan" => "Pelayanan cepat dan ramah.",
                            "tanggal" => "2025-06-10"
                        ],
                        [
                            "nama" => "Sari Dewi",
                            "usia" => 32,
                            "gender" => "Perempuan",
                            "kunjungan" => "Kembali",
                            "rating" => 4.3,
                            "ulasan" => "Dokter menjelaskan dengan jelas.",
                            "tanggal" => "2025-06-12"
                        ],
                        [
                            "nama" => "Budi Hartono",
                            "usia" => 41,
                            "gender" => "Laki-laki",
                            "kunjungan" => "Baru",
                            "rating" => 3.5,
                            "ulasan" => "Antri cukup lama.",
                            "tanggal" => "2025-06-15"
                        ],
                        [
                        "nama" => "Lina Marlina",
                        "usia" => 28,
                        "gender" => "Perempuan",
                        "kunjungan" => "Kembali",
                        "rating" => 2.2,
                        "ulasan" => "Kurang ramah saat pendaftaran.",
                        "tanggal" => "2025-06-09"
                    ],
                    [
                        "nama" => "Rizky Hidayat",
                        "usia" => 35,
                        "gender" => "Laki-laki",
                        "kunjungan" => "Baru",
                        "rating" => 5.0,
                        "ulasan" => "Dokter sangat profesional dan pelayanan cepat.",
                        "tanggal" => "2025-06-08"
                    ],
                    [
                        "nama" => "Intan Permata",
                        "usia" => 30,
                        "gender" => "Perempuan",
                        "kunjungan" => "Kembali",
                        "rating" => 1.8,
                        "ulasan" => "Menunggu terlalu lama dan kurang penjelasan.",
                        "tanggal" => "2025-06-05"
                    ]
                        // Tambahkan hingga lebih dari 10 untuk tabel paginasi
                    ];
                    // Sorting rating tertinggi dan terendah
                    $ulasanPositif = array_slice(array_values(array_filter($dataPasien, fn($d) => $d['rating'] >= 4)), 0, 5);
                    $ulasanNegatif = array_slice(array_values(array_filter($dataPasien, fn($d) => $d['rating'] < 4)), 0, 5);

                    // Hardcode Data Ringkasan Pasien
                    $totalPasien = 123;
                    $pasienBaru = 45;
                    $pasienKembali = 78;
                    $rataRating = 4.4;
                    $kenaikanPasienBulanIni = 12; // %
                    ?>
                    <!-- 🔵 Row 1: Ringkasan -->
                    <h4 class="mb-4 font-weight-bold text-secondary">Ringkasan Data Pasien</h4>
                    <div class="row">
                    <!-- Total Pasien -->
                    <div class="col-md-3 mb-4">
                        <div class="card bg-primary text-white shadow">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <h6>Total Pasien</h6>
                            <h4><span class="counter" data-count="<?= $totalPasien ?>">0</span> Orang</h4>
                            </div>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        </div>
                    </div>

                    <!-- Pasien Baru -->
                    <div class="col-md-3 mb-4">
                        <div class="card bg-success text-white shadow">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <h6>Pasien Baru</h6>
                            <h4><span class="counter" data-count="<?= $pasienBaru ?>">0</span> Orang</h4>
                            </div>
                            <i class="fas fa-user-plus fa-2x"></i>
                        </div>
                        </div>
                    </div>

                    <!-- Pasien Kembali -->
                    <div class="col-md-3 mb-4">
                        <div class="card bg-info text-white shadow">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <h6>Pasien Kembali</h6>
                            <h4><span class="counter" data-count="<?= $pasienKembali ?>">0</span> Orang</h4>
                            </div>
                            <i class="fas fa-redo fa-2x"></i>
                        </div>
                        </div>
                    </div>

                    <!-- Rata Rating -->
                    <div class="col-md-3 mb-4">
                        <div class="card bg-warning text-white shadow">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <h6>Rating Rata-rata</h6>
                            <h4><span class="counter" data-count="<?= $rataRating ?>">0</span> / 5.0</h4>
                            </div>
                            <i class="fas fa-star fa-2x"></i>
                        </div>
                        </div>
                    </div>
                    </div>

                    <!-- 🔢 Script Counter -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                    $('.counter').each(function () {
                        var $this = $(this),
                            countTo = $this.attr('data-count');

                        $({ countNum: 0 }).animate({
                        countNum: countTo
                        }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function () {
                            let val = parseFloat(this.countNum);
                            $this.text(val % 1 === 0 ? val.toFixed(0) : val.toFixed(1));
                        },
                        complete: function () {
                            let val = parseFloat(this.countNum);
                            $this.text(val % 1 === 0 ? val.toFixed(0) : val.toFixed(1));
                        }
                        });
                    });
                    </script>


                    <!-- 🟠 Row 2: Insight MIS -->
                    <?php
                    $ratingKurang = 10;
                    $pasienBaruTurun = false; // Jika true, kampanye pemasaran bisa dievaluasi
                    $rasioPasienPria = 35; // dalam persen
                    ?>

                    <!-- 🔮 Insight MIS -->
                    <div class="mb-4">
                    <div class="card border-left-primary shadow h-100 py-2 bg-light">
                        <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                            <i class="fas fa-lightbulb text-primary fa-2x"></i>
                            </div>
                            <div>
                            <h6 class="font-weight-bold text-primary mb-1">Insight MIS</h6>
                            <p class="mb-2">
                                📈 Pasien meningkat sebesar <strong><?= $kenaikanPasienBulanIni ?>%</strong> dibanding bulan lalu.
                                Pertumbuhan didominasi oleh <strong>pasien baru (<?= $pasienBaru ?> orang)</strong>. Pertimbangkan
                                penambahan <em>kapasitas layanan</em> & jadwal dokter tambahan di akhir pekan.
                            </p>

                            <!-- Tambahan Rekomendasi MIS -->
                            <ul class="pl-3 mb-0 text-dark">
                                <?php if ($pasienBaruTurun): ?>
                                <li>📉 Jumlah pasien baru menurun 20% dari bulan lalu, evaluasi efektivitas <strong>kampanye pemasaran</strong>.</li>
                                <?php endif; ?>

                                <?php if ($ratingKurang > 0): ?>
                                <li>⭐ <strong><?= $ratingKurang ?> pasien</strong> memberi rating < 3 bintang, perlu evaluasi <strong>pengalaman layanan & kecepatan</strong>.</li>
                                <?php endif; ?>

                                <?php if ($rasioPasienPria < 40): ?>
                                <li>👨 Rasio pasien pria hanya <strong><?= $rasioPasienPria ?>%</strong>. Pertimbangkan <strong>layanan khusus pria</strong> atau promosi yang relevan.</li>
                                <?php endif; ?>

                                <?php if ($kenaikanPasienBulanIni > 10): ?>
                                <li>📅 Pertumbuhan signifikan, pastikan <strong>dokter tambahan & ruang tunggu</strong> cukup untuk menghindari antrian panjang.</li>
                                <?php endif; ?>
                            </ul>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>



                    <!-- 🟣 Row 3: Top Ulasan -->
                    <h5 class="mb-3 font-weight-bold text-secondary d-flex justify-content-between align-items-center">
                    Ulasan & Kepuasan Pasien
                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#topReviewModal">
                        <i class="fas fa-comments mr-1"></i> Lihat Top 5 Ulasan
                    </button>
                    </h5>

                    <div class="row" id="ulasanContainer">
                    <?php foreach (array_slice($dataPasien, 0, 3) as $ulasan) { ?>
                        <div class="col-md-4 mb-3">
                        <div class="card h-100 shadow-sm border-left-info">
                            <div class="card-body">
                            <h6 class="font-weight-bold"><?= $ulasan['nama'] ?> (<?= $ulasan['kunjungan'] ?>)</h6>
                            <p class="text-muted mb-1"><?= $ulasan['tanggal'] ?> | Rating: <span class="text-warning"><?= $ulasan['rating'] ?> ★</span></p>
                            <p class="mb-0">"<?= $ulasan['ulasan'] ?>"</p>
                            </div>
                        </div>
                        </div>
                    <?php } ?>
                    </div>
                    <!-- Pagination Control for Ulasan -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                    <button id="prevUlasan" class="btn btn-outline-secondary btn-sm"><i class="fas fa-angle-left mr-1"></i> Previous</button>
                    <button id="nextUlasan" class="btn btn-outline-secondary btn-sm">Next <i class="fas fa-angle-right ml-1"></i></button>
                    </div>
                    <script>
                    const ulasanCards = $('#ulasanContainer .col-md-4');
                    let currentUlasanPage = 1;
                    const ulasanPerPage = 6;

                    function showUlasanPage(page) {
                    const totalPages = Math.ceil(ulasanCards.length / ulasanPerPage);
                    ulasanCards.hide();
                    const start = (page - 1) * ulasanPerPage;
                    const end = start + ulasanPerPage;
                    ulasanCards.slice(start, end).show();

                    $('#prevUlasan').prop('disabled', page === 1);
                    $('#nextUlasan').prop('disabled', page === totalPages);
                    }

                    $('#prevUlasan').click(() => {
                    if (currentUlasanPage > 1) {
                        currentUlasanPage--;
                        showUlasanPage(currentUlasanPage);
                    }
                    });

                    $('#nextUlasan').click(() => {
                    const totalPages = Math.ceil(ulasanCards.length / ulasanPerPage);
                    if (currentUlasanPage < totalPages) {
                        currentUlasanPage++;
                        showUlasanPage(currentUlasanPage);
                    }
                    });

                    $(document).ready(() => {
                    showUlasanPage(1); // tampilkan halaman awal
                    });
                    </script>


                    <!-- 🔍 Row 3 Modal Top 5 Ulasan -->
                    <div class="modal fade" id="topReviewModal" tabindex="-1" role="dialog" aria-labelledby="topReviewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title" id="topReviewModalLabel"><i class="fas fa-comments mr-2"></i>Top 5 Ulasan Positif & Negatif</h5>
                            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            <!-- POSITIF -->
                            <div class="col-md-6">
                                <h6 class="text-success mb-3"><i class="fas fa-smile mr-1"></i>Ulasan Positif</h6>
                                <?php foreach ($ulasanPositif as $u) { ?>
                                <div class="card mb-2 border-left-success">
                                    <div class="card-body p-2">
                                    <small class="text-muted"><?= $u['tanggal'] ?> | Rating: <?= $u['rating'] ?> ★</small>
                                    <p class="mb-0"><strong><?= $u['nama'] ?>:</strong> "<?= $u['ulasan'] ?>"</p>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <!-- NEGATIF -->
                            <div class="col-md-6">
                                <h6 class="text-danger mb-3"><i class="fas fa-frown mr-1"></i>Ulasan Negatif</h6>
                                <?php foreach ($ulasanNegatif as $u) { ?>
                                <div class="card mb-2 border-left-danger">
                                    <div class="card-body p-2">
                                    <small class="text-muted"><?= $u['tanggal'] ?> | Rating: <?= $u['rating'] ?> ★</small>
                                    <p class="mb-0"><strong><?= $u['nama'] ?>:</strong> "<?= $u['ulasan'] ?>"</p>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <?php
                    // Data tambahan untuk chart demografi
                    $usiaGroups = [
                    '0-12' => 4,
                    '13-24' => 12,
                    '25-45' => 15,
                    '46-65' => 2,
                    '65+' => 6
                    ];
                    $genderDist = [
                    'Laki-laki' => 4,
                    'Perempuan' => 7,
                    'Lainnya' => 0
                    ];

                    foreach ($dataPasien as $pasien) {
                    $usia = $pasien['usia'];
                    if ($usia <= 12) $usiaGroups['0-12']++;
                    elseif ($usia <= 24) $usiaGroups['13-24']++;
                    elseif ($usia <= 45) $usiaGroups['25-45']++;
                    elseif ($usia <= 65) $usiaGroups['46-65']++;
                    else $usiaGroups['65+']++;

                    if (isset($genderDist[$pasien['gender']])) {
                        $genderDist[$pasien['gender']]++;
                    } else {
                        $genderDist['Lainnya']++;
                    }
                    }
                    ?>

                    <!-- 🟢 Row 4: Analisis Demografi -->
                    <h5 class="mb-3 font-weight-bold text-secondary">Analisis Demografi Pasien</h5>
                    <div class="row">
                    <!-- Chart Usia -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow h-100">
                        <div class="card-body">
                            <h6 class="font-weight-bold text-primary">Distribusi Usia Pasien</h6>
                            <canvas id="usiaChart" height="250"></canvas>
                            <div class="mt-2 small text-muted">📌 Kelompok usia <strong>25-45</strong> mendominasi, fokuskan layanan konsultasi umum dan promosi kesehatan kerja.</div>
                        </div>
                        </div>
                    </div>

                    <!-- Chart Gender -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow h-100">
                        <div class="card-body">
                            <h6 class="font-weight-bold text-primary">Distribusi Gender Pasien</h6>
                            <canvas id="genderChart" height="250"></canvas>
                            <div class="mt-2 small text-muted">💡 Pasien perempuan sedikit lebih banyak. Pertimbangkan edukasi kesehatan wanita dan layanan prenatal.</div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                    // Distribusi Usia
                    const usiaChart = new Chart(document.getElementById('usiaChart'), {
                        type: 'bar',
                        data: {
                        labels: <?= json_encode(array_keys($usiaGroups)) ?>,
                        datasets: [{
                            label: 'Jumlah Pasien',
                            data: <?= json_encode(array_values($usiaGroups)) ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                        },
                        options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: true }
                        },
                        scales: {
                            y: { beginAtZero: true }
                        }
                        }
                    });

                    // Distribusi Gender
                    const genderChart = new Chart(document.getElementById('genderChart'), {
                        type: 'doughnut',
                        data: {
                        labels: <?= json_encode(array_keys($genderDist)) ?>,
                        datasets: [{
                            label: 'Gender',
                            data: <?= json_encode(array_values($genderDist)) ?>,
                            backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                        },
                        options: {
                        responsive: true,
                        plugins: {
                            legend: {
                            position: 'bottom',
                            labels: {
                                color: '#333',
                                font: { size: 12 }
                            }
                            },
                            tooltip: { enabled: true }
                        }
                        }
                    });
                    </script>


                    <!-- ⚪ Row 5: Tabel Detail Pasien -->
                    <h5 class="mt-5 font-weight-bold text-secondary">Detail Data Pasien</h5>
                    <div class="table-responsive">
                        <table id="tabelPasien" class="table table-striped table-bordered">
                        <thead class="thead-light">
                            <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Usia</th>
                            <th>Gender</th>
                            <th>Kunjungan</th>
                            <th>Rating</th>
                            <th>Ulasan</th>
                            <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($dataPasien as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['usia'] ?> tahun</td>
                                <td><?= $row['gender'] ?></td>
                                <td><?= $row['kunjungan'] ?></td>
                                <td><?= $row['rating'] ?> ★</td>
                                <td><?= $row['ulasan'] ?></td>
                                <td><?= $row['tanggal'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        </table>
                    </div>
                    </div>

                    <!-- ✅ Tambahkan jQuery & DataTables -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
                    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>

                    <script>
                    $(document).ready(function () {
                        $('#tabelPasien').DataTable({
                        pageLength: 10,
                        lengthChange: false,
                        ordering: true,
                        language: {
                            search: "Cari:",
                            paginate: {
                            previous: "Sebelumnya",
                            next: "Berikutnya"
                            }
                        }
                        });
                    });
                    </script>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Tabel Data Pasien
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $nomor = 1; ?>
                                        <?php $ambil = $koneksi->query("SELECT * FROM tb_pasien"); ?>
                                        <?php while ($pecah = $ambil->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $nomor; ?></td>
                                                <td><?php echo $pecah['nm_pasien']; ?></td>
                                                <td><?php echo $pecah['jenis_kelamin']; ?></td>
                                                <td><?php echo $pecah['tgl_lahir']; ?></td>
                                                <td><?php echo $pecah['alamat']; ?></td>
                                                <td>
                                                    <?php if ($_SESSION["jabatan"] == 'admin') : ?>
                                                        <a href="pasien_view.php?&id_pasien=<?php echo $pecah['id_pasien']; ?>" class="btn-primary btn-sm btn">
                                                            <i class="fas fa-eye"></i></i>
                                                        </a>
                                                        <a href="pasien_ubah.php?&id_pasien=<?php echo $pecah['id_pasien']; ?>" class="btn-warning btn-sm btn">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="pasien_hapus.php?&id_pasien=<?php echo $pecah['id_pasien']; ?>" class="btn-danger btn-sm btn">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    <?php elseif ($_SESSION["jabatan"] == 'pendaftaran') : ?>
                                                        <a href="pasien_view.php?&id_pasien=<?php echo $pecah['id_pasien']; ?>" class="btn-primary btn-sm btn">
                                                            <i class="fas fa-eye"></i></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php $nomor++; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="pasien_tambah.php" class="btn-success btn px-3 font-weight-bold"><i class="fas fa-plus "></i> Tambah Data Pasien</a>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-3 bg-dark mt-auto">
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