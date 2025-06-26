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
    <title>Poli Klinik | Data Pendaftaran</title>
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
                            <a class="nav-link" href="../data-pemeriksaan/pemeriksaan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Data Pemeriksaan
                            </a>
                            <a class="nav-link active" href="keuntungan/keuntungan.php">
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
                        <h1 class="mt-4">Laporan Keuntungan</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../index.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active">Keuntungan</li>
                        </ol>

                        <!-- Summary Box -->
                        <div class="row">
                            <!-- Total Keuntungan Tahun Ini -->
                            <div class="col-md-3 mb-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="font-weight-bold">Total Keuntungan Tahun Ini</div>
                                        <div><i class="fas fa-coins fa-2x text-white"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h5>Rp <span class="counter" data-count="<?php 
                                            $totalKeuntungan = 320000000; // ambil dari database
                                            echo $totalKeuntungan;
                                        ?>">0</span></h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Rata-rata Keuntungan Bulanan -->
                            <div class="col-md-3 mb-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="font-weight-bold">Rata-rata / Bulan</div>
                                        <div><i class="fas fa-chart-line fa-2x text-white"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h5>Rp <span class="counter" data-count="<?php 
                                            $rataBulan = 320000000 / 12;
                                            echo $rataBulan;
                                        ?>">0</span></h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Keuntungan Bulan Ini -->
                            <div class="col-md-3 mb-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="font-weight-bold">Keuntungan Bulan Ini</div>
                                        <div><i class="fas fa-calendar-alt fa-2x text-white"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h5>Rp <span class="counter" data-count="<?php 
                                            $keuntunganBulanIni = 27000000; 
                                            echo $keuntunganBulanIni;
                                        ?>">0</span></h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Pertumbuhan Bulanan -->
                            <div class="col-md-3 mb-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="font-weight-bold">Pertumbuhan Bulanan</div>
                                        <div><i class="fas fa-percentage fa-2x text-white"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h5><span class="counter" data-count="<?php 
                                            $pertumbuhan = 15; // misal 15% pertumbuhan
                                            echo $pertumbuhan;
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


                        <!-- Header Grafik Keuntungan Bulanan -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white font-weight-bold d-flex justify-content-between align-items-center">
                                <div><i class="fas fa-chart-bar mr-2"></i> Grafik Keuntungan Bulanan</div>
                                <div>
                                    <select id="tahunSelect" class="form-control form-control-sm">
                                        <option value="2025" selected>2025</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Bar Chart & Pie Chart disusun dalam satu row -->
                        <div class="row mb-4">
                            <!-- Bar Chart -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body" style="height: 300px;">
                                        <canvas id="keuntunganChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- Pie Chart -->
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                <div style="width: 100%; height: 300px;">
                                    <canvas id="pieKeuntunganChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Load Library Chart.js dan Plugin DataLabels -->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

                        <script>
                            // Data Bar Chart
                            const dataKeuntungan = {
                                2025: [40, 45, 50, 55, 52, 60, 65, 70, 68, 72, 75, 80],
                                2024: [35, 40, 42, 50, 47, 55, 58, 60, 61, 63, 68, 70]
                            };

                            const labels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
                            const colors = [
                                '#5A9BFF', '#5ACF85', '#4BBFC9', '#FFD350',
                                '#E35B5B', '#8A5BFF', '#3ED1AA', '#FF9240',
                                '#9356A3', '#FF70A6', '#FFB347', '#FF8F8F'
                            ];

                            const ctx = document.getElementById("keuntunganChart").getContext('2d');
                            let chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Keuntungan (Juta)',
                                        data: dataKeuntungan[2025],
                                        backgroundColor: colors,
                                        borderColor: colors,
                                        borderWidth: 0,
                                        borderRadius: 20,
                                        barThickness: 10,
                                        categoryPercentage: 0.8,
                                        barPercentage: 0.9
                                    }]
                                },
                                options: {
                                    indexAxis: 'y',
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { display: false }
                                    },
                                    scales: {
                                        x: {
                                            beginAtZero: true,
                                            grid: { display: false },
                                            ticks: {
                                                callback: function(value) { return 'Rp ' + value + 'jt'; },
                                                font: { size: 12 }
                                            }
                                        },
                                        y: {
                                            grid: { display: false },
                                            ticks: { font: { size: 12 } }
                                        }
                                    }
                                }
                            });

                            document.getElementById('tahunSelect').addEventListener('change', function() {
                                const tahun = this.value;
                                chart.data.datasets[0].data = dataKeuntungan[tahun];
                                chart.update();
                            });

                            // Data Pie Chart
                            const pieLabels = [
                                "Penjualan Obat",
                                "Pemeriksaan Cepat",
                                "Vaksinasi",
                                "Konsultasi Dokter",
                                "Kesehatan Korporat",
                                "Alat Kesehatan & Vitamin"
                            ];
                            const pieData = [180, 40, 25, 60, 35, 20];
                            const pieColors = [
                                '#5A9BFF', '#5ACF85', '#FFD350',
                                '#E35B5B', '#8A5BFF', '#FF9240'
                            ];

                            const pieCtx = document.getElementById('pieKeuntunganChart').getContext('2d');
                            const pieChart = new Chart(pieCtx, {
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
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    cutout: '60%', 
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'bottom',
                                            labels: { font: { size: 12 } }
                                        },
                                        datalabels: {
                                            color: '#fff',
                                            font: { size: 12, weight: 'bold' },
                                            formatter: function(value, context) {
                                                let total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                                let percentage = (value / total * 100).toFixed(1) + '%';
                                                return percentage;
                                            }
                                        }
                                    }
                                },
                                plugins: [ChartDataLabels]
                            });
                        </script>


                        <!-- Tabel Keuntungan -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white font-weight-bold">
                                <i class="fas fa-table mr-2"></i> Breakdown Keuntungan per Layanan
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>Layanan</th>
                                    <th>Sub Layanan</th>
                                    <th>Total Keuntungan</th>
                                    <th>Jumlah Pasien / Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Penjualan Obat</td>
                                    <td>Obat Resep, Obat Bebas (OTC)</td>
                                    <td>Rp 180.000.000</td>
                                    <td>500 transaksi</td>
                                </tr>
                                <tr>
                                    <td>Layanan Pemeriksaan Cepat</td>
                                    <td>Cek Tekanan Darah, Gula Darah, Kolesterol</td>
                                    <td>Rp 40.000.000</td>
                                    <td>200 pasien</td>
                                </tr>
                                <tr>
                                    <td>Vaksinasi</td>
                                    <td>Vaksin Flu, Hepatitis</td>
                                    <td>Rp 25.000.000</td>
                                    <td>100 pasien</td>
                                </tr>
                                <tr>
                                    <td>Konsultasi Dokter</td>
                                    <td>Konsultasi Umum</td>
                                    <td>Rp 60.000.000</td>
                                    <td>150 pasien</td>
                                </tr>
                                <tr>
                                    <td>Layanan Kesehatan Korporat</td>
                                    <td>Medical Checkup Karyawan</td>
                                    <td>Rp 35.000.000</td>
                                    <td>5 perusahaan</td>
                                </tr>
                                <tr>
                                    <td>Alat Kesehatan & Vitamin</td>
                                    <td>Alat Medis Kecil, Vitamin</td>
                                    <td>Rp 20.000.000</td>
                                    <td>80 transaksi</td>
                                </tr>
                            </tbody>
                        </table>
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