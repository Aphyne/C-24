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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Tambahkan di dalam <head> sebelum </head> -->
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
  padding: 18px 16px 14px 16px; /* diperkecil dari sebelumnya */
  display: flex;
  flex-direction: column;
  min-height: 120px; /* diperkecil dari sebelumnya */
  position: relative;
  border: none;
  transition: box-shadow 0.2s;
}
.summary-box:hover {
  box-shadow: 0 8px 32px rgba(8,131,149,0.13);
}
.summary-box .summary-title {
  color: #088395;
  font-size: 1.08rem;
  font-weight: 700;
  margin-bottom: 10px;
  letter-spacing: 0.2px;
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
  top: 14px; /* lebih ke atas */
  right: 14px;
  width: 36px;   /* diperkecil dari 52px */
  height: 36px;  /* diperkecil dari 52px */
  border-radius: 10px;
  background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3rem; /* diperkecil dari 2.1rem */
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
  .summary-box .summary-icon { width: 26px; height: 26px; font-size: 0.95rem; top: 7px; right: 7px; }
}
/* --- END SUMMARY BOX MODERN --- */

/* TABEL PASIEN MODERN */
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
    margin-bottom: 8px !important;
    margin-top: -8px !important;
}
.dataTables_filter label {
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

/* --- END TABLE STYLES --- */

/* REVIEW CARD STYLE */
.review-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(84,89,172,0.08);
    padding: 22px 20px 18px 20px;
    transition: box-shadow 0.22s, transform 0.22s;
    border: none;
    min-height: 260px;
    position: relative;
    cursor: pointer;
}
.review-card:hover {
    box-shadow: 0 8px 32px rgba(8,131,149,0.16);
    transform: translateY(-4px) scale(1.025);
}
.review-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    font-weight: 700;
    font-size: 1.3rem;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(8,131,149,0.10);
}
.review-name {
    font-weight: 700;
    font-size: 1.1rem;
    color: #222;
    font-family: 'Poppins', Arial, sans-serif;
}
.review-badge {
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 8px;
    padding: 2px 10px;
    margin-top: 2px;
    display: inline-block;
}
.badge-active {
    background: #e6f7ec;
    color: #1ca97a;
}
.badge-pending {
    background: #fdeaea;
    color: #e74c3c;
}
.review-meta {
    font-size: 0.95rem;
    color: #888;
    font-family: 'Poppins', Arial, sans-serif;
}
.review-rating .review-star {
    font-size: 1.15rem;
    font-weight: 700;
    color: #f7b731;
    letter-spacing: 1px;
}
.review-text {
    font-size: 1rem;
    color: #333;
    font-family: 'Poppins', Arial, sans-serif;
    min-height: 48px;
}

