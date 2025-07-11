<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../login/index.php'</script>";
    exit();
}

// Get current year and month
$currentYear = date('Y');
$currentMonth = date('n');

// Get target and KPI data from database
$queryKPI = "SELECT * FROM keuntungan_target_kpi WHERE tahun = $currentYear ORDER BY id DESC LIMIT 1";
$resultKPI = mysqli_query($koneksi, $queryKPI);
$kpiData = mysqli_fetch_assoc($resultKPI);

// Get total keuntungan from layanan summary for current year
$queryTotalKeuntungan = "SELECT SUM(total_keuntungan_tahun) as total_tahun FROM keuntungan_layanan_summary WHERE tahun = $currentYear";
$resultTotalKeuntungan = mysqli_query($koneksi, $queryTotalKeuntungan);
$totalKeuntunganData = mysqli_fetch_assoc($resultTotalKeuntungan);

$totalKeuntunganTahun = $totalKeuntunganData['total_tahun'] ? $totalKeuntunganData['total_tahun'] : ($kpiData ? $kpiData['target_tahunan'] : 320000000);
$rataBulan = $totalKeuntunganTahun / 12;

// Get current month profit data (try current month first, then latest available)
$queryBulanIni = "SELECT total_keuntungan, pertumbuhan_vs_bulan_lalu 
                  FROM keuntungan_bulanan_analytics 
                  WHERE tahun = $currentYear AND bulan = $currentMonth 
                  ORDER BY id DESC LIMIT 1";
$resultBulanIni = mysqli_query($koneksi, $queryBulanIni);
$bulanIniData = mysqli_fetch_assoc($resultBulanIni);

// If no data for current month, get latest available month
if (!$bulanIniData) {
    $queryBulanTerakhir = "SELECT total_keuntungan, pertumbuhan_vs_bulan_lalu 
                           FROM keuntungan_bulanan_analytics 
                           WHERE tahun = $currentYear 
                           ORDER BY bulan DESC LIMIT 1";
    $resultBulanTerakhir = mysqli_query($koneksi, $queryBulanTerakhir);
    $bulanIniData = mysqli_fetch_assoc($resultBulanTerakhir);
}

$keuntunganBulanIni = $bulanIniData ? $bulanIniData['total_keuntungan'] : 27000000;
$pertumbuhanBulanan = $bulanIniData ? $bulanIniData['pertumbuhan_vs_bulan_lalu'] : 15;

// Get monthly analytics data for charts
$dataKeuntunganBulanan = [2025 => [], 2024 => []];

// Get 2025 data
$query2025 = "SELECT bulan, total_keuntungan FROM keuntungan_bulanan_analytics 
              WHERE tahun = 2025 ORDER BY bulan";
$result2025 = mysqli_query($koneksi, $query2025);
while ($row = mysqli_fetch_assoc($result2025)) {
    $dataKeuntunganBulanan[2025][$row['bulan'] - 1] = round($row['total_keuntungan'] / 1000000); // Convert to millions
}

// Get 2024 data
$query2024 = "SELECT bulan, total_keuntungan FROM keuntungan_bulanan_analytics 
              WHERE tahun = 2024 ORDER BY bulan";
$result2024 = mysqli_query($koneksi, $query2024);
while ($row = mysqli_fetch_assoc($result2024)) {
    $dataKeuntunganBulanan[2024][$row['bulan'] - 1] = round($row['total_keuntungan'] / 1000000); // Convert to millions
}

// Fill missing months with 0
for ($i = 0; $i < 12; $i++) {
    if (!isset($dataKeuntunganBulanan[2025][$i])) {
        $dataKeuntunganBulanan[2025][$i] = 0;
    }
    if (!isset($dataKeuntunganBulanan[2024][$i])) {
        $dataKeuntunganBulanan[2024][$i] = 0;
    }
}

