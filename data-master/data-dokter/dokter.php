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
    <title>Poli Klinik | Data Master - Dokter</title>
    <link href="../../assets/css/styles.css" rel="stylesheet" />
    <link href="../../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .progress {
            background-color: #e9ecef;
        }
        .progress-bar {
            width: 0%; /* Penting! Mulai dari 0 */
            transition: width 1.5s ease;
        }
    </style>
    <script src="../../assets/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                                    <a class="nav-link active" href="data-dokter/dokter.php">Data Dokter</a>
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
        <h1 class="mt-4">Data Dokter</h1>
             <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../../index.php" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Master</li>
                <li class="breadcrumb-item active">Data Dokter</li>
            </ol>

            <?php
            // Data hardcode sementara MIS Dokter
            $totalDokterAktif = 12;
            $rataKehadiran = 93; // persen
            $dokterNonaktif = 2;
            $totalPasienBulanIni = 1440; // total pasien klinik bulan ini
            $rataPasienPerDokter = $totalPasienBulanIni / $totalDokterAktif; // otomatis dihitung
            ?>

            <!-- Summary Box -->
            <div class="row">
                <!-- Total Dokter -->
                <div class="col-md-3 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body d-flex justify-content-between">
                            <div class="font-weight-bold">Total Dokter</div>
                            <div><i class="fas fa-user-md fa-2x"></i></div>
                        </div>
                        <div class="card-footer">
                            <h5><span class="counter" data-count="<?php echo $totalDokterAktif; ?>">0</span> Orang</h5>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Kehadiran -->
                <div class="col-md-3 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body d-flex justify-content-between">
                            <div class="font-weight-bold">Rata Rata Kehadiran (Bulan)</div>
                            <div><i class="fas fa-calendar-check fa-2x"></i></div>
                        </div>
                        <div class="card-footer">
                            <h5><span class="counter" data-count="<?php echo $rataKehadiran; ?>">0</span>%</h5>
                        </div>
                    </div>
                </div>

                <!-- Dokter Nonaktif -->
                <div class="col-md-3 mb-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body d-flex justify-content-between">
                            <div class="font-weight-bold">Dokter Nonaktif</div>
                            <div><i class="fas fa-user-slash fa-2x"></i></div>
                        </div>
                        <div class="card-footer">
                            <h5><span class="counter" data-count="<?php echo $dokterNonaktif; ?>">0</span> Orang</h5>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Pasien per Dokter per Bulan -->
                <div class="col-md-3 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body d-flex justify-content-between">
                            <div class="font-weight-bold">Rata Pasien/Dokter (Bulan)</div>
                            <div><i class="fas fa-users fa-2x"></i></div>
                        </div>
                        <div class="card-footer">
                            <h5><span class="counter" data-count="<?php echo round($rataPasienPerDokter); ?>">0</span> Pasien</h5>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Script animasi counter -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $('.counter').each(function () {
                    var $this = $(this),
                        countTo = $this.attr('data-count');

                    $({ countNum: 0 }).animate({
                        countNum: countTo
                    },
                    {
                        duration: 1500,
                        easing: 'swing',
                        step: function () {
                            $this.text(new Intl.NumberFormat('id-ID').format(Math.floor(this.countNum)));
                        },
                        complete: function () {
                            $this.text(new Intl.NumberFormat('id-ID').format(this.countNum));
                        }
                    });
                });
            </script>

           <!-- Performance Review Dokter (Hardcode Array Version) -->
            <?php
            $dokterPerformance = [
                [
                    "nama" => "Dr. Andi",
                    "spesialis" => "Spesialis Umum",
                    "total_jam" => 450,
                    "target_jam" => 500,
                    "kehadiran" => 95,
                    "pertumbuhan_pasien" => 12,
                    "total_pasien" => 120,
                    "rating" => 5.0,
                    "rating_bintang" => "★★★★★",
                    "kinerja" => "Sangat Baik",
                    "badge" => "success",
                    "progress_color" => "success"
                ],
                [
                    "nama" => "Dr. Budi",
                    "spesialis" => "Spesialis Anak",
                    "total_jam" => 380,
                    "target_jam" => 500,
                    "kehadiran" => 85,
                    "pertumbuhan_pasien" => 5,
                    "total_pasien" => 150,
                    "rating" => 4.0,
                    "rating_bintang" => "★★★★☆",
                    "kinerja" => "Perlu Monitoring",
                    "badge" => "warning",
                    "progress_color" => "warning"
                ],
                [
                    "nama" => "Dr. Citra",
                    "spesialis" => "Spesialis Gigi",
                    "total_jam" => 520,
                    "target_jam" => 500,
                    "kehadiran" => 98,
                    "pertumbuhan_pasien" => 18,
                    "total_pasien" => 140,
                    "rating" => 4.8,
                    "rating_bintang" => "★★★★★",
                    "kinerja" => "Top Performer",
                    "badge" => "primary",
                    "progress_color" => "success"
                ]
            ];
            ?>

           <div class="d-flex justify-content-between mb-3">
    <div>
                <h4 class="font-weight-bold text-secondary mb-2">Performance Review Dokter</h4>
                <!-- Form pencarian dan filter -->
                <input type="text" id="searchDokter" class="form-control d-inline-block mr-2 mb-2" style="width: 200px;" placeholder="Cari nama atau spesialis">
                <select id="filterKinerja" class="form-control d-inline-block mr-2 mb-2" style="width: 150px;">
                <option value="">Semua Kinerja</option>
                <option value="Sangat Baik">Sangat Baik</option>
                <option value="Top Performer">Top Performer</option>
                <option value="Perlu Monitoring">Perlu Monitoring</option>
                </select>
                <select id="filterSpesialis" class="form-control d-inline-block mr-2 mb-2" style="width: 150px;">
                <option value="">Semua Spesialis</option>
                <option value="Spesialis Umum">Spesialis Umum</option>
                <option value="Spesialis Anak">Spesialis Anak</option>
                <option value="Spesialis Gigi">Spesialis Gigi</option>
                </select>
                <button class="btn btn-secondary btn-sm mb-2" id="resetDokterFilter">Reset</button>
            </div>
            <div class="align-self-end">
                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#topDokterModal">
                <i class="fas fa-trophy mr-2"></i>Lihat Top 3 Dokter Terbaik
                </button>
            </div>
            </div>



            <!-- Modal - Top 3 Dokter -->
            <div class="modal fade" id="topDokterModal" tabindex="-1" role="dialog" aria-labelledby="topDokterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="topDokterModalLabel"><i class="fas fa-trophy mr-2"></i>Top 3 Dokter Terbaik</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    // Ambil 3 dokter terbaik berdasarkan rating tertinggi
                    $topDokter = $dokterPerformance;
                    usort($topDokter, function ($a, $b) {
                        return $b['rating'] <=> $a['rating']; // descending
                    });
                    $topDokter = array_slice($topDokter, 0, 3);
                    ?>
                    <div class="row">
                    <?php foreach ($topDokter as $i => $dok) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0"><i class="fas fa-trophy mr-1"></i> Peringkat <?= $i + 1 ?></h5>
                        </div>
                        <div class="card-body">
                            <h6><strong><?= $dok['nama'] ?></strong></h6>
                            <p class="text-muted mb-1">Spesialis: <?= $dok['spesialis'] ?></p>
                            <p class="mb-1"><i class="fas fa-clock mr-1"></i> Jam Praktik: <?= $dok['total_jam'] ?> jam</p>
                            <p class="mb-1"><i class="fas fa-calendar-check mr-1"></i> Kehadiran: <?= $dok['kehadiran'] ?>%</p>
                            <p class="mb-1"><i class="fas fa-star text-warning mr-1"></i> Rating: <?= $dok['rating'] ?>/5.0</p>
                        </div>
                        <div class="card-footer text-center">
                            <span class="badge badge-success px-3 py-1"><?= $dok['kinerja'] ?></span>
                        </div>
                        </div>
                    </div>
                    <?php } ?>
                    </div>
                </div>
                </div>
            </div>
            </div>

            <div class="row" id="dokterCards">
            <?php foreach ($dokterPerformance as $dokter) { ?>
                <div class="col-md-4 mb-4 dokter-card"
                    data-nama="<?= strtolower($dokter['nama']) ?>"
                    data-spesialis="<?= strtolower($dokter['spesialis']) ?>"
                    data-kinerja="<?= strtolower($dokter['kinerja']) ?>">

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><?= $dokter['nama'] ?> (<?= $dokter['spesialis'] ?>)</div>
                                <i class="fas fa-user-md fa-lg"></i>
                            </div>
                        </div>
                        <div class="card-body">

                            <p><b>Total Jam Praktik:</b> 
                                <span class="counter" data-count="<?= $dokter['total_jam'] ?>">0</span> Jam / Target <?= $dokter['target_jam'] ?> Jam
                            </p>
                            <div class="progress mb-2" style="height: 10px;">
                                <div class="progress-bar bg-<?= $dokter['progress_color'] ?>" data-width="<?= round(($dokter['total_jam'] / $dokter['target_jam']) * 100) ?>"></div>
                            </div>

                            <p><b>Kehadiran:</b> 
                                <span class="counter" data-count="<?= $dokter['kehadiran'] ?>">0</span>%
                            </p>
                            <div class="progress mb-2" style="height: 10px;">
                                <div class="progress-bar bg-info" data-width="<?= $dokter['kehadiran'] ?>"></div>
                            </div>

                            <p><b>Pertumbuhan Pasien:</b> +<span class="counter" data-count="<?= $dokter['pertumbuhan_pasien'] ?>">0</span>%</p>
                            <div class="progress mb-2" style="height: 10px;">
                                <div class="progress-bar bg-warning" data-width="<?= $dokter['pertumbuhan_pasien'] ?>"></div>
                            </div>

                            <p><b>Total Pasien:</b> <span class="counter" data-count="<?= $dokter['total_pasien'] ?>">0</span> Pasien</p>
                            <div class="progress mb-2" style="height: 10px;">
                                <div class="progress-bar bg-primary" data-width="100"></div>
                            </div>

                            <p><b>Rating Pasien:</b> 
                                <span class="text-warning"><?= $dokter['rating_bintang'] ?></span> (<?= $dokter['rating'] ?>)
                            </p>

                        </div>
                        <div class="card-footer text-center">
                            <span class="badge badge-<?= $dokter['badge'] ?>">Kinerja <?= $dokter['kinerja'] ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
    <button id="prevDokter" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-angle-left mr-1"></i> Previous
    </button>
    <button id="nextDokter" class="btn btn-outline-secondary btn-sm">
        Next <i class="fas fa-angle-right ml-1"></i>
    </button>
</div>


            <!-- Load jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
            // Counter animasi
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

            // Progress bar animasi
            $('.progress-bar').each(function () {
                var $this = $(this);
                var targetWidth = $this.data('width');
                $this.animate({ width: targetWidth + '%' }, 1500);
            });
            </script>
            
            <script>
            $('#searchDokter, #filterKinerja, #filterSpesialis').on('input change', function () {
                const keyword = $('#searchDokter').val().toLowerCase();
                const kinerja = $('#filterKinerja').val().toLowerCase();
                const spesialis = $('#filterSpesialis').val().toLowerCase();

                $('.dokter-card').each(function () {
                const nama = $(this).data('nama');
                const spesialisCard = $(this).data('spesialis');
                const kinerjaCard = $(this).data('kinerja');

                let match = true;
                if (keyword && !(nama.includes(keyword) || spesialisCard.includes(keyword))) match = false;
                if (kinerja && kinerjaCard !== kinerja) match = false;
                if (spesialis && spesialisCard !== spesialis) match = false;

                $(this).toggle(match);
                });

                // Reset ke halaman pertama setelah filter
                showDokterPage(1);
            });

            $('#resetDokterFilter').on('click', function () {
                $('#searchDokter').val('');
                $('#filterKinerja').val('');
                $('#filterSpesialis').val('');
                $('.dokter-card').show();
                showDokterPage(1);
            });
            </script>

            <?php
// Insight Dokter Otomatis
$lowKehadiran = 0;
$jamBerlebih = 0;
$rendahRating = 0;

foreach ($dokterPerformance as $d) {
    if ($d['kehadiran'] < 90) $lowKehadiran++;
    if ($d['total_jam'] > $d['target_jam']) $jamBerlebih++;
    if ($d['rating'] < 4.5) $rendahRating++;
}

$saranDokter = [];
if ($lowKehadiran > 0) $saranDokter[] = "$lowKehadiran dokter dengan kehadiran < 90%";
if ($jamBerlebih > 0) $saranDokter[] = "$jamBerlebih dokter bekerja melebihi target jam";
if ($rendahRating > 0) $saranDokter[] = "$rendahRating dokter memiliki rating di bawah 4.5";
if (empty($saranDokter)) $saranDokter[] = "Semua dokter memenuhi indikator performa yang baik.";
else $saranDokter[] = "Saran: Pertimbangkan evaluasi, distribusi beban kerja, atau pelatihan layanan.";
?>
<!-- Insight Saran Cerdas -->
<h4 class="mb-3 font-weight-bold text-secondary">💡 Insight Saran Cerdas</h4>
<div class="row">
  <div class="col-md-12 mb-3">
    <div class="card shadow-sm border-left-info">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <i class="fas fa-lightbulb fa-2x text-info mr-3"></i>
          <div>
            <h6 class="text-info font-weight-bold mb-2">Insight Otomatis</h6>
            <ul class="mb-0">
              <?php foreach ($saranDokter as $item) { ?>
                <li><?= $item ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



            <!-- Jadwal & Ketidakhadiran Dokter (Hardcode Version) -->
            <?php
            $jadwalPraktik = [
                ["hari" => "Senin", "dokter" => "Dr. Andi", "shift" => "Pagi", "jam" => "08:00 - 12:00", "badge" => "success"],
                ["hari" => "Selasa", "dokter" => "Dr. Budi", "shift" => "Sore", "jam" => "13:00 - 17:00", "badge" => "warning"],
                ["hari" => "Rabu", "dokter" => "Dr. Citra", "shift" => "Pagi", "jam" => "08:00 - 12:00", "badge" => "primary"],
                ["hari" => "Kamis", "dokter" => "Dr. Andi", "shift" => "Overload", "jam" => "Double Shift", "badge" => "danger"],
                ["hari" => "Jumat", "dokter" => "Dr. Budi", "shift" => "Pagi", "jam" => "08:00 - 12:00", "badge" => "success"],
            ];

            $riwayatKehadiran = [
                "Dr. Andi" => ["hadir" => 24, "izin" => 2, "sakit" => 1],
                "Dr. Budi" => ["hadir" => 22, "izin" => 3, "sakit" => 2],
                "Dr. Citra" => ["hadir" => 26, "izin" => 1, "sakit" => 0],
            ];
            ?>

            <h4 class="mb-4 font-weight-bold text-secondary">Jadwal & Ketidakhadiran Dokter</h4>
            <div class="row">
                <!-- Jadwal Praktik Dokter -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-info text-white">
                            <i class="fas fa-calendar-alt mr-2"></i> Jadwal Praktik Mingguan
                        </div>
                        <div class="card-body" style="min-height: 320px;">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($jadwalPraktik as $jadwal): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= $jadwal['hari'] ?> (<?= $jadwal['dokter'] ?>)
                                        <span class="badge badge-<?= $jadwal['badge'] ?>">
                                            <?= $jadwal['shift'] ?> (<?= $jadwal['jam'] ?>)
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Ketidakhadiran -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-danger text-white">
                            <i class="fas fa-user-times mr-2"></i> Riwayat Ketidakhadiran Bulan Ini
                        </div>
                        <div class="card-body" style="min-height: 320px;">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($riwayatKehadiran as $dokter => $data): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= $dokter ?>
                                        <div>
                                            <span class="badge badge-success mr-1">Hadir: <?= $data['hadir'] ?></span>
                                            <span class="badge badge-warning mr-1">Izin: <?= $data['izin'] ?></span>
                                            <span class="badge badge-danger">Sakit: <?= $data['sakit'] ?></span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Jadwal & Ketidakhadiran Dokter -->
        </div>
    
            <!-- Tabel Master Data Dokter - Compact MIS Klinik -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-user-md fa-lg mr-2"></i> 
                    <h5 class="mb-0 font-weight-bold">Master Data Dokter</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover" id="dataTable" style="font-size: 14px;">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th style="width: 40px;">No</th>
                                    <th style="width: 80px;">Kode</th>
                                    <th style="min-width: 80px;">Nama</th>
                                    <th style="width: 110px;">Spesialis</th>
                                    <th style="width: 110px;">No. STR</th>
                                    <th style="width: 110px;">No. SIP</th>
                                    <th style="width: 110px;">Kontak</th>
                                    <th style="min-width: 100px;">Alamat</th>
                                    <th style="width: 80px;">Status</th>
                                    <th style="width: 120px;">Tarif</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor = 1; ?>
                                <?php 
                                $dataDokter = [
                                    [
                                        'kd_dokter' => 'D001',
                                        'nm_dokter' => 'Dr. Andi',
                                        'spesialis_dokter' => 'Umum',
                                        'str_dokter' => 'STR123456',
                                        'sip_dokter' => 'SIP654321',
                                        'kontak_dokter' => '081234567890',
                                        'alamat_dokter' => 'Jl. Melati No.10',
                                        'status_dokter' => 'Aktif',
                                        'tarif_dokter' => 75000
                                    ],
                                    [
                                        'kd_dokter' => 'D002',
                                        'nm_dokter' => 'Dr. Budi',
                                        'spesialis_dokter' => 'Gigi',
                                        'str_dokter' => 'STR223344',
                                        'sip_dokter' => 'SIP445566',
                                        'kontak_dokter' => '081298765432',
                                        'alamat_dokter' => 'Jl. Kenanga No.5',
                                        'status_dokter' => 'Nonaktif',
                                        'tarif_dokter' => 80000
                                    ],
                                    [
                                        'kd_dokter' => 'D003',
                                        'nm_dokter' => 'Dr. Citra',
                                        'spesialis_dokter' => 'Anak',
                                        'str_dokter' => 'STR334455',
                                        'sip_dokter' => 'SIP556677',
                                        'kontak_dokter' => '081356789012',
                                        'alamat_dokter' => 'Jl. Mawar No.20',
                                        'status_dokter' => 'Aktif',
                                        'tarif_dokter' => 90000
                                    ]
                                ];

                                foreach ($dataDokter as $pecah) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo $nomor; ?></td>
                                        <td class="text-center"><?php echo $pecah['kd_dokter']; ?></td>
                                        <td><?php echo $pecah['nm_dokter']; ?></td>
                                        <td class="text-center"><?php echo $pecah['spesialis_dokter']; ?></td>
                                        <td class="text-center"><?php echo $pecah['str_dokter']; ?></td>
                                        <td class="text-center"><?php echo $pecah['sip_dokter']; ?></td>
                                        <td class="text-center"><?php echo $pecah['kontak_dokter']; ?></td>
                                        <td><?php echo $pecah['alamat_dokter']; ?></td>
                                        <td class="text-center">
                                            <?php if($pecah['status_dokter'] == 'Aktif') { ?>
                                                <span class="badge badge-success px-2 py-1">Aktif</span>
                                            <?php } else { ?>
                                                <span class="badge badge-danger px-2 py-1">Nonaktif</span>
                                            <?php } ?>
                                        </td>
                                        <td class="text-right">Rp. <?php echo number_format($pecah['tarif_dokter'], 0, ',', '.'); ?></td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php $nomor++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="dokter_tambah.php" class="btn-success btn px-3 font-weight-bold"><i class="fas fa-plus"></i> Tambah Data Dokter</a>
            </div>
            <footer class="py-4 bg-dark mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted font-weight-bold">Copyright &copy; Poli Klinik 2021</div>
                </div>
            </div>
        </footer>
        </div>
    </div>
    </main>
</div>


<script src="../../assets/js/jquery-3.5.1.slim.min.js"></script>
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/scripts.js"></script>
<script src="../../assets/js/jquery.dataTables.min.js"></script>
<script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/demo/datatables-demo.js"></script>
</body>
</html>