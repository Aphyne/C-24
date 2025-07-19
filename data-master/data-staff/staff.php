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
    <title>Apothecary | Data Master - Staff</title>
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
.staff-card-modern .badge-primary {
  background: #e3f2fd;
  color: #1976d2;
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
    outline: none !important;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    text-decoration: none;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:focus {
    outline: none !important;
    box-shadow: 0 2px 8px rgba(8,131,149,0.08) !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #5459AC !important;
    color: #fff !important;
    border-color: #5459AC;
    box-shadow: 0 4px 18px rgba(8,131,149,0.13) !important;
    outline: none !important;
}

/* Fix untuk menghilangkan kotak ganda pada pagination links */
.dataTables_wrapper .dataTables_paginate .paginate_button a {
    outline: none !important;
    box-shadow: none !important;
    border: none !important;
    background: transparent !important;
    color: inherit !important;
    text-decoration: none !important;
    display: block;
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
}

.dataTables_wrapper .dataTables_paginate .paginate_button a:focus,
.dataTables_wrapper .dataTables_paginate .paginate_button a:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button a:active {
    outline: none !important;
    box-shadow: none !important;
    border: none !important;
    background: transparent !important;
    color: inherit !important;
    text-decoration: none !important;
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
    .dataTables_wrapper .dataTables_paginate .paginate_button { 
        padding: 4px 10px; 
        font-size: 0.95rem; 
        outline: none !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
}

/* Padding atas main agar tidak menempel headbar */
#layoutSidenav_content main > .container-fluid,
#layoutSidenav_content main > .container {
    padding-top: 1.5rem;
}

 /* DataTables Search Input Styling */
                  .dataTables_filter input {
                      background: #fff !important;
                      color: #5459AC !important;
                      border: 2px solid #6fc3d0 !important;
                      border-radius: 8px !important;
                      padding: 8px 16px !important;
                      font-weight: 500 !important;
                      font-family: 'Poppins', sans-serif !important;
                      transition: all 0.18s ease !important;
                      box-shadow: 0 2px 8px rgba(84,89,172,0.08) !important;
                  }
                  
                  .dataTables_filter input:focus {
                      border-color: #5459AC !important;
                      box-shadow: 0 4px 16px rgba(84,89,172,0.15) !important;
                      outline: none !important;
                  }
                  
                  .dataTables_filter label {
                      color: #5459AC !important;
                      font-weight: 600 !important;
                      font-family: 'Poppins', sans-serif !important;
                      display: flex !important;
                      align-items: center !important;
                      gap: 12px !important;
                  }
                  
                  /* DataTables Pagination Buttons */
                  .dataTables_paginate .paginate_button {
                      background: #fff !important;
                      color: #5459AC !important;
                      border: 2px solid #6fc3d0 !important;
                      border-radius: 8px !important;
                      padding: 8px 16px !important;
                      margin: 0 4px !important;
                      font-weight: 600 !important;
                      font-family: 'Poppins', sans-serif !important;
                      transition: all 0.18s ease !important;
                      box-shadow: 0 2px 8px rgba(84,89,172,0.08) !important;
                      text-decoration: none !important;
                      outline: none !important;
                      -webkit-appearance: none !important;
                      -moz-appearance: none !important;
                      appearance: none !important;
                  }
                  
                  .dataTables_paginate .paginate_button:focus {
                      outline: none !important;
                      box-shadow: 0 2px 8px rgba(84,89,172,0.08) !important;
                  }
                  
                  .dataTables_paginate .paginate_button:hover {
                      background: linear-gradient(90deg, #6fc3d0 0%, #5459AC 100%) !important;
                      color: #fff !important;
                      border-color: #5459AC !important;
                      transform: translateY(-2px) scale(1.04) !important;
                      box-shadow: 0 8px 32px rgba(8,131,149,0.13) !important;
                      outline: none !important;
                  }
                  
                  .dataTables_paginate .paginate_button.current {
                      background: linear-gradient(90deg, #6fc3d0 0%, #5459AC 100%) !important;
                      color: #fff !important;
                      border-color: #5459AC !important;
                      box-shadow: 0 4px 16px rgba(84,89,172,0.15) !important;
                      outline: none !important;
                  }
                  
                  .dataTables_paginate .paginate_button.disabled {
                      background: #f2f2f2 !important;
                      color: #aaa !important;
                      border: 2px solid #e0e6ed !important;
                      cursor: not-allowed !important;
                      transform: none !important;
                      box-shadow: none !important;
                      outline: none !important;
                  }
                  
                  /* Fix untuk pagination links dalam button */
                  .dataTables_paginate .paginate_button a {
                      outline: none !important;
                      box-shadow: none !important;
                      border: none !important;
                      background: transparent !important;
                      color: inherit !important;
                      text-decoration: none !important;
                      display: block;
                      width: 100%;
                      height: 100%;
                      padding: 0;
                      margin: 0;
                  }
                  
                  .dataTables_paginate .paginate_button a:focus,
                  .dataTables_paginate .paginate_button a:hover,
                  .dataTables_paginate .paginate_button a:active {
                      outline: none !important;
                      box-shadow: none !important;
                      border: none !important;
                      background: transparent !important;
                      color: inherit !important;
                      text-decoration: none !important;
                  }
                  
                  /* DataTables Info Text */
                  .dataTables_info {
                      color: #5459AC !important;
                      font-weight: 600 !important;
                      font-family: 'Poppins', sans-serif !important;
                      margin-top: 12px !important;
                  }
                  
                  /* Table Header Styling */
                  #staffTable thead th {
                      background: linear-gradient(90deg, #6fc3d0 0%, #5459AC 100%) !important;
                      color: #fff !important;
                      font-weight: 600 !important;
                      font-family: 'Poppins', sans-serif !important;
                      border: none !important;
                      padding: 15px 12px !important;
                      text-align: center !important;
                      font-size: 0.95rem !important;
                      letter-spacing: 0.5px !important;
                      text-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
                  }
                  
                  /* Table Body Styling */
                  #staffTable tbody td {
                      padding: 12px !important;
                      vertical-align: middle !important;
                      font-family: 'Poppins', sans-serif !important;
                      border-bottom: 1px solid #e9ecef !important;
                      font-size: 0.9rem !important;
                      transition: background-color 0.2s ease !important;
                  }
                  
                  #staffTable tbody tr:hover {
                      background-color: rgba(111,195,208,0.12) !important;
                  }
                  
                  /* Enhanced Badge Styling */
                  .badge {
                      font-family: 'Poppins', sans-serif !important;
                      font-weight: 600 !important;
                      font-size: 0.8rem !important;
                      letter-spacing: 0.3px !important;
                  }
                  
                  /* Card Enhancement */
                  .card-header.bg-primary {
                      background: linear-gradient(90deg, #6fc3d0 0%, #5459AC 100%) !important;
                      border: none !important;
                      padding: 15px 20px !important;
                      margin-bottom: 0 !important;
                  }
                  
                  .card-header h5 {
                      margin: 0 !important;
                      display: flex !important;
                      align-items: center !important;
                  }
                  
                  .card-body {
                      padding-top: 10px !important;
                      padding-bottom: 10px !important;
                  }
                  
                  /* Header Search Styling */
                  .header-search-container {
                      min-width: 300px;
                  }
                  
                  .header-search-input {
                      background: rgba(255,255,255,0.9) !important;
                      border: 2px solid rgba(255,255,255,0.3) !important;
                      border-radius: 8px !important;
                      color: #5459AC !important;
                      font-family: 'Poppins', sans-serif !important;
                      font-weight: 500 !important;
                      transition: all 0.18s ease !important;
                      box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
                  }
                  
                  .header-search-input:focus {
                      background: #fff !important;
                      border-color: rgba(255,255,255,0.8) !important;
                      box-shadow: 0 4px 16px rgba(0,0,0,0.15) !important;
                      outline: none !important;
                  }
                  
                  .header-search-input::placeholder {
                      color: #8a92b2 !important;
                      font-style: italic;
                  }
                  
                  /* Hide default DataTables search */
                  .dataTables_filter {
                      display: none !important;
                  }
                  
                  /* DataTables Wrapper */
                  .dataTables_wrapper {
                      margin-top: 0 !important;
                  }
                  
                  .dataTables_wrapper .row {
                      margin: 10px 0 !important;
                  }
                  
                  /* Search and Info Layout */
                  .dataTables_filter {
                      text-align: right !important;
                      margin-bottom: 20px !important;
                  }
                  
                  .dataTables_info {
                      padding-top: 12px !important;
                  }
                  
                  /* Mobile responsiveness enhancements */
                  @media (max-width: 768px) {
                      .card-header.bg-primary {
                          flex-direction: column !important;
                          gap: 15px !important;
                          padding: 15px 20px !important;
                      }
                      
                      .header-search-container {
                          min-width: 100% !important;
                          max-width: 100% !important;
                      }
                      
                      .header-search-input {
                          width: 100% !important;
                      }
                      
                      .dataTables_paginate {
                          text-align: center !important;
                      }
                      
                      .dataTables_paginate .paginate_button {
                          padding: 6px 12px !important;
                          font-size: 0.85rem !important;
                          margin: 0 1px !important;
                          outline: none !important;
                          -webkit-appearance: none !important;
                          -moz-appearance: none !important;
                          appearance: none !important;
                      }
                      
                      #staffTable thead th {
                          font-size: 0.8rem !important;
                          padding: 10px 6px !important;
                      }
                      
                      #staffTable tbody td {
                          font-size: 0.8rem !important;
                          padding: 8px 6px !important;
                      }
                      
                      .card-header h5 {
                          font-size: 1.1rem !important;
                      }
                      
                      .badge {
                          font-size: 0.7rem !important;
                          padding: 3px 6px !important;
                      }
                  }
                  
                  /* Additional table enhancements */
                  .table-responsive {
                      border-radius: 0 !important;
                      box-shadow: none !important;
                      margin-bottom: 0 !important;
                  }
                  
                  #staffTable {
                      margin-bottom: 0 !important;
                      margin-top: 0 !important;
                  }
                  
                  .dataTables_wrapper .dataTables_length,
                  .dataTables_wrapper .dataTables_filter,
                  .dataTables_wrapper .dataTables_info,
                  .dataTables_wrapper .dataTables_processing,
                  .dataTables_wrapper .dataTables_paginate {
                      color: #5459AC !important;
                  }
                  
                  .dataTables_paginate {
                      text-align: right !important;
                      padding-top: 12px !important;
                  }

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
                    .staff-card-modern .badge-primary {
                        background: #e3f2fd;
                        color: #1976d2;
                        font-weight: 600;
                    }
                    .staff-card-modern .badge-info {
                        background: #e0f7fa;
                        color: #0097a7;
                        font-weight: 600;
                    }
                    .staff-card-modern .badge-warning {
                        background: #fffbe6;
                        color: #ff8f00;
                        font-weight: 600;
                    }
                    .staff-card-modern .badge-danger {
                        background: #fdeaea;
                        color: #e74c3c;
                        font-weight: 600;
                    }
                    .staff-card-modern .badge-secondary {
                        background: #f5f5f5;
                        color: #6c757d;
                        font-weight: 600;
                    }
                    
                    /* Button Gradient Outline Style - Match dokter.php */
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
                    
                    .btn-gradient-outline:disabled {
                        background: #f2f2f2;
                        color: #aaa !important;
                        border: 2px solid #e0e6ed;
                        cursor: not-allowed;
                        transform: none;
                        box-shadow: none !important;
                    }
                    
                    .shadow-custom {
                        box-shadow: 0 2px 8px rgba(84,89,172,0.08) !important;
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
        <a class="navbar-brand font-weight-bold text-center" href="../../index.php">Apothecary</a>
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
                        <div class="sb-sidenav-menu-heading">Apothecary</div>
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
                            <a class="nav-link" href="../../chatbot-ai/chatbot.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Chatbot AI
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
                    // Get staff data from database - with fallback if view doesn't exist
                    $staffData = [];
                    
                    // Try to use the view first
                    $viewExists = $koneksi->query("SHOW TABLES LIKE 'v_staff_dashboard'");
                    
                    if ($viewExists && $viewExists->num_rows > 0) {
                        // Use the view if it exists
                        $staffQuery = $koneksi->query("SELECT * FROM v_staff_dashboard ORDER BY rating_kinerja DESC");
                        if ($staffQuery) {
                            while ($row = $staffQuery->fetch_assoc()) {
                                $staffData[] = $row;
                            }
                        }
                    } else {
                        // Fallback to basic staff table if view doesn't exist
                        $staffQuery = $koneksi->query("SELECT 
                            s.id_staff,
                            s.nip,
                            s.nama_staff,
                            s.jabatan,
                            s.departemen,
                            s.status_staff,
                            COALESCE(p.total_jam_kerja, 176) as total_jam_kerja,
                            COALESCE(p.target_jam_kerja, 176) as target_jam_kerja,
                            COALESCE(p.persentase_kehadiran, 95.0) as persentase_kehadiran,
                            COALESCE(p.total_shift_bulan_ini, 22) as total_shift_bulan_ini,
                            COALESCE(p.total_lembur_jam, 4) as total_lembur_jam,
                            COALESCE(p.rating_kinerja, 4.0) as rating_kinerja,
                            COALESCE(p.jumlah_review, 20) as jumlah_review,
                            COALESCE(p.status_kinerja, 'Baik') as status_kinerja,
                            COALESCE(p.catatan_kinerja, 'Performa staff yang konsisten') as catatan_kinerja,
                            CASE 
                                WHEN COALESCE(p.rating_kinerja, 4.0) >= 4.5 THEN '★★★★★'
                                WHEN COALESCE(p.rating_kinerja, 4.0) >= 3.5 THEN '★★★★☆'
                                WHEN COALESCE(p.rating_kinerja, 4.0) >= 2.5 THEN '★★★☆☆'
                                WHEN COALESCE(p.rating_kinerja, 4.0) >= 1.5 THEN '★★☆☆☆'
                                ELSE '★☆☆☆☆'
                            END as rating_bintang,
                            CASE
                                WHEN COALESCE(p.status_kinerja, 'Baik') = 'Sangat Baik' THEN 'success'
                                WHEN COALESCE(p.status_kinerja, 'Baik') = 'Baik' THEN 'primary'
                                WHEN COALESCE(p.status_kinerja, 'Baik') = 'Cukup' THEN 'warning'
                                WHEN COALESCE(p.status_kinerja, 'Baik') = 'Perlu Monitoring' THEN 'danger'
                                ELSE 'secondary'
                            END as badge_class,
                            22 as total_hari_kerja,
                            1 as total_izin,
                            0 as total_sakit,
                            1 as total_terlambat
                        FROM tb_staff s
                        LEFT JOIN tb_performance_staff p ON s.id_staff = p.id_staff 
                            AND p.bulan_periode = MONTH(CURDATE()) 
                            AND p.tahun_periode = YEAR(CURDATE())
                        WHERE s.status_staff = 'aktif'
                        ORDER BY COALESCE(p.rating_kinerja, 4.0) DESC");
                        
                        if ($staffQuery) {
                            while ($row = $staffQuery->fetch_assoc()) {
                                $staffData[] = $row;
                            }
                        }
                    }
                    
                    // Calculate staff summary statistics from database
                    $totalStaffQuery = $koneksi->query("SELECT COUNT(*) as total FROM tb_staff WHERE status_staff = 'aktif'");
                    $totalStaff = ($totalStaffQuery && $totalStaffQuery->num_rows > 0) ? $totalStaffQuery->fetch_assoc()['total'] : 15;
                    
                    $staffAktifQuery = $koneksi->query("SELECT COUNT(*) as aktif FROM tb_staff WHERE status_staff = 'aktif'");
                    $staffAktif = ($staffAktifQuery && $staffAktifQuery->num_rows > 0) ? $staffAktifQuery->fetch_assoc()['aktif'] : 15;
                    
                    $staffCutiQuery = $koneksi->query("SELECT COUNT(*) as cuti FROM tb_staff WHERE status_staff = 'cuti'");
                    $staffCuti = ($staffCutiQuery && $staffCutiQuery->num_rows > 0) ? $staffCutiQuery->fetch_assoc()['cuti'] : 0;
                    
                    // Check if performance table exists
                    $perfTableExists = $koneksi->query("SHOW TABLES LIKE 'tb_performance_staff'");
                    if ($perfTableExists && $perfTableExists->num_rows > 0) {
                        $rataKehadiranQuery = $koneksi->query("SELECT AVG(persentase_kehadiran) as rata FROM tb_performance_staff WHERE bulan_periode = MONTH(CURDATE()) AND tahun_periode = YEAR(CURDATE())");
                        $rataKehadiran = ($rataKehadiranQuery && $rataKehadiranQuery->num_rows > 0) ? round($rataKehadiranQuery->fetch_assoc()['rata'], 1) : 94.5;
                        
                        $staffKurangPerformaQuery = $koneksi->query("SELECT COUNT(*) as count FROM tb_performance_staff WHERE status_kinerja = 'Perlu Monitoring' AND bulan_periode = MONTH(CURDATE()) AND tahun_periode = YEAR(CURDATE())");
                        $staffKurangPerforma = ($staffKurangPerformaQuery && $staffKurangPerformaQuery->num_rows > 0) ? $staffKurangPerformaQuery->fetch_assoc()['count'] : 2;
                    } else {
                        $rataKehadiran = 94.5;
                        $staffKurangPerforma = 2;
                    }
                    
                    // Calculate month over month growth
                    $bulanLalu = date('m') - 1;
                    $tahunLalu = date('Y');
                    if ($bulanLalu == 0) {
                        $bulanLalu = 12;
                        $tahunLalu = date('Y') - 1;
                    }
                    
                    $staffBulanIniQuery = $koneksi->query("SELECT COUNT(*) as count FROM tb_staff WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())");
                    $staffBulanIni = ($staffBulanIniQuery && $staffBulanIniQuery->num_rows > 0) ? $staffBulanIniQuery->fetch_assoc()['count'] : 1;
                    
                    $staffBulanLaluQuery = $koneksi->query("SELECT COUNT(*) as count FROM tb_staff WHERE MONTH(created_at) = $bulanLalu AND YEAR(created_at) = $tahunLalu");
                    $staffBulanLalu = ($staffBulanLaluQuery && $staffBulanLaluQuery->num_rows > 0) ? $staffBulanLaluQuery->fetch_assoc()['count'] : 1;
                    
                    $kenaikanStaffBulanIni = $staffBulanLalu > 0 ? round((($staffBulanIni - $staffBulanLalu) / $staffBulanLalu) * 100, 1) : 0;
                    
                    // Get positive and negative reviews from staff data
                    $ulasanPositif = array_slice(array_values(array_filter($staffData, fn($d) => isset($d['rating_kinerja']) && $d['rating_kinerja'] >= 4)), 0, 5);
                    $ulasanNegatif = array_slice(array_values(array_filter($staffData, fn($d) => isset($d['rating_kinerja']) && $d['rating_kinerja'] < 4)), 0, 5);
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
                            <div class="d-flex align-items-start">
                                <div class="insight-icon mr-3">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="insight-title mb-3">🤖 Insight AI Saran Cerdas Staff</h5>
                                    <p class="insight-desc mb-3">
                                        Berdasarkan analisis otomatis seluruh data staff, berikut insight dan rekomendasi strategis untuk pengelolaan SDM klinik:
                                    </p>
                                    <ul class="insight-list">
                                    <?php
                                    // 1. Prediksi Staff Berisiko Performa Turun
                                    $staffTurun = [];
                                    foreach ($staffData as $d) {
                                        if ($d['persentase_kehadiran'] < 90 || $d['rating_kinerja'] < 4.0) $staffTurun[] = $d['nama_staff'];
                                    }
                                    if (count($staffTurun) > 0) {
                                        echo '<li><b>Prediksi Performa Turun:</b> ' . count($staffTurun) . ' staff berpotensi turun performa (kehadiran < 90% atau rating < 4.0): <span class="text-info">' . implode(', ', array_slice($staffTurun,0,5)) . (count($staffTurun)>5?' ...':'') . '</span></li>';
                                    }

                                    // 2. Rekomendasi Penjadwalan Shift/Lembur
                                    $overload = [];
                                    foreach ($staffData as $d) {
                                        if ($d['total_jam_kerja'] > $d['target_jam_kerja'] || $d['total_lembur_jam'] > 10) $overload[] = $d['nama_staff'];
                                    }
                                    if (count($overload) > 0) {
                                        echo '<li><b>Rekomendasi Penjadwalan:</b> ' . count($overload) . ' staff overload jam kerja/lembur, sebaiknya distribusi ulang shift: <span class="text-warning">' . implode(', ', array_slice($overload,0,5)) . (count($overload)>5?' ...':'') . '</span></li>';
                                    }

                                    // 3. Deteksi Anomali Data Staff (NIP ganda, rating outlier)
                                    $nipSet = [];
                                    $nipDuplikat = [];
                                    $ratingOutlier = [];
                                    foreach ($staffData as $d) {
                                        if (!empty($d['nip'])) {
                                            if (isset($nipSet[$d['nip']])) $nipDuplikat[] = $d['nama_staff'];
                                            $nipSet[$d['nip']] = true;
                                        }
                                        if ($d['rating_kinerja'] > 5.0 || $d['rating_kinerja'] < 1.0) $ratingOutlier[] = $d['nama_staff'];
                                    }
                                    if (count($nipDuplikat)>0)
                                        echo '<li><b>Deteksi NIP Ganda:</b> <span class="text-danger">'.implode(', ', array_slice($nipDuplikat,0,5)).(count($nipDuplikat)>5?' ...':'').'</span></li>';
                                    if (count($ratingOutlier)>0)
                                        echo '<li><b>Deteksi Rating Outlier:</b> <span class="text-danger">'.implode(', ', array_slice($ratingOutlier,0,5)).(count($ratingOutlier)>5?' ...':'').'</span></li>';

                                    // 4. Segmentasi Kinerja Staff
                                    $segSangatBaik = $segBaik = $segCukup = $segPerlu = 0;
                                    foreach ($staffData as $d) {
                                        if ($d['status_kinerja'] == 'Sangat Baik') $segSangatBaik++;
                                        elseif ($d['status_kinerja'] == 'Baik') $segBaik++;
                                        elseif ($d['status_kinerja'] == 'Cukup') $segCukup++;
                                        elseif ($d['status_kinerja'] == 'Perlu Monitoring') $segPerlu++;
                                    }
                                    echo '<li><b>Segmentasi Kinerja:</b> Sangat Baik: <span class="text-success">'.$segSangatBaik.'</span>, Baik: <span class="text-primary">'.$segBaik.'</span>, Cukup: <span class="text-warning">'.$segCukup.'</span>, Perlu Monitoring: <span class="text-danger">'.$segPerlu.'</span></li>';

                                    // 5. Prediksi Kebutuhan Rekrutmen
                                    $rasio = $totalStaff > 0 ? round($staffAktif/$totalStaff,2) : 0;
                                    if ($rasio < 0.8) {
                                        echo '<li><b>Prediksi Rekrutmen:</b> Rasio staff aktif/total rendah ('.$rasio.'), pertimbangkan rekrutmen staff baru.</li>';
                                    }

                                    // 6. Analisis Kepuasan & Review Staff
                                    $ratingTertinggi = null; $ratingTerendah = null;
                                    foreach ($staffData as $d) {
                                        if ($ratingTertinggi === null || $d['rating_kinerja'] > $ratingTertinggi['rating_kinerja']) $ratingTertinggi = $d;
                                        if ($ratingTerendah === null || $d['rating_kinerja'] < $ratingTerendah['rating_kinerja']) $ratingTerendah = $d;
                                    }
                                    if ($ratingTertinggi && $ratingTerendah) {
                                        echo '<li><b>Kepuasan Staff:</b> Rating tertinggi: <span class="text-success">'.$ratingTertinggi['nama_staff'].' ('.$ratingTertinggi['rating_kinerja'].'/5)</span>, terendah: <span class="text-danger">'.$ratingTerendah['nama_staff'].' ('.$ratingTerendah['rating_kinerja'].'/5)</span></li>';
                                    }

                                    // 7. Saran Pengembangan Karir
                                    $stagnan = [];
                                    foreach ($staffData as $d) {
                                        if ($d['status_kinerja'] == 'Perlu Monitoring' || $d['rating_kinerja'] < 3.5) $stagnan[] = $d['nama_staff'];
                                    }
                                    if (count($stagnan) > 0) {
                                        echo '<li><b>Pengembangan Karir:</b> Rekomendasi pelatihan untuk '.count($stagnan).' staff: <span class="text-info">'.implode(', ', array_slice($stagnan,0,5)).(count($stagnan)>5?' ...':'').'</span></li>';
                                    }

                                    // 8. Forecasting Kebutuhan Shift Bulan Depan
                                    $prediksiShift = $staffAktif > 0 ? round($staffAktif * 1.05) : 0;
                                    echo '<li><b>Forecasting Shift Bulan Depan:</b> <span class="text-primary">Perkiraan kebutuhan shift: '.$prediksiShift.'</span></li>';

                                    // 9. Deteksi Staff Baru & Turnover
                                    $staffBaruList = [];
                                    foreach ($staffData as $d) {
                                        if (isset($d['created_at']) && date('Y-m', strtotime($d['created_at'])) == date('Y-m')) $staffBaruList[] = $d['nama_staff'];
                                    }
                                    if (count($staffBaruList)>0)
                                        echo '<li><b>Staff Baru Bulan Ini:</b> <span class="text-success">'.implode(', ', array_slice($staffBaruList,0,5)).(count($staffBaruList)>5?' ...':'').'</span></li>';
                                    if ($staffCuti > 0)
                                        echo '<li><b>Staff Cuti:</b> <span class="text-warning">'.$staffCuti.' staff cuti</span></li>';

                                    // 10. Rekomendasi Insentif/Reward
                                    $reward = [];
                                    foreach ($staffData as $d) {
                                        if ($d['status_kinerja'] == 'Sangat Baik' && $d['rating_kinerja'] >= 4.7) $reward[] = $d['nama_staff'];
                                    }
                                    if (count($reward)>0)
                                        echo '<li><b>Rekomendasi Reward:</b> <span class="text-success">'.implode(', ', array_slice($reward,0,5)).(count($reward)>5?' ...':'').'</span></li>';

                                    // Jika tidak ada insight khusus
                                    if (count($staffData) == 0) {
                                        echo '<li>Data staff belum tersedia untuk insight AI.</li>';
                                    }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ===================== Row 2: Review Performa Staff ===================== -->
                    <?php
                    // Use the staff data from database instead of hardcoded data
                    $staffPerformance = $staffData; // Already fetched from v_staff_dashboard view
                    ?>

                    <h4 class="mb-4 font-weight-bold text-secondary">Review Performa Staff</h4>
                    <div class="staff-filter-bar mb-4">
                      <input type="text" id="searchInput" class="form-control" placeholder="Cari nama atau posisi" style="border: 2px solid #6fc3d0; border-radius: 8px;">
                      <select id="filterStatus" class="form-control" style="border: 2px solid #6fc3d0; border-radius: 8px;">
                          <option value="">Semua Status</option>
                          <option value="Sangat Baik">Sangat Baik</option>
                          <option value="Cukup">Cukup</option>
                          <option value="Perlu Monitoring">Perlu Monitoring</option>
                      </select>
                      <select id="filterPosisi" class="form-control" style="border: 2px solid #6fc3d0; border-radius: 8px;">
                          <option value="">Semua Posisi</option>
                          <option value="Admin Apotik">Admin Apotik</option>
                          <option value="Kasir">Kasir</option>
                          <option value="Apoteker">Apoteker</option>
                          <option value="Suster">Suster</option>
                          <option value="Cleaning Service">Cleaning Service</option>
                      </select>
                      <button class="btn btn-gradient-outline btn-sm px-3 font-weight-bold shadow-custom" id="resetFilter"><i class="fas fa-undo mr-1"></i> Reset</button>
                      <div class="ml-auto d-flex align-items-center" style="gap:8px;">
                          <button class="btn btn-gradient-outline font-weight-bold px-4 shadow-custom" style="min-width:220px;" data-toggle="modal" data-target="#topStaffModal">
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
                            // Get top 3 staff from database with fallback
                            $topStaff = [];
                            
                            if ($viewExists && $viewExists->num_rows > 0) {
                                $topStaffQuery = $koneksi->query("SELECT * FROM v_staff_dashboard ORDER BY rating_kinerja DESC, total_jam_kerja DESC LIMIT 3");
                                if ($topStaffQuery) {
                                    $rank = 1;
                                    while ($row = $topStaffQuery->fetch_assoc()) {
                                        $row['rank'] = $rank;
                                        $row['badge'] = $rank == 1 ? 'Teladan' : ($rank == 2 ? 'Sangat Baik' : 'Konsisten');
                                        $topStaff[] = $row;
                                        $rank++;
                                    }
                                }
                            }
                            
                            // Fallback data if no database or view
                            if (empty($topStaff)) {
                                $topStaff = [
                                    ["rank" => 1, "nama_staff" => "Sari Manager", "jabatan" => "Manager Operasional", "total_jam_kerja" => 185, "persentase_kehadiran" => 99.2, "rating_kinerja" => 4.9, "badge" => "Teladan"],
                                    ["rank" => 2, "nama_staff" => "Nurse Ana Kristina", "jabatan" => "Perawat Senior", "total_jam_kerja" => 180, "persentase_kehadiran" => 98.5, "rating_kinerja" => 4.9, "badge" => "Sangat Baik"],
                                    ["rank" => 3, "nama_staff" => "Indra IT Support", "jabatan" => "IT Support", "total_jam_kerja" => 174, "persentase_kehadiran" => 95.8, "rating_kinerja" => 4.8, "badge" => "Konsisten"]
                                ];
                            }
                            
                            $badgeClass = ["Teladan" => "success", "Sangat Baik" => "primary", "Konsisten" => "info"];
                            foreach ($topStaff as $staff) { ?>
                              <div class="col-md-4">
                                <div class="card top-staff-card h-100">
                                  <div class="card-header text-center">
                                    <span class="fa fa-trophy"></span>
                                    <span class="font-weight-bold">Peringkat <?= $staff['rank'] ?></span>
                                  </div>
                                  <div class="card-body text-center">
                                    <h5 class="mb-1"><?= $staff['nama_staff'] ?></h5>
                                    <div class="text-muted mb-2"><?= $staff['jabatan'] ?></div>
                                    <div class="mb-2"><i class="fas fa-clock mr-1"></i> <b><?= $staff['total_jam_kerja'] ?> jam</b></div>
                                    <div class="mb-2"><i class="fas fa-calendar-check mr-1"></i> Kehadiran: <b><?= $staff['persentase_kehadiran'] ?>%</b></div>
                                    <div class="mb-2"><i class="fas fa-star text-warning mr-1"></i> Rating: <b><?= $staff['rating_kinerja'] ?>/5.0</b></div>
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
                            $initial = strtoupper(substr($staff['nama_staff'], 0, 1));
                            // Pilih warna avatar (acak dari array)
                            $avatarColors = ['#5459AC', '#17a2b8', '#ffc107', '#28a745', '#dc3545'];
                            $color = $avatarColors[crc32($staff['nama_staff']) % count($avatarColors)];
                            // Badge status dengan proper color mapping
                            $badgeText = $staff['status_kinerja'];
                            
                            // Fix badge class based on status
                            switch(strtolower($badgeText)) {
                                case 'excellent':
                                case 'sangat baik':
                                    $badgeClass = 'success';
                                    break;
                                case 'good':
                                case 'baik':
                                    $badgeClass = 'primary';
                                    break;
                                case 'average':
                                case 'cukup':
                                    $badgeClass = 'warning';
                                    break;
                                case 'poor':
                                case 'kurang':
                                case 'perlu monitoring':
                                    $badgeClass = 'danger';
                                    break;
                                default:
                                    $badgeClass = 'secondary';
                            }
                        ?>
                        <div class="col-md-4 mb-4 staff-card"
                            data-nama="<?= strtolower($staff['nama_staff']) ?>"
                            data-posisi="<?= strtolower($staff['jabatan']) ?>"
                            data-status="<?= strtolower($staff['status_kinerja']) ?>">
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
                                            <div style="font-weight:700;font-size:1.15rem;"><?= $staff['nama_staff'] ?></div>
                                            <div class="text-muted" style="font-size:0.98rem;"><?= $staff['jabatan'] ?></div>
                                        </div>
                                    </div>
                                    <!-- Jam Kerja -->
                                    <div class="mb-2" style="font-size:0.98rem;">
                                        <i class="fas fa-clock mr-1 text-secondary"></i>
                                        Jam Kerja: <b><?= $staff['total_jam_kerja'] ?> / <?= $staff['target_jam_kerja'] ?> Jam</b>
                                    </div>
                                    <div class="progress mb-2" style="height:9px;">
                                        <div class="progress-bar bg-success" data-width="<?= round(($staff['total_jam_kerja'] / $staff['target_jam_kerja']) * 100) ?>"></div>
                                    </div>
                                    <!-- Kehadiran -->
                                    <div class="mb-2" style="font-size:0.98rem;">
                                        <i class="fas fa-calendar-check mr-1 text-info"></i>
                                        Kehadiran: <b><?= $staff['persentase_kehadiran'] ?>%</b>
                                    </div>
                                    <div class="progress mb-2" style="height:9px;">
                                        <div class="progress-bar bg-info" data-width="<?= $staff['persentase_kehadiran'] ?>"></div>
                                    </div>
                                    <!-- Shift & Lembur -->
                                    <div class="mb-2" style="font-size:0.98rem;">
                                        <i class="fas fa-user-clock mr-1 text-warning"></i>
                                        Shift: <b><?= $staff['total_shift_bulan_ini'] ?></b> &nbsp; | &nbsp; Lembur: <b><?= $staff['total_lembur_jam'] ?></b>
                                    </div>
                                    <!-- Rating -->
                                    <div class="mb-2" style="font-size:0.98rem;">
                                        <i class="fas fa-star text-warning mr-1"></i>
                                        Rating: <span class="text-warning" style="font-size:1.1rem;"><?= $staff['rating_bintang'] ?></span> (<?= $staff['rating_kinerja'] ?>)
                                    </div>
                                    <!-- Catatan -->
                                    <div class="mb-2 text-muted" style="font-size:0.97rem;">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <?= $staff['catatan_kinerja'] ?>
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
                    </div>
                    <div class="row staff-pagination-bar mb-4" style="margin-top: 20px;">
                        <div class="col-4 d-flex justify-content-start align-items-center">
                            <button id="prevPage" class="btn btn-gradient-outline btn-sm px-3 font-weight-bold shadow-custom">
                                <i class="fas fa-angle-left mr-1"></i> Previous
                            </button>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center">
                            <span id="staffPageInfo" class="text-muted font-weight-bold">Halaman 1 dari <span id="totalStaffPages">1</span></span>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <button id="nextPage" class="btn btn-gradient-outline btn-sm px-3 font-weight-bold shadow-custom">
                                Next <i class="fas fa-angle-right ml-1"></i>
                            </button>
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
                        $('#nextPage').prop('disabled', currentPage === totalPages || totalPages === 0);
                        $('#staffPageInfo').text(`Halaman ${currentPage} dari ${totalPages}`);
                        $('#totalStaffPages').text(totalPages);
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
                              <select id="posisiFilter" class="form-control form-control-sm w-auto" style="border: 2px solid #6fc3d0; border-radius: 8px;">
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
                    <?php
                    // Get position distribution from database with fallback
                    $positions = [];
                    $counts = [];
                    
                    $positionQuery = $koneksi->query("SELECT jabatan, COUNT(*) as count FROM tb_staff WHERE status_staff = 'aktif' GROUP BY jabatan");
                    if ($positionQuery && $positionQuery->num_rows > 0) {
                        while ($row = $positionQuery->fetch_assoc()) {
                            $positions[] = $row['jabatan'];
                            $counts[] = $row['count'];
                        }
                    } else {
                        // Fallback data
                        $positions = ["Perawat Senior", "Apoteker", "Kasir", "Teknisi Lab", "Manager", "Admin"];
                        $counts = [3, 2, 2, 2, 1, 5];
                    }
                    ?>
                    const posisiLabels = <?= json_encode($positions) ?>;
                    const posisiJumlah = <?= json_encode($counts) ?>;
                    const donutColors = [
                      'rgba(84,89,172,0.9)', 'rgba(111,195,208,0.9)', 'rgba(61,191,211,0.9)',
                      'rgba(8,131,149,0.9)', 'rgba(0,255,202,0.75)', 'rgba(111,195,208,0.7)'
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
                      <?php foreach ($staffData as $staff): ?>
                      { nama: "<?= $staff['nama_staff'] ?>", posisi: "<?= $staff['jabatan'] ?>", hadir: <?= $staff['persentase_kehadiran'] ?> },
                      <?php endforeach; ?>
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
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users fa-lg mr-2"></i> 
                                <h5 class="mb-0 font-weight-bold text-white">📋 Detail Data Staff</h5>
                            </div>
                            <div class="header-search-container">
                                <div class="d-flex align-items-center" style="gap:12px;">
                                    <input type="search" id="staffSearchInput" class="form-control header-search-input" placeholder="Cari nama, posisi, atau status staff...">
                                    <a href="staff_input.php" class="btn btn-gradient-outline font-weight-bold px-4 shadow-custom ml-2" style="min-width:180px;">
                                        <i class="fas fa-plus mr-2"></i>Tambah Staff
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="background:#f7f9fc; border-radius: 0 0 18px 18px; padding: 15px 20px;">
                            <div class="table-responsive">
                                <table id="staffTable" class="table table-sm table-bordered table-hover mb-0">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 40px;">No</th>
                                            <th style="min-width: 120px;">Nama</th>
                                            <th style="width: 100px;">Posisi</th>
                                            <th style="width: 90px;">Jam Kerja</th>
                                            <th style="width: 90px;">Kehadiran</th>
                                            <th style="width: 70px;">Izin</th>
                                            <th style="width: 90px;">Terlambat</th>
                                            <th style="width: 70px;">Sakit</th>
                                            <th style="width: 90px;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Use database data for detail staff table
                                        $no = 1;
                                        foreach ($staffData as $staff) {
                                            $statusClass = '';
                                            $statusText = $staff['status_kinerja'];
                                            
                                            // Add status badge styling
                                            switch(strtolower($statusText)) {
                                                case 'excellent':
                                                case 'sangat baik':
                                                    $statusClass = 'badge-success';
                                                    break;
                                                case 'good':
                                                case 'baik':
                                                    $statusClass = 'badge-primary';
                                                    break;
                                                case 'average':
                                                case 'cukup':
                                                    $statusClass = 'badge-warning';
                                                    break;
                                                case 'poor':
                                                case 'kurang':
                                                case 'perlu monitoring':
                                                    $statusClass = 'badge-danger';
                                                    break;
                                                default:
                                                    $statusClass = 'badge-secondary';
                                            }
                                            
                                            echo "<tr>
                                                <td class='text-center'>{$no}</td>
                                                <td>{$staff['nama_staff']}</td>
                                                <td class='text-center'>{$staff['jabatan']}</td>
                                                <td class='text-center'>{$staff['total_jam_kerja']} Jam</td>
                                                <td class='text-center'>{$staff['total_hari_kerja']} Hari</td>
                                                <td class='text-center'>{$staff['total_izin']}</td>
                                                <td class='text-center'>{$staff['total_terlambat']}</td>
                                                <td class='text-center'>{$staff['total_sakit']}</td>
                                                <td class='text-center'><span class='badge {$statusClass} px-2 py-1'>{$statusText}</span></td>
                                            </tr>";
                                            $no++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                  <!-- DataTables CSS & JS -->
                  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
                  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

                  <!-- Custom DataTables Styling to Match Button Design -->

                  <script>
                  $(document).ready(function () {
                      var table = $('#staffTable').DataTable({
                          pageLength: 10,
                          lengthChange: false,
                          ordering: true,
                          responsive: true,
                          searching: true,
                          language: {
                              paginate: {
                                  previous: "<i class='fas fa-angle-left mr-1'></i> Previous",
                                  next: "Next <i class='fas fa-angle-right ml-1'></i>"
                              },
                              info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri staff",
                              infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                              infoFiltered: "(difilter dari _MAX_ total entri)",
                              zeroRecords: "Tidak ada data staff yang ditemukan",
                              emptyTable: "Tidak ada data staff tersedia dalam tabel",
                              processing: "Memproses..."
                          },
                          dom: '<"row"<"col-sm-12 col-md-6"><"col-sm-12 col-md-6">>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                          columnDefs: [
                              { targets: [0, 3, 4, 5, 6, 7, 8], className: "text-center" },
                              { targets: [1, 2], className: "text-left" }
                          ],
                          initComplete: function () {
                              // Add custom wrapper styling
                              $('.dataTables_wrapper').addClass('shadow-sm rounded');
                              
                              // Style table container
                              $('#staffTable').closest('.table-responsive').addClass('border-0');
                          },
                          drawCallback: function() {
                              // Ensure pagination buttons maintain style after redraw
                              $('.dataTables_paginate .paginate_button').each(function() {
                                  if ($(this).hasClass('previous') && !$(this).find('i').length) {
                                      $(this).html('<i class="fas fa-angle-left mr-1"></i> Previous');
                                  }
                                  if ($(this).hasClass('next') && !$(this).find('i').length) {
                                      $(this).html('Next <i class="fas fa-angle-right ml-1"></i>');
                                  }
                              });
                          }
                      });
                      
                      // Custom search functionality
                      $('#staffSearchInput').on('keyup', function() {
                          table.search(this.value).draw();
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
                        <div class="text-muted font-weight-bold">Copyright &copy; Apothecary - 2025</div>
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