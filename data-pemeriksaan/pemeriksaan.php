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
            box-shadow: 0 4px 24px rgba(84,89,172,0.08);
            padding: 28px 22px 20px 22px;
            display: flex;
            flex-direction: column;
            min-height: 170px;
            position: relative;
            border: none;
            transition: box-shadow 0.2s;
            height: 100%;
        }
        .summary-box:hover {
            box-shadow: 0 8px 32px rgba(8,131,149,0.13);
        }
        .summary-box .summary-title {
            color: #088395;
            font-size: 1.08rem;
            font-weight: 700;
            margin-bottom: 0;
            letter-spacing: 0.2px;
            line-height: 1.2;
        }
        .summary-box .summary-value {
            font-size: 2.0rem;
            font-weight: 800;
            color: #222;
            margin-bottom: 0;
            line-height: 1.1;
            letter-spacing: 1px;
        }
        .summary-box .summary-icon {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            box-shadow: 0 2px 8px rgba(8,131,149,0.10);
        }
        .summary-box .summary-badge {
            margin-top: 18px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            padding: 8px 0;
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
        .review-mini-card {
            box-shadow: 0 4px 24px rgba(8,131,149,0.08) !important;
        }

        /* ==== Insight Card Pemeriksaan ==== */
        .insight-card {
            background: #fff;
            border-radius: 18px;
            border-left: 8px solid #5459AC;
            box-shadow: 0 4px 24px rgba(84,89,172,0.08);
            padding: 28px 28px 22px 28px;
            transition: box-shadow 0.2s;
            margin-bottom: 30px;
        }
        .insight-card:hover {
            box-shadow: 0 8px 32px rgba(8,131,149,0.13);
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

        /* ===== Modern Chart Container ===== */
        .chart-container {
            background: #fff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            padding: 0;
            margin-bottom: 24px;
            overflow: hidden;
        }
        .chart-header {
            padding: 20px 24px 16px 24px;
            border-bottom: 1px solid #f1f3f4;
        }
        .chart-title {
            color: #2c3e50;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 4px;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .chart-subtitle {
            color: #6c757d;
            font-size: 0.85rem;
            margin-bottom: 0;
            font-family: 'Poppins', Arial, sans-serif;
            font-weight: 400;
        }
        .chart-body {
            padding: 16px 24px 24px 24px;
        }
        .chart-wrapper {
            height: 280px;
            position: relative;
            margin-bottom: 16px;
            background: #fafbfc;
            border-radius: 8px;
            padding: 16px;
        }
        
        /* Modern Filter Buttons */
        .filter-buttons {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .filter-btn {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #6c757d;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .filter-btn:hover {
            background: #e9ecef;
            border-color: #adb5bd;
        }
        .filter-btn.active {
            background: linear-gradient(135deg, #5459AC 30%, rgb(111,195,208) 100%);
            border-color: #5459AC;
            color: #fff;
            box-shadow: 0 2px 8px rgba(84, 89, 172, 0.3);
        }
        .filter-btn-success.active {
            background: linear-gradient(135deg, #5459AC 30%, rgb(111,195,208) 100%);
            border-color: #5459AC;
            color: #fff;
            box-shadow: 0 2px 8px rgba(84, 89, 172, 0.3);
        }

        /* Chart Insight */
        .chart-insight {
            background: #f8f9fa;
            border-left: 3px solid #6fc3d0;
            border-radius: 4px;
            padding: 10px 14px;
            margin-top: 12px;
            font-size: 0.85rem;
            color: #495057;
            font-weight: 500;
        }

        /* ===== Modern Table Styling ===== */
        .modern-table-wrapper {
            background: #fff;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            overflow: hidden;
            margin-bottom: 30px;
        }
        .modern-table-header {
            background: #f8f9fa;
            padding: 16px 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modern-table-title {
            color: #495057;
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            display: flex;
            align-items: center;
        }
        .modern-table-title i {
            color: #6fc3d0;
            margin-right: 8px;
            font-size: 1.1rem;
        }
        .add-btn {
            background: linear-gradient(135deg, #5459AC 30%, rgb(111,195,208) 100%);
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(84, 89, 172, 0.3);
        }
        .add-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(84, 89, 172, 0.4);
            color: #fff;
            text-decoration: none;
        }
        
        .modern-table {
            width: 100%;
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            border-collapse: separate;
            border-spacing: 0;
        }
        .modern-table thead th {
            background: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            border: none;
            border-bottom: 1px solid #e9ecef;
            text-align: left;
        }
        .modern-table tbody td {
            padding: 14px 16px;
            border: none;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
            color: #495057;
            font-size: 0.9rem;
        }
        .modern-table tbody tr {
            transition: all 0.2s ease;
        }
        .modern-table tbody tr:hover {
            background: #f8f9fa;
        }
        .modern-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Enhanced Status Badges */
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: capitalize;
            display: inline-block;
        }
        .status-low {
            background: #fee2e2;
            color: #dc2626;
        }
        .status-good {
            background: #dcfce7;
            color: #16a34a;
        }
        .status-medium {
            background: #fef3c7;
            color: #d97706;
        }
        .status-info {
            background: #dbeafe;
            color: #2563eb;
        }
        .status-success {
            background: #dcfce7;
            color: #16a34a;
        }
        .status-warning {
            background: #fef3c7;
            color: #d97706;
        }

        /* Enhanced Action Buttons */
        .action-btn {
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 0.8rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .action-btn-primary {
            background: #007bff;
            color: #fff;
        }
        .action-btn-success {
            background: #28a745;
            color: #fff;
        }
        .action-btn-secondary {
            background: #6c757d;
            color: #fff;
        }
        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            color: #fff;
            text-decoration: none;
        }

        /* Patient Name Styling */
        .patient-name {
            font-weight: 600;
            color: #2c3e50;
        }

        /* Code Styling */
        .exam-code {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #5459AC;
            background: #f0f4ff;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.85rem;
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
                    <?php
                    // Hardcoded Data Pemeriksaan
                    $dataPemeriksaan = [
                        ["nama" => "Andi Wijaya", "keluhan" => "Demam", "diagnosa" => "Flu", "tanggal" => "2025-06-10", "durasi" => 10, "status" => "Selesai"],
                        ["nama" => "Sari Dewi", "keluhan" => "Batuk", "diagnosa" => "ISPA", "tanggal" => "2025-06-11", "durasi" => 15, "status" => "Selesai"],
                        ["nama" => "Budi Hartono", "keluhan" => "Pusing", "diagnosa" => "Vertigo", "tanggal" => "2025-06-12", "durasi" => 18, "status" => "Selesai"],
                        ["nama" => "Lina Marlina", "keluhan" => "Mual", "diagnosa" => "Gastritis", "tanggal" => "2025-06-12", "durasi" => 20, "status" => "Selesai"],
                        ["nama" => "Rizky Hidayat", "keluhan" => "Flu", "diagnosa" => "Common Cold", "tanggal" => "2025-06-13", "durasi" => 12, "status" => "Selesai"],
                        ["nama" => "Intan Permata", "keluhan" => "Demam", "diagnosa" => "DBD", "tanggal" => "2025-06-14", "durasi" => 22, "status" => "Selesai"],
                        ["nama" => "Ahmad Fauzi", "keluhan" => "Batuk", "diagnosa" => "Bronkitis", "tanggal" => "2025-06-15", "durasi" => 25, "status" => "Selesai"],
                        ["nama" => "Maya Sari", "keluhan" => "Pusing", "diagnosa" => "Migrain", "tanggal" => "2025-06-16", "durasi" => 14, "status" => "Selesai"],
                    ];

                    $totalPemeriksaan = count($dataPemeriksaan);
                    $pasienBatal = 8;
                    $rataDurasi = array_sum(array_column($dataPemeriksaan, 'durasi')) / max($totalPemeriksaan, 1);

                    // Hitung keluhan terbanyak
                    $keluhanCount = array_count_values(array_column($dataPemeriksaan, 'keluhan'));
                    arsort($keluhanCount);
                    $keluhanTerbanyak = array_key_first($keluhanCount);
                    $jumlahKeluhanTerbanyak = $keluhanCount[$keluhanTerbanyak];
                    ?>

                    <!-- 🔵 Row 1: Ringkasan Data Pemeriksaan -->
                    <h4 class="mb-4 font-weight-bold text-secondary">Ringkasan Data Pemeriksaan</h4>
                    <div class="row">
                        <!-- Total Pemeriksaan -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Total Pemeriksaan</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $totalPemeriksaan ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-stethoscope"></i></div>
                                <span class="summary-badge badge-green">Bulan Ini</span>
                            </div>
                        </div>
                        <!-- Pasien Batal -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Pasien Batal</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $pasienBatal ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-user-times"></i></div>
                                <span class="summary-badge badge-red">Perlu Tindak Lanjut</span>
                            </div>
                        </div>
                        <!-- Rata-rata Durasi -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Rata Durasi Konsultasi</div>
                                <div class="summary-value"><span class="counter" data-count="<?= round($rataDurasi, 1) ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-clock"></i></div>
                                <span class="summary-badge badge-blue">Menit per Pasien</span>
                            </div>
                        </div>
                        <!-- Keluhan Terbanyak -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Keluhan Terbanyak</div>
                                <div class="summary-value"><?= $jumlahKeluhanTerbanyak ?></div>
                                <div class="summary-icon"><i class="fas fa-notes-medical"></i></div>
                                <span class="summary-badge badge-orange"><?= $keluhanTerbanyak ?></span>
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

                    <!-- 💡 Insight Card -->
                    <div class="insight-card">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="insight-icon">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="insight-title mb-2">Insight Analisis Pemeriksaan</h6>
                                <p class="insight-desc mb-2">Berdasarkan data pemeriksaan terkini, sistem mendeteksi beberapa pola penting:</p>
                                <ul class="insight-list mb-0">
                                    <li>Durasi konsultasi >15 menit banyak terjadi di jam sibuk (17:00-20:00), pertimbangan tambahan dokter shift sore</li>
                                    <li>Sistem mendeteksi <strong><?= $pasienBatal ?> pasien batal</strong> dalam 2 minggu terakhir</li>
                                    <li>Keluhan pencernaan meningkat 20% bulan ini. Waktu tunggu tertinggi hari Jumat pukul 18:00</li>
                                    <li>Pola diagnosa <strong>Flu & ISPA</strong> meningkat, pastikan stok obat tersedia</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <?php
                    // 🔢 ROW 4: Data Diagnosa dan Waktu Tunggu
                    $dataDiagnosaPerHari = [
                        "Senin" => ["Flu" => 5, "Gastritis" => 3, "ISPA" => 2, "Vertigo" => 1, "DBD" => 2],
                        "Selasa" => ["Flu" => 4, "Gastritis" => 4, "ISPA" => 1, "Vertigo" => 3, "Common Cold" => 2],
                        "Rabu" => ["Gastritis" => 6, "Flu" => 2, "ISPA" => 3, "Common Cold" => 1],
                        "Kamis" => ["DBD" => 5, "Gastritis" => 2, "Flu" => 3, "ISPA" => 2],
                        "Jumat" => ["Flu" => 7, "Gastritis" => 5, "ISPA" => 4, "Common Cold" => 3, "DBD" => 4]
                    ];

                    $waktuTungguPerHari = [
                        "Senin" => ["08:00" => 10, "09:00" => 12, "10:00" => 13, "11:00" => 15, "12:00" => 17, "13:00" => 14, "14:00" => 16, "15:00" => 18, "16:00" => 19, "17:00" => 21, "18:00" => 22],
                        "Selasa" => ["08:00" => 9, "09:00" => 10, "10:00" => 12, "11:00" => 13, "12:00" => 14, "13:00" => 15, "14:00" => 16, "15:00" => 17, "16:00" => 18, "17:00" => 20, "18:00" => 21],
                        "Rabu" => ["08:00" => 8, "09:00" => 9, "10:00" => 11, "11:00" => 12, "12:00" => 14, "13:00" => 13, "14:00" => 14, "15:00" => 16, "16:00" => 18, "17:00" => 20, "18:00" => 21],
                        "Kamis" => ["08:00" => 11, "09:00" => 12, "10:00" => 14, "11:00" => 16, "12:00" => 17, "13:00" => 18, "14:00" => 19, "15:00" => 20, "16:00" => 21, "17:00" => 22, "18:00" => 23],
                        "Jumat" => ["08:00" => 13, "09:00" => 14, "10:00" => 15, "11:00" => 16, "12:00" => 18, "13:00" => 19, "14:00" => 21, "15:00" => 22, "16:00" => 23, "17:00" => 25, "18:00" => 27],
                    ];
                    ?>

                    <!-- 🔵 Charts Section -->
                    <div class="row mb-4">
                        <!-- 📊 Kiri: Diagnosa & Keluhan -->
                        <div class="col-md-6">
                            <div class="chart-container">
                                <div class="chart-header">
                                    <h6 class="chart-title">Analisis Diagnosa & Keluhan</h6>
                                    <p class="chart-subtitle">Mengidentifikasi pola penyakit untuk penyesuaian layanan dan stok obat</p>
                                </div>
                                
                                <div class="chart-body">
                                    <!-- Filter Buttons -->
                                    <div class="filter-buttons">
                                        <?php foreach (array_keys($dataDiagnosaPerHari) as $hari): ?>
                                        <button class="filter-btn<?= $hari === 'Senin' ? ' active' : '' ?>" onclick="tampilkanDiagnosaHari('<?= $hari ?>')"><?= $hari ?></button>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- Chart -->
                                    <div class="chart-wrapper">
                                        <canvas id="chartDiagnosaHari"></canvas>
                                    </div>
                                    
                                    <div class="chart-insight">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Kategori <strong>Demam & Batuk</strong> memiliki demand tertinggi. Pastikan stok selalu optimal.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 🕒 Kanan: Waktu Tunggu -->
                        <div class="col-md-6">
                            <div class="chart-container">
                                <div class="chart-header">
                                    <h6 class="chart-title">Laporan Waktu Tunggu</h6>
                                    <p class="chart-subtitle">Optimasi pelayanan & efisiensi tenaga medis berdasarkan jam operasional</p>
                                </div>
                                
                                <div class="chart-body">
                                    <!-- Filter Buttons -->
                                    <div class="filter-buttons">
                                        <?php foreach (array_keys($waktuTungguPerHari) as $hari): ?>
                                        <button class="filter-btn filter-btn-success<?= $hari === "Senin" ? ' active' : '' ?>" onclick="tampilkanJamHari('<?= $hari ?>')"><?= $hari ?></button>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <!-- Chart -->
                                    <div class="chart-wrapper">
                                        <canvas id="chartJamPerHari"></canvas>
                                    </div>
                                    
                                    <div class="chart-insight">
                                        <i class="fas fa-clock mr-2"></i>
                                        Waktu tunggu tertinggi terjadi pada <strong>jam 17:00-18:00</strong>. Pertimbangkan penambahan tenaga medis.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scripts untuk Chart Diagnosa dan Waktu Tunggu -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                                    label: 'Jumlah Kasus',
                                    data: data,
                                    backgroundColor: '#6fc3d0',
                                    borderRadius: 20,
                                    borderSkipped: false,
                                    maxBarThickness: 60
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        enabled: false
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: { 
                                            display: false 
                                        },
                                        ticks: {
                                            color: '#6c757d',
                                            font: { 
                                                size: 11, 
                                                weight: '500',
                                                family: 'Poppins'
                                            }
                                        },
                                        border: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        max: 8,
                                        grid: { 
                                            color: 'rgba(108, 117, 125, 0.1)',
                                            drawBorder: false
                                        },
                                        ticks: {
                                            color: '#6c757d',
                                            font: { 
                                                size: 11, 
                                                weight: '500',
                                                family: 'Poppins'
                                            },
                                            stepSize: 2
                                        },
                                        border: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });

                        if (!fromLoad) {
                            document.querySelectorAll(".filter-btn:not(.filter-btn-success)").forEach(btn => btn.classList.remove("active"));
                            event.target.classList.add("active");
                        }
                    }

                    let chartJam;
                    const ctxJam = document.getElementById('chartJamPerHari').getContext('2d');
                    const dataPerHari = <?= json_encode($waktuTungguPerHari) ?>;

                    function tampilkanJamHari(hari) {
                        const jam = Object.keys(dataPerHari[hari]);
                        const data = Object.values(dataPerHari[hari]);
                        const data2 = data.map(val => val - 5); // Second line data

                        if (chartJam) chartJam.destroy();
                        chartJam = new Chart(ctxJam, {
                            type: 'line',
                            data: {
                                labels: jam,
                                datasets: [{
                                    label: 'Waktu Tunggu',
                                    data: data,
                                    borderColor: '#6fc3d0',
                                    backgroundColor: 'rgba(111, 195, 208, 0.2)',
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: '#6fc3d0',
                                    pointBorderColor: '#6fc3d0',
                                    pointBorderWidth: 2,
                                    pointRadius: 4
                                }, {
                                    label: 'Target Waktu',
                                    data: data2,
                                    borderColor: '#5459AC',
                                    backgroundColor: 'rgba(84, 89, 172, 0.2)',
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: '#5459AC',
                                    pointBorderColor: '#5459AC',
                                    pointBorderWidth: 2,
                                    pointRadius: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top',
                                        align: 'start',
                                        labels: {
                                            usePointStyle: true,
                                            pointStyle: 'rect',
                                            font: {
                                                size: 12,
                                                weight: '500',
                                                family: 'Poppins'
                                            },
                                            color: '#495057',
                                            padding: 20
                                        }
                                    },
                                    tooltip: {
                                        enabled: false
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: { 
                                            display: false 
                                        },
                                        ticks: {
                                            color: '#6c757d',
                                            font: { 
                                                size: 11, 
                                                weight: '500',
                                                family: 'Poppins'
                                            }
                                        },
                                        border: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        max: 30,
                                        grid: { 
                                            color: 'rgba(108, 117, 125, 0.1)',
                                            drawBorder: false
                                        },
                                        ticks: {
                                            color: '#6c757d',
                                            font: { 
                                                size: 11, 
                                                weight: '500',
                                                family: 'Poppins'
                                            },
                                            stepSize: 5
                                        },
                                        border: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });

                        // Set active class
                        document.querySelectorAll(".filter-btn-success").forEach(btn => btn.classList.remove("active"));
                        event.target.classList.add("active");
                    }

                    // ✅ Tampilkan langsung hari Senin saat halaman load
                    document.addEventListener("DOMContentLoaded", function () {
                        tampilkanDiagnosaHari("Senin", true);
                        tampilkanJamHari("Senin");
                    });
                    </script>

                    <!-- 🟣 ROW 5: Detail Tabel Pemeriksaan -->
                    <h4 class="mb-4 font-weight-bold text-secondary mt-5">Detail Tabel Pemeriksaan</h4>
                    
                    <!-- Tabel Ringkas Data Pemeriksaan -->
                    <div class="modern-table-wrapper">
                        <div class="modern-table-header">
                            <h6 class="modern-table-title">
                                <i class="fas fa-table"></i>
                                Ringkasan Data Pemeriksaan
                            </h6>
                            <a href="pemeriksaan_tambah.php" class="add-btn">
                                <i class="fas fa-plus mr-1"></i> Tambah Data Periksa
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pasien</th>
                                        <th>Keluhan</th>
                                        <th>Diagnosa</th>
                                        <th>Tanggal</th>
                                        <th>Durasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($dataPemeriksaan as $dp): ?>
                                    <tr>
                                        <td><strong><?= $no++ ?></strong></td>
                                        <td><span class="patient-name"><?= $dp['nama'] ?></span></td>
                                        <td><span class="status-badge status-info"><?= $dp['keluhan'] ?></span></td>
                                        <td><?= $dp['diagnosa'] ?></td>
                                        <td><?= date('d M Y', strtotime($dp['tanggal'])) ?></td>
                                        <td>
                                            <span class="status-badge <?= $dp['durasi'] > 20 ? 'status-warning' : 'status-good' ?>">
                                                <?= $dp['durasi'] ?> menit
                                            </span>
                                        </td>
                                        <td><span class="status-badge status-success"><?= $dp['status'] ?></span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabel Database Pemeriksaan -->
                    <div class="modern-table-wrapper">
                        <div class="modern-table-header">
                            <h6 class="modern-table-title">
                                <i class="fas fa-database"></i>
                                Database Pemeriksaan Klinik
                            </h6>
                            <a href="pemeriksaan_tambah.php" class="add-btn">
                                <i class="fas fa-plus mr-1"></i> Tambah Data Periksa
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="modern-table" id="dataTable" width="100%" cellspacing="0">
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
                                            <td><span class="exam-code"><?php echo $pecah['kd_pemeriksaan']; ?></span></td>
                                            <td><span class="patient-name"><?php echo $pecah['nm_pasien']; ?></span></td>
                                            <td><span class="status-badge status-info"><?php echo $pecah['nm_poli']; ?></span></td>
                                            <td><?php echo date('d M Y', strtotime($pecah['tgl_pemeriksaan'])); ?></td>
                                            <td>
                                                <?php if ($pecah['status_periksa'] == 0) { ?>
                                                    <a href="pemeriksaan_view.php?&id_pemeriksaan=<?php echo $pecah['id_pemeriksaan']; ?>" class="action-btn action-btn-primary">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                <?php } elseif ($pecah['status_periksa'] == 1) { ?>
                                                    <a href="pemeriksaan_view.php?&id_pemeriksaan=<?php echo $pecah['id_pemeriksaan']; ?>" class="action-btn action-btn-success">
                                                        <i class="fas fa-check-circle"></i> Selesai
                                                    </a>
                                                <?php } else { ?>
                                                    <button class="action-btn action-btn-secondary" disabled>
                                                        <i class="fas fa-minus"></i> N/A
                                                    </button>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($pecah['status_periksa'] == 0) { ?>
                                                    <span class="status-badge status-low">Belum Menerima Resep</span>
                                                <?php } elseif ($pecah['status_periksa'] == 1) { ?>
                                                    <span class="status-badge status-good">Sudah Menerima Resep</span>
                                                <?php } else { ?>
                                                    <span class="status-badge status-medium">Status Tidak Diketahui</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
