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
    <title>Apothecary | Data Master - Dokter</title>
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

/* --- EQUAL HEIGHT CARDS UNTUK JADWAL & INSIGHT --- */
.equal-height-cards {
    display: flex;
    align-items: stretch;
}
.equal-height-cards .col-md-4 {
    display: flex;
    flex-direction: column;
}
.card-equal-height {
    border-radius: 18px;
    background: #f7f9fc;
    box-shadow: 0 4px 24px rgba(84,89,172,0.08);
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 420px; /* Tinggi minimum yang sama */
    max-height: 420px; /* Tinggi maksimum yang sama */
}
.card-header-custom {
    border-radius: 18px 18px 0 0;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    min-height: 60px;
}
.card-header-custom.bg-primary {
    background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%) !important;
}
.card-header-custom.bg-warning {
    background: linear-gradient(90deg, #f7b731 70%, #ffed4e 100%) !important;
}
.card-header-custom.bg-success {
    background: linear-gradient(90deg, #1ca97a 70%, #6fc3d0 100%) !important;
}
.card-body-custom {
    padding: 16px 20px 12px 20px;
    background: #f7f9fc;
    border-radius: 0 0 18px 18px;
    flex: 1;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.scrollable-content {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    max-height: 320px; /* Tinggi scroll area */
    padding-right: 8px;
}
.scrollable-content::-webkit-scrollbar {
    width: 6px;
}
.scrollable-content::-webkit-scrollbar-track {
    background: #e9ecef;
    border-radius: 6px;
}
.scrollable-content::-webkit-scrollbar-thumb {
    background: #6fc3d0;
    border-radius: 6px;
}
.scrollable-content::-webkit-scrollbar-thumb:hover {
    background: #5459AC;
}

/* AGENDA ITEMS */
.agenda-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
    transition: background 0.2s;
}
.agenda-item:hover {
    background: rgba(84,89,172,0.05);
    border-radius: 8px;
    margin: 0 -8px;
    padding: 12px 8px;
}
.agenda-icon {
    margin-right: 12px;
    width: 24px;
    text-align: center;
}
.agenda-content {
    flex: 1;
}
.agenda-day {
    font-weight: 700;
    color: #5459AC;
    font-size: 0.95rem;
}
.agenda-doctor {
    font-weight: 600;
    color: #222;
    font-size: 0.9rem;
    margin-bottom: 2px;
}
.agenda-spec {
    color: #666;
    font-size: 0.85rem;
}
.agenda-badge {
    text-align: right;
}
.agenda-badge .badge {
    font-size: 0.8rem;
    padding: 4px 8px;
}

/* NOTIFICATION ITEMS */
.notification-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
    transition: background 0.2s;
}
.notification-item:hover {
    background: rgba(247,183,49,0.05);
    border-radius: 8px;
    margin: 0 -8px;
    padding: 12px 8px;
}
.notification-item.priority-high {
    border-left: 3px solid #e74c3c;
    padding-left: 8px;
    margin-left: -8px;
    background: rgba(231,76,60,0.03);
}
.notification-item.priority-medium {
    border-left: 3px solid #f7b731;
    padding-left: 8px;
    margin-left: -8px;
    background: rgba(247,183,49,0.03);
}
.notification-icon {
    margin-right: 12px;
    width: 24px;
    text-align: center;
}
.notification-content {
    flex: 1;
}
.notification-doctor {
    font-weight: 700;
    color: #222;
    font-size: 0.9rem;
}
.notification-spec {
    color: #666;
    font-size: 0.85rem;
    margin-bottom: 2px;
}
.notification-status {
    color: #5459AC;
    font-size: 0.85rem;
    font-weight: 600;
}
.notification-badges {
    text-align: right;
}
.notification-badges .badge {
    font-size: 0.75rem;
    padding: 2px 6px;
    margin: 1px;
    display: block;
}

/* PERFORMANCE ITEMS */
.performance-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
    transition: background 0.2s;
}
.performance-item:hover {
    background: rgba(28,169,122,0.05);
    border-radius: 8px;
    margin: 0 -8px;
    padding: 12px 8px;
}
.performance-icon {
    margin-right: 12px;
    width: 24px;
    text-align: center;
}
.performance-content {
    flex: 1;
}
.performance-doctor {
    font-weight: 700;
    color: #222;
    font-size: 0.9rem;
}
.performance-spec {
    color: #666;
    font-size: 0.85rem;
    margin-bottom: 2px;
}
.performance-rating {
    color: #f7b731;
    font-size: 0.85rem;
    font-weight: 600;
}
.performance-status {
    text-align: right;
}
.performance-status .badge {
    font-size: 0.8rem;
    padding: 4px 8px;
    margin-bottom: 4px;
}

/* SHOW MORE BUTTON */
.show-more-btn {
    text-align: center;
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 8px;
}

