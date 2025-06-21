<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='login/index.php'</script>";
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
    <title>Poli Klinik | Dashboard</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="assets/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="index.php">Poli Klinik</a>
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
                    <a class="dropdown-item" href="login/logout.php">Logout</a>
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
                        <a class="nav-link active" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <!-- SIDEBAR -->
                        <?php if ($_SESSION["jabatan"] == 'admin') : ?>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#data-master" aria-expanded="false" aria-controls="data-master">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Data Master
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="data-master" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="data-master/data-pasien/pasien.php">Data Pasien</a>
                                    <a class="nav-link" href="data-master/data-dokter/dokter.php">Data Dokter</a>
                                    <a class="nav-link" href="data-master/data-obat/obat.php">Data Obat</a>
                                    <a class="nav-link" href="data-master/data-poli/poli.php">Data Poli</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="data-pendaftaran/pendaftaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Data Pendaftaran
                            </a>
                            <a class="nav-link" href="data-pemeriksaan/pemeriksaan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Data Pemeriksaan
                            </a>
                            <a class="nav-link" href="keuntungan/keuntungan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                                Keuntungan
                            </a>
                            <a class="nav-link" href="data-pembayaran/pembayaran.php">
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
                            <!-- /SIDEBAR END -->

                            <!-- ISI DASHBOARD -->
                            <!-- <a class="nav-link" href="data-pendaftaran/pendaftaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                            Keuntungan
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pemeriksaan') : ?>
                            <a class="nav-link" href="data-pemeriksaan/pemeriksaan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Pengeluaran
                            </a>
                            <a class="nav-link" href="data-resep/resep.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                             Total Kategori Obat
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pembayaran') : ?>
                            <a class="nav-link" href="data-pembayaran/pembayaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Total Dokter
                            </a> -->
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" class="bg-white text-dark">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <!-- Content Row -->

                
                     <!-- 4 KOLOM -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example - KEUNTUNGAN -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="keuntungan/keuntungan.php" style="text-decoration: none;">
                                <div class="card border-left-primary h-100 py-2 bg-primary">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                    Keuntungan</div>
                                                <div class="h5 mb-0 font-weight-bold text-dark">
                                                    <span class="counter" data-count="<?php 
                                                        $ambil = mysqli_query($koneksi, "SELECT * FROM tb_pasien"); 
                                                        $count = mysqli_num_rows($ambil); 
                                                        echo $count;
                                                    ?>">0</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-alt fa-2x text-dark"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Earnings (Monthly) Card Example - PENGELUARAN -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="pengeluaran/pengeluaran.php" style="text-decoration: none;">
                                <div class="card border-left-success h-100 py-2 bg-success">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                    Pengeluaran</div>
                                                <div class="h5 mb-0 font-weight-bold text-dark">
                                                    <span class="counter" data-count="<?php 
                                                        $ambil = mysqli_query($koneksi, "SELECT * FROM tb_obat"); 
                                                        $count = mysqli_num_rows($ambil); 
                                                        echo $count;
                                                    ?>">0</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-capsules fa-2x text-dark"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Earnings (Monthly) Card Example - TOTAL KATEGORI OBAT -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="data-master/data-obat/obat.php" style="text-decoration: none;">
                                <div class="card border-left-info h-100 py-2 bg-info">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                    Total Kategori Obat</div>
                                                <div class="h5 mb-0 font-weight-bold text-dark">
                                                    <span class="counter" data-count="<?php 
                                                        $ambil = mysqli_query($koneksi, "SELECT * FROM tb_pendaftaran WHERE status = '0'"); 
                                                        $count = mysqli_num_rows($ambil); 
                                                        echo $count;
                                                    ?>">0</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-dark"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Pending Requests Card Example - TOTAL DOKTER -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="data-master/data-dokter/dokter.php" style="text-decoration: none;">
                                <div class="card border-left-warning h-100 py-2 bg-warning">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                    Total Dokter</div>
                                                <div class="h5 mb-0 font-weight-bold text-dark">
                                                    <span class="counter" data-count="<?php 
                                                        $ambil = mysqli_query($koneksi, "SELECT * FROM tb_resep WHERE status_rsp = '0'"); 
                                                        $count = mysqli_num_rows($ambil); 
                                                        echo $count;
                                                    ?>">0</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-shopping-cart fa-2x text-dark"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
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
                                    $this.text(Math.floor(this.countNum));
                                },
                                complete: function () {
                                    $this.text(this.countNum);
                                }
                            });
                        });
                    </script>
                    <!-- 4 KOLOM END -->

