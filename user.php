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
    <title>Apothecary | Data User</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="assets/js/all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
/* --- NAVBAR ATAS (HEADBAR) --- */
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

/* --- SIDEBAR --- */
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

/* --- STYLING UTAMA --- */
body {
  font-family: 'Poppins', sans-serif;
  background: #fff !important;
}

.card {
  border: none !important;
  box-shadow: 0 4px 24px rgba(8,131,149,0.08) !important;
  border-radius: 15px !important;
}

.card-header {
  background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%) !important;
  color: #fff !important;
  font-weight: 700 !important;
  border-radius: 15px 15px 0 0 !important;
  border: none !important;
}

.card-footer {
  background: #f8f9fa !important;
  border-radius: 0 0 15px 15px !important;
  border: none !important;
}

/* --- TABLE STYLING --- */
.table {
  font-family: 'Poppins', sans-serif;
  border-radius: 15px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 4px 24px rgba(8,131,149,0.08);
  border: none;
}

.table thead th {
  background: linear-gradient(135deg, #5459AC 0%, #6fc3d0 100%) !important;
  color: #fff !important;
  font-weight: 600 !important;
  border: none !important;
  text-align: center !important;
  font-size: 0.9rem !important;
  letter-spacing: 0.5px !important;
  padding: 18px 12px !important;
  text-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
  position: relative;
}

.table thead th:first-child {
  border-radius: 15px 0 0 0;
}

.table thead th:last-child {
  border-radius: 0 15px 0 0;
}

.table tbody td {
  vertical-align: middle !important;
  border: none !important;
  color: #222 !important;
  text-align: center !important;
  padding: 15px 12px !important;
  font-size: 0.9rem !important;
  border-bottom: 1px solid rgba(111,195,208,0.1) !important;
  transition: all 0.2s ease !important;
}

.table tbody tr {
  transition: all 0.2s ease !important;
}

.table tbody tr:hover {
  background: linear-gradient(135deg, rgba(111,195,208,0.08) 0%, rgba(84,89,172,0.05) 100%) !important;
  transform: translateY(-1px) !important;
  box-shadow: 0 2px 8px rgba(8,131,149,0.08) !important;
}

.table tbody tr:last-child td:first-child {
  border-radius: 0 0 0 15px;
}

.table tbody tr:last-child td:last-child {
  border-radius: 0 0 15px 0;
}

/* Username styling */
.username-cell {
  font-weight: 600 !important;
  color: #5459AC !important;
  position: relative;
}

.username-cell::before {
  content: '';
  position: absolute;
  left: -8px;
  top: 50%;
  transform: translateY(-50%);
  width: 3px;
  height: 20px;
  background: linear-gradient(135deg, #5459AC 0%, #6fc3d0 100%);
  border-radius: 2px;
  opacity: 0;
  transition: opacity 0.2s ease;
}

.table tbody tr:hover .username-cell::before {
  opacity: 1;
}

/* Password cell styling */
.password-cell {
  background: rgba(108,117,125,0.05) !important;
  border-radius: 8px !important;
  margin: 0 8px !important;
  padding: 8px 12px !important;
  font-family: monospace !important;
  border: 1px solid rgba(108,117,125,0.1) !important;
}

/* Enhanced Badge Styling */
.role-badge {
  font-family: 'Poppins', sans-serif !important;
  font-weight: 600 !important;
  font-size: 0.75rem !important;
  padding: 8px 16px !important;
  border-radius: 20px !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
  border: 2px solid rgba(255,255,255,0.2) !important;
  transition: all 0.2s ease !important;
}

.role-badge:hover {
  transform: translateY(-1px) scale(1.05) !important;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

.status-badge {
  font-family: 'Poppins', sans-serif !important;
  font-weight: 500 !important;
  font-size: 0.75rem !important;
  padding: 6px 12px !important;
  border-radius: 15px !important;
  background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
  color: #fff !important;
  border: none !important;
  box-shadow: 0 2px 6px rgba(40,167,69,0.2) !important;
  transition: all 0.2s ease !important;
}

.status-badge:hover {
  transform: translateY(-1px) !important;
  box-shadow: 0 4px 10px rgba(40,167,69,0.3) !important;
}

/* Action Buttons Enhanced */
.btn-action-group {
  display: flex !important;
  gap: 6px !important;
  justify-content: center !important;
  align-items: center !important;
}

.btn-action {
  width: 36px !important;
  height: 36px !important;
  border-radius: 8px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  font-size: 0.85rem !important;
  transition: all 0.2s ease !important;
  border: none !important;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1) !important;
}

.btn-action:hover {
  transform: translateY(-2px) scale(1.1) !important;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;
}

.btn-info.btn-action {
  background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%) !important;
  color: #fff !important;
}

.btn-danger.btn-action {
  background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%) !important;
  color: #fff !important;
}