// Get pie chart data from layanan summary
$pieKeuntunganData = [];
$queryPie = "SELECT layanan, total_keuntungan_tahun, color_theme 
             FROM keuntungan_layanan_summary 
             WHERE tahun = $currentYear 
             ORDER BY total_keuntungan_tahun DESC";
$resultPie = mysqli_query($koneksi, $queryPie);
while ($row = mysqli_fetch_assoc($resultPie)) {
    $pieKeuntunganData[] = [
        'nama' => $row['layanan'],
        'nilai' => round($row['total_keuntungan_tahun'] / 1000000), // Convert to millions
        'color' => $row['color_theme']
    ];
}

// Get breakdown data
$breakdownKeuntungan = [];
$queryBreakdown = "SELECT layanan, sub_layanan, total_keuntungan_tahun, total_transaksi_tahun, icon_class, color_theme 
                   FROM keuntungan_layanan_summary 
                   WHERE tahun = $currentYear 
                   ORDER BY total_keuntungan_tahun DESC";
$resultBreakdown = mysqli_query($koneksi, $queryBreakdown);
while ($row = mysqli_fetch_assoc($resultBreakdown)) {
    $breakdownKeuntungan[] = [
        'layanan' => $row['layanan'],
        'sub_layanan' => $row['sub_layanan'],
        'keuntungan' => $row['total_keuntungan_tahun'],
        'transaksi' => $row['total_transaksi_tahun'] . ' transaksi',
        'icon' => $row['icon_class'],
        'color' => $row['color_theme']
    ];
}

// Get insights and recommendations from database
$queryInsight = "SELECT insight_otomatis, nama_bulan FROM keuntungan_bulanan_analytics 
                 WHERE tahun = $currentYear 
                 ORDER BY bulan DESC LIMIT 1";
$resultInsight = mysqli_query($koneksi, $queryInsight);
$insightData = mysqli_fetch_assoc($resultInsight);

$queryRekomendasi = "SELECT rekomendasi_strategis, bulan_terbaik, bulan_terburuk, layanan_andalan 
                     FROM keuntungan_target_kpi 
                     WHERE tahun = $currentYear 
                     ORDER BY id DESC LIMIT 1";
$resultRekomendasi = mysqli_query($koneksi, $queryRekomendasi);
$rekomendasiData = mysqli_fetch_assoc($resultRekomendasi);

// Get best performing month insight
$queryBestMonth = "SELECT nama_bulan, total_keuntungan, insight_otomatis 
                   FROM keuntungan_bulanan_analytics 
                   WHERE tahun = $currentYear 
                   ORDER BY total_keuntungan DESC LIMIT 1";