<title>Dashboard Klinik Modern</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #e0f7fa, #ffffff);
        margin: 0;
        padding: 20px;
    }
    .container {
        width: 100%;
        max-width: 1400px;
        margin: auto;
        background: #ffffff;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .header h2 {
        font-weight: 700;
        color: #0077b6;
        margin: 0;
        font-size: 26px;
    }
    .chart-note {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        width: 100%;
    }
    .chart-container {
        flex: 2.9;  /* Lebar chart dipersempit */
        background: #fff;
        padding: 15px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        min-height: 450px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }
    .note-container {
        flex: 1.1;  /* Notes dilebarkan */
        background: #e0f2ff;
        border-radius: 15px;
        padding: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 100%;
    }
    .note-card, .summary-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        margin-bottom: 15px;
    }
    .summary-card { margin-bottom: 0; }
    h3 {
        margin: 0 0 8px 0;
        font-size: 20px;
        color: #0077b6;
    }
    p {
        margin: 4px 0;
        font-size: 15px;
        color: #333;
    }
    select {
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 15px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    @media (max-width: 992px) {
        .chart-note {
            flex-direction: column;
        }
        .chart-container, .note-container {
            width: 100%;
            flex: none;
        }
    }
</style>


<div class="container">
    <div class="header">
        <h2>Dashboard Keuangan Klinik</h2>
        <div>
            Pilih Tahun:
            <select id="yearSelect">
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025" selected>2025</option>
            </select>
        </div>
    </div>

    <div class="chart-note">
        <div class="chart-container">
            <canvas id="areaChart"></canvas>
        </div>
        <div class="note-container">
            <div class="note-card" id="noteCard">
                <h3>Data Belum Dipilih</h3>
                <p>Klik grafik bulan untuk melihat rincian.</p>
            </div>
            <div class="summary-card" id="summaryCard"></div>
        </div>
    </div>
</div>

<script>
    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    const dataKeuntungan = {
        2021: [2.2, 3.1, 1.5, 4.8, 3.9, 5.0, 4.1, 2.8, 3.7, 4.0, 4.6, 5.2],
        2022: [4.5, 5.2, 6.0, 5.4, 7.0, 8.5, 7.5, 6.3, 8.2, 9.5, 10.0, 11.5],
        2023: [5.8, 6.5, 7.2, 8.0, 9.5, 10.8, 11.0, 12.3, 13.5, 14.2, 15.0, 16.3],
        2024: [7.0, 8.5, 9.2, 10.5, 11.8, 13.0, 14.5, 15.7, 16.8, 18.0, 19.5, 20.7],
        2025: [9.0, 10.5, 12.2, 13.5, 15.0, 16.5, 18.2, 19.0, 20.8, 21.5, 23.0, 24.7]
    };

    const dataPengeluaran = {
        2021: [1.5, 2.0, 1.2, 3.0, 2.5, 3.5, 2.8, 2.0, 2.5, 3.0, 3.4, 3.8],
        2022: [3.0, 3.8, 4.2, 3.6, 4.5, 5.0, 4.8, 4.2, 5.5, 6.0, 6.5, 7.2],
        2023: [4.0, 4.5, 5.0, 5.8, 6.5, 7.2, 8.0, 8.5, 9.0, 10.0, 11.0, 12.0],
        2024: [5.5, 6.0, 6.8, 7.5, 8.0, 9.2, 10.0, 10.8, 12.0, 13.5, 14.2, 15.5],
        2025: [7.0, 8.0, 9.0, 10.5, 11.2, 12.5, 13.8, 14.5, 15.8, 16.5, 18.0, 19.0]
    };

    let tahunAktif = '2025';
    let chartInstance = null;

    function generateNote(tahun, bulanIndex) {
        const month = labels[bulanIndex];
        const keuntungan = dataKeuntungan[tahun][bulanIndex].toFixed(1);
        const pengeluaran = dataPengeluaran[tahun][bulanIndex].toFixed(1);
        const labaBersih = (keuntungan - pengeluaran).toFixed(1);
        return `<h3>${month} ${tahun}</h3>
                <p>Keuntungan: Rp ${keuntungan} Juta</p>
                <p>Pengeluaran: Rp ${pengeluaran} Juta</p>
                <p>Laba Bersih: Rp ${labaBersih} Juta</p>`;
    }

    function generateSummary(tahun) {
        const keuntungan = dataKeuntungan[tahun].reduce((a,b)=>a+b,0);
        const pengeluaran = dataPengeluaran[tahun].reduce((a,b)=>a+b,0);
        const rataKeuntungan = (keuntungan / 12).toFixed(1);
        const rataPengeluaran = (pengeluaran / 12).toFixed(1);
        return `<h3>Rata-rata ${tahun}</h3>
                <p>Keuntungan: Rp ${rataKeuntungan} Juta/bln</p>
                <p>Pengeluaran: Rp ${rataPengeluaran} Juta/bln</p>
                <p>Laba Bersih: Rp ${(rataKeuntungan - rataPengeluaran).toFixed(1)} Juta/bln</p>`;
    }

    function createChart(tahun, bulanAwal) {
        tahunAktif = tahun;
        const ctx = document.getElementById('areaChart').getContext('2d');
        if (chartInstance) chartInstance.destroy();
        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Keuntungan',
                        data: dataKeuntungan[tahun],
                        fill: true,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 10
                    },
                    {
                        label: 'Pengeluaran',
                        data: dataPengeluaran[tahun],
                        fill: true,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 10
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                onClick: (e, elements) => {
                    if (elements.length > 0) {
                        const bulanIndex = elements[0].index;
                        document.getElementById('noteCard').innerHTML = generateNote(tahunAktif, bulanIndex);
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: context => `${context.dataset.label}: Rp ${context.formattedValue} Juta`
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: { callback: val => 'Rp ' + val + 'jt' }
                    }
                }
            }
        });
        document.getElementById('noteCard').innerHTML = generateNote(tahun, bulanAwal);
        document.getElementById('summaryCard').innerHTML = generateSummary(tahun);
    }

    document.getElementById('yearSelect').addEventListener('change', () => {
        createChart(document.getElementById('yearSelect').value, 0);
    });

    createChart(tahunAktif, 0);
</script>

            </script>

            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Poli Klinik 2021 | Repost by <a href='https://stokcoding.com/' title='StokCoding.com' target='_blank'>StokCoding.com</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

</html>