/* Table Container Enhancement */
.table-container {
  border-radius: 15px !important;
  overflow: hidden !important;
  box-shadow: 0 6px 30px rgba(8,131,149,0.1) !important;
  background: #fff !important;
  border: 1px solid rgba(111,195,208,0.1) !important;
}

/* Row Number Styling */
.row-number {
  background: linear-gradient(135deg, rgba(84,89,172,0.1) 0%, rgba(111,195,208,0.1) 100%) !important;
  color: #5459AC !important;
  font-weight: 700 !important;
  border-radius: 50% !important;
  width: 28px !important;
  height: 28px !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  margin: 0 auto !important;
  font-size: 0.8rem !important;
  border: 2px solid rgba(84,89,172,0.2) !important;
}

/* --- BUTTONS --- */
.btn {
  border-radius: 8px !important;
  font-weight: 600 !important;
  font-family: 'Poppins', sans-serif !important;
  transition: all 0.18s ease !important;
}

.btn-success {
  background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
  border: none !important;
  box-shadow: 0 2px 8px rgba(40,167,69,0.15) !important;
}

.btn-success:hover {
  transform: translateY(-2px) scale(1.02) !important;
  box-shadow: 0 4px 16px rgba(40,167,69,0.25) !important;
}

.btn-danger {
  background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%) !important;
  border: none !important;
  box-shadow: 0 2px 8px rgba(220,53,69,0.15) !important;
}

.btn-danger:hover {
  transform: translateY(-2px) scale(1.02) !important;
  box-shadow: 0 4px 16px rgba(220,53,69,0.25) !important;
}

/* --- BADGE STYLING --- */
.badge {
  font-family: 'Poppins', sans-serif !important;
  font-weight: 600 !important;
  font-size: 0.8rem !important;
  padding: 6px 12px !important;
  border-radius: 8px !important;
}

.badge-admin {
  background: linear-gradient(135deg, #5459AC 0%, #6fc3d0 100%) !important;
  color: #fff !important;
}

.badge-pendaftaran {
  background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
  color: #fff !important;
}

.badge-pemeriksaan {
  background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%) !important;
  color: #fff !important;
}

.badge-pembayaran {
  background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
  color: #fff !important;
}

/* --- SUMMARY BOX STYLING (KONSISTEN DENGAN INDEX.PHP) --- */
.summary-box {
  background-color: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(8,131,149,0.12);
  padding: 25px;
  margin-bottom: 25px;
  transition: box-shadow 0.3s, transform 0.3s;
  height: 180px;
  color: #222;
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border: 1px solid rgba(8,131,149,0.08);
}

.summary-box:hover {
  box-shadow: 0 8px 32px rgba(8,131,149,0.25);
  transform: translateY(-4px) scale(1.03);
}

.summary-title {
  font-weight: bold;
  font-size: 14px;
  color: #088395;
}

.summary-value {
  font-size: 28px;
  font-weight: bold;
  margin-top: 5px;
  color: #222;
  display: flex;
  align-items: center;
  gap: 10px;
}

.summary-change {
  font-size: 13px;
  border-radius: 8px;
  padding: 4px 10px;
  margin-top: 10px;
  font-weight: 500;
  display: inline-block;
  min-width: unset;
  width: auto;
  max-width: 100%;
  text-align: left;
  box-shadow: 0 1px 4px rgba(8,131,149,0.08);
  color: #5459AC !important;
  vertical-align: top;
  background: transparent;
}

.custom-bg-success {
  background: rgba(40, 167, 69, 0.18) !important;
}

.custom-bg-info {
  background: rgba(23, 162, 184, 0.18) !important;
}

.custom-bg-warning {
  background: rgba(255, 193, 7, 0.18) !important;
}

