<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../login/index.php'</script>";
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
    <title>Poli Klinik | Data Pemeriksaan</title>
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="../assets/js/all.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="../index.php">Poli Klinik</a>
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
                    <a class="dropdown-item" href="../login/logout.php">Logout</a>
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
                        <a class="nav-link " href="../index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <!-- SIDEBAR -->
                        <?php if ($_SESSION["jabatan"] == 'admin') : ?>
                            <a class="nav-link collapsed" href="../index.php" data-toggle="collapse" data-target="#data-master" aria-expanded="false" aria-controls="data-master">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Data Master
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="data-master" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../data-master/data-pasien/pasien.php">Data Pasien</a>
                                    <a class="nav-link" href="../data-master/data-dokter/dokter.php">Data Dokter</a>
                                    <a class="nav-link" href="../data-master/data-obat/obat.php">Data Obat</a>
                                    <a class="nav-link" href="../data-master/data-staff/staff.php">Data Staff</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="../data-pendaftaran/pendaftaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Data Pendaftaran
                            </a>
                            <a class="nav-link active" href="data-pemeriksaan/pemeriksaan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Data Pemeriksaan
                            </a>
                            <a class="nav-link" href="../keuntungan/keuntungan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                                Keuntungan
                            </a>
                            <a class="nav-link" href="../data-pembayaran/pembayaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Pengeluaran
                            </a>
                            <div class="sb-sidenav-menu-heading">Admin</div>
                            <a class="nav-link" href="../user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Data User
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" class="bg-white text-dark">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Data Pemeriksaan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Pemeriksaan</li>
                    </ol>
                    <?php
                        // Hardcoded Data Pemeriksaan
                        $dataPemeriksaan = [
                        ["nama" => "Andi Wijaya", "keluhan" => "Demam", "diagnosa" => "Flu", "tanggal" => "2025-06-10", "durasi" => 10, "status" => "Selesai"],
                        ["nama" => "Sari Dewi", "keluhan" => "Batuk", "diagnosa" => "ISPA", "tanggal" => "2025-06-11", "durasi" => 15, "status" => "Selesai"],
                        ["nama" => "Budi Hartono", "keluhan" => "Pusing", "diagnosa" => "Vertigo", "tanggal" => "2025-06-12", "durasi" => 18, "status" => "Selesai"],
                        ["nama" => "Lina Marlina", "keluhan" => "Mual", "diagnosa" => "Gastritis", "tanggal" => "2025-06-12", "durasi" => 20, "status" => "Selesai"],
                        ["nama" => "Rizky Hidayat", "keluhan" => "Flu", "diagnosa" => "Common Cold", "tanggal" => "2025-06-13", "durasi" => 12, "status" => "Selesai"],
                        ["nama" => "Intan Permata", "keluhan" => "Demam", "diagnosa" => "DBD", "tanggal" => "2025-06-14", "durasi" => 22, "status" => "Selesai"],
                        ];

                        $totalPemeriksaan = count($dataPemeriksaan);
                        $pasienBatal = 8;
                        $rataDurasi = array_sum(array_column($dataPemeriksaan, 'durasi')) / max($totalPemeriksaan, 1);

                        // Hitung keluhan terbanyak
                        $keluhanCount = array_count_values(array_column($dataPemeriksaan, 'keluhan'));
                        arsort($keluhanCount);
                        $keluhanTerbanyak = array_key_first($keluhanCount);
                        ?>

                        <!-- 🔵 ROW 1: Ringkasan Pemeriksaan -->
                        <h4 class="mb-4 font-weight-bold text-primary">Ringkasan Pemeriksaan Bulan Ini</h4>
                        <div class="row mb-4">
                        <!-- Total Pemeriksaan -->
                        <div class="col-md-3 mb-3">
                            <div class="card bg-primary text-white shadow">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                <h6>Total Pemeriksaan</h6>
                                <h4><span class="counter" data-count="<?= $totalPemeriksaan ?>">0</span> Pemeriksaan</h4>
                                </div>
                                <i class="fas fa-stethoscope fa-2x"></i>
                            </div>
                            </div>
                        </div>

                        <!-- Pasien Batal -->
                        <div class="col-md-3 mb-3">
                            <div class="card bg-warning text-white shadow">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                <h6>Pasien Batal</h6>
                                <h4><span class="counter" data-count="<?= $pasienBatal ?>">0</span> Orang</h4>
                                </div>
                                <i class="fas fa-user-times fa-2x"></i>
                            </div>
                            </div>
                        </div>

                        <!-- Rata-rata Durasi -->
                        <div class="col-md-3 mb-3">
                            <div class="card bg-info text-white shadow">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                <h6>Rata Durasi Konsultasi</h6>
                                <h4><span class="counter" data-count="<?= round($rataDurasi, 1) ?>">0</span> Menit</h4>
                                </div>
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            </div>
                        </div>

                        <!-- Keluhan Terbanyak -->
                        <div class="col-md-3 mb-3">
                            <div class="card bg-success text-white shadow">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                <h6>Keluhan Terbanyak</h6>
                                <h4><?= $keluhanTerbanyak ?></h4>
                                </div>
                                <i class="fas fa-notes-medical fa-2x"></i>
                            </div>
                            </div>
                        </div>
                        </div>

                        <!-- 💡 Insight Pemeriksaan -->
                        <div class="alert alert-secondary shadow-sm">
                        <i class="fas fa-lightbulb text-warning mr-2"></i>
                        <strong>Insight:</strong>
                        Durasi konsultasi &gt;15 menit banyak terjadi di jam sibuk (17:00–20:00),
                        pertimbangkan tambahan dokter shift sore.
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


                        <?php
                        // 🔢 ROW 2 Kiri: Data Diagnosa
                        $dataDiagnosaPerHari = [
                        "Senin" => ["Flu" => 5, "Gastritis" => 3, "ISPA" => 2, "Vertigo" => 1, "DBD" => 2],
                        "Selasa" => ["Flu" => 4, "Gastritis" => 4, "ISPA" => 1, "Vertigo" => 3, "Common Cold" => 2],
                        "Rabu" => ["Gastritis" => 6, "Flu" => 2, "ISPA" => 3, "Common Cold" => 1],
                        "Kamis" => ["DBD" => 5, "Gastritis" => 2, "Flu" => 3, "ISPA" => 2],
                        "Jumat" => ["Flu" => 7, "Gastritis" => 5, "ISPA" => 4, "Common Cold" => 3, "DBD" => 4]
                        ];

                        // 🔢 ROW 2 Kanan: Data Waktu Tunggu Per Jam Per Hari
                        $waktuTungguPerHari = [
                        "Senin" => ["08:00" => 10, "09:00" => 12, "10:00" => 13, "11:00" => 15, "12:00" => 17, "13:00" => 14, "14:00" => 16, "15:00" => 18, "16:00" => 19, "17:00" => 21, "18:00" => 22],
                        "Selasa" => ["08:00" => 9, "09:00" => 10, "10:00" => 12, "11:00" => 13, "12:00" => 14, "13:00" => 15, "14:00" => 16, "15:00" => 17, "16:00" => 18, "17:00" => 20, "18:00" => 21],
                        "Rabu" => ["08:00" => 8, "09:00" => 9, "10:00" => 11, "11:00" => 12, "12:00" => 14, "13:00" => 13, "14:00" => 14, "15:00" => 16, "16:00" => 18, "17:00" => 20, "18:00" => 21],
                        "Kamis" => ["08:00" => 11, "09:00" => 12, "10:00" => 14, "11:00" => 16, "12:00" => 17, "13:00" => 18, "14:00" => 19, "15:00" => 20, "16:00" => 21, "17:00" => 22, "18:00" => 23],
                        "Jumat" => ["08:00" => 13, "09:00" => 14, "10:00" => 15, "11:00" => 16, "12:00" => 18, "13:00" => 19, "14:00" => 21, "15:00" => 22, "16:00" => 23, "17:00" => 25, "18:00" => 27],
                        ];
                        ?>

                        <!-- 🔵 ROW 2 : Gabungan Diagnosa dan Waktu Tunggu -->
                        <div class="row">
                        <!-- 📊 Kiri: Diagnosa & Keluhan -->
                        <div class="col-md-6">
                        <h4 class="font-weight-bold text-secondary">Analisis Diagnosa & Keluhan</h4>
                        <p class="text-muted">Tujuan: Mengidentifikasi pola penyakit untuk penyesuaian layanan dan stok obat.</p>
                        
                        <!-- 🔘 Tombol Filter Hari -->
                        <div class="btn-group mb-3" role="group">
                            <?php foreach (array_keys($dataDiagnosaPerHari) as $hari): ?>
                            <button class="btn btn-outline-primary<?= $hari === 'Senin' ? ' active' : '' ?>" onclick="tampilkanDiagnosaHari('<?= $hari ?>')"><?= $hari ?></button>
                            <?php endforeach; ?>
                        </div>

                        <!-- 📈 Chart Diagnosa -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                            <canvas id="chartDiagnosaHari" height="150"></canvas>
                            </div>
                        </div>
                        </div>

                        <!-- 🧠 Script Diagnosa Per Hari -->
                        <!-- 🧠 Script Diagnosa Per Hari -->
                        <script>
                        const ctxDiagnosaHari = document.getElementById('chartDiagnosaHari').getContext('2d');
                        const dataDiagnosaPerHari = <?= json_encode($dataDiagnosaPerHari) ?>;
                        let chartDiagnosaHari;

                        function tampilkanDiagnosaHari(hari, fromLoad = false) {
                        const labels = Object.keys(dataDiagnosaPerHari[hari]);
                        const data = Object.values(dataDiagnosaPerHari[hari]);

                        if (chartDiagnosaHari) chartDiagnosaHari.destroy();
                        chartDiagnosaHari = new Chart(ctxDiagnosaHari, {
                            type: 'bar',
                            data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Diagnosa',
                                data: data,
                                backgroundColor: '#007bff'
                            }]
                            },
                            options: {
                            responsive: true,
                            scales: { y: { beginAtZero: true } },
                            plugins: { legend: { display: false } }
                            }
                        });

                        if (!fromLoad) {
                            document.querySelectorAll(".btn-group .btn").forEach(btn => btn.classList.remove("active"));
                            event.target.classList.add("active");
                        }
                        }

                        // ✅ Tampilkan langsung hari Senin saat halaman load
                        document.addEventListener("DOMContentLoaded", function () {
                        tampilkanDiagnosaHari("Senin", true);
                        tampilkanJamHari("Senin");
                        });
                        </script>


                        <!-- 🕒 Kanan: Waktu Tunggu -->
                        <div class="col-md-6">
                            <h4 class="font-weight-bold text-secondary">Laporan Waktu Tunggu</h4>
                            <p class="text-muted">Tujuan: Optimasi pelayanan & efisiensi tenaga medis.</p>
                            <div class="btn-group mb-3" role="group">
                            <?php foreach (array_keys($waktuTungguPerHari) as $hari): ?>
                                <button class="btn btn-outline-primary<?= $hari === "Senin" ? ' active' : '' ?>" onclick="tampilkanJamHari('<?= $hari ?>')"><?= $hari ?></button>
                            <?php endforeach; ?>
                            </div>
                            <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <canvas id="chartJamPerHari" height="150"></canvas>
                            </div>
                            </div>
                        </div>
                        </div>

                        <!-- 🕒 Script Waktu Tunggu -->
                        <script>
                        let chartJam;
                        const ctxJam = document.getElementById('chartJamPerHari').getContext('2d');
                        const dataPerHari = <?= json_encode($waktuTungguPerHari) ?>;

                        function tampilkanJamHari(hari) {
                        const jam = Object.keys(dataPerHari[hari]);
                        const data = Object.values(dataPerHari[hari]);

                        if (chartJam) chartJam.destroy();
                        chartJam = new Chart(ctxJam, {
                            type: 'line',
                            data: {
                            labels: jam,
                            datasets: [{
                                label: 'Rata-rata Waktu Tunggu (menit)',
                                data: data,
                                borderColor: '#28a745',
                                tension: 0.2,
                                fill: false
                            }]
                            },
                            options: {
                            responsive: true,
                            scales: { y: { beginAtZero: true } },
                            plugins: { legend: { display: true } }
                            }
                        });

                        // Set active class
                        document.querySelectorAll(".btn-group .btn").forEach(btn => btn.classList.remove("active"));
                        event.target.classList.add("active");
                        }
                        window.onload = () => tampilkanJamHari("Senin");
                        </script>

                        <!-- 💡 Gabungan Insight -->
                        <div class="alert alert-info shadow-sm mt-3">
                        <i class="fas fa-lightbulb text-info"></i>
                        <strong>Insight Gabungan:</strong><br>
                        Keluhan pencernaan meningkat 20% bulan ini → sesuaikan stok & edukasi IG Klinik.<br>
                        Waktu tunggu tertinggi hari Jumat pukul 18:00 → pertimbangkan tenaga tambahan atau pembatasan slot.
                        </div>


                        <!-- 🟣 ROW 5: Tabel Pemeriksaan -->
                        <h5 class="font-weight-bold text-secondary">Detail Pemeriksaan</h5>
                        <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>Diagnosa</th>
                            <th>Tanggal</th>
                            <th>Durasi (menit)</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($dataPemeriksaan as $dp): ?>
                            <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $dp['nama'] ?></td>
                            <td><?= $dp['keluhan'] ?></td>
                            <td><?= $dp['diagnosa'] ?></td>
                            <td><?= $dp['tanggal'] ?></td>
                            <td><?= $dp['durasi'] ?></td>
                            <td><?= $dp['status'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        </table>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-9">
                                    <i class="fas fa-table mr-1 mt-2"></i>
                                    Tabel Data Pemeriksaan
                                </div>
                                <div class="col-md-3">
                                    <a href="pemeriksaan_tambah.php" class="btn-success btn px-3 font-weight-bold ml-5">
                                        <i class="fas fa-plus"></i> Tambah Data Periksa
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode Pemeriksaan</th>
                                            <th>Nama Pasien</th>
                                            <th>Poli</th>
                                            <th>Tanggal Periksa</th>
                                            <th>Aksi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $ambil = $koneksi->query("SELECT * FROM tb_pemeriksaan a
                                            JOIN tb_pendaftaran b ON a.id_pendaftaran = b.id_pendaftaran
                                            JOIN tb_pasien c ON b.id_pasien = c.id_pasien
                                            JOIN tb_poli d ON b.id_poli = d.id_poli"); ?>
                                        <?php while ($pecah = $ambil->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $pecah['kd_pemeriksaan']; ?></td>
                                                <td><?php echo $pecah['nm_pasien']; ?></td>
                                                <td><?php echo $pecah['nm_poli']; ?></td>
                                                <td><?php echo $pecah['tgl_pemeriksaan']; ?></td>
                                                <td>
                                                    <?php if ($pecah['status_periksa'] == 0) { ?>
                                                        <a href="pemeriksaan_view.php?&id_pemeriksaan=<?php echo $pecah['id_pemeriksaan']; ?>" class="btn-primary btn-sm btn">
                                                            <i class="fas fa-eye"></i></i>
                                                        </a>
                                                    <?php } elseif ($pecah['status_periksa'] == 1) { ?>
                                                        <a href="pemeriksaan_view.php?&id_pemeriksaan=<?php echo $pecah['id_pemeriksaan']; ?>" class="btn-primary btn-sm btn">
                                                            <i class="fas fa-eye"></i></i>
                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="#" class="btn-secondary btn-sm btn">
                                                            <i class="fas fa-minus"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($pecah['status_periksa'] == 0) { ?>
                                                        <span class="badge badge-danger p-2">Belum Menerima Resep</span>
                                                    <?php } elseif ($pecah['status_periksa'] == 1) { ?>
                                                        <span class="badge badge-success p-2">Sudah Menerima Resep</span>
                                                    <?php } else { ?>
                                                        <span class="badge badge-danger p-2">
                                                            <i class="fas fa-minus"></i>
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">

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
    <script src="../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/Chart.min.js"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/demo/datatables-demo.js"></script>
</body>

</html>