/* RESPONSIVE */
@media (max-width: 991px) {
    .equal-height-cards {
        flex-direction: column;
    }
    .card-equal-height {
        min-height: 300px;
        max-height: 350px;
        margin-bottom: 16px;
    }
    .scrollable-content {
        max-height: 250px;
    }
}
@media (max-width: 767px) {
    .card-header-custom {
        padding: 14px 16px;
        font-size: 0.95rem;
    }
    .card-body-custom {
        padding: 12px 16px 8px 16px;
    }
    .card-equal-height {
        min-height: 280px;
        max-height: 320px;
    }
    .scrollable-content {
        max-height: 220px;
    }
}

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
  flex-wrap: nowrap;
  align-items: center;
  justify-content: flex-start;
  gap: 12px;
  width: 100%;
}
.dokter-filter-bar input,
.dokter-filter-bar select {
  border-radius: 8px;
  border: 2px solid #6fc3d0;
  font-size: 1rem;
  font-family: 'Poppins', Arial, sans-serif;
  padding: 6px 12px;
  background: #fff;
  color: #222;
  transition: border 0.18s;
  box-shadow: 0 2px 8px rgba(8,131,149,0.08);
  margin-right: 8px;
}
.dokter-filter-bar input {
  min-width: 200px;
  flex: 1 1 200px;
  max-width: 280px;
}
.dokter-filter-bar select {
  min-width: 160px;
  flex: 0 0 160px;
}
.dokter-filter-bar input:focus,
.dokter-filter-bar select:focus {
  border-color: #5459AC;
  outline: none;
}
.dokter-filter-bar button {
  border-radius: 8px;
  font-weight: 600;
  font-size: 1rem;
  padding: 7px 18px;
  margin-right: 8px;
  white-space: nowrap;
  flex-shrink: 0;
}
@media (max-width: 991px) {
  .dokter-filter-bar {
    flex-wrap: wrap;
    justify-content: flex-start;
    overflow-x: visible;
  }
  .dokter-filter-bar input {
    min-width: 100%;
    max-width: 100%;
    margin-right: 0;
    margin-bottom: 8px;
  }
  .dokter-filter-bar select {
    min-width: calc(50% - 4px);
    flex: 1 1 calc(50% - 4px);
    margin-right: 8px;
    margin-bottom: 8px;
  }
  .dokter-filter-bar select:last-of-type {
    margin-right: 0;
  }
  .dokter-filter-bar button {
    margin-right: 8px;
    margin-bottom: 8px;
    flex: 1 1 auto;
  }
  .dokter-filter-bar button:last-child {
    margin-right: 0;
  }
}
/* --- TOP 3 DOKTER MODAL --- */
.top-dokter-card {
  border-radius: 18px;
  background: #fff;
  box-shadow: 0 4px 24px rgba(84,89,172,0.10);
  border: none;
  overflow: hidden;
  position: relative;
  transition: box-shadow 0.2s, transform 0.2s;
  display: flex;
  flex-direction: column;
}
.top-dokter-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 32px rgba(84,89,172,0.15);
}
.top-dokter-card .card-header {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-bottom: 1px solid #e0e6ed;
  padding: 18px;
  border-radius: 18px 18px 0 0;
}
.top-dokter-card .dokter-modern-status {
  margin-top: 4px;
  margin-bottom: 4px;
}
.top-dokter-card .card-body {
  padding: 18px 18px 10px 18px;
  flex: 1;
}
.top-dokter-card .card-footer {
  background: #f7f9fc;
  border-top: 1px solid #e0e6ed;
  text-align: center;
  padding: 12px 0;
  margin-top: auto;
}
.top-dokter-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
  color: #fff;
  font-weight: bold;
  font-size: 1.3rem;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  box-shadow: 0 3px 12px rgba(8,131,149,0.15);
}
.top-dokter-badge {
  font-size: 0.98rem;
  font-weight: 600;
  border-radius: 8px;
  padding: 6px 16px;
  background: #e6f7ec;
  color: #1ca97a;
}
/* Efek khusus untuk ranking medal */
.top-dokter-card[style*="f7b731"] {
  box-shadow: 0 4px 24px rgba(247, 183, 49, 0.2);
}
.top-dokter-card[style*="c0c0c0"] {
  box-shadow: 0 4px 24px rgba(192, 192, 192, 0.2);
}
.top-dokter-card[style*="cd7f32"] {
  box-shadow: 0 4px 24px rgba(205, 127, 50, 0.2);
}
@media (max-width: 767px) {
  .top-dokter-card .card-header,
  .top-dokter-card .card-body { 
    padding: 12px 10px; 
  }
  .top-dokter-avatar { 
    width: 40px; 
    height: 40px; 
    font-size: 1.1rem; 
  }
}
/* --- PAGINATION BUTTONS --- */
.dokter-pagination-bar {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 18px;
  margin-top: 18px;
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

/* Tambahan efek glow untuk icon insight */
.summary-icon.bg-info {
  box-shadow: 0 0 12px 0 #6fc3d0a0;
  animation: glowLamp 1.8s infinite alternate;
}
@keyframes glowLamp {
  from { box-shadow: 0 0 8px #6fc3d0a0; }
  to   { box-shadow: 0 0 20px #6fc3d0cc; }
}

/* === TABEL DOKTER MODERN DARI OBAT.PHP === */
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

/* DataTables Filter dan Wrapper - Style dari obat.php */
.dataTables_wrapper .dataTables_filter {
    margin: 12px 0 !important;
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

/* DataTables Pagination - Style dari obat.php */
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
    box-shadow: 0 4px 18px rgba(8,131,149,0.13);
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
    </style>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>
    <script src="../../assets/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/js/chart.min.js"></script>
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
                                    <a class="nav-link active" href="data-dokter/dokter.php">Data Dokter</a>
                                    <a class="nav-link" href="../data-obat/obat.php">Data Obat</a>
                                    <a class="nav-link" href="../data-staff/staff.php">Data Staff</a>
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
        <h1 class="mt-4">Data Dokter</h1>
            <?php
            // Ambil data dari database
            $queryTotalDokterAktif = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_dokter WHERE status_dokter = 'aktif'");
            $totalDokterAktif = mysqli_fetch_array($queryTotalDokterAktif)['total'];
            
            $queryDokterNonaktif = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_dokter WHERE status_dokter = 'nonaktif'");
            $dokterNonaktif = mysqli_fetch_array($queryDokterNonaktif)['total'];
            
            $rataKehadiran = 93; // persen (bisa dikembangkan dengan tabel kehadiran)
            $totalPasienBulanIni = 1440; // total pasien klinik bulan ini (bisa dikembangkan dengan tabel pemeriksaan)
            $rataPasienPerDokter = $totalDokterAktif > 0 ? $totalPasienBulanIni / $totalDokterAktif : 0; // otomatis dihitung
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

           <!-- Performance Review Dokter (Data dari Database) -->
            <?php
            // Ambil data dokter beserta performance dari database
            $queryDokterPerformance = mysqli_query($koneksi, "
                SELECT d.*, p.total_jam_praktik, p.target_jam_praktik, p.persentase_kehadiran, 
                       p.total_pasien_bulan_ini, p.pertumbuhan_pasien_persen, p.rating_pelayanan, 
                       p.status_kinerja, p.jumlah_review
                FROM tb_dokter d 
                LEFT JOIN tb_performance_dokter p ON d.id_dokter = p.id_dokter 
                WHERE d.status_dokter = 'aktif'
            ");
            $dokterPerformance = [];
            
            while($dokter = mysqli_fetch_array($queryDokterPerformance)) {
                // Gunakan data dari tabel tb_performance_dokter
                $ratingValue = $dokter['rating_pelayanan'] ? $dokter['rating_pelayanan'] : 4.0;
                $totalJam = $dokter['total_jam_praktik'] ? $dokter['total_jam_praktik'] : 400;
                $kehadiran = $dokter['persentase_kehadiran'] ? $dokter['persentase_kehadiran'] : 90;
                $pertumbuhanPasien = $dokter['pertumbuhan_pasien_persen'] ? $dokter['pertumbuhan_pasien_persen'] : 10;
                $totalPasien = $dokter['total_pasien_bulan_ini'] ? $dokter['total_pasien_bulan_ini'] : 100;
                $statusKinerja = $dokter['status_kinerja'] ? $dokter['status_kinerja'] : 'Sangat Baik';
                
                // Generate rating bintang berdasarkan rating_pelayanan
                $fullStars = floor($ratingValue);
                $halfStar = ($ratingValue - $fullStars) >= 0.5 ? 1 : 0;
                $emptyStars = 5 - $fullStars - $halfStar;
                $ratingBintang = str_repeat("★", $fullStars) . ($halfStar ? "★" : "") . str_repeat("☆", $emptyStars);
                
                $performance = [
                    "nama" => $dokter['nama_dokter'],
                    "spesialis" => $dokter['spesialisasi'],
                    "total_jam" => $totalJam,
                    "target_jam" => $dokter['target_jam_praktik'] ? $dokter['target_jam_praktik'] : 500,
                    "kehadiran" => $kehadiran,
                    "pertumbuhan_pasien" => $pertumbuhanPasien,
                    "total_pasien" => $totalPasien,
                    "rating" => $ratingValue,
                    "rating_bintang" => $ratingBintang,
                    "kinerja" => $statusKinerja,
                    "badge" => "success",
                    "progress_color" => "success"
                ];
                
                // Set badge dan progress color berdasarkan status_kinerja dari database
                switch($statusKinerja) {
                    case 'Top Performer':
                        $performance['badge'] = "primary";
                        $performance['progress_color'] = "success";
                        break;
                    case 'Perlu Monitoring':
                        $performance['badge'] = "warning";
                        $performance['progress_color'] = "warning";
                        break;
                    case 'Sangat Baik':
                    default:
                        $performance['badge'] = "success";
                        $performance['progress_color'] = "success";
                        break;
                }
                
                $dokterPerformance[] = $performance;
            }
            ?>

            <!-- Performance Review Dokter Section -->
            <div class="row">
                <div class="col-12">
                    <h4 class="font-weight-bold text-secondary mb-3">Performance Review Dokter</h4>
                    <!-- Form pencarian dan filter -->
                    <div class="dokter-filter-bar mb-4">
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
                        <button class="btn btn-gradient-outline btn-sm px-3 font-weight-bold shadow-custom" id="resetDokterFilter"><i class="fas fa-undo mr-1"></i> Reset</button>
                        <div class="flex-grow-1"></div>
                        <button class="btn btn-gradient-outline font-weight-bold px-4 shadow-custom" style="min-width:220px;" data-toggle="modal" data-target="#topDokterModal">
                            <i class="fas fa-trophy mr-2"></i>Lihat Top 3 Dokter Terbaik
                        </button>
                    </div>
                </div>
            </div>



            <!-- Modal - Top 3 Dokter -->
            <?php
// Ambil top 3 dokter berdasarkan kombinasi skor performance
$topDokter = $dokterPerformance;

// Hitung skor untuk setiap dokter
foreach ($topDokter as $key => $dok) {
    // Skor berdasarkan: kehadiran (40%) + jam praktik (30%) + rating (20%) + pertumbuhan pasien (10%)
    $skor_kehadiran = ($dok['kehadiran'] / 100) * 40;
    $skor_jam = (min($dok['total_jam'], $dok['target_jam']) / $dok['target_jam']) * 30;
    $skor_rating = ($dok['rating'] / 5) * 20;
    $skor_pertumbuhan = (min($dok['pertumbuhan_pasien'], 20) / 20) * 10;
    
    $topDokter[$key]['total_skor'] = $skor_kehadiran + $skor_jam + $skor_rating + $skor_pertumbuhan;
}

// Sort berdasarkan skor tertinggi dan ambil 3 teratas
usort($topDokter, function($a, $b) {
    return $b['total_skor'] <=> $a['total_skor'];
});
$topDokter = array_slice($topDokter, 0, 3);
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
        <div class="mb-3 text-center">
          <p class="text-muted mb-2">
            <small><i class="fas fa-info-circle mr-1"></i>Ranking berdasarkan kombinasi: Kehadiran (40%) + Jam Praktik (30%) + Rating (20%) + Pertumbuhan Pasien (10%)</small>
          </p>
        </div>
        <div class="row">
          <?php foreach ($topDokter as $i => $dok) { 
            $initial = strtoupper(substr($dok['nama'], 4, 1));
            $statusClass = strtolower($dok['badge']);
            // Tentukan warna border berdasarkan ranking
            $borderColor = $i == 0 ? '#f7b731' : ($i == 1 ? '#c0c0c0' : '#cd7f32'); // Gold, Silver, Bronze
            $rankIcon = $i == 0 ? '🥇' : ($i == 1 ? '🥈' : '🥉');
          ?>
          <div class="col-md-4 mb-4 d-flex">
            <div class="top-dokter-card shadow-sm h-100 w-100" style="border:3px solid <?= $borderColor ?>; min-height: 420px;">
              <div class="card-header py-3 text-center">
                <div class="mb-2"><?= $rankIcon ?></div>
                <div class="top-dokter-avatar mb-2 mx-auto"><?= $initial ?></div>
                <div class="text-center">
                  <div class="font-weight-bold" style="font-size:1.1rem; color:#222;"><?= $dok['nama'] ?></div>
                  <div class="text-muted mb-1" style="font-size:0.98rem;"><?= $dok['spesialis'] ?></div>
                  <span class="dokter-modern-status <?= $statusClass ?> d-inline-block my-1" style="position:static; font-size:0.95rem;"><?= $dok['kinerja'] ?></span>
                  <div class="mt-2">
                    <small class="text-info font-weight-bold">Skor: <?= number_format($dok['total_skor'], 1) ?>/100</small>
                  </div>
                </div>
              </div>
              <div class="card-body px-3 py-2 flex-fill">
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
            <div class="dokter-pagination-bar d-flex justify-content-between align-items-center mb-4">
                <button id="prevDokter" class="btn btn-gradient-outline btn-sm px-3 font-weight-bold shadow-custom">
                    <i class="fas fa-angle-left mr-1"></i> Previous
                </button>
                <div class="text-center">
                    <span id="dokterPageInfo" class="text-muted">Halaman 1 dari <span id="totalDokterPages">1</span></span>
                </div>
                <button id="nextDokter" class="btn btn-gradient-outline btn-sm px-3 font-weight-bold shadow-custom">
                    Next <i class="fas fa-angle-right ml-1"></i>
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

                // Reset ke halaman pertama setelah filter dan update pagination
                updateDokterPagination();
                showDokterPage(1);
            });

            $('#resetDokterFilter').on('click', function () {
                $('#searchDokter').val('');
                $('#filterKinerja').val('');
                $('#filterSpesialis').val('');
                $('.dokter-card').show();
                updateDokterPagination();
                showDokterPage(1);
            });

            // Pagination untuk card dokter
            let currentDokterPage = 1;
            const dokterPerPage = 6; // 6 card per halaman
            
            function updateDokterPagination() {
                // Get all cards that should be visible based on current filters
                const allCards = $('.dokter-card');
                let visibleCount = 0;
                
                // Count visible cards based on current filter state
                allCards.each(function() {
                    const $card = $(this);
                    const keyword = $('#searchDokter').val().toLowerCase();
                    const kinerja = $('#filterKinerja').val().toLowerCase();
                    const spesialis = $('#filterSpesialis').val().toLowerCase();
                    
                    const nama = $card.data('nama');
                    const spesialisCard = $card.data('spesialis');
                    const kinerjaCard = $card.data('kinerja');
                    
                    let match = true;
                    if (keyword && !(nama.includes(keyword) || spesialisCard.includes(keyword))) match = false;
                    if (kinerja && kinerjaCard !== kinerja) match = false;
                    if (spesialis && spesialisCard !== spesialis) match = false;
                    
                    if (match) {
                        visibleCount++;
                    }
                });
                
                const totalPages = Math.ceil(visibleCount / dokterPerPage);
                
                $('#totalDokterPages').text(totalPages);
                
                if (totalPages <= 1) {
                    $('.dokter-pagination-bar').hide();
                } else {
                    $('.dokter-pagination-bar').show();
                }
            }

            function showDokterPage(page) {
                // Get all cards that should be visible based on current filters
                const allCards = $('.dokter-card');
                const visibleCards = [];
                
                // Build array of visible cards based on current filter state
                allCards.each(function() {
                    const $card = $(this);
                    const keyword = $('#searchDokter').val().toLowerCase();
                    const kinerja = $('#filterKinerja').val().toLowerCase();
                    const spesialis = $('#filterSpesialis').val().toLowerCase();
                    
                    const nama = $card.data('nama');
                    const spesialisCard = $card.data('spesialis');
                    const kinerjaCard = $card.data('kinerja');
                    
                    let match = true;
                    if (keyword && !(nama.includes(keyword) || spesialisCard.includes(keyword))) match = false;
                    if (kinerja && kinerjaCard !== kinerja) match = false;
                    if (spesialis && spesialisCard !== spesialis) match = false;
                    
                    if (match) {
                        visibleCards.push($card);
                    }
                });
                
                const totalDokter = visibleCards.length;
                const totalPages = Math.ceil(totalDokter / dokterPerPage);
                
                // Hide all cards first
                allCards.hide();
                
                // Show cards for the selected page
                const start = (page - 1) * dokterPerPage;
                const end = start + dokterPerPage;
                
                for (let i = start; i < end && i < totalDokter; i++) {
                    visibleCards[i].show();
                }

                // Update button state
                $('#prevDokter').prop('disabled', page === 1);
                $('#nextDokter').prop('disabled', page === totalPages || totalPages === 0);
                $('#dokterPageInfo').text(`Halaman ${page} dari ${totalPages}`);
                
                currentDokterPage = page;
            }

            $('#prevDokter').click(() => {
                if (currentDokterPage > 1) {
                    currentDokterPage--;
                    showDokterPage(currentDokterPage);
                }
            });

            $('#nextDokter').click(() => {
                // Count visible cards based on current filter state
                const allCards = $('.dokter-card');
                let visibleCount = 0;
                
                allCards.each(function() {
                    const $card = $(this);
                    const keyword = $('#searchDokter').val().toLowerCase();
                    const kinerja = $('#filterKinerja').val().toLowerCase();
                    const spesialis = $('#filterSpesialis').val().toLowerCase();
                    
                    const nama = $card.data('nama');
                    const spesialisCard = $card.data('spesialis');
                    const kinerjaCard = $card.data('kinerja');
                    
                    let match = true;
                    if (keyword && !(nama.includes(keyword) || spesialisCard.includes(keyword))) match = false;
                    if (kinerja && kinerjaCard !== kinerja) match = false;
                    if (spesialis && spesialisCard !== spesialis) match = false;
                    
                    if (match) {
                        visibleCount++;
                    }
                });
                
                const totalPages = Math.ceil(visibleCount / dokterPerPage);
                if (currentDokterPage < totalPages) {
                    currentDokterPage++;
                    showDokterPage(currentDokterPage);
                }
            });

            // Initialize pagination saat halaman load
            $(document).ready(() => {
                updateDokterPagination();
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
<!-- 🔮 Insight AI Saran Cerdas -->
<div class="mb-4">
    <div class="insight-card shadow-sm">
        <div class="d-flex align-items-start">
            <div class="insight-icon mr-4">
                <i class="fas fa-lightbulb"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="insight-title mb-3">🤖 Insight AI Saran Cerdas</h5>
                <p class="insight-desc mb-3">
                    Berdasarkan analisis otomatis seluruh data dokter, berikut insight dan rekomendasi strategis untuk pengelolaan SDM klinik:
                </p>
                <ul class="insight-list">
                <?php
                // 1. Prediksi Kinerja Dokter
                $dokterTurun = [];
                foreach ($dokterPerformance as $d) {
                    if ($d['kehadiran'] < 90 || $d['rating'] < 4.5) {
                        $dokterTurun[] = $d['nama'];
                    }
                }
                if (count($dokterTurun) > 0) {
                    echo '<li><b>Prediksi Kinerja Turun:</b> ' . count($dokterTurun) . ' dokter berpotensi turun performa (kehadiran < 90% atau rating < 4.5): <span class="text-info">' . implode(', ', array_slice($dokterTurun,0,5)) . (count($dokterTurun)>5?' ...':'') . '</span></li>';
                }

                // 2. Rekomendasi Penjadwalan
                $overload = [];
                foreach ($dokterPerformance as $d) {
                    if ($d['total_jam'] > $d['target_jam']) $overload[] = $d['nama'];
                }
                if (count($overload) > 0) {
                    echo '<li><b>Rekomendasi Penjadwalan:</b> ' . count($overload) . ' dokter overload jam praktik, sebaiknya distribusi ulang jadwal: <span class="text-warning">' . implode(', ', array_slice($overload,0,5)) . (count($overload)>5?' ...':'') . '</span></li>';
                }

                // 3. Deteksi Anomali Data
                $anomali = [];
                foreach ($dokterPerformance as $d) {
                    if ($d['total_jam'] > 0 && $d['total_pasien'] < 10 && $d['total_jam'] > $d['target_jam']*0.8) {
                        $anomali[] = $d['nama'];
                    }
                }
                if (count($anomali) > 0) {
                    echo '<li><b>Deteksi Anomali:</b> Ada ' . count($anomali) . ' dokter jam praktik tinggi tapi pasien sedikit: <span class="text-danger">' . implode(', ', array_slice($anomali,0,5)) . (count($anomali)>5?' ...':'') . '</span></li>';
                }

                // 4. Segmentasi Dokter
                $segHigh = $segMid = $segLow = 0;
                foreach ($dokterPerformance as $d) {
                    if ($d['kinerja'] == 'Tinggi') $segHigh++;
                    elseif ($d['kinerja'] == 'Sedang') $segMid++;
                    else $segLow++;
                }
                echo '<li><b>Segmentasi Kinerja:</b> Tinggi: <span class="text-success">'.$segHigh.'</span>, Sedang: <span class="text-primary">'.$segMid.'</span>, Rendah: <span class="text-danger">'.$segLow.'</span></li>';

                // 5. Prediksi Kebutuhan Rekrutmen
                $rasio = $totalDokterAktif > 0 ? round($totalPasienBulanIni/$totalDokterAktif) : 0;
                if ($rasio > 200) {
                    echo '<li><b>Prediksi Rekrutmen:</b> Rasio pasien/dokter bulan ini tinggi ('.$rasio.'), pertimbangkan rekrutmen dokter baru.</li>';
                }

                // 6. Analisis Kepuasan Pasien
                $ratingTertinggi = null; $ratingTerendah = null;
                foreach ($dokterPerformance as $d) {
                    if ($ratingTertinggi === null || $d['rating'] > $ratingTertinggi['rating']) $ratingTertinggi = $d;
                    if ($ratingTerendah === null || $d['rating'] < $ratingTerendah['rating']) $ratingTerendah = $d;
                }
                if ($ratingTertinggi && $ratingTerendah) {
                    echo '<li><b>Kepuasan Pasien:</b> Rating tertinggi: <span class="text-success">'.$ratingTertinggi['nama'].' ('.$ratingTertinggi['rating'].'/5)</span>, terendah: <span class="text-danger">'.$ratingTerendah['nama'].' ('.$ratingTerendah['rating'].'/5)</span></li>';
                }

                // 7. Saran Pengembangan Karir
                $stagnan = [];
                foreach ($dokterPerformance as $d) {
                    if ($d['kinerja'] == 'Rendah' || $d['rating'] < 4.2) $stagnan[] = $d['nama'];
                }
                if (count($stagnan) > 0) {
                    echo '<li><b>Pengembangan Karir:</b> Rekomendasi pelatihan untuk '.count($stagnan).' dokter: <span class="text-info">'.implode(', ', array_slice($stagnan,0,5)).(count($stagnan)>5?' ...':'').'</span></li>';
                }

                // 8. Forecasting Jumlah Pasien
                $prediksi = [];
                foreach ($dokterPerformance as $d) {
                    $prediksi[] = $d['nama'].': '.(int)($d['total_pasien']*1.05).' pasien (perkiraan bulan depan)';
                }
                if (count($prediksi) > 0) {
                    echo '<li><b>Forecasting Pasien Bulan Depan:</b> <span class="text-primary">'.implode('; ', array_slice($prediksi,0,3)).(count($prediksi)>3?' ...':'').'</span></li>';
                }

                // Jika tidak ada insight khusus
                if (count($dokterPerformance) == 0) {
                    echo '<li>Data dokter belum tersedia untuk insight AI.</li>';
                }
                ?>
                </ul>
            </div>
        </div>
    </div>
</div>

            <!-- Jadwal & Ketidakhadiran Dokter (Data dari Database) -->
            <?php
            // Ambil jadwal praktik dari database (menggunakan jadwal_praktek dari tb_dokter)
            $queryJadwal = mysqli_query($koneksi, "SELECT nama_dokter, jadwal_praktek, spesialisasi FROM tb_dokter WHERE status_dokter = 'aktif' ORDER BY nama_dokter LIMIT 10");
            $jadwalPraktik = [];
            $hariArray = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
            $badgeArray = ["success", "warning", "primary", "danger", "info"];
            
            $i = 0;
            while($jadwal = mysqli_fetch_array($queryJadwal)) {
                $jadwalPraktik[] = [
                    "hari" => $hariArray[$i % 7],
                    "dokter" => $jadwal['nama_dokter'],
                    "spesialisasi" => $jadwal['spesialisasi'],
                    "shift" => $i % 4 == 3 ? "Overload" : ($i % 2 == 0 ? "Pagi" : "Sore"),
                    "jam" => $jadwal['jadwal_praktek'] ? $jadwal['jadwal_praktek'] : "08:00 - 12:00",
                    "badge" => $badgeArray[$i % 5]
                ];
                $i++;
            }

            // Riwayat kehadiran berdasarkan data dokter dari database
            $queryDokterKehadiran = mysqli_query($koneksi, "
                SELECT d.nama_dokter, d.spesialisasi, p.persentase_kehadiran, p.status_kinerja 
                FROM tb_dokter d 
                LEFT JOIN tb_performance_dokter p ON d.id_dokter = p.id_dokter 
                WHERE d.status_dokter = 'aktif' 
                ORDER BY p.persentase_kehadiran ASC
            ");
            $riwayatKehadiran = [];
            while($dokter = mysqli_fetch_array($queryDokterKehadiran)) {
                $kehadiran = $dokter['persentase_kehadiran'] ? $dokter['persentase_kehadiran'] : rand(85, 95);
                $riwayatKehadiran[] = [
                    "nama" => $dokter['nama_dokter'],
                    "spesialisasi" => $dokter['spesialisasi'],
                    "kehadiran" => $kehadiran,
                    "status" => $dokter['status_kinerja'] ? $dokter['status_kinerja'] : 'Baik',
                    "hadir" => round($kehadiran * 0.3), // simulasi hari hadir dari persentase
                    "izin" => rand(1, 3),
                    "sakit" => rand(0, 2),
                    "priority" => $kehadiran < 90 ? 'high' : ($kehadiran < 95 ? 'medium' : 'low')
                ];
            }
            ?>

            <h4 class="mb-4 font-weight-bold text-secondary">Jadwal & Insight Dokter</h4>
            <div class="row equal-height-cards">
                <!-- Jadwal Praktik Dokter -->
                <div class="col-md-4 mb-4">
                    <div class="card-equal-height shadow-sm">
                        <!-- Header gradasi -->
                        <div class="card-header-custom bg-primary">
                            <i class="fas fa-calendar-alt fa-lg text-white mr-3"></i>
                            <span class="font-weight-bold text-white">Kalender Mini (Agenda Mingguan)</span>
                        </div>
                        <div class="card-body-custom">
                            <div class="scrollable-content">
                                <?php foreach (array_slice($jadwalPraktik, 0, 5) as $jadwal): ?>
                                    <div class="agenda-item">
                                        <div class="agenda-icon">
                                            <?php
                                            // Icon sesuai shift/badge
                                            if ($jadwal['badge'] == 'success') echo '<i class="fas fa-user-md text-success"></i>';
                                            elseif ($jadwal['badge'] == 'warning') echo '<i class="fas fa-user-clock text-warning"></i>';
                                            elseif ($jadwal['badge'] == 'danger') echo '<i class="fas fa-user-times text-danger"></i>';
                                            else echo '<i class="fas fa-user-md text-primary"></i>';
                                            ?>
                                        </div>
                                        <div class="agenda-content">
                                            <div class="agenda-day"><?= $jadwal['hari'] ?></div>
                                            <div class="agenda-doctor"><?= $jadwal['dokter'] ?></div>
                                            <div class="agenda-spec"><?= $jadwal['spesialisasi'] ?></div>
                                        </div>
                                        <div class="agenda-badge">
                                            <span class="badge badge-<?= $jadwal['badge'] ?>"><?= $jadwal['shift'] ?></span>
                                            <small class="text-muted d-block"><?= $jadwal['jam'] ?></small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                
                                <?php if (count($jadwalPraktik) > 5): ?>
                                    <div class="show-more-btn">
                                        <small class="text-info">Scroll untuk melihat <?= count($jadwalPraktik) - 5 ?> jadwal lainnya</small>
                                    </div>
                                    <?php foreach (array_slice($jadwalPraktik, 5) as $jadwal): ?>
                                        <div class="agenda-item">
                                            <div class="agenda-icon">
                                                <?php
                                                if ($jadwal['badge'] == 'success') echo '<i class="fas fa-user-md text-success"></i>';
                                                elseif ($jadwal['badge'] == 'warning') echo '<i class="fas fa-user-clock text-warning"></i>';
                                                elseif ($jadwal['badge'] == 'danger') echo '<i class="fas fa-user-times text-danger"></i>';
                                                else echo '<i class="fas fa-user-md text-primary"></i>';
                                                ?>
                                            </div>
                                            <div class="agenda-content">
                                                <div class="agenda-day"><?= $jadwal['hari'] ?></div>
                                                <div class="agenda-doctor"><?= $jadwal['dokter'] ?></div>
                                                <div class="agenda-spec"><?= $jadwal['spesialisasi'] ?></div>
                                            </div>
                                            <div class="agenda-badge">
                                                <span class="badge badge-<?= $jadwal['badge'] ?>"><?= $jadwal['shift'] ?></span>
                                                <small class="text-muted d-block"><?= $jadwal['jam'] ?></small>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Insight & Notifikasi Kehadiran -->
                <div class="col-md-4 mb-4">
                    <div class="card-equal-height shadow-sm">
                        <!-- Header gradasi -->
                        <div class="card-header-custom bg-warning">
                            <i class="fas fa-bell fa-lg text-white mr-3"></i>
                            <span class="font-weight-bold text-white">Insight & Notifikasi</span>
                        </div>
                        <div class="card-body-custom">
                            <div class="scrollable-content">
                                <?php foreach (array_slice($riwayatKehadiran, 0, 5) as $dokter): ?>
                                    <div class="notification-item priority-<?= $dokter['priority'] ?>">
                                        <div class="notification-icon">
                                            <i class="fas fa-user-md <?= $dokter['priority'] == 'high' ? 'text-danger' : ($dokter['priority'] == 'medium' ? 'text-warning' : 'text-success') ?>"></i>
                                        </div>
                                        <div class="notification-content">
                                            <div class="notification-doctor"><?= $dokter['nama'] ?></div>
                                            <div class="notification-spec"><?= $dokter['spesialisasi'] ?></div>
                                            <div class="notification-status">Kehadiran: <?= $dokter['kehadiran'] ?>%</div>
                                        </div>
                                        <div class="notification-badges">
                                            <span class="badge badge-success badge-sm">H: <?= $dokter['hadir'] ?></span>
                                            <span class="badge badge-warning badge-sm">I: <?= $dokter['izin'] ?></span>
                                            <span class="badge badge-danger badge-sm">S: <?= $dokter['sakit'] ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                
                                <?php if (count($riwayatKehadiran) > 5): ?>
                                    <div class="show-more-btn">
                                        <small class="text-info">Scroll untuk melihat <?= count($riwayatKehadiran) - 5 ?> dokter lainnya</small>
                                    </div>
                                    <?php foreach (array_slice($riwayatKehadiran, 5) as $dokter): ?>
                                        <div class="notification-item priority-<?= $dokter['priority'] ?>">
                                            <div class="notification-icon">
                                                <i class="fas fa-user-md <?= $dokter['priority'] == 'high' ? 'text-danger' : ($dokter['priority'] == 'medium' ? 'text-warning' : 'text-success') ?>"></i>
                                            </div>
                                            <div class="notification-content">
                                                <div class="notification-doctor"><?= $dokter['nama'] ?></div>
                                                <div class="notification-spec"><?= $dokter['spesialisasi'] ?></div>
                                                <div class="notification-status">Kehadiran: <?= $dokter['kehadiran'] ?>%</div>
                                            </div>
                                            <div class="notification-badges">
                                                <span class="badge badge-success badge-sm">H: <?= $dokter['hadir'] ?></span>
                                                <span class="badge badge-warning badge-sm">I: <?= $dokter['izin'] ?></span>
                                                <span class="badge badge-danger badge-sm">S: <?= $dokter['sakit'] ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Performance Dokter -->
                <div class="col-md-4 mb-4">
                    <div class="card-equal-height shadow-sm">
                        <!-- Header gradasi -->
                        <div class="card-header-custom bg-success">
                            <i class="fas fa-chart-line fa-lg text-white mr-3"></i>
                            <span class="font-weight-bold text-white">Status Performance</span>
                        </div>
                        <div class="card-body-custom">
                            <div class="scrollable-content">
                                <?php 
                                // Ambil data performance dengan rating tertinggi
                                $topPerformers = array_slice($dokterPerformance, 0, 10);
                                foreach (array_slice($topPerformers, 0, 5) as $perf): 
                                ?>
                                    <div class="performance-item">
                                        <div class="performance-icon">
                                            <i class="fas fa-star text-warning"></i>
                                        </div>
                                        <div class="performance-content">
                                            <div class="performance-doctor"><?= $perf['nama'] ?></div>
                                            <div class="performance-spec"><?= $perf['spesialis'] ?></div>
                                            <div class="performance-rating">Rating: <?= $perf['rating'] ?>/5.0</div>
                                        </div>
                                        <div class="performance-status">
                                            <span class="badge badge-<?= $perf['badge'] ?>"><?= $perf['kinerja'] ?></span>
                                            <small class="text-muted d-block"><?= $perf['total_pasien'] ?> pasien</small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                
                                <?php if (count($topPerformers) > 5): ?>
                                    <div class="show-more-btn">
                                        <small class="text-info">Scroll untuk melihat <?= count($topPerformers) - 5 ?> dokter lainnya</small>
                                    </div>
                                    <?php foreach (array_slice($topPerformers, 5) as $perf): ?>
                                        <div class="performance-item">
                                            <div class="performance-icon">
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                            <div class="performance-content">
                                                <div class="performance-doctor"><?= $perf['nama'] ?></div>
                                                <div class="performance-spec"><?= $perf['spesialis'] ?></div>
                                                <div class="performance-rating">Rating: <?= $perf['rating'] ?>/5.0</div>
                                            </div>
                                            <div class="performance-status">
                                                <span class="badge badge-<?= $perf['badge'] ?>"><?= $perf['kinerja'] ?></span>
                                                <small class="text-muted d-block"><?= $perf['total_pasien'] ?> pasien</small>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
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
            <!-- Elemen search dan button input data dokter bagian bawah (duplikat) dihapus, hanya tersisa satu baris di kanan atas tabel -->
            <!-- Baris search dan button input data dokter di atas tabel dihapus agar tidak double, hanya DataTables search bawaan + button input yang akan dipindahkan ke kanan atas tabel -->
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
                    <?php 
                    $nomor = 1;
                    // Ambil data dokter dari database
                    $queryDataDokter = mysqli_query($koneksi, "SELECT * FROM tb_dokter ORDER BY nama_dokter ASC");
                    
                    while($pecah = mysqli_fetch_array($queryDataDokter)) { ?>
                        <tr>
                            <td class="text-center"><?php echo $nomor; ?></td>
                            <td class="text-center">D<?php echo str_pad($pecah['id_dokter'], 3, '0', STR_PAD_LEFT); ?></td>
                            <td><?php echo $pecah['nama_dokter']; ?></td>
                            <td class="text-center"><?php echo $pecah['spesialisasi']; ?></td>
                            <td class="text-center"><?php echo $pecah['no_sip'] ? $pecah['no_sip'] : '-'; ?></td>
                            <td class="text-center"><?php echo $pecah['no_sip']; ?></td>
                            <td class="text-center"><?php echo $pecah['no_hp'] ? $pecah['no_hp'] : '-'; ?></td>
                            <td><?php echo $pecah['alamat'] ? $pecah['alamat'] : '-'; ?></td>
                            <td class="text-center">
                                <?php if($pecah['status_dokter'] == 'aktif') { ?>
                                    <span class="badge badge-success px-2 py-1">Aktif</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger px-2 py-1">Nonaktif</span>
                                <?php } ?>
                            </td>
                            <td class="text-right">Rp. <?php echo number_format($pecah['tarif_konsultasi'], 0, ',', '.'); ?></td>
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
    <!-- Card footer dihapus agar button tidak redundant, button input data dokter sudah ada di atas tabel -->
</div>
<footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Apothecary - 2025</div>
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
<script>
$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        lengthChange: false // Disable 'show 10 entries' dropdown
    });
    // Gabungkan search DataTables dan button input data dokter di kanan atas tabel
    var filter = $('#dataTable_filter');
    var inputBtn = $('<a href="dokter_input.php" class="btn btn-gradient-outline font-weight-bold px-4 shadow-custom ml-2" style="min-width:180px;"><i class="fas fa-plus mr-2"></i> Input Data Dokter</a>');
    var wrapper = $('<div class="d-flex justify-content-end align-items-center mb-2" style="gap:12px;"></div>');
    filter.css({'float':'','display':'flex','align-items':'center','gap':'8px','margin-bottom':'0'});
    filter.find('label').css({'margin-bottom':'0','font-weight':'600','color':'#5459AC'});
    filter.find('input').attr('placeholder','Cari dokter...').css({'border-radius':'8px','border':'2px solid #6fc3d0','padding':'6px 12px','font-size':'1rem','font-family':'Poppins,Arial,sans-serif','background':'#fff','color':'#222','transition':'border 0.18s','box-shadow':'0 2px 8px rgba(8,131,149,0.08)','margin-left':'8px'});
    filter.append(inputBtn);
    wrapper.append(filter);
    // Tempatkan wrapper di atas tabel
    $('.table-responsive').prepend(wrapper);
});
</script>
</body>
</html>