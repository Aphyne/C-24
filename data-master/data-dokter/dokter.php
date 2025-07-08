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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
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
  position: static;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.15rem;
  color: #fff;
  box-shadow: 0 2px 8px rgba(8,131,149,0.10);
  margin-left: 8px;
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

/* --- MODERN DOKTER CARD --- */
.dokter-modern-card {
  border-radius: 18px;
  background: #fff;
  box-shadow: 0 4px 24px rgba(84,89,172,0.10);
  transition: box-shadow 0.2s, transform 0.2s;
  border: none;
  padding: 0;
  overflow: hidden;
  min-height: 230px;
  position: relative;
}
.dokter-modern-card:hover {
  box-shadow: 0 8px 32px rgba(8,131,149,0.13);
  transform: translateY(-2px) scale(1.02);
}
.dokter-modern-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
  color: #fff;
  font-weight: bold;
  font-size: 1.3rem;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 14px;
  box-shadow: 0 2px 8px rgba(8,131,149,0.10);
}
.dokter-modern-header {
  display: flex;
  align-items: center;
  padding: 18px 22px 8px 22px;
  border-bottom: 1px solid #f2f2f2;
  background: transparent;
}
.dokter-modern-title {
  font-size: 1.15rem;
  font-weight: 700;
  margin-bottom: 2px;
  color: #222;
}
.dokter-modern-sub {
  font-size: 0.98rem;
  color: #888;
  margin-bottom: 0;
}
.dokter-modern-status {
  position: absolute;
  top: 18px;
  right: 22px;
  font-size: 0.95rem;
  font-weight: 600;
  padding: 4px 12px;
  border-radius: 12px;
}
.dokter-modern-status.success { background: #e6f7ec; color: #1ca97a; }
.dokter-modern-status.warning { background: #fff6e0; color: #e6b800; }
.dokter-modern-status.primary { background: #eaf2ff; color: #5459ac; }
.dokter-modern-status.danger { background: #fdeaea; color: #e74c3c; }
.dokter-modern-body {
  padding: 14px 22px 10px 22px;
}
.dokter-modern-body p {
  margin-bottom: 8px;
  font-size: 1.01rem;
}
.dokter-modern-progress {
  height: 8px;
  border-radius: 8px;
  margin-bottom: 10px;
  background: #f2f2f2;
}
.dokter-modern-footer {
  padding: 10px 22px 16px 22px;
  border-top: 1px solid #f2f2f2;
  background: transparent;
  text-align: right;
}
.dokter-modern-badge {
  font-size: 0.98rem;
  font-weight: 600;
  border-radius: 8px;
  padding: 6px 16px;
}
.dokter-modern-badge.success { background: #e6f7ec; color: #1ca97a; }
.dokter-modern-badge.warning { background: #fff6e0; color: #e6b800; }
.dokter-modern-badge.primary { background: #eaf2ff; color: #5459ac; }
.dokter-modern-badge.danger { background: #fdeaea; color: #e74c3c; }
.dokter-modern-rating {
  font-size: 1.15rem;
  font-weight: 700;
  color: #f7b731;
  letter-spacing: 1px;
}
.dokter-modern-label {
  font-size: 0.93rem;
  color: #888;
  margin-right: 8px;
}
@media (max-width: 767px) {
  .dokter-modern-header, .dokter-modern-body, .dokter-modern-footer { padding: 12px 10px; }
  .dokter-modern-card { min-height: 180px; }
  .dokter-modern-avatar { width: 36px; height: 36px; font-size: 1rem; }
}
/* --- FILTER MODERN --- */
.dokter-filter-bar {
  background: #f7f9fc;
  border-radius: 14px;
  padding: 18px 22px;
  margin-bottom: 18px;
  box-shadow: 0 2px 12px rgba(84,89,172,0.06);
  display: flex;
  flex-wrap: wrap;
  align-items: center;
    justify-content: space-between; /* Biar rata kiri-kanan */
  gap: 12px;
  width: 100%;
}
.dokter-filter-bar input,
.dokter-filter-bar select {
  border-radius: 8px;
  border: 1px solid #e0e6ed;
  font-size: 1rem;
  padding: 7px 14px;
  min-width: 180px;
  margin-right: 8px;
  background: #fff;
  flex: 1 1 180px;
  max-width: 250px;
}
.dokter-filter-bar button {
  border-radius: 8px;
  font-weight: 600;
  font-size: 1rem;
  padding: 7px 18px;
  margin-right: 8px;
  white-space: nowrap;
}
.dokter-filter-bar .btn-outline-primary {
  border: 2px solid #5459ac;
  color: #5459ac;
  background: #fff;
  transition: background 0.2s, color 0.2s;
}
.dokter-filter-bar .btn-outline-primary:hover {
  background: #5459ac;
  color: #fff;
}
.dokter-filter-bar .btn-secondary {
  background: #e0e6ed;
  color: #222;
  border: none;
}
.dokter-filter-bar .btn-secondary:hover {
  background: #5459ac;
  color: #fff;
}
@media (max-width: 991px) {
  .dokter-filter-bar {
    flex-direction: column;
    align-items: stretch;
    gap: 10px;
  }
  .dokter-filter-bar input,
  .dokter-filter-bar select {
    max-width: 100%;
    margin-right: 0;
  }
  .dokter-filter-bar button {
    margin-right: 0;
    width: 100%;
  }
}
/* --- TOP 3 DOKTER MODAL --- */
.top-dokter-card {
  border-radius: 18px;
  background: #fff;
  box-shadow: 0 4px 24px rgba(84,89,172,0.10);
  border: none;
  overflow: hidden;
  min-height: 210px;
  position: relative;
  transition: box-shadow 0.2s, transform 0.2s;
}
.top-dokter-card .card-header {
  background: none;
  border-bottom: none;
  padding-bottom: 0;
}
.top-dokter-card .dokter-modern-status {
  margin-top: 4px;
  margin-bottom: 4px;
}
.top-dokter-card .card-body {
  padding: 18px 18px 10px 18px;
}
.top-dokter-card .card-footer {
  background: #f7f9fc;
  border-top: none;
  text-align: center;
  padding: 10px 0 14px 0;
}
.top-dokter-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
  color: #fff;
  font-weight: bold;
  font-size: 1.2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 10px auto;
  box-shadow: 0 2px 8px rgba(8,131,149,0.10);
}
.top-dokter-badge {
  font-size: 0.98rem;
  font-weight: 600;
  border-radius: 8px;
  padding: 6px 16px;
  background: #e6f7ec;
  color: #1ca97a;
}
@media (max-width: 767px) {
  .top-dokter-card .card-body { padding: 10px 6px 6px 6px; }
  .top-dokter-avatar { width: 32px; height: 32px; font-size: 1rem; }
}
/* --- PAGINATION BUTTONS --- */
.dokter-pagination-bar {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 18px;
  margin-top: 18px;
}
.dokter-pagination-bar .btn {
  border-radius: 8px;
  font-weight: 600;
  font-size: 1rem;
  padding: 7px 28px;
  background: #fff;
  color: #5459ac;
  border: 2px solid #5459ac;
  box-shadow: 0 2px 8px rgba(84,89,172,0.08);
  transition: background 0.2s, color 0.2s, box-shadow 0.2s;
  display: flex;
  align-items: center;
  gap: 6px;
}
.dokter-pagination-bar .btn:hover {
  background: #5459ac;
  color: #fff;
  box-shadow: 0 4px 16px rgba(84,89,172,0.13);
}
.dokter-pagination-bar .btn:disabled {
  background: #f2f2f2;
  color: #aaa;
  border: 2px solid #e0e6ed;
  cursor: not-allowed;
}

/* Tambahan efek glow untuk icon insight */
.summary-icon.bg-info {
  box-shadow: 0 0 12px 0 #6fc3d0a0;
  animation: glowLamp 1.8s infinite alternate;
}
@keyframes glowLamp {
  from { box-shadow: 0 0 8px #6fc3d0a0; }
  to   { box-shadow: 0 0 20px #6fc3d0cc; }
}

.table-master-dokter {
  border-radius: 16px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 4px 24px rgba(84,89,172,0.10);
}
.table-master-dokter thead th {
  background: #5459AC !important;
  color: #fff !important;
  font-weight: 700;
  font-size: 1.04rem;
  letter-spacing: 0.5px;
  border-bottom: none;
  vertical-align: middle;
}
.table-master-dokter tbody tr {
  background: #f7f9fc;
  transition: background 0.2s;
}
.table-master-dokter tbody tr:hover {
  background: #eaf2ff;
}
.table-master-dokter td, .table-master-dokter th {
  vertical-align: middle !important;
  border-color: #e0e6ed !important;
}
.table-master-dokter .badge-success {
  background: #e6f7ec;
  color: #1ca97a;
  font-weight: 600;
}
.table-master-dokter .badge-danger {
  background: #fdeaea;
  color: #e74c3c;
  font-weight: 600;
}
.table-master-dokter .btn {
  border-radius: 8px;
  font-size: 0.98rem;
  padding: 4px 10px;
}
.table-master-dokter .btn-primary { background: #6fc3d0; border: none; }
.table-master-dokter .btn-warning { background: #f7b731; border: none; color: #fff; }
.table-master-dokter .btn-danger { background: #e74c3c; border: none; }
.table-master-dokter .btn-primary:hover { background: #5459ac; }
.table-master-dokter .btn-warning:hover { background: #e6b800; }
.table-master-dokter .btn-danger:hover { background: #c0392b; }
.table-master-dokter th, .table-master-dokter td {
  padding-top: 12px !important;
  padding-bottom: 12px !important;
}
.table-master-dokter td.text-right {
  font-weight: 600;
  color:background:linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%)
}
.table-master-dokter td.text-center {
  font-weight: 500;
}
.card-header.bg-primary {
  background: #5459AC !important;
  color: #fff !important;
  border-radius: 18px 18px 0 0;
  min-height: 56px;
  display: flex;
  align-items: center;
}
.card-header.bg-primary h5 {
  font-size: 1.18rem;
  font-weight: 700;
  margin-bottom: 0;
}
    </style>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>
    <script src="../../assets/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/js/chart.min.js"></script>
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
                <div class="col-md-3 mb-3 d-flex">
                    <div class="summary-box shadow-sm w-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="summary-title mb-0">Total Dokter</div>
                            <div class="summary-icon bg-primary">
                                <i class="fas fa-user-md"></i>
                            </div>
                        </div>
                        <div class="summary-value counter" data-count="<?php echo $totalDokterAktif; ?>">0</div>
                        <span class="summary-badge badge-green"><?php echo $totalDokterAktif; ?> Orang</span>
                    </div>
                </div>
                <!-- Rata-rata Kehadiran -->
                <div class="col-md-3 mb-3 d-flex">
                    <div class="summary-box shadow-sm w-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="summary-title mb-0">Rata Rata Kehadiran (Bulan)</div>
                            <div class="summary-icon bg-info">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="summary-value counter" data-count="<?php echo $rataKehadiran; ?>">0</div>
                        <span class="summary-badge badge-green"><?php echo $rataKehadiran; ?>%</span>
                    </div>
                </div>
                <!-- Dokter Nonaktif -->
                <div class="col-md-3 mb-3 d-flex">
                    <div class="summary-box shadow-sm w-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="summary-title mb-0">Dokter Nonaktif</div>
                            <div class="summary-icon bg-danger">
                                <i class="fas fa-user-slash"></i>
                            </div>
                        </div>
                        <div class="summary-value counter" data-count="<?php echo $dokterNonaktif; ?>">0</div>
                        <span class="summary-badge badge-red"><?php echo $dokterNonaktif; ?> Orang</span>
                    </div>
                </div>
                <!-- Rata-rata Pasien per Dokter per Bulan -->
                <div class="col-md-3 mb-3 d-flex">
                    <div class="summary-box shadow-sm w-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="summary-title mb-0">Rata Pasien/Dokter (Bulan)</div>
                            <div class="summary-icon bg-success">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="summary-value counter" data-count="<?php echo round($rataPasienPerDokter); ?>">0</div>
                        <span class="summary-badge badge-green"><?php echo round($rataPasienPerDokter); ?> Pasien</span>
                    </div>
                </div>
            </div>
            <!-- End Summary Box -->


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
                <div class="dokter-filter-bar mb-3 w-100 d-flex align-items-center" style="gap:12px;">
    <input type="text" id="searchDokter" placeholder="Cari nama atau spesialis">
    <select id="filterKinerja">
        <option value="">Semua Kinerja</option>
        <option value="Sangat Baik">Sangat Baik</option>
        <option value="Top Performer">Top Performer</option>
        <option value="Perlu Monitoring">Perlu Monitoring</option>
    </select>
    <select id="filterSpesialis">
        <option value="">Semua Spesialis</option>
        <option value="Spesialis Umum">Spesialis Umum</option>
        <option value="Spesialis Anak">Spesialis Anak</option>
        <option value="Spesialis Gigi">Spesialis Gigi</option>
    </select>
    <button class="btn btn-secondary" id="resetDokterFilter"><i class="fas fa-undo mr-1"></i> Reset</button>
    <div class="flex-grow-1"></div>
    <button class="btn btn-outline-primary font-weight-bold" style="min-width:220px;" data-toggle="modal" data-target="#topDokterModal">
        <i class="fas fa-trophy mr-2"></i>Lihat Top 3 Dokter Terbaik
    </button>
</div>
            </div>
            
            </div>



            <!-- Modal - Top 3 Dokter -->
            <?php
// Tambahkan ini sebelum modal jika $topDokter belum ada
$topDokter = $dokterPerformance;
?>
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
        <div class="row">
          <?php foreach ($topDokter as $i => $dok) { 
            $initial = strtoupper(substr($dok['nama'], 4, 1));
            $statusClass = strtolower($dok['badge']);
          ?>
          <div class="col-md-4 mb-4">
            <div class="top-dokter-card shadow-sm" style="border:2px solid #f7b731;">
              <div class="card-header py-3">
                <div class="top-dokter-avatar mb-2 mx-auto"><?= $initial ?></div>
                <div class="text-center">
                  <div class="font-weight-bold" style="font-size:1.1rem; color:#222;"><?= $dok['nama'] ?></div>
                  <div class="text-muted mb-1" style="font-size:0.98rem;"><?= $dok['spesialis'] ?></div>
                  <span class="dokter-modern-status <?= $statusClass ?> d-inline-block my-1" style="position:static; font-size:0.95rem;"><?= $dok['kinerja'] ?></span>
                </div>
              </div>
              <div class="card-body px-3 py-2">
                <div class="mb-2">
                  <span class="dokter-modern-label"><i class="fas fa-clock mr-1"></i>Jam Praktik:</span>
                  <b><?= $dok['total_jam'] ?></b> / <?= $dok['target_jam'] ?> Jam
                </div>
                <div class="dokter-modern-progress mb-2">
                  <div class="progress-bar bg-<?= $dok['progress_color'] ?>" style="width:<?= round(($dok['total_jam']/$dok['target_jam'])*100) ?>%;height:8px;"></div>
                </div>
                <div class="mb-2">
                  <span class="dokter-modern-label"><i class="fas fa-calendar-check mr-1"></i>Kehadiran:</span>
                  <b><?= $dok['kehadiran'] ?>%</b>
                </div>
                <div class="dokter-modern-progress mb-2">
                  <div class="progress-bar bg-info" style="width:<?= $dok['kehadiran'] ?>%;height:8px;"></div>
                </div>
                <div class="mb-2">
                  <span class="dokter-modern-label"><i class="fas fa-chart-line mr-1"></i>Pertumbuhan Pasien:</span>
                  +<b><?= $dok['pertumbuhan_pasien'] ?>%</b>
                </div>
                <div class="dokter-modern-progress mb-2">
                  <div class="progress-bar bg-warning" style="width:<?= $dok['pertumbuhan_pasien'] ?>%;height:8px;"></div>
                </div>
                <div class="mb-2">
                  <span class="dokter-modern-label"><i class="fas fa-users mr-1"></i>Total Pasien:</span>
                  <b><?= $dok['total_pasien'] ?></b>
                </div>
                <div class="dokter-modern-progress mb-2">
                  <div class="progress-bar bg-primary" style="width:100%;height:8px;"></div>
                </div>
                <div class="mb-2">
                  <span class="dokter-modern-label"><i class="fas fa-star text-warning mr-1"></i>Rating:</span>
                  <span class="dokter-modern-rating"><?= $dok['rating_bintang'] ?></span>
                  <span class="text-muted">(<?= $dok['rating'] ?>)</span>
                </div>
              </div>
              <div class="card-footer text-center py-2">
                <span class="dokter-modern-badge <?= $statusClass ?>">Kinerja <?= $dok['kinerja'] ?></span>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END Modal Top 3 Dokter -->

            <div class="row" id="dokterCards">
<?php foreach ($dokterPerformance as $dokter) { 
    $initial = strtoupper(substr($dokter['nama'], 4, 1)); // Ambil inisial nama depan
    $statusClass = strtolower($dokter['badge']);
?>
    <div class="col-md-4 mb-4 dokter-card"
        data-nama="<?= strtolower($dokter['nama']) ?>"
        data-spesialis="<?= strtolower($dokter['spesialis']) ?>"
        data-kinerja="<?= strtolower($dokter['kinerja']) ?>">

        <div class="dokter-modern-card shadow-sm">
            <div class="dokter-modern-header">
                <div class="dokter-modern-avatar"><?= $initial ?></div>
                <div>
                    <div class="dokter-modern-title"><?= $dokter['nama'] ?></div>
                    <div class="dokter-modern-sub"><?= $dokter['spesialis'] ?></div>
                </div>
                <span class="dokter-modern-status <?= $statusClass ?> ml-auto"><?= $dokter['kinerja'] ?></span>
            </div>
            <div class="dokter-modern-body">
                <p>
                    <span class="dokter-modern-label"><i class="fas fa-clock mr-1"></i>Jam Praktik:</span>
                    <span class="counter" data-count="<?= $dokter['total_jam'] ?>">0</span> / <?= $dokter['target_jam'] ?> Jam
                </p>
                <div class="dokter-modern-progress mb-2">
                    <div class="progress-bar bg-<?= $dokter['progress_color'] ?>" data-width="<?= round(($dokter['total_jam'] / $dokter['target_jam']) * 100) ?>" style="height:8px;"></div>
                </div>
                <p>
                    <span class="dokter-modern-label"><i class="fas fa-calendar-check mr-1"></i>Kehadiran:</span>
                    <span class="counter" data-count="<?= $dokter['kehadiran'] ?>">0</span>%
                </p>
                <div class="dokter-modern-progress mb-2">
                    <div class="progress-bar bg-info" data-width="<?= $dokter['kehadiran'] ?>" style="height:8px;"></div>
                </div>
                <p>
                    <span class="dokter-modern-label"><i class="fas fa-chart-line mr-1"></i>Pertumbuhan Pasien:</span>
                    +<span class="counter" data-count="<?= $dokter['pertumbuhan_pasien'] ?>">0</span>%
                </p>
                <div class="dokter-modern-progress mb-2">
                    <div class="progress-bar bg-warning" data-width="<?= $dokter['pertumbuhan_pasien'] ?>" style="height:8px;"></div>
                </div>
                <p>
                    <span class="dokter-modern-label"><i class="fas fa-users mr-1"></i>Total Pasien:</span>
                    <span class="counter" data-count="<?= $dokter['total_pasien'] ?>">0</span>
                </p>
                <div class="dokter-modern-progress mb-2">
                    <div class="progress-bar bg-primary" data-width="100" style="height:8px;"></div>
                </div>
                <p>
                    <span class="dokter-modern-label"><i class="fas fa-star text-warning mr-1"></i>Rating:</span>
                    <span class="dokter-modern-rating"><?= $dokter['rating_bintang'] ?></span>
                    <span class="text-muted">(<?= $dokter['rating'] ?>)</span>
                </p>
            </div>
            <div class="dokter-modern-footer">
                <span class="dokter-modern-badge <?= $statusClass ?>">Kinerja <?= $dokter['kinerja'] ?></span>
            </div>
        </div>
    </div>
<?php } ?>
</div>
            <div class="dokter-pagination-bar">
  <button id="prevDokter" class="btn" type="button">
    <i class="fas fa-angle-left"></i> Previous
  </button>
  <button id="nextDokter" class="btn" type="button">
    Next <i class="fas fa-angle-right"></i>
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
    <div class="summary-box shadow-sm border-0 d-flex align-items-center" style="background: linear-gradient(90deg, #eaf2ff 60%, #f7f9fc 100%); min-height: 120px;">
      <div class="summary-icon bg-info mr-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
        <i class="fas fa-lightbulb fa-lg"></i>
      </div>
      <div class="flex-grow-1">
        <h6 class="text-info font-weight-bold mb-2" style="font-size:1.08rem;">Insight Otomatis</h6>
        <ul class="mb-0 pl-3" style="font-size:1.05rem; color:#333;">
          <?php foreach ($saranDokter as $item) { ?>
            <li><?= $item ?></li>
          <?php } ?>
        </ul>
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
        <div class="shadow-sm" style="border-radius:18px; background:#f7f9fc;">
            <!-- Header gradasi -->
            <div style="border-radius:18px 18px 0 0; background:linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%); padding:18px 24px; display:flex; align-items:center;">
                <i class="fas fa-calendar-alt fa-lg text-white mr-3"></i>
                <span class="font-weight-bold text-white" style="font-size:1.13rem; letter-spacing:0.5px;">Kalender Mini (Agenda Mingguan Dokter)</span>
            </div>
            <div style="padding:22px 24px 18px 24px; background:#f7f9fc; border-radius:0 0 18px 18px;">
                <ul class="pl-0 mb-0" style="list-style:none;">
                    <?php foreach ($jadwalPraktik as $jadwal): ?>
                        <li class="d-flex align-items-center mb-3" style="font-size:1.04rem;">
                            <span class="mr-3">
                                <?php
                                // Icon sesuai shift/badge
                                if ($jadwal['badge'] == 'success') echo '<i class="fas fa-user-md text-success"></i>';
                                elseif ($jadwal['badge'] == 'warning') echo '<i class="fas fa-user-clock text-warning"></i>';
                                elseif ($jadwal['badge'] == 'danger') echo '<i class="fas fa-user-times text-danger"></i>';
                                else echo '<i class="fas fa-user-md text-primary"></i>';
                                ?>
                            </span>
                            <span class="font-weight-bold text-primary"><?= $jadwal['hari'] ?></span>
                            <span class="mx-2 text-muted" style="font-size:0.97rem;">(<?= $jadwal['dokter'] ?>)</span>
                            <span class="ml-auto dokter-modern-badge <?= $jadwal['badge'] ?> px-3 py-2" style="font-size:0.98rem;">
                                <?= $jadwal['shift'] ?> <span class="text-muted" style="font-size:0.93rem;">(<?= $jadwal['jam'] ?>)</span>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Riwayat Ketidakhadiran -->
    <div class="col-md-6 mb-4">
        <div class="shadow-sm" style="border-radius:18px; background:#f7f9fc;">
            <!-- Header gradasi -->
            <div style="border-radius:18px 18px 0 0; background:linear-gradient(90deg, #e74c3c 70%, #fdeaea 100%); padding:18px 24px; display:flex; align-items:center;">
                <i class="fas fa-bell fa-lg text-white mr-3"></i>
                <span class="font-weight-bold text-white" style="font-size:1.13rem; letter-spacing:0.5px;">Insight & Notifikasi Ketidakhadiran</span>
            </div>
            <div style="padding:22px 24px 18px 24px; background:#f7f9fc; border-radius:0 0 18px 18px;">
                <ul class="pl-0 mb-0" style="list-style:none;">
                    <?php foreach ($riwayatKehadiran as $dokter => $data): ?>
                        <li class="d-flex align-items-center mb-3" style="font-size:1.04rem;">
                            <span class="mr-3"><i class="fas fa-user-md text-danger"></i></span>
                            <span class="font-weight-bold text-danger"><?= $dokter ?></span>
                            <span class="ml-auto">
                                <span class="badge badge-success mr-1" style="font-size:0.97rem;">Hadir: <?= $data['hadir'] ?></span>
                                <span class="badge badge-warning mr-1" style="font-size:0.97rem;">Izin: <?= $data['izin'] ?></span>
                                <span class="badge badge-danger" style="font-size:0.97rem;">Sakit: <?= $data['sakit'] ?></span>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

            <!-- End Jadwal & Ketidakhadiran Dokter -->
        </div>
    
            <!-- Tabel Master Data Dokter - Modern -->

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary">
        <i class="fas fa-user-md fa-lg mr-2"></i> 
        <h5 class="mb-0 font-weight-bold">Master Data Dokter</h5>
    </div>
    <div class="card-body" style="background:#f7f9fc; border-radius: 0 0 18px 18px;">
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover table-master-dokter mb-0" id="dataTable">
                <thead>
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
                                <a href="#" class="btn btn-sm btn-primary" title="Lihat"><i class="fas fa-eye"></i></a>
                                <a href="#" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php $nomor++; } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="dokter_tambah.php" class="btn-success btn px-3 font-weight-bold"><i class="fas fa-plus"></i> Tambah Data Dokter</a>
    </div>
</div>
<footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Clinic 24 - 2024</div>
                    </div>
                </div>
            </footer>
        </div>    
    </main>

<script src="../../assets/js/jquery-3.5.1.slim.min.js"></script>
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/scripts.js"></script>
<script src="../../assets/js/jquery.dataTables.min.js"></script>
<script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/demo/datatables-demo.js"></script>
</body>
</html>