$resultBestMonth = mysqli_query($koneksi, $queryBestMonth);
$bestMonthData = mysqli_fetch_assoc($resultBestMonth);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Poli Klinik | Laporan Keuntungan</title>
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="../assets/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* NAVBAR */
        .sb-topnav.navbar {
            background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%) !important;
            box-shadow: 0 4px 18px rgba(84,89,172,0.12);
            border-bottom: none;
            min-height: 62px;
        }
        .sb-topnav .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: 1px;
            color: #fff !important;
            text-shadow: 0 2px 8px rgba(84,89,172,0.10);
        }
        .sb-topnav .navbar-nav .nav-link,
        .sb-topnav .navbar-nav .dropdown-toggle {
            color: #fff !important;
            font-weight: 500;
            font-size: 1.1rem;
            transition: color 0.2s;
        }
        .sb-topnav .navbar-nav .nav-link:hover,
        .sb-topnav .navbar-nav .dropdown-toggle:hover {
            color:rgb(255, 255, 255) !important;
        }
        .sb-topnav .form-control {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 8px rgba(84,89,172,0.08);
        }
        .sb-topnav .btn-light {
            background: #fff;
            color: #5459AC;
            border-radius: 8px;
            border: none;
            transition: background 0.2s, color 0.2s;
        }
        .sb-topnav .btn-light:hover {
            background:rgb(255, 255, 255);
            color: #222;
        }

        /* SIDEBAR */
        .sb-sidenav {
            background: linear-gradient(135deg, #5459AC 50%, rgb(111,195,208) 100%) !important;
            color: #fff;
            box-shadow: 2px 0 18px rgba(84,89,172,0.10);
        }
        .sb-sidenav .sb-sidenav-menu-heading {
            color: #fff;
            font-weight: 700;
            letter-spacing: 1px;
            margin-top: 18px;
            margin-bottom: 8px;
        }
        .sb-sidenav .nav-link {
            color: #fff !important;
            font-weight: 500;
            border-radius: 8px;
            margin-bottom: 4px;
            transition: background 0.18s, color 0.18s, transform 0.18s;
            padding: 10px 18px;
            position: relative;
        }
        .sb-sidenav .nav-link.active,
        .sb-sidenav .nav-link:hover,
        .sb-sidenav .nav-link:focus {
            background: rgba(255,255,255,0.13) !important;
            color: #fff !important;
            transform: translateX(4px) scale(1.04);
            box-shadow: 0 2px 12px rgba(84,89,172,0.10);
        }
        .sb-sidenav .sb-nav-link-icon {
            color: #fff !important;
            margin-right: 10px;
            font-size: 1.1rem;
            transition: color 0.18s;
        }
        .sb-sidenav .nav-link.active .sb-nav-link-icon,
        .sb-sidenav .nav-link:hover .sb-nav-link-icon {
            color:rgb(255, 255, 255) !important;
        }
        .sb-sidenav .sb-sidenav-collapse-arrow {
            color: #fff;
        }
        .sb-sidenav .collapse .nav-link {
            background: rgba(255,255,255,0.08) !important;
            color: #fff !important;
            margin-left: 12px;
        }
        .sb-sidenav .collapse .nav-link:hover {
            background: rgba(0,255,202,0.13) !important;
            color: #fff !important;
        }
        .sb-sidenav .sb-sidenav-menu-nested .nav-link {
            font-size: 1rem;
            padding-left: 32px;
        }
        .sb-sidenav .sb-sidenav-menu-heading {
            margin-left: 8px;
        }
        .sb-sidenav::-webkit-scrollbar {
            width: 7px;
            background: transparent;
        }
        .sb-sidenav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.18);
            border-radius: 8px;
        }
        @media (max-width: 991px) {
            .sb-sidenav {
                background:linear-gradient(135deg, #5459AC 30%, rgb(111,195,208) 100%) !important;
            }
        }

        /* --- SUMMARY BOX MODERN STYLE --- */
        body, .summary-box, .summary-box * {
            font-family: 'Poppins', Arial, sans-serif !important;
        }

        .summary-box {
            background: #fff;
            border-radius: 18px;
            padding: 20px 18px 16px 18px;
            display: flex;
            flex-direction: column;
            min-height: 150px;
            position: relative;
            border: none;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            height: 100%;
            justify-content: space-between;
            cursor: pointer;
        }
        .summary-box:hover {
            transform: translateY(-3px);
            border-color: rgba(8,131,149,0.15);
        }
        .summary-box .summary-title {
            color: #088395;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 12px;
            letter-spacing: 0.2px;
            line-height: 1.3;
            padding-right: 50px;
            word-wrap: break-word;
        }
        .summary-box .summary-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: #222;
            margin-bottom: 12px;
            line-height: 1.1;
            letter-spacing: 1px;
            margin-top: auto;
            display: flex;
            align-items: baseline;
            justify-content: flex-start;
        }
        
        .summary-value .currency {
            font-size: 1.2rem;
            margin-right: 4px;
            color: #666;
            font-weight: 600;
        }
        .summary-box .summary-icon {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff;
            box-shadow: 0 2px 8px rgba(8,131,149,0.10);
            transition: transform 0.3s ease;
        }
        .summary-box:hover .summary-icon {
            transform: scale(1.1);
        }
        .summary-box .summary-badge {
            margin-top: 0;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 8px;
            padding: 8px 12px;
            text-align: center;
            width: 100%;
            display: block;
            letter-spacing: 0.1px;
        }
        .summary-box .badge-green {
            background: #e6f7ec;
            color: #1ca97a;
        }
        .summary-box .badge-red {
            background: #fdeaea;
            color: #e74c3c;
        }
        .summary-box .badge-blue {
            background: #e6f0fa;
            color: #5459AC;
        }
        .summary-box .badge-orange {
            background: #fffbe6;
            color: #ffc107;
        }
        @media (max-width: 767px) {
            .summary-box { min-height: 90px; padding: 10px 6px 8px 6px; }
            .summary-box .summary-value { font-size: 1.2rem; }
            .summary-box .summary-icon { width: 22px; height: 22px; font-size: 0.85rem; }
        }

        /* SHADOW CUSTOM UNTUK SEMUA CARD */
        .shadow-custom {
            box-shadow: 0 4px 24px rgba(8,131,149,0.08) !important;
        }
        .summary-box,
        .insight-card,
        .review-card,
        .card,
        .review-mini-card,
        .service-card,
        .demografi-card {
            box-shadow: 0 4px 24px rgba(8,131,149,0.08) !important;
        }
        
        /* Override untuk hover effects */
        .summary-box:hover,
        .insight-card:hover,
        .service-card:hover {
            box-shadow: 0 8px 32px rgba(8,131,149,0.13) !important;
        }

        /* ==== Insight Card Keuntungan ==== */
        .insight-card {
            background: #fff;
            border-radius: 18px;
            border-left: 8px solid #5459AC;
            padding: 28px 28px 22px 28px;
            transition: box-shadow 0.2s;
            margin-bottom: 0;
        }
        .insight-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fff;
            box-shadow: 0 2px 8px rgba(8,131,149,0.10);
        }
        .insight-title {
            color: #5459AC;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.2px;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .insight-desc {
            color: #222;
            font-size: 1rem;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .insight-list {
            padding-left: 18px;
            color: #222;
            font-size: 0.98rem;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .insight-list li {
            margin-bottom: 6px;
            line-height: 1.5;
        }
        @media (max-width: 767px) {
            .insight-card { padding: 16px 10px 12px 10px; }
            .insight-icon { width: 36px; height: 36px; font-size: 1.2rem; }
            .insight-title { font-size: 1rem; }
        }

        /* ===== Style untuk Visualisasi Chart ===== */
        .demografi-card {
            border-radius: 12px;
            overflow: hidden;
        }
        .demografi-chart-canvas {
            width: 100% !important;
            height: 100% !important;
            max-height: 100%;
        }
        .chart-wrapper {
            height: 260px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .chart-caption {
            margin-top: 0.75rem;
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* === TABEL KEUNTUNGAN MODERN === */
        .table, .dataTable {
            box-shadow: 0 4px 24px rgba(8,131,149,0.08);
        }
        .table thead th, .dataTable thead th {
            background: #5459AC !important;
            color: #fff !important;
            font-weight: 700;
            border: none;
            font-size: 1.05rem;
            letter-spacing: 0.5px;
        }
        .table tbody td, .dataTable tbody td {
            color: #222;
            background: #fff;
            border: none;
            vertical-align: middle;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background: #f8fafc;
        }
        .table-bordered {
            border: none;
        }
        .table-bordered th, .table-bordered td {
            border: none !important;
        }
        .table-hover tbody tr:hover {
            background: rgba(111,195,208,0.12) !important;
            transition: background 0.18s;
        }

        /* Service Cards */
        .service-card {
            background: #fff;
            border-radius: 12px;
            padding: 16px 12px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 160px;
        }
        .service-card:hover {
            transform: translateY(-3px);
            border-color: rgba(84,89,172,0.15);
        }
        .service-icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            transition: transform 0.3s ease;
        }
        .service-card:hover .service-icon-wrapper {
            transform: scale(1.05);
        }
        .service-icon-wrapper i {
            font-size: 1.8rem;
            transition: all 0.3s ease;
        }
        .service-info {
            width: 100%;
        }
        .service-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 6px;
            font-family: 'Poppins', Arial, sans-serif;
            line-height: 1.2;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .service-revenue {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 4px;
            font-family: 'Poppins', Arial, sans-serif;
            line-height: 1.1;
        }
        .service-transactions {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0;
            font-weight: 500;
            font-family: 'Poppins', Arial, sans-serif;
        }

        /* Padding atas main agar tidak menempel headbar */
        #layoutSidenav_content main > .container-fluid,
        #layoutSidenav_content main > .container {
            padding-top: 1.5rem;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="../index.php">Clinic 24</a>
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
                        <div class="sb-sidenav-menu-heading">C24</div>
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

                    <!-- 🔵 Row 1: Ringkasan Data Keuntungan -->
                    <h4 class="mb-4 font-weight-bold text-secondary">Ringkasan Data Keuntungan</h4>
                    <div class="row">
                        <!-- Total Keuntungan Tahun Ini -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Total Keuntungan Tahun Ini</div>
                                <div class="summary-value"><span class="currency">Rp</span><span class="counter" data-count="<?= $totalKeuntunganTahun ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-coins"></i></div>
                                <span class="summary-badge badge-green">Target Tercapai</span>
                            </div>
                        </div>
                        <!-- Rata-rata Keuntungan Bulanan -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Rata-rata / Bulan</div>
                                <div class="summary-value"><span class="currency">Rp</span><span class="counter" data-count="<?= $rataBulan ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-chart-line"></i></div>
                                <span class="summary-badge badge-blue">Konsisten</span>
                            </div>
                        </div>
                        <!-- Keuntungan Bulan Ini -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Keuntungan Bulan Ini</div>
                                <div class="summary-value"><span class="currency">Rp</span><span class="counter" data-count="<?= $keuntunganBulanIni ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-calendar-alt"></i></div>
                                <span class="summary-badge badge-orange">Bulan Berjalan</span>
                            </div>
                        </div>
                        <!-- Pertumbuhan Bulanan -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Pertumbuhan Bulanan</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $pertumbuhanBulanan ?>">0</span>%</div>
                                <div class="summary-icon"><i class="fas fa-percentage"></i></div>
                                <span class="summary-badge badge-green">Trend Positif</span>
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
                            $this.text(val % 1 === 0 ? new Intl.NumberFormat('id-ID').format(val.toFixed(0)) : new Intl.NumberFormat('id-ID').format(val.toFixed(1)));
                        },
                        complete: function () {
                            let val = parseFloat(this.countNum);
                            $this.text(val % 1 === 0 ? new Intl.NumberFormat('id-ID').format(val.toFixed(0)) : new Intl.NumberFormat('id-ID').format(val.toFixed(1)));
                        }
                        });
                    });
                    </script>

                    <!-- 🟠 Row 2: Insight Keuangan Otomatis -->
                    <div class="mb-4">
                        <div class="insight-card shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="insight-icon mr-3">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <div>
                                    <h6 class="insight-title mb-2">Insight Saran Cerdas Keuangan</h6>
                                    <p class="insight-desc mb-2">
                                        <?php if ($insightData): ?>
                                            📊 <strong><?= $insightData['insight_otomatis'] ?></strong>
                                        <?php else: ?>
                                            📊 Sistem mendeteksi <strong><?= $rekomendasiData['layanan_andalan'] ?? 'Penjualan Obat' ?></strong> sebagai sumber keuntungan utama.
                                        <?php endif; ?>
                                        <?php if ($bestMonthData): ?>
                                            Bulan <strong><?= $bestMonthData['nama_bulan'] ?></strong> mencatatkan keuntungan tertinggi sebesar <strong>Rp <?= number_format($bestMonthData['total_keuntungan'] / 1000000, 0) ?> juta</strong>.
                                        <?php endif; ?>
                                    </p>
                                    <ul class="insight-list mb-0">
                                        <?php if ($rekomendasiData): ?>
                                            <li>🎯 <strong>Rekomendasi Strategis:</strong> <?= $rekomendasiData['rekomendasi_strategis'] ?></li>
                                            <li>🏆 <strong>Bulan Terbaik:</strong> <?= $rekomendasiData['bulan_terbaik'] ?> - analisis faktor keberhasilan untuk replikasi</li>
                                            <li>� <strong>Layanan Andalan:</strong> <?= $rekomendasiData['layanan_andalan'] ?> sebagai tulang punggung revenue</li>
                                            <?php if ($rekomendasiData['bulan_terburuk']): ?>
                                            <li>⚠️ <strong>Perlu Perhatian:</strong> Evaluasi performa bulan <?= $rekomendasiData['bulan_terburuk'] ?> untuk improvement</li>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <li>💊 <strong>Penjualan Obat</strong> adalah sumber revenue utama, fokuskan inventory management.</li>
                                            <li>📈 Evaluasi tren bulanan untuk optimalisasi strategi pemasaran.</li>
                                            <li>🎯 <strong>Konsultasi Dokter</strong> menunjukkan potensi besar, tingkatkan kapasitas layanan.</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 🟢 Row 3: Visualisasi Distribusi Keuntungan -->
                    <h5 class="mb-3 font-weight-bold text-secondary">Visualisasi Distribusi Keuntungan</h5>
                    <div class="row">
                        <!-- Pie Chart Sumber Keuntungan -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow demografi-card h-100">
                                <div class="card-body pb-2">
                                    <h6 class="font-weight-bold text-primary">Distribusi Sumber Keuntungan (%)</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="pieKeuntunganChart" class="demografi-chart-canvas"></canvas>
                                    </div>
                                    <div class="chart-caption">📊 <strong><?= $rekomendasiData['layanan_andalan'] ?? 'Penjualan Obat' ?></strong> mendominasi revenue. Diversifikasi layanan untuk stabilitas.</div>
                                </div>
                            </div>
                        </div>
                        <!-- Bar Chart Keuntungan Bulanan -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow demografi-card h-100">
                                <div class="card-body pb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="font-weight-bold text-primary">Grafik Keuntungan Bulanan</h6>
                                        <select id="tahunSelect" class="form-control form-control-sm" style="width: auto;">
                                            <option value="2025" selected>2025</option>
                                            <option value="2024">2024</option>
                                        </select>
                                    </div>
                                    <div class="chart-wrapper">
                                        <canvas id="keuntunganChart" class="demografi-chart-canvas"></canvas>
                                    </div>
                                    <div class="chart-caption">📈 <strong><?= $bestMonthData['nama_bulan'] ?? 'Juni' ?></strong> menunjukkan performa terbaik. Analisis faktor penyebab untuk replikasi strategi.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Script Chart.js -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
                    <script>
                    // Data from PHP database queries
                    const dataKeuntunganBulanan = {
                        2025: <?= json_encode(array_values($dataKeuntunganBulanan[2025])) ?>,
                        2024: <?= json_encode(array_values($dataKeuntunganBulanan[2024])) ?>
                    };
                    const bulanLabels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
                    const barColors = [
                        '#5A9BFF', '#5ACF85', '#4BBFC9', '#FFD350',
                        '#E35B5B', '#8A5BFF', '#3ED1AA', '#FF9240',
                        '#9356A3', '#FF70A6', '#FFB347', '#FF8F8F'
                    ];

                    const pieKeuntunganData = <?= json_encode($pieKeuntunganData) ?>;
                    const pieColors = [
                      'rgba(84,89,172,0.92)', 'rgba(111,195,208,0.92)', 'rgba(8,131,149,0.92)',
                      'rgba(111,195,208,0.65)', 'rgba(84,89,172,0.65)', 'rgba(8,131,149,0.65)'
                    ];

                    // Bar Chart
                    const ctx = document.getElementById("keuntunganChart").getContext('2d');
                    let chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: bulanLabels,
                            datasets: [{
                                label: 'Keuntungan (Juta)',
                                data: dataKeuntunganBulanan[2025],
                                backgroundColor: 'rgba(8,131,149,0.85)',
                                borderRadius: 12,
                                borderSkipped: false,
                                maxBarThickness: 38
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#5459AC',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    borderColor: '#6fc3d0',
                                    borderWidth: 1,
                                    callbacks: {
                                        label: (ctx) => `Keuntungan: Rp ${ctx.raw} juta`
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    ticks: {
                                        color: '#5459AC',
                                        font: { weight: 'bold', family: 'Poppins' }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: { color: 'rgba(8,131,149,0.08)' },
                                    ticks: {
                                        color: '#5459AC',
                                        font: { weight: 'bold', family: 'Poppins' }
                                    }
                                }
                            }
                        }
                    });

                    document.getElementById('tahunSelect').addEventListener('change', function() {
                        const tahun = this.value;
                        chart.data.datasets[0].data = dataKeuntunganBulanan[tahun];
                        chart.update();
                    });

                    // Pie Chart
                    new Chart(document.getElementById('pieKeuntunganChart'), {
                        type: 'doughnut',
                        data: {
                            labels: pieKeuntunganData.map(item => item.nama),
                            datasets: [{
                                data: pieKeuntunganData.map(item => item.nilai),
                                backgroundColor: pieColors,
                                borderColor: '#fff',
                                borderWidth: 3,
                                hoverOffset: 8
                            }]
                        },
                        options: {
                            cutout: '68%',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        color: '#5459AC',
                                        font: { size: 13, weight: 'bold', family: 'Poppins' },
                                        boxWidth: 18,
                                        padding: 18
                                    }
                                },
                                tooltip: {
                                    backgroundColor: '#5459AC',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    borderColor: '#6fc3d0',
                                    borderWidth: 1,
                                    callbacks: {
                                        label: function(ctx) {
                                            const total = pieKeuntunganData.reduce((a, b) => a + b.nilai, 0);
                                            const val = pieKeuntunganData[ctx.dataIndex].nilai;
                                            const percent = ((val / total) * 100).toFixed(1);
                                            return `${ctx.label}: Rp ${val} juta (${percent}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                    </script>

                    <!-- Service Revenue Cards Section -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="font-weight-bold text-secondary mb-0">Breakdown Keuntungan per Layanan</h5>
                        <div class="d-flex align-items-center">
                            <div class="input-group" style="width: 280px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0" style="border: 1px solid #e3e6f0; border-right: none;">
                                        <i class="fas fa-search text-muted" style="font-size: 0.9rem;"></i>
                                    </span>
                                </div>
                                <input type="text" id="serviceDetailSearch" class="form-control border-left-0 pl-0" placeholder="Cari layanan atau sub layanan..." style="border: 1px solid #e3e6f0; border-left: none; font-size: 0.9rem;">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <?php foreach($breakdownKeuntungan as $service): ?>
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="service-card">
                                <div class="service-icon-wrapper" style="background-color: <?= $service['color'] ?>20;">
                                    <i class="<?= $service['icon'] ?>" style="color: <?= $service['color'] ?>;"></i>
                                </div>
                                <div class="service-info">
                                    <h6 class="service-name"><?= $service['layanan'] ?></h6>
                                    <p class="service-revenue" style="color: <?= $service['color'] ?>;">Rp <?= number_format($service['keuntungan'] / 1000000) ?>jt</p>
                                    <p class="service-transactions"><?= $service['transaksi'] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Tabel Keuntungan Detail -->
                    <div class="card mb-4 shadow-sm" style="border: none; border-radius: 12px; overflow: hidden;">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="serviceDetailTable">
                                    <thead style="background: linear-gradient(90deg, #5459AC 85%, #6fc3d0 100%);">
                                        <tr>
                                            <th style="border: none; padding: 16px 20px; font-weight: 700; color: #fff; font-size: 0.95rem;">Layanan</th>
                                            <th style="border: none; padding: 16px 20px; font-weight: 700; color: #fff; font-size: 0.95rem;">Sub Layanan</th>
                                            <th style="border: none; padding: 16px 20px; font-weight: 700; color: #fff; font-size: 0.95rem;">Total Keuntungan</th>
                                            <th style="border: none; padding: 16px 20px; font-weight: 700; color: #fff; font-size: 0.95rem;">Volume Transaksi</th>
                                            <th style="border: none; padding: 16px 20px; font-weight: 700; color: #fff; font-size: 0.95rem;">Kontribusi (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $totalKeuntunganAll = array_sum(array_column($breakdownKeuntungan, 'keuntungan'));
                                        foreach($breakdownKeuntungan as $service): 
                                            $kontribusi = ($service['keuntungan'] / $totalKeuntunganAll) * 100;
                                        ?>
                                        <tr class="service-detail-row" style="border-bottom: 1px solid #f1f3f4;">
                                            <td style="border: none; padding: 18px 20px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3" style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, <?= $service['color'] ?>20 0%, <?= $service['color'] ?>10 100%); display: flex; align-items: center; justify-content: center;">
                                                        <i class="<?= $service['icon'] ?>" style="color: <?= $service['color'] ?>; font-size: 1.2rem;"></i>
                                                    </div>
                                                    <strong style="color: #2c3e50; font-size: 0.95rem;"><?= $service['layanan'] ?></strong>
                                                </div>
                                            </td>
                                            <td style="border: none; padding: 18px 20px; color: #6c757d; font-size: 0.9rem;"><?= $service['sub_layanan'] ?></td>
                                            <td style="border: none; padding: 18px 20px;">
                                                <strong style="color: #2c3e50; font-size: 0.95rem;">Rp <?= number_format($service['keuntungan']) ?></strong>
                                            </td>
                                            <td style="border: none; padding: 18px 20px;">
                                                <span class="badge px-3 py-2" style="background: <?= $service['color'] ?>15; color: <?= $service['color'] ?>; font-weight: 600; border-radius: 6px; font-size: 0.8rem;">
                                                    <?= $service['transaksi'] ?>
                                                </span>
                                            </td>
                                            <td style="border: none; padding: 18px 20px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress mr-2" style="width: 60px; height: 6px; border-radius: 3px; background: #f1f3f4;">
                                                        <div class="progress-bar" style="background: <?= $service['color'] ?>; width: <?= number_format($kontribusi, 1) ?>%; border-radius: 3px;"></div>
                                                    </div>
                                                    <span style="color: <?= $service['color'] ?>; font-weight: 700; font-size: 0.85rem;">
                                                        <?= number_format($kontribusi, 1) ?>%
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Search Script for Detail Table -->
                    <script>
                    document.getElementById('serviceDetailSearch').addEventListener('keyup', function() {
                        const searchTerm = this.value.toLowerCase();
                        const rows = document.querySelectorAll('#serviceDetailTable .service-detail-row');
                        
                        rows.forEach(row => {
                            const serviceName = row.cells[0].textContent.toLowerCase();
                            const subService = row.cells[1].textContent.toLowerCase();
                            
                            if (serviceName.includes(searchTerm) || subService.includes(searchTerm)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    });
                    </script>

                </div>
            </main>

            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Clinic 24 - 2024</div>
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