.summary-icon {
  font-size: 24px;
  background: linear-gradient(135deg,rgb(111, 195, 208) 0%, #5459AC 100%);
  color: #fff;
  border-radius: 10px;
  padding: 10px 14px;
  margin-left: auto;
  margin-right: 0;
  box-shadow: 0 2px 8px rgba(8,131,149,0.15);
  transition: background 0.3s, color 0.3s, transform 0.3s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.summary-box:hover .summary-icon {
  background: linear-gradient(135deg, #5459AC 0%, #088395 100%);
  color: #fff;
  transform: scale(1.15) rotate(-6deg);
}

/* --- BREADCRUMB --- */
.breadcrumb {
  background: transparent !important;
  font-family: 'Poppins', sans-serif !important;
  font-weight: 500 !important;
}

.breadcrumb-item a {
  color: #5459AC !important;
  text-decoration: none !important;
}

.breadcrumb-item.active {
  color: #6c757d !important;
}

/* --- HEADER TITLE --- */
h1 {
  color: #5459AC !important;
  font-family: 'Poppins', sans-serif !important;
  font-weight: 700 !important;
}

/* --- DATATABLES STYLING --- */
.dataTables_wrapper .dataTables_filter input {
  background: #fff !important;
  color: #5459AC !important;
  border: 2px solid #6fc3d0 !important;
  border-radius: 8px !important;
  padding: 8px 16px !important;
  font-weight: 500 !important;
  font-family: 'Poppins', sans-serif !important;
}

.dataTables_wrapper .dataTables_filter input:focus {
  border-color: #5459AC !important;
  outline: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
  background: #fff !important;
  color: #5459AC !important;
  border: 2px solid #6fc3d0 !important;
  border-radius: 8px !important;
  font-weight: 600 !important;
  font-family: 'Poppins', sans-serif !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: linear-gradient(90deg, #6fc3d0 0%, #5459AC 100%) !important;
  color: #fff !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: linear-gradient(90deg, #6fc3d0 0%, #5459AC 100%) !important;
  color: #fff !important;
}
</style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="index.php">Apothecary</a>
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
                        <div class="sb-sidenav-menu-heading">Apothecary</div>
                        <a class="nav-link" href="index.php">
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
                                    <a class="nav-link" href="data-master/data-pasien/pasien.php">
                                        <i class="fas fa-user-injured sb-nav-link-icon"></i> Data Pasien
                                    </a>
                                    <a class="nav-link" href="data-master/data-dokter/dokter.php">
                                        <i class="fas fa-user-md sb-nav-link-icon"></i> Data Dokter
                                    </a>
                                    <a class="nav-link" href="data-master/data-obat/obat.php">
                                        <i class="fas fa-capsules sb-nav-link-icon"></i> Data Obat
                                    </a>
                                    <a class="nav-link" href="data-master/data-staff/staff.php">
                                        <i class="fas fa-users-cog sb-nav-link-icon"></i> Data Staff
                                    </a>
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
                            <a class="nav-link active" href="user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Data User
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" class="bg-white text-dark">
            <main style="padding: 15px;">
                <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 15px;">
                    <h1 class="mt-4 mb-2">Data User Management</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data User</li>
                    </ol>
                    
                    <?php
                    // Get additional statistics
                    $totalUsers = $koneksi->query("SELECT COUNT(*) as total FROM tb_user")->fetch_assoc()['total'];
                    $adminCount = $koneksi->query("SELECT COUNT(*) as total FROM tb_user WHERE jabatan = 'admin'")->fetch_assoc()['total'];
                    $pendaftaranCount = $koneksi->query("SELECT COUNT(*) as total FROM tb_user WHERE jabatan = 'pendaftaran'")->fetch_assoc()['total'];
                    $pemeriksaanCount = $koneksi->query("SELECT COUNT(*) as total FROM tb_user WHERE jabatan = 'pemeriksaan'")->fetch_assoc()['total'];
                    $pembayaranCount = $koneksi->query("SELECT COUNT(*) as total FROM tb_user WHERE jabatan = 'pembayaran'")->fetch_assoc()['total'];
                    ?>
                    
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="summary-box">
                                <div class="summary-title">Total Users</div>
                                <div class="summary-value">
                                    <span class="counter" data-count="<?php echo $totalUsers; ?>"><?php echo $totalUsers; ?></span>
                                    <span class="summary-icon"><i class="fas fa-users"></i></span>
                                </div>
                                <div class="summary-change custom-bg-success">System Users Active</div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="summary-box">
                                <div class="summary-title">Admin Users</div>
                                <div class="summary-value">
                                    <span class="counter" data-count="<?php echo $adminCount; ?>"><?php echo $adminCount; ?></span>
                                    <span class="summary-icon"><i class="fas fa-user-shield"></i></span>
                                </div>
                                <div class="summary-change custom-bg-info">Full Access Level</div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="summary-box">
                                <div class="summary-title">Staff Operasional</div>
                                <div class="summary-value">
                                    <span class="counter" data-count="<?php echo ($pendaftaranCount + $pemeriksaanCount + $pembayaranCount); ?>"><?php echo ($pendaftaranCount + $pemeriksaanCount + $pembayaranCount); ?></span>
                                    <span class="summary-icon"><i class="fas fa-user-cog"></i></span>
                                </div>
                                <div class="summary-change custom-bg-success">Operational Staff</div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="summary-box">
                                <div class="summary-title">Active Roles</div>
                                <div class="summary-value">
                                    <span class="counter" data-count="4">4</span>
                                    <span class="summary-icon"><i class="fas fa-key"></i></span>
                                </div>
                                <div class="summary-change custom-bg-warning">Different Access Levels</div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-table mr-2"></i>
                                    <strong>Tabel Data User System</strong>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="user_tambah.php" class="btn btn-success btn-sm px-3 py-2 mr-2">
                                        <i class="fas fa-plus mr-2"></i>Tambah User
                                    </a>
                                    <span class="badge badge-info px-3 py-2">Total: <?php echo $totalUsers; ?> Users</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-container">
                                <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px;">No</th>
                                            <th style="min-width: 140px;">Username</th>
                                            <th style="min-width: 120px;">Password</th>
                                            <th style="width: 140px;">Role/Jabatan</th>
                                            <th style="width: 160px;">Status Akses</th>
                                            <th style="width: 120px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $nomor = 1; 
                                        $ambil = $koneksi->query("SELECT * FROM tb_user ORDER BY jabatan, username"); 
                                        while ($pecah = $ambil->fetch_assoc()) { 
                                            // Determine badge style for different roles
                                            $badgeClass = '';
                                            $statusText = '';
                                            switch(strtolower($pecah['jabatan'])) {
                                                case 'admin':
                                                    $badgeClass = 'badge-admin';
                                                    $statusText = 'Full Access';
                                                    break;
                                                case 'pendaftaran':
                                                    $badgeClass = 'badge-pendaftaran';
                                                    $statusText = 'Registration';
                                                    break;
                                                case 'pemeriksaan':
                                                    $badgeClass = 'badge-pemeriksaan';
                                                    $statusText = 'Medical Check';
                                                    break;
                                                case 'pembayaran':
                                                    $badgeClass = 'badge-pembayaran';
                                                    $statusText = 'Payment';
                                                    break;
                                                default:
                                                    $badgeClass = 'badge-secondary';
                                                    $statusText = 'Limited';
                                            }
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="row-number"><?php echo $nomor; ?></div>
                                                </td>
                                                <td>
                                                    <div class="username-cell">
                                                        <i class="fas fa-user-circle mr-2" style="color: #6fc3d0;"></i>
                                                        <strong><?php echo htmlspecialchars($pecah['username']); ?></strong>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="password-cell">
                                                        <i class="fas fa-lock mr-2" style="color: #6c757d;"></i>
                                                        <span class="text-muted">••••••••</span>
                                                        <small class="text-info ml-2">(Protected)</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge role-badge <?php echo $badgeClass; ?>">
                                                        <?php echo ucfirst($pecah['jabatan']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge status-badge">
                                                        <i class="fas fa-check-circle mr-1"></i><?php echo $statusText; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-action-group">
                                                        <button type="button" class="btn btn-info btn-action" title="View Details" data-toggle="tooltip">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <a href="user_hapus.php?&id_user=<?php echo $pecah['id_user']; ?>" 
                                                           class="btn btn-danger btn-action" 
                                                           title="Delete User"
                                                           data-toggle="tooltip"
                                                           onclick="return confirm('Apakah Anda yakin ingin menghapus user <?php echo $pecah['username']; ?>?');">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $nomor++; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    <small><i class="fas fa-info-circle mr-1"></i>Kelola pengguna sistem dan tingkat akses</small>
                                </div>
                                <div class="text-muted">
                                    <small><i class="fas fa-shield-alt mr-1"></i>Sistem Keamanan Aktif</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Apothecary 2025</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Custom Scripts for User Management -->
    <script>
        $(document).ready(function() {
            // Counter Animation
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
            
            // Check if DataTable is already initialized and destroy it
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }
            
            // Initialize DataTables with custom settings
            $('#dataTable').DataTable({
                "pageLength": 10,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ entries",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entries",
                    "infoFiltered": "(filtered dari _MAX_ total entries)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Add smooth animations for table rows
            $('.table tbody tr').hover(
                function() {
                    $(this).addClass('table-row-hover');
                },
                function() {
                    $(this).removeClass('table-row-hover');
                }
            );
        });
    </script>
    
    <style>
        .table-row-hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(8,131,149,0.15) !important;
        }
        
        /* DataTables responsive styling */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-bottom: 10px;
        }
        
        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #6fc3d0 !important;
            border-radius: 6px !important;
            padding: 4px 8px !important;
            color: #5459AC !important;
        }
    </style>
</body>

</html>