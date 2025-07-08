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
  /* NEW: biar sejajar icon */
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
@media (max-width: 767px) {
  .summary-box { min-height: 90px; padding: 10px 6px 8px 6px; }
  .summary-box .summary-value { font-size: 1.2rem; }
  .summary-box .summary-icon { width: 22px; height: 22px; font-size: 0.85rem; }
}
/* --- END SUMMARY BOX MODERN --- */

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


/* --- STAFF PERFORMANCE MODERN --- */
.staff-filter-bar {
  background: #f8f9fa;
  border-radius: 14px;
  padding: 14px 18px 10px 18px;
  margin-bottom: 18px;
  box-shadow: 0 2px 12px rgba(84,89,172,0.07);
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: nowrap;
}
.staff-filter-bar .form-control,
.staff-filter-bar .btn,
.staff-filter-bar select {
  border-radius: 8px !important;
  font-size: 1rem;
  min-width: 140px;
  margin-right: 0;
  margin-bottom: 0;
}
.staff-filter-bar .form-control {
  flex: 0 0 180px;
}
.staff-filter-bar .btn-secondary {
  background: #e6f7ec;
  color: #1ca97a;
  border: none;
  font-weight: 600;
  margin-left: 0;
}
.staff-filter-bar .btn-secondary:hover {
  background: #1ca97a;
  color: #fff;
}
.staff-filter-bar .btn-outline-primary {
  border: 2px solid #5459AC;
  color: #5459AC;
  background: #fff;
  font-weight: 600;
  letter-spacing: 0.2px;
  transition: background 0.18s, color 0.18s;
  margin-left: auto;
  min-width: 210px;
}
.staff-filter-bar .btn-outline-primary:hover {
  background: #5459AC;
  color: #fff;
}
@media (max-width: 991px) {
  .staff-filter-bar {
    flex-wrap: wrap;
    gap: 8px;
  }
  .staff-filter-bar .btn-outline-primary {
    min-width: 100%;
    margin-left: 0;
    margin-top: 8px;
  }
}
.staff-card-modern .card {
  border-radius: 16px;
  box-shadow: 0 4px 18px rgba(84,89,172,0.10);
  border: none;
  transition: box-shadow 0.18s;
}
.staff-card-modern .card:hover {
  box-shadow: 0 8px 32px rgba(8,131,149,0.13);
  transform: translateY(-2px) scale(1.01);
}
.staff-card-modern .card-header {
  border-radius: 16px 16px 0 0;
  background: linear-gradient(90deg, #5459AC 80%, #6fc3d0 100%);
  color: #fff;
  font-weight: 600;
  font-size: 1.1rem;
  letter-spacing: 0.2px;
}
.staff-card-modern .card-footer {
  background: #f8f9fa;
  border-radius: 0 0 16px 16px;
}
.staff-card-modern .badge-success {
  background: #e6f7ec;
  color: #1ca97a;
  font-weight: 600;
}
.staff-card-modern .badge-warning {
  background: #fffbe6;
  color: #ffc107;
  font-weight: 600;
}
.staff-card-modern .badge-danger {
  background: #fdeaea;
  color: #e74c3c;
  font-weight: 600;
}
.staff-card-modern .progress {
  background: #e9ecef;
  border-radius: 8px;
  height: 10px;
}
.staff-card-modern .progress-bar {
  border-radius: 8px;
}
.staff-pagination {
  margin-top: 18px;
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}
.staff-pagination .btn {
  border-radius: 8px;
  min-width: 110px;
  font-weight: 600;
  letter-spacing: 0.2px;
  border: 2px solid #5459AC;
  color: #5459AC;
  background: #fff;
  transition: background 0.18s, color 0.18s;
}
.staff-pagination .btn:disabled {
  background: #f0f0f0;
  color: #aaa;
  border-color: #eee;
}
.staff-pagination .btn:hover:not(:disabled) {
  background: #5459AC;
  color: #fff;
}
@media (max-width: 767px) {
  .staff-filter-bar { flex-direction: column; align-items: stretch; }
  .staff-pagination { justify-content: center; }
}
/* --- TOP 3 STAFF MODAL MODERN --- */
.top-staff-card {
  border-radius: 16px;
  box-shadow: 0 4px 18px rgba(84,89,172,0.10);
  border: none;
  background: #fff;
  transition: box-shadow 0.18s;
  margin-bottom: 18px;
}
.top-staff-card .card-header {
  border-radius: 16px 16px 0 0;
  background: linear-gradient(90deg, #ffc107 80%, #fffbe6 100%);
  color: #222;
  font-weight: 700;
  font-size: 1.1rem;
}
.top-staff-card .badge {
  font-size: 1rem;
  border-radius: 8px;
  padding: 6px 18px;
  font-weight: 600;
}
.top-staff-card .badge-success {
  background: #e6f7ec;
  color: #1ca97a;
}
.top-staff-card .badge-warning {
  background: #fffbe6;
  color: #ffc107;
}
.top-staff-card .badge-info {
  background: #e6f0fa;
  color: #5459AC;
}
.top-staff-card .fa-trophy {
  color: #ffc107;
  margin-right: 6px;
}

/* Avatar bulat gradasi dengan icon orang */
.staff-avatar-gradient {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
    color: #fff;
    font-size: 1.7rem;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(84,89,172,0.10);
    display: flex;
    align-items: center;
    justify-content: center;
}
.staff-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
}
.staff-pagination .btn {
    border-radius: 8px;
    min-width: 120px;
    font-weight: 600;
    border: 2px solid #5459AC;
    color: #5459AC;
    background: #fff;
    transition: background 0.18s, color 0.18s;
}
.staff-pagination .btn:disabled {
    background: #f0f0f0;
    color: #aaa;
    border-color: #eee;
}
.staff-pagination .btn:hover:not(:disabled) {
    background: #5459AC;
    color: #fff;
}
/* ===== Style untuk Visualisasi Staff Chart ===== */

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
/* ==== Insight Card Staff ==== */
.insight-card {
    background: #fff;
    border-radius: 18px;
    border-left: 8px solid #5459AC;
    box-shadow: 0 4px 24px rgba(84,89,172,0.08);
    padding: 28px 28px 22px 28px;
    transition: box-shadow 0.2s;
    margin-bottom: 0;
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

/* === TABEL STAFF MODERN === */
.table, .dataTable {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    font-family: 'Poppins', Arial, sans-serif;
    font-size: 1rem;
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
.dataTables_wrapper .dataTables_filter {
    margin: 12px 0 !important;  /* ✅ Atur margin atas dan bawah agar tidak terpotong */
    float: right;
    text-align: right;
}

.dataTables_filter label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #5459AC;
    font-family: 'Poppins', Arial, sans-serif;
    margin-bottom: 0;
}
.dataTables_filter input[type="search"] {
    border-radius: 8px;
    border: 2px solid #6fc3d0;
    padding: 6px 12px;
    font-size: 1rem;
    font-family: 'Poppins', Arial, sans-serif;
    margin-left: 8px;
    background: #fff;
    color: #222;
    transition: border 0.18s;
    box-shadow: 0 2px 8px rgba(8,131,149,0.08);
}
.dataTables_filter input[type="search"]:focus {
    border-color: #5459AC;
    outline: none;
}
.dataTables_wrapper .dataTables_paginate {
    margin-top: 10px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    background: #fff;
    color: #5459AC !important;
    border: 2px solid #6fc3d0;
    border-radius: 8px;
    font-weight: 600;
    font-family: 'Poppins', Arial, sans-serif;
    margin: 0 2px;
    padding: 4px 18px;
    transition: background 0.18s, color 0.18s, border 0.18s, box-shadow 0.18s;
    box-shadow: 0 2px 8px rgba(8,131,149,0.08);
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #5459AC !important;
    color: #fff !important;
    border-color: #5459AC;
    box-shadow: 0 4px 18px rgba(8,131,149,0.13);
}
.dataTables_wrapper .dataTables_info {
    font-size: 0.98rem;
    color: #5459AC;
    font-family: 'Poppins', Arial, sans-serif;
    margin-top: 10px;
}
@media (max-width: 767px) {
    .table, .dataTable { font-size: 0.95rem; }
    .dataTables_filter input[type="search"] { font-size: 0.95rem; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 4px 10px; font-size: 0.95rem; }
}

/* Padding atas main agar tidak menempel headbar */
#layoutSidenav_content main > .container-fluid,
#layoutSidenav_content main > .container {
    padding-top: 1.5rem;
}
    </style>
    <script src="../../assets/js/jquery-3.5.1.min.js"></script>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>
    <script src="../../assets/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/js/custom.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="../../index.php">Clinic 24</a>
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
                        <div class="sb-sidenav-menu-heading">C24</div>
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
                      <?php
                    // Hardcode Data Staff (Contoh)
                    $dataStaff = [
                        [
                            "nama" => "Suster Ayu",
                            "posisi" => "Admin Apotik",
                            "jam_kerja" => 160,
                            "kehadiran" => 95,
                            "rating" => 4.8,
                            "ulasan" => "Sangat profesional dan ramah.",
                            "tanggal" => "2025-06-10"
                        ],
                        [
                            "nama" => "Dita",
                            "posisi" => "Kasir",
                            "jam_kerja" => 150,
                            "kehadiran" => 82,
                            "rating" => 4.3,
                            "ulasan" => "Pelayanan cepat dan akurat.",
                            "tanggal" => "2025-06-12"
                        ],
                        [
                            "nama" => "Andre",
                            "posisi" => "Apoteker",
                            "jam_kerja" => 140,
                            "kehadiran" => 80,
                            "rating" => 3.5,
                            "ulasan" => "Perlu peningkatan kehadiran.",
                            "tanggal" => "2025-06-15"
                        ],
                        [
                            "nama" => "Sinta",
                            "posisi" => "Suster",
                            "jam_kerja" => 170,
                            "kehadiran" => 98,
                            "rating" => 4.7,
                            "ulasan" => "Sangat teliti dan bertanggung jawab.",
                            "tanggal" => "2025-06-09"
                        ],
                        [
                            "nama" => "Budi",
                            "posisi" => "Cleaning Service",
                            "jam_kerja" => 160,
                            "kehadiran" => 90,
                            "rating" => 4.0,
                            "ulasan" => "Rajin dan tepat waktu.",
                            "tanggal" => "2025-06-08"
                        ],
                        [
                            "nama" => "Rina",
                            "posisi" => "Admin",
                            "jam_kerja" => 155,
                            "kehadiran" => 85,
                            "rating" => 4.1,
                            "ulasan" => "Perlu peningkatan disiplin.",
                            "tanggal" => "2025-06-05"
                        ]
                    ];
                    
                    // Sorting rating tertinggi dan terendah
                    $ulasanPositif = array_slice(array_values(array_filter($dataStaff, fn($d) => $d['rating'] >= 4)), 0, 5);
                    $ulasanNegatif = array_slice(array_values(array_filter($dataStaff, fn($d) => $d['rating'] < 4)), 0, 5);
                    
                    // Hardcode Data Ringkasan Staff
                    $totalStaff = 18;
                    $staffAktif = 16;
                    $staffCuti = 2;
                    $rataKehadiran = 92;
                    $kenaikanStaffBulanIni = 8; // %
                    $staffKurangPerforma = 3;
                    ?>
                    
                    <!-- 🔵 Row 1: Ringkasan -->
                    <h4 class="mb-4 font-weight-bold text-secondary">Ringkasan Data Staff</h4>
                    <div class="row">
                        <!-- Total Staff -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Total Staff</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $totalStaff ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-users"></i></div>
                                <span class="summary-badge badge-green">+<?= $kenaikanStaffBulanIni ?>% this month</span>
                            </div>
                        </div>
                        <!-- Staff Aktif -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Staff Aktif</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $staffAktif ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-user-check"></i></div>
                                <span class="summary-badge badge-green">Active</span>
                            </div>
                        </div>
                        <!-- Staff Cuti -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Staff Cuti</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $staffCuti ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-user-slash"></i></div>
                                <span class="summary-badge badge-red">On Leave</span>
                            </div>
                        </div>
                        <!-- Rata Kehadiran -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Rata-rata Kehadiran</div>
                                <div class="summary-value">
                                    <span class="counter" data-count="<?= $rataKehadiran ?>">0</span>
                                    <span style="font-size:1.3rem;color:#1ca97a;vertical-align:middle;">%</span>
                                </div>
                                <div class="summary-icon"><i class="fas fa-calendar-check"></i></div>
                                <span class="summary-badge badge-red"><?= $staffKurangPerforma ?> staff perlu perhatian</span>
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
                    $staffBaru = true; // Jika true, ada rekrutmen baru
                    $rasioStaffPria = 40; // dalam persen
                    ?>
                    <!-- 🔮 Insight MIS -->
                    <div class="mb-4">
                        <div class="insight-card shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="insight-icon mr-3">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <div>
                                    <h6 class="insight-title mb-2">Insight MIS</h6>
                                    <p class="insight-desc mb-2">
                                        📈 Jumlah staff meningkat sebesar <strong><?= $kenaikanStaffBulanIni ?>%</strong> dibanding bulan lalu.
                                        Kehadiran rata-rata <strong><?= $rataKehadiran ?>%</strong> menunjukkan disiplin yang baik. Pertimbangkan
                                        <em>program reward</em> untuk staff dengan performa terbaik.
                                    </p>
                                    <ul class="insight-list mb-0">
                                        <?php if ($staffBaru): ?>
                                        <li>👥 Rekrutmen staff baru berhasil, pastikan <strong>orientasi & training</strong> berjalan optimal.</li>
                                        <?php endif; ?>
                                        <?php if ($staffKurangPerforma > 0): ?>
                                        <li>⚠️ <strong><?= $staffKurangPerforma ?> staff</strong> memiliki performa di bawah standar, perlu <strong>evaluasi & coaching</strong>.</li>
                                        <?php endif; ?>
                                        <?php if ($rasioStaffPria < 50): ?>
                                        <li>👨 Rasio staff pria hanya <strong><?= $rasioStaffPria ?>%</strong>. Pertimbangkan <strong>keseimbangan gender</strong> dalam rekrutmen.</li>
                                        <?php endif; ?>
                                        <?php if ($rataKehadiran > 90): ?>
                                        <li>✅ Tingkat kehadiran sangat baik, pertahankan dengan <strong>sistem reward</strong> dan <strong>work-life balance</strong>.</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="staff-filter-bar mb-4">
                      <input type="text" id="searchInput" class="form-control" placeholder="Cari nama atau posisi">
                      <select id="filterStatus" class="form-control">
                          <option value="">Semua Status</option>
                          <option value="Sangat Baik">Sangat Baik</option>
                          <option value="Cukup">Cukup</option>
                          <option value="Perlu Monitoring">Perlu Monitoring</option>
                      </select>
                      <select id="filterPosisi" class="form-control">
                          <option value="">Semua Posisi</option>
                          <option value="Admin Apotik">Admin Apotik</option>
                          <option value="Kasir">Kasir</option>
                          <option value="Apoteker">Apoteker</option>
                          <option value="Suster">Suster</option>
                          <option value="Cleaning Service">Cleaning Service</option>
                      </select>
                      <button class="btn btn-secondary" id="resetFilter"><i class="fas fa-sync-alt mr-1"></i>Reset</button>
                      <div class="ml-auto d-flex align-items-center" style="gap:8px;">
                          <button class="btn btn-outline-primary" data-toggle="modal" data-target="#topStaffModal">
                              <i class="fas fa-trophy mr-2"></i>Lihat Top 3 Staff Terbaik
                          </button>
                      </div>
                  </div>

                    <!-- Modal Popup - Top 3 Staff Terbaik -->
                    <div class="modal fade" id="topStaffModal" tabindex="-1" role="dialog" aria-labelledby="topStaffModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content top-staff-modal">
                          <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="topStaffModalLabel"><i class="fas fa-trophy mr-2"></i>Top 3 Staff Terbaik Bulan Ini</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                            <?php
                            $topStaff = [
                                ["rank" => 1, "nama" => "Ayu", "posisi" => "Admin Apotik", "jam" => 176, "kehadiran" => 98, "rating" => 4.9, "badge" => "Teladan"],
                                ["rank" => 2, "nama" => "Budi", "posisi" => "Apoteker", "jam" => 170, "kehadiran" => 95, "rating" => 4.7, "badge" => "Sangat Baik"],
                                ["rank" => 3, "nama" => "Sinta", "posisi" => "Kasir", "jam" => 168, "kehadiran" => 94, "rating" => 4.6, "badge" => "Konsisten"]
                            ];
                            $badgeClass = ["Teladan" => "success", "Sangat Baik" => "warning", "Konsisten" => "info"];
                            foreach ($topStaff as $staff) { ?>
                              <div class="col-md-4">
                                <div class="card top-staff-card h-100">
                                  <div class="card-header text-center">
                                    <span class="fa fa-trophy"></span>
                                    <span class="font-weight-bold">Peringkat <?= $staff['rank'] ?></span>
                                  </div>
                                  <div class="card-body text-center">
                                    <h5 class="mb-1"><?= $staff['nama'] ?></h5>
                                    <div class="text-muted mb-2"><?= $staff['posisi'] ?></div>
                                    <div class="mb-2"><i class="fas fa-clock mr-1"></i> <b><?= $staff['jam'] ?> jam</b></div>
                                    <div class="mb-2"><i class="fas fa-calendar-check mr-1"></i> Kehadiran: <b><?= $staff['kehadiran'] ?>%</b></div>
                                    <div class="mb-2"><i class="fas fa-star text-warning mr-1"></i> Rating: <b><?= $staff['rating'] ?>/5.0</b></div>
                                  </div>
                                  <div class="card-footer text-center">
                                    <span class="badge badge-<?= $badgeClass[$staff['badge']] ?? 'success' ?>"><?= $staff['badge'] ?></span>
                                  </div>
                                </div>
                              </div>
                            <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row staff-card-modern" id="staffCards">
                        <?php foreach ($staffPerformance as $staff) { 
                            // Ambil inisial nama
                            $initial = strtoupper(substr($staff['nama'], 0, 1));
                            // Pilih warna avatar (acak dari array)
                            $avatarColors = ['#5459AC', '#17a2b8', '#ffc107', '#28a745', '#dc3545'];
                            $color = $avatarColors[crc32($staff['nama']) % count($avatarColors)];
                            // Badge status
                            $badgeMap = [
                                "success" => ["Sangat Baik" => "Sangat Baik", "Baik" => "Baik"],
                                "warning" => ["Cukup" => "Cukup"],
                                "danger" => ["Perlu Monitoring" => "Perlu Monitoring"]
                            ];
                            $badgeText = $staff['status'];
                            $badgeClass = $staff['badge'] == 'success' ? 'success' : ($staff['badge'] == 'warning' ? 'warning' : 'danger');
                        ?>
                        <div class="col-md-4 mb-4 staff-card"
                            data-nama="<?= strtolower($staff['nama']) ?>"
                            data-posisi="<?= strtolower($staff['posisi']) ?>"
                            data-status="<?= strtolower($staff['status']) ?>">
                            <div class="card shadow-sm h-100 position-relative" style="border-radius:18px;">
                                <!-- Badge Status di kanan atas -->
                                <span class="position-absolute" style="top:18px;right:18px;z-index:2;">
                                    <span class="badge badge-<?= $badgeClass ?>" style="font-size:1rem;padding:7px 16px;">
                                        <?= $badgeText ?>
                                    </span>
                                </span>
                                <div class="card-body pb-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <!-- Avatar Bulat Gradasi dengan Inisial Nama -->
                                        <div class="staff-avatar-gradient d-flex align-items-center justify-content-center">
                                            <?= $initial ?>
                                        </div>
                                        <div class="ml-3">
                                            <div style="font-weight:700;font-size:1.15rem;"><?= $staff['nama'] ?></div>
                                            <div class="text-muted" style="font-size:0.98rem;"><?= $staff['posisi'] ?></div>
                                        </div>
                                    </div>
                                    <!-- Jam Kerja -->
                                    <div class="mb-2" style="font-size:0.98rem;">
                                        <i class="fas fa-clock mr-1 text-secondary"></i>
                                        Jam Kerja: <b><?= $staff['jam_kerja'] ?> / <?= $staff['target_jam'] ?> Jam</b>
                                    </div>
                                    <div class="progress mb-2" style="height:9px;">
                                        <div class="progress-bar bg-success" data-width="<?= round(($staff['jam_kerja'] / $staff['target_jam']) * 100) ?>"></div>
                                    </div>
                                    <!-- Kehadiran -->
                                    <div class="mb-2" style="font-size:0.98rem;">
                                        <i class="fas fa-calendar-check mr-1 text-info"></i>
                                        Kehadiran: <b><?= $staff['kehadiran'] ?>%</b>
                                    </div>
                                    <div class="progress mb-2" style="height:9px;">
                                        <div class="progress-bar bg-info" data-width="<?= $staff['kehadiran'] ?>"></div>
                                    </div>
                                    <!-- Shift & Lembur -->
                                    <div class="mb-2" style="font-size:0.98rem;">
                                        <i class="fas fa-user-clock mr-1 text-warning"></i>
                                        Shift: <b><?= $staff['shift'] ?></b> &nbsp; | &nbsp; Lembur: <b><?= $staff['lembur'] ?></b>
                                    </div>
                                    <!-- Rating -->
                                    <div class="mb-2" style="font-size:0.98rem;">
                                        <i class="fas fa-star text-warning mr-1"></i>
                                        Rating: <span class="text-warning" style="font-size:1.1rem;"><?= $staff['rating_bintang'] ?></span> (<?= $staff['rating'] ?>)
                                    </div>
                                    <!-- Catatan -->
                                    <div class="mb-2 text-muted" style="font-size:0.97rem;">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <?= $staff['catatan'] ?>
                                    </div>
                                </div>
                                <!-- Footer badge status -->
                                <div class="card-footer text-center bg-white" style="border-radius:0 0 18px 18px;">
                                    <span class="badge badge-<?= $badgeClass ?>" style="font-size:1rem;padding:7px 16px;">
                                        Kinerja <?= $badgeText ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- PAGINATION BUTTONS FOR STAFF PERFORMANCE CARDS -->
                    <div class="staff-pagination mb-4">
                        <button class="btn" id="prevPage"><i class="fas fa-chevron-left mr-1"></i>Prev</button>
                        <button class="btn" id="nextPage">Next<i class="fas fa-chevron-right ml-1"></i></button>
                    </div>
                    </div>
                    <!-- Animasi progress bar tetap -->
                    <script>
                    $('.progress-bar').each(function () {
                        var $this = $(this);
                        var targetWidth = $this.data('width');
                        $this.css('width', '0%');
                        $this.animate({ width: targetWidth + '%' }, 1500);
                    });
                    </script>
                    <style>
                    .staff-card-modern .card {
                        border-radius: 18px;
                        box-shadow: 0 4px 18px rgba(84,89,172,0.10);
                        border: none;
                        transition: box-shadow 0.18s;
                        min-height: 340px;
                    }
                    .staff-card-modern .card:hover {
                        box-shadow: 0 8px 32px rgba(8,131,149,0.13);
                        transform: translateY(-2px) scale(1.01);
                    }
                    .staff-card-modern .badge-success {
                        background: #e6f7ec;
                        color: #1ca97a;
                        font-weight: 600;
                    }
                    .staff-card-modern .badge-warning {
                        background: #fffbe6;
                        color: #ffc107;
                        font-weight: 600;
                    }
                    .staff-card-modern .badge-danger {
                        background: #fdeaea;
                        color: #e74c3c;
                        font-weight: 600;
                    }
                    </style>

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
                        $('#pageInfo').text(`Halaman ${currentPage} dari ${totalPages}`);
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

                    <!-- 🟢 Row 3: Visualisasi Tenaga Kerja -->
                    <h5 class="mb-3 font-weight-bold text-secondary">Visualisasi Tenaga Kerja Berdasarkan Posisi</h5>
                    <div class="row">
                      <!-- Donut Chart Posisi Staff -->
                      <div class="col-md-6 mb-4">
                        <div class="card shadow demografi-card h-100">
                          <div class="card-body pb-2">
                            <h6 class="font-weight-bold text-primary">Distribusi Jumlah Staff per Posisi</h6>
                            <div class="chart-wrapper">
                              <canvas id="donutChart" class="demografi-chart-canvas"></canvas>
                            </div>
                            <div class="chart-caption">📌 Posisi <strong>Admin dan Suster</strong> mendominasi. Fokuskan pelatihan dan efisiensi kerja di posisi ini.</div>
                          </div>
                        </div>
                      </div>

                      <!-- Bar Chart Kehadiran -->
                      <div class="col-md-6 mb-4">
                        <div class="card shadow demografi-card h-100">
                          <div class="card-body pb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                              <h6 class="font-weight-bold text-primary mb-0">Rata-rata Kehadiran per Staff</h6>
                              <select id="posisiFilter" class="form-control form-control-sm w-auto">
                                <option value="all">Semua Posisi</option>
                                <option value="Admin">Admin</option>
                                <option value="Apoteker">Apoteker</option>
                                <option value="Kasir">Kasir</option>
                                <option value="Suster">Suster</option>
                                <option value="Cleaning Service">Cleaning Service</option>
                              </select>
                            </div>
                            <div class="chart-wrapper">
                              <canvas id="barChartStaff" class="demografi-chart-canvas"></canvas>
                            </div>
                            <div class="chart-caption">📉 Beberapa staff memiliki kehadiran <strong>di bawah 85%</strong>. Perlu evaluasi disiplin dan jadwal kerja.</div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                    const posisiLabels = ["Admin", "Apoteker", "Kasir", "Suster", "Cleaning Service"];
                    const posisiJumlah = [5, 2, 3, 4, 2];
                    const donutColors = [
                      'rgba(84,89,172,0.92)', 'rgba(111,195,208,0.92)', 'rgba(8,131,149,0.92)',
                      'rgba(111,195,208,0.65)', 'rgba(84,89,172,0.65)'
                    ];

                    new Chart(document.getElementById('donutChart'), {
                      type: 'doughnut',
                      data: {
                        labels: posisiLabels,
                        datasets: [{
                          data: posisiJumlah,
                          backgroundColor: donutColors,
                          borderColor: '#fff',
                          borderWidth: 3,
                          hoverOffset: 8
                        }]
                      },
                      options: {
                        cutout: '68%',
                        responsive: true,
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
                            backgroundColor: 'rgba(8,131,149,0.85)',
                            borderRadius: 12,
                            borderSkipped: false,
                            maxBarThickness: 38
                          }]
                        },
                        options: {
                          responsive: true,
                          plugins: {
                            legend: { display: false },
                            tooltip: {
                              backgroundColor: '#5459AC',
                              titleColor: '#fff',
                              bodyColor: '#fff',
                              borderColor: '#6fc3d0',
                              borderWidth: 1,
                              callbacks: {
                                label: (ctx) => `Kehadiran: ${ctx.raw}%`
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
                              max: 100,
                              grid: { color: 'rgba(8,131,149,0.08)' },
                              ticks: {
                                color: '#5459AC',
                                font: { weight: 'bold', family: 'Poppins' }
                              }
                            }
                          }
                        }
                      });
                    }
                    document.getElementById('posisiFilter').addEventListener('change', function () {
                      renderBarChart(this.value);
                    });
                    renderBarChart('all');
                    </script>


                    <!-- 🟠 Row 5: Insight Saran Cerdas -->
                    <h4 class="mb-4 font-weight-bold text-secondary">💡 Insight Saran Cerdas</h4>
                    <div class="mb-4">
                      <div class="insight-card shadow-sm">
                        <div class="d-flex align-items-center">
                          <div class="insight-icon mr-3">
                            <i class="fas fa-lightbulb"></i>
                          </div>
                          <div>
                            <h6 class="insight-title mb-2">Insight Otomatis</h6>
                            <p class="insight-desc mb-2">
                              📊 Berdasarkan data kehadiran dan beban kerja staff bulan ini, sistem menemukan beberapa anomali yang memerlukan perhatian manajerial.
                            </p>
                            <ul class="insight-list mb-0">
                              <li>📉 <strong>3 staff</strong> dengan kehadiran kurang dari <strong>85%</strong>.</li>
                              <li>⏱️ <strong>2 staff</strong> bekerja lebih dari <strong>180 jam</strong> dalam sebulan.</li>
                              <li>👥 Saran: <strong>Evaluasi beban kerja</strong> dan pertimbangkan <strong>perekrutan part-time</strong> untuk menghindari burnout.</li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>


                    <!-- ROW 6 – TABEL DETAIL STAFF (PAGINASI) -->
                    <h5 class="mt-5 font-weight-bold text-secondary">📋 Detail Data Staff</h5>
                    <div class="table-responsive">
                        <table id="staffTable" class="table table-striped table-bordered">
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
                    </div>


                  <!-- DataTables CSS & JS -->
                  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
                  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

                  <script>
                  $(document).ready(function () {
                      $('#staffTable').DataTable({
                          pageLength: 10,
                          lengthChange: false,
                          ordering: true,
                          language: {
                              search: "Cari:",
                              paginate: {
                                  previous: "Previous",
                                  next: "Next"
                              }
                          }
                      });
                  });
                  </script>

                    <!-- <h1 class="mt-4">Data Poli</h1>
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
                    </div> -->
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