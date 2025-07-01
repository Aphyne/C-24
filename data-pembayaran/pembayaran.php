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
    <title>Poli Klinik | Kasir Pembayaran</title>
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
                            <a class="nav-link " href="../data-pendaftaran/pendaftaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Data Pendaftaran
                            </a>
                            <a class="nav-link" href="../data-pemeriksaan/pemeriksaan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Data Pemeriksaan
                            </a>
                            <a class="nav-link" href="../keuntungan/keuntungan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                                Keuntungan
                            </a>
                            <a class="nav-link active" href="data-pembayaran/pembayaran.php">
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
                <h1 class="mt-4">Pengeluaran Klinik</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../index.php" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pengeluaran</li>
                </ol>

                <!-- Summary Box Pengeluaran -->
                <div class="row">
                    <!-- Total Pengeluaran Tahun Ini -->
                    <div class="col-md-3 mb-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="font-weight-bold">Total Pengeluaran Tahun Ini</div>
                                <div><i class="fas fa-coins fa-2x text-white"></i></div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <h5>Rp <span class="counter" data-count="<?php 
                                    $totalPengeluaran = 200000000; // ambil dari database
                                    echo $totalPengeluaran;
                                ?>">0</span></h5>
                            </div>
                        </div>
                    </div>

                    <!-- Rata-rata Pengeluaran Bulanan -->
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="font-weight-bold">Rata-rata / Bulan</div>
                                <div><i class="fas fa-chart-line fa-2x text-white"></i></div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <h5>Rp <span class="counter" data-count="<?php 
                                    $rataPengeluaran = 200000000 / 12;
                                    echo $rataPengeluaran;
                                ?>">0</span></h5>
                            </div>
                        </div>
                    </div>

                    <!-- Pengeluaran Bulan Ini -->
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="font-weight-bold">Pengeluaran Bulan Ini</div>
                                <div><i class="fas fa-calendar-alt fa-2x text-white"></i></div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <h5>Rp <span class="counter" data-count="<?php 
                                    $pengeluaranBulanIni = 17500000; 
                                    echo $pengeluaranBulanIni;
                                ?>">0</span></h5>
                            </div>
                        </div>
                    </div>

                    <!-- Pertumbuhan Bulanan Pengeluaran -->
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="font-weight-bold">Pertumbuhan Bulanan</div>
                                <div><i class="fas fa-percentage fa-2x text-white"></i></div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <h5><span class="counter" data-count="<?php 
                                    $pertumbuhanPengeluaran = 5; 
                                    echo $pertumbuhanPengeluaran;
                                ?>">0</span>%</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Script animasi counter -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $('.counter').each(function () {
                        var $this = $(this),
                            countTo = parseFloat($this.attr('data-count'));

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


                <!-- Grafik Bar + Pie -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white font-weight-bold d-flex justify-content-between align-items-center">
                        <div><i class="fas fa-chart-bar mr-2"></i> Grafik Pengeluaran Bulanan</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8" style="height: 300px;">
                                <canvas id="pengeluaranChart"></canvas>
                            </div>
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                <div style="width: 100%; height: 300px;">
                                    <canvas id="piePengeluaranChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW Insight Pengeluaran -->
                 <!-- INSIGHT – Saran Cerdas dari Pengeluaran -->
                <h4 class="mb-4 font-weight-bold text-secondary">💡 Insight Saran Cerdas</h4>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card shadow-sm border-left-danger">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-lightbulb fa-2x text-danger mr-3"></i>
                                    <div>
                                        <h6 class="text-danger font-weight-bold">Insight Otomatis</h6>
                                        <ul class="mb-0">
                                            <li>Pertumbuhan pengeluaran bulanan sebesar <strong><?= $pertumbuhanPengeluaran ?>%</strong>.</li>
                                            <li>Kategori pengeluaran terbesar: <strong>Gaji Karyawan</strong> dan <strong>Obat-obatan</strong>.</li>
                                            <li>Pengeluaran bulan ini sebesar <strong>Rp <?= number_format($pengeluaranBulanIni, 0, ',', '.') ?></strong>, sedikit di bawah rata-rata bulanan.</li>
                                            <li><strong>Saran:</strong> Evaluasi efisiensi penggunaan obat-obatan dan pertimbangkan optimalisasi tenaga kerja pada bulan mendatang.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Breakdown Table -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        <i class="fas fa-table mr-2"></i> Breakdown Pengeluaran
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead class="thead-light">
                            <tr>
                                <th>Kategori</th>
                                <th>Detail</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr><td>Obat & Alkes</td><td>Pengadaan Stok</td><td>Rp 100.000.000</td></tr>
                                <tr><td>Gaji Karyawan</td><td>Dokter, Apoteker, Admin</td><td>Rp 60.000.000</td></tr>
                                <tr><td>Operasional</td><td>Listrik, Air, Internet</td><td>Rp 20.000.000</td></tr>
                                <tr><td>Peralatan & Maintenance</td><td>Servis alat medis</td><td>Rp 10.000.000</td></tr>
                                <tr><td>Promosi</td><td>Marketing & Event</td><td>Rp 5.000.000</td></tr>
                                <tr><td>Lain-lain</td><td>Tak terduga</td><td>Rp 5.000.000</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- JS Chart -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                // Data Bar Chart
                const barData = [15, 20, 18, 17, 19, 16, 14, 20, 22, 19, 18, 22];
                const barLabels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
                const barColors = ['#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF','#FF9F40',
                                '#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF','#FF9F40'];

                const ctxBar = document.getElementById("pengeluaranChart").getContext('2d');
                const pengeluaranChart = new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: barLabels,
                        datasets: [{
                            label: 'Pengeluaran (Juta)',
                            data: barData,
                            backgroundColor: barColors,
                            borderRadius: 10
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) { return 'Rp ' + value + 'jt'; }
                                }
                            }
                        }
                    }
                });

                // Data Pie Chart
                const pieLabels = ["Obat & Alkes", "Gaji", "Operasional", "Peralatan", "Promosi", "Lain-lain"];
                const pieData = [100, 60, 20, 10, 5, 5];
                const pieColors = ['#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF','#FF9F40'];

                const ctxPie = document.getElementById("piePengeluaranChart").getContext('2d');
                const pieChart = new Chart(ctxPie, {
                    type: 'doughnut',
                    data: {
                        labels: pieLabels,
                        datasets: [{
                            data: pieData,
                            backgroundColor: pieColors,
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            </script>
</div>
            </main>
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Poli Klinik 2020</div>
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