/* MINI CARD FOR MODAL */
.review-mini-card {
    background: #f8f9fa;
    border-radius: 14px;
    border-left: 6px solid #5459AC;
    box-shadow: 0 2px 10px rgba(84,89,172,0.07);
    padding: 12px 14px 10px 14px;
    margin-bottom: 10px;
    transition: box-shadow 0.18s, transform 0.18s;
}
.review-mini-card.border-left-success { border-left: 6px solid #1ca97a; }
.review-mini-card.border-left-danger { border-left: 6px solid #e74c3c; }
.review-mini-card:hover {
    box-shadow: 0 6px 18px rgba(8,131,149,0.13);
    transform: translateY(-2px) scale(1.01);
}
.review-avatar-sm {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    font-weight: 700;
    font-size: 1rem;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
}
.review-star-sm {
    font-size: 1rem;
    color: #f7b731;
    font-weight: 700;
    margin-bottom: 2px;
}
.review-modal .modal-header.bg-gradient-primary {
    background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%) !important;
    color: #fff;
    border-top-left-radius: 0.3rem;
    border-top-right-radius: 0.3rem;
}
.review-modal .modal-content {
    border-radius: 18px;
    border: none;
}
.review-modal .modal-header {
    border-bottom: none;
}
.review-modal .modal-title {
    font-family: 'Poppins', Arial, sans-serif;
    font-weight: 700;
    font-size: 1.15rem;
}
.review-modal .close {
    opacity: 1;
    font-size: 1.5rem;
}
@media (max-width: 767px) {
    .review-card { padding: 12px 7px 10px 7px; min-height: 180px; }
    .review-avatar { width: 36px; height: 36px; font-size: 1rem; }
    .review-name { font-size: 1rem; }
    .review-text { font-size: 0.95rem; }
    .review-mini-card { padding: 8px 7px 7px 7px; }
    .review-avatar-sm { width: 28px; height: 28px; font-size: 0.85rem; }
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


/* BUTTON GRADIENT PRIMARY */
.btn-gradient-primary {
    background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%);
    color: #fff !important;
    border: none;
    border-radius: 8px;
    transition: background 0.18s, box-shadow 0.18s, transform 0.18s;
}
.btn-gradient-primary:hover, .btn-gradient-primary:focus {
    background: linear-gradient(90deg, #6fc3d0 0%, #5459AC 100%);
    color: #fff !important;
    transform: translateY(-2px) scale(1.04);
    box-shadow: 0 8px 32px rgba(8,131,149,0.13) !important;
}

/* BUTTON OUTLINE GRADIENT */
.btn-gradient-outline {
    background: #fff;
    color: #5459AC !important;
    border: 2px solid #6fc3d0;
    border-radius: 8px;
    transition: background 0.18s, color 0.18s, box-shadow 0.18s, transform 0.18s;
}
.btn-gradient-outline:hover, .btn-gradient-outline:focus {
    background: linear-gradient(90deg, #6fc3d0 0%, #5459AC 100%);
    color: #fff !important;
    border-color: #5459AC;
    transform: translateY(-2px) scale(1.04);
    box-shadow: 0 8px 32px rgba(8,131,149,0.13) !important;
}

/* Untuk konsistensi card lain */
.card {
    border-radius: 18px !important;
    border: none !important;
    box-shadow: 0 4px 24px rgba(8,131,149,0.08) !important;
}
.card-header {
    background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%) !important;
    color: #fff !important;
    font-weight: 700;
    border-top-left-radius: 18px !important;
    border-top-right-radius: 18px !important;
    border: none !important;
    font-family: 'Poppins', Arial, sans-serif;
    font-size: 1.1rem;
}
.card-footer {
    background: #f8f9fa !important;
    border-bottom-left-radius: 18px !important;
    border-bottom-right-radius: 18px !important;
    border: none !important;
}
@media (max-width: 767px) {
    .card.shadow, .card.shadow-custom { border-radius: 12px !important; }
    .card-header { font-size: 1rem; }
}

/* Card chart lebih kecil dan sejajar */
.card.demografi-card {
    min-height: 340px;
    max-height: 360px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.card.demografi-card .card-body {
    padding: 18px 14px 10px 14px;
}
.demografi-chart-canvas {
    max-height: 210px !important;
    height: 210px !important;
}
@media (max-width: 991px) {
    .card.demografi-card { min-height: 260px; max-height: 280px; }
    .demografi-chart-canvas { max-height: 150px !important; height: 150px !important; }
}

h5.mt-5.font-weight-bold.text-secondary {
    margin-top: 1.5rem !important;
    margin-bottom: 0.7rem !important;
    font-size: 1.18rem;
    padding-bottom: 0;
}

/* Padding atas main agar tidak menempel headbar */
#layoutSidenav_content main > .container-fluid,
#layoutSidenav_content main > .container {
    padding-top: 1.5rem;
}
@media (max-width: 767px) {
    #layoutSidenav_content main > .container-fluid,
    #layoutSidenav_content main > .container {
        padding-top: 1rem;
    }
}
</style>
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
                    $ratingKurang = 10;
                    ?>
                    <!-- 🔵 Row 1: Ringkasan -->
                    <h4 class="mb-4 font-weight-bold text-secondary">Ringkasan Data Pasien</h4>
                    <div class="row">
                        <!-- Total Pasien -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Total Pasien</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $totalPasien ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-users"></i></div>
                                <span class="summary-badge badge-green">+<?= $kenaikanPasienBulanIni ?> new this month</span>
                            </div>
                        </div>
                        <!-- Pasien Baru -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Pasien Baru</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $pasienBaru ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-user-plus"></i></div>
                                <span class="summary-badge badge-green">+<?= $pasienBaru ?> this month</span>
                            </div>
                        </div>
                        <!-- Pasien Kembali -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Pasien Kembali</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $pasienKembali ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-redo"></i></div>
                                <span class="summary-badge badge-green">Stable</span>
                            </div>
                        </div>
                        <!-- Rata Rating -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Rating Rata-rata</div>
                                <div class="summary-value">
                                    <span class="counter" data-count="<?= $rataRating ?>">0</span>
                                    <span style="font-size:1.3rem;color:#f7b731;vertical-align:middle;">★</span>
                                </div>
                                <div class="summary-icon"><i class="fas fa-star"></i></div>
                                <span class="summary-badge badge-red"><?= $ratingKurang ?> rating &lt; 3</span>
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
                    $pasienBaruTurun = false; // Jika true, kampanye pemasaran bisa dievaluasi
                    $rasioPasienPria = 35; // dalam persen
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
                                        📈 Pasien meningkat sebesar <strong><?= $kenaikanPasienBulanIni ?>%</strong> dibanding bulan lalu.
                                        Pertumbuhan didominasi oleh <strong>pasien baru (<?= $pasienBaru ?> orang)</strong>. Pertimbangkan
                                        penambahan <em>kapasitas layanan</em> & jadwal dokter tambahan di akhir pekan.
                                    </p>
                                    <ul class="insight-list mb-0">
                                        <?php if ($pasienBaruTurun): ?>
                                        <li>📉 Jumlah pasien baru menurun 20% dari bulan lalu, evaluasi efektivitas <strong>kampanye pemasaran</strong>.</li>
                                        <?php endif; ?>
                                        <?php if ($ratingKurang > 0): ?>
                                        <li>⭐ <strong><?= $ratingKurang ?> pasien</strong> memberi rating &lt; 3 bintang, perlu evaluasi <strong>pengalaman layanan & kecepatan</strong>.</li>
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

<style>
/* INSIGHT CARD MODERN */
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
</style>


                    <!-- 🟣 Row 3: Top Ulasan -->
                    <h5 class="mb-3 font-weight-bold text-secondary d-flex justify-content-between align-items-center">
                        Ulasan & Kepuasan Pasien
                        <button class="btn btn-gradient-primary btn-sm px-3 font-weight-bold shadow-custom" data-toggle="modal" data-target="#topReviewModal">
                            <i class="fas fa-comments mr-1"></i> Lihat Top 5 Ulasan
                        </button>
                    </h5>

                    <div class="row" id="ulasanContainer">
                    <?php foreach (array_slice($dataPasien, 0, 3) as $ulasan) { ?>
                        <div class="col-md-4 mb-3">
                            <div class="review-card shadow-sm">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="review-avatar" style="background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);">
                                        <?= strtoupper(substr($ulasan['nama'],0,2)) ?>
                                    </div>
                                    <div class="ml-3">
                                        <div class="review-name"><?= $ulasan['nama'] ?></div>
                                        <div class="review-badge <?= $ulasan['rating'] >= 4 ? 'badge-active' : 'badge-pending' ?>">
                                            <?= $ulasan['rating'] >= 4 ? 'Active' : 'Pending' ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="review-meta mb-2">
                                    <span><i class="fas fa-calendar-alt mr-1"></i><?= $ulasan['tanggal'] ?></span>
                                    <span class="mx-2">|</span>
                                    <span><i class="fas fa-user-check mr-1"></i><?= $ulasan['kunjungan'] ?></span>
                                </div>
                                <div class="review-rating mb-2">
                                    <span class="review-star"><?= number_format($ulasan['rating'],1) ?> ★</span>
                                </div>
                                <div class="review-text mb-2">
                                    "<?= $ulasan['ulasan'] ?>"
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                    <!-- Pagination Control for Ulasan -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <button id="prevUlasan" class="btn btn-gradient-outline btn-sm px-3 font-weight-bold shadow-custom">
                            <i class="fas fa-angle-left mr-1"></i> Previous
                        </button>
                        <button id="nextUlasan" class="btn btn-gradient-outline btn-sm px-3 font-weight-bold shadow-custom">
                            Next <i class="fas fa-angle-right ml-1"></i>
                        </button>
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
                        <div class="modal-content review-modal">
                            <div class="modal-header bg-gradient-primary text-white">
                                <h5 class="modal-title" id="topReviewModalLabel"><i class="fas fa-comments mr-2"></i>Top 5 Ulasan Positif & Negatif</h5>
                                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <!-- POSITIF -->
                                <div class="col-md-6">
                                    <h6 class="text-success mb-3"><i class="fas fa-smile mr-1"></i>Ulasan Positif</h6>
                                    <?php foreach ($ulasanPositif as $u) { ?>
                                    <div class="review-mini-card border-left-success mb-3">
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="review-avatar-sm bg-success text-white"><?= strtoupper(substr($u['nama'],0,2)) ?></div>
                                            <div class="ml-2">
                                                <span class="font-weight-bold"><?= $u['nama'] ?></span>
                                                <span class="badge badge-success ml-2">Positif</span>
                                            </div>
                                        </div>
                                        <div class="small text-muted mb-1"><?= $u['tanggal'] ?> | <?= $u['kunjungan'] ?></div>
                                        <div class="review-star-sm"><?= number_format($u['rating'],1) ?> ★</div>
                                        <div class="small">"<?= $u['ulasan'] ?>"</div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <!-- NEGATIF -->
                                <div class="col-md-6">
                                    <h6 class="text-danger mb-3"><i class="fas fa-frown mr-1"></i>Ulasan Negatif</h6>
                                    <?php foreach ($ulasanNegatif as $u) { ?>
                                    <div class="review-mini-card border-left-danger mb-3">
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="review-avatar-sm bg-danger text-white"><?= strtoupper(substr($u['nama'],0,2)) ?></div>
                                            <div class="ml-2">
                                                <span class="font-weight-bold"><?= $u['nama'] ?></span>
                                                <span class="badge badge-danger ml-2">Negatif</span>
                                            </div>
                                        </div>
                                        <div class="small text-muted mb-1"><?= $u['tanggal'] ?> | <?= $u['kunjungan'] ?></div>
                                        <div class="review-star-sm"><?= number_format($u['rating'],1) ?> ★</div>
                                        <div class="small">"<?= $u['ulasan'] ?>"</div>
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
                        <div class="card shadow demografi-card h-100">
                            <div class="card-body">
                                <h6 class="font-weight-bold text-primary">Distribusi Usia Pasien</h6>
                                <canvas id="usiaChart" class="demografi-chart-canvas"></canvas>
                                <div class="mt-2 small text-muted">📌 Kelompok usia <strong>25-45</strong> mendominasi, fokuskan layanan konsultasi umum dan promosi kesehatan kerja.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Gender -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow demografi-card h-100">
                            <div class="card-body">
                                <h6 class="font-weight-bold text-primary">Distribusi Gender Pasien</h6>
                                <canvas id="genderChart" class="demografi-chart-canvas"></canvas>
                                <div class="mt-2 small text-muted">💡 Pasien perempuan sedikit lebih banyak. Pertimbangkan edukasi kesehatan wanita dan layanan prenatal.</div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                    // Distribusi Usia (Bar Chart)
                    const usiaChart = new Chart(document.getElementById('usiaChart'), {
                        type: 'bar',
                        data: {
                            labels: <?= json_encode(array_keys($usiaGroups)) ?>,
                            datasets: [{
                                label: 'Jumlah Pasien',
                                data: <?= json_encode(array_values($usiaGroups)) ?>,
                                backgroundColor: [
                                    'rgba(111,195,208,0.85)',
                                    'rgba(84,89,172,0.85)',
                                    'rgba(8,131,149,0.85)',
                                    'rgba(111,195,208,0.65)',
                                    'rgba(84,89,172,0.65)'
                                ],
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
                                    enabled: true,
                                    backgroundColor: '#5459AC',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    borderColor: '#6fc3d0',
                                    borderWidth: 1
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

                    // Distribusi Gender (Pie/Doughnut Chart)
                    const genderChart = new Chart(document.getElementById('genderChart'), {
                        type: 'doughnut',
                        data: {
                            labels: <?= json_encode(array_keys($genderDist)) ?>,
                            datasets: [{
                                label: 'Gender',
                                data: <?= json_encode(array_values($genderDist)) ?>,
                                backgroundColor: [
                                    'rgba(84,89,172,0.92)',
                                    'rgba(111,195,208,0.92)',
                                    'rgba(8,131,149,0.92)'
                                ],
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
                                    enabled: true,
                                    backgroundColor: '#5459AC',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    borderColor: '#6fc3d0',
                                    borderWidth: 1
                                }
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
                previous: "Previous",
                next: "Next"
            }
        }
    });
                    });
                    </script>

                    <!-- <div class="card mb-4">
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
                        </div> -->
                        <div class="card-footer">
                            <a href="pasien_tambah.php" class="btn-success btn px-3 font-weight-bold"><i class="fas fa-plus "></i> Tambah Data Pasien</a>
                        </div>
                        <footer class="py-3 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Clinic 24 - 2024</div>
                    </div>
                    </div>
                </div>
            </footer>
                </div>
            </main>
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