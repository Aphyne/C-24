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
    <title>Apothecary | Data Master - Obat</title>
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

/* ==== Insight Card Obat ==== */
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

/* === TABEL OBAT MODERN === */
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

/* Monitoring Cards */
.monitoring-card {
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(84,89,172,0.10);
    border: none;
    transition: box-shadow 0.18s;
}
.monitoring-card:hover {
    box-shadow: 0 8px 32px rgba(8,131,149,0.13);
}
.monitoring-card .card-header {
    border-radius: 16px 16px 0 0;
    font-weight: 600;
    font-size: 1.1rem;
    letter-spacing: 0.2px;
}
.monitoring-card .list-group-item {
    border: none;
    padding: 12px 20px;
    font-family: 'Poppins', Arial, sans-serif;
}
.monitoring-card .badge {
    font-size: 0.9rem;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
}

/* Inventory Management Header */
.inventory-management-header {
    background: #f8f9fa;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 2px 12px rgba(84,89,172,0.06);
}

.inventory-title {
    color: #2c3e50;
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 8px;
    font-family: 'Poppins', Arial, sans-serif;
}

.inventory-subtitle {
    color: #6c757d;
    font-size: 1rem;
    margin-bottom: 24px;
    font-family: 'Poppins', Arial, sans-serif;
}

.inventory-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .inventory-controls {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }
    
    .inventory-search-container {
        max-width: 100%;
        order: 1;
    }
    
    .inventory-filter-tabs {
        order: 2;
        justify-content: center;
        margin: 8px 0;
    }
    
    .inventory-actions {
        order: 3;
        justify-content: center;
    }
    
    .inventory-management-header {
        padding: 16px;
        margin-bottom: 16px;
    }
    
    .inventory-title {
        font-size: 1.5rem;
        text-align: center;
    }
    
    .inventory-subtitle {
        text-align: center;
        margin-bottom: 16px;
    }
}

.inventory-search-container {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.inventory-search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1.1rem;
}

.inventory-search-input {
    width: 100%;
    padding: 12px 16px 12px 48px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 1rem;
    font-family: 'Poppins', Arial, sans-serif;
    transition: all 0.3s ease;
    background: #fff;
}

.inventory-search-input:focus {
    border-color: #5459AC;
    box-shadow: 0 0 0 0.2rem rgba(84,89,172,0.25);
    outline: none;
}

.inventory-filter-tabs {
    display: flex;
    gap: 8px;
    align-items: center;
}

.filter-tab {
    padding: 8px 16px;
    border: 2px solid #e9ecef;
    border-radius: 20px;
    background: #fff;
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
    font-family: 'Poppins', Arial, sans-serif;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.filter-tab:hover {
    border-color: #5459AC;
    color: #5459AC;
    text-decoration: none;
}

.filter-tab.active {
    background: #5459AC;
    border-color: #5459AC;
    color: #fff;
}

.inventory-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

.add-medicine-btn {
    background: #17a2b8;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    font-family: 'Poppins', Arial, sans-serif;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.add-medicine-btn:hover {
    background: #138496;
    color: #fff;
    text-decoration: none;
    transform: translateY(-1px);
}

.filter-btn {
    background: #fff;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 10px 12px;
    color: #6c757d;
    transition: all 0.3s ease;
    cursor: pointer;
}

.filter-btn:hover {
    border-color: #5459AC;
    color: #5459AC;
}

/* Medicine Categories Styles */
.category-scroll-container {
    overflow-x: auto;
    padding: 10px 0;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: rgba(84,89,172,0.3) transparent;
}

.category-scroll-container::-webkit-scrollbar {
    height: 6px;
}

.category-scroll-container::-webkit-scrollbar-track {
    background: transparent;
}

.category-scroll-container::-webkit-scrollbar-thumb {
    background: rgba(84,89,172,0.3);
    border-radius: 3px;
}

.category-scroll-container::-webkit-scrollbar-thumb:hover {
    background: rgba(84,89,172,0.5);
}

.category-cards-wrapper {
    display: flex;
    gap: 20px;
    padding: 0 5px;
    min-width: fit-content;
}

.category-card-item {
    flex: 0 0 auto;
    width: 200px;
}

.category-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px 20px;
    text-align: center;
    box-shadow: 0 4px 18px rgba(84,89,172,0.08);
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid transparent;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 32px rgba(84,89,172,0.15);
    border-color: rgba(84,89,172,0.2);
}

.category-icon-wrapper {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    transition: transform 0.3s ease;
}

.category-card:hover .category-icon-wrapper {
    transform: scale(1.1);
}

.category-icon-wrapper i {
    font-size: 2.5rem;
    transition: all 0.3s ease;
}

.category-info {
    width: 100%;
}

.category-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 8px;
    font-family: 'Poppins', Arial, sans-serif;
    line-height: 1.2;
}

.category-count {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0;
    font-weight: 500;
    font-family: 'Poppins', Arial, sans-serif;
}

/* Modern Inventory Card Styles */
.modern-inventory-card {
    border-radius: 16px;
    border: none;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(84,89,172,0.10);
    transition: box-shadow 0.18s;
}

.modern-inventory-card:hover {
    box-shadow: 0 8px 32px rgba(8,131,149,0.13);
}

.modern-card-header {
    background: linear-gradient(90deg, #5459AC 80%, #6fc3d0 100%);
    color: #fff;
    border: none;
    padding: 16px 20px;
    font-size: 1.1rem;
}

.modern-card-header-danger {
    background: linear-gradient(90deg, #e74c3c 80%, #ff6b6b 100%);
    color: #fff;
    border: none;
    padding: 16px 20px;
    font-size: 1.1rem;
}

.scrollable-container {
    max-height: 400px;
    overflow-y: auto;
}

/* Responsive adjustments for scrollable containers */
@media (max-width: 992px) {
    .scrollable-container {
        max-height: 350px;
    }
}

@media (max-width: 768px) {
    .scrollable-container {
        max-height: 300px;
    }
    
    .modern-inventory-card {
        margin-bottom: 16px;
    }
    
    .inventory-item {
        padding: 12px 16px;
    }
}

.scrollable-container::-webkit-scrollbar {
    width: 6px;
}

.scrollable-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.scrollable-container::-webkit-scrollbar-thumb {
    background: #5459AC;
    border-radius: 10px;
}

.scrollable-container::-webkit-scrollbar-thumb:hover {
    background: #6fc3d0;
}

.inventory-item {
    padding: 16px 20px;
    transition: background 0.18s;
}

.inventory-item:hover {
    background: rgba(111,195,208,0.08);
}

.inventory-rank {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

.rank-number {
    color: #fff;
    font-weight: 700;
    font-size: 0.9rem;
}

.medicine-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 1.2rem;
}

.inventory-details {
    min-width: 0;
}

.inventory-name {
    font-weight: 600;
    color: #222;
    font-size: 1rem;
    margin-bottom: 4px;
    font-family: 'Poppins', Arial, sans-serif;
}

.inventory-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.category-badge {
    background: rgba(84,89,172,0.1);
    color: #5459AC;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.sku-text {
    color: #6c757d;
    font-size: 0.8rem;
}

.inventory-stats {
    min-width: 80px;
}

.sales-count {
    margin-bottom: 4px;
}

.count-number {
    font-weight: 700;
    color: #222;
    font-size: 1.1rem;
}

.count-unit {
    color: #6c757d;
    font-size: 0.85rem;
    margin-left: 2px;
}

.trend-indicator {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 4px;
}

.trend-text {
    font-size: 0.8rem;
    font-weight: 600;
}

.inventory-status {
    min-width: 120px;
}

.status-badge {
    background: #fff;
    border-radius: 8px;
    padding: 6px 10px;
    margin-bottom: 8px;
    text-align: center;
}

.status-critical {
    border: 2px solid #e74c3c;
    background: rgba(231,76,60,0.05);
}

.status-expiring {
    border: 2px solid #ffc107;
    background: rgba(255,193,7,0.05);
}

.status-expired {
    border: 2px solid #dc3545;
    background: rgba(220,53,69,0.05);
}

.status-warning {
    border: 2px solid #fd7e14;
    background: rgba(253,126,20,0.05);
}

.status-text {
    display: block;
    font-weight: 600;
    font-size: 0.85rem;
    color: #222;
}

.status-label {
    display: block;
    font-size: 0.75rem;
    color: #6c757d;
}

.reorder-btn {
    border-color: #5459AC;
    color: #5459AC;
    font-size: 0.8rem;
    padding: 4px 8px;
    border-radius: 6px;
    transition: all 0.18s;
}

.reorder-btn:hover {
    background: #5459AC;
    color: #fff;
    border-color: #5459AC;
}

/* Modern Inventory Table Styles */
.modern-inventory-table {
    border-radius: 16px;
    border: none;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(84,89,172,0.10);
}

.inventory-table-container {
    background: #fff;
}

.inventory-table-header {
    background: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
}

.table-header-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1.5fr 1fr;
    gap: 16px;
    padding: 16px 20px;
    align-items: center;
}

.header-cell {
    font-weight: 700;
    color: #5459AC;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    font-family: 'Poppins', Arial, sans-serif;
}

.inventory-table-body {
    max-height: 600px;
    overflow-y: auto;
}

.inventory-table-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1.5fr 1fr;
    gap: 16px;
    padding: 16px 20px;
    align-items: center;
    border-bottom: 1px solid #f1f1f1;
    transition: background 0.18s;
}

.inventory-table-row:hover {
    background: rgba(111,195,208,0.08);
}

.medicine-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.medicine-info {
    min-width: 0;
}

.medicine-name {
    font-weight: 600;
    color: #222;
    font-size: 0.95rem;
    margin-bottom: 2px;
    font-family: 'Poppins', Arial, sans-serif;
}

.medicine-sku {
    color: #6c757d;
    font-size: 0.8rem;
}

.category-cell {
    font-size: 0.9rem;
    color: #5459AC;
    font-weight: 500;
}

.stock-cell {
    font-size: 0.9rem;
    font-weight: 600;
}

.stock-danger { color: #e74c3c; }
.stock-warning { color: #ffc107; }
.stock-success { color: #27ae60; }

.price-cell {
    font-size: 0.9rem;
    font-weight: 600;
    color: #222;
}

.expiry-cell {
    font-size: 0.85rem;
    color: #6c757d;
}

.supplier-cell {
    font-size: 0.85rem;
    color: #6c757d;
}

.actions-cell {
    display: flex;
    gap: 8px;
}

.action-btn {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.18s;
}

.reorder-action {
    background: #17a2b8;
    color: #fff;
    border: none;
}

.reorder-action:hover {
    background: #138496;
    transform: translateY(-1px);
}

.inventory-pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
}

.pagination-info {
    color: #6c757d;
    font-size: 0.9rem;
    font-family: 'Poppins', Arial, sans-serif;
}

.pagination-controls {
    display: flex;
    gap: 15px;
    align-items: center;
}

/* BUTTON OUTLINE GRADIENT - Style dari dokter.php */
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

/* Modal Styles */
.modern-modal .modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 8px 32px rgba(84,89,172,0.15);
}

.modern-modal-header {
    background: linear-gradient(90deg, #5459AC 80%, #6fc3d0 100%);
    color: #fff;
    border-radius: 16px 16px 0 0;
    border: none;
}

.detail-card {
    background: #fff;
    border-radius: 12px;
    border: 2px solid rgba(84,89,172,0.1);
    padding: 16px;
    height: 100%;
    transition: border-color 0.18s;
}

.detail-card:hover {
    border-color: rgba(84,89,172,0.3);
}

.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.detail-rank {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}

.detail-medicine-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 12px;
}

.detail-name {
    color: #222;
    font-weight: 600;
    margin-bottom: 12px;
    font-family: 'Poppins', Arial, sans-serif;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
}

.info-label {
    color: #6c757d;
    font-size: 0.85rem;
}

.info-value {
    color: #222;
    font-weight: 500;
    font-size: 0.85rem;
}

/* Responsive adjustments */
@media (max-width: 1199px) {
    .category-card-item {
        width: 180px;
    }
    
    .category-icon-wrapper {
        width: 70px;
        height: 70px;
    }
    
    .category-icon-wrapper i {
        font-size: 2rem;
    }
    
    .category-name {
        font-size: 1rem;
    }
    
    .category-count {
        font-size: 0.85rem;
    }
}

@media (max-width: 767px) {
    .inventory-controls {
        flex-direction: column;
        align-items: stretch;
    }
    
    .inventory-search-container {
        max-width: none;
    }
    
    .inventory-filter-tabs {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .inventory-actions {
        justify-content: center;
    }
    
    .category-card-item {
        width: 160px;
    }
    
    .category-card {
        padding: 20px 16px;
    }
    
    .category-icon-wrapper {
        width: 60px;
        height: 60px;
        margin-bottom: 12px;
    }
    
    .category-icon-wrapper i {
        font-size: 1.5rem;
    }
    
    .category-name {
        font-size: 0.95rem;
    }
    
    .category-count {
        font-size: 0.8rem;
    }
    
    .inventory-item {
        padding: 12px 16px;
    }
    
    .inventory-rank {
        width: 28px;
        height: 28px;
        margin-right: 8px;
    }
    
    .medicine-icon {
        width: 32px;
        height: 32px;
        margin-right: 8px;
        font-size: 1rem;
    }
    
    .inventory-name {
        font-size: 0.9rem;
    }
    
    .count-number {
        font-size: 1rem;
    }
    
    .table-header-row,
    .inventory-table-row {
        grid-template-columns: 1fr;
        gap: 8px;
        padding: 12px 16px;
    }
    
    .header-cell {
        display: none; /* Hide headers on mobile, use labels instead */
    }
    
    .medicine-cell,
    .category-cell,
    .stock-cell,
    .price-cell,
    .expiry-cell,
    .supplier-cell,
    .actions-cell {
        padding: 6px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    /* Add labels for mobile view */
    .category-cell::before { content: "Category: "; font-weight: bold; color: #5459AC; }
    .stock-cell::before { content: "Stock: "; font-weight: bold; color: #5459AC; }
    .price-cell::before { content: "Price: "; font-weight: bold; color: #5459AC; }
    .expiry-cell::before { content: "Expiry: "; font-weight: bold; color: #5459AC; }
    .supplier-cell::before { content: "Supplier: "; font-weight: bold; color: #5459AC; }
    .actions-cell::before { content: "Actions: "; font-weight: bold; color: #5459AC; }
    
    .inventory-table-body {
        max-height: 500px;
    }
}

@media (max-width: 575px) {
    .col-sm-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

/* Padding atas main agar tidak menempel headbar */
#layoutSidenav_content main > .container-fluid,
#layoutSidenav_content main > .container {
    padding-top: 1.5rem;
}

/* Additional responsive improvements */
@media (max-width: 1200px) {
    .modern-inventory-card {
        margin-bottom: 20px;
    }
    
    .inventory-management-header {
        padding: 20px;
    }
}

@media (max-width: 992px) {
    .col-lg-6 {
        margin-bottom: 20px;
    }
    
    .inventory-title {
        font-size: 1.6rem;
    }
    
    .modern-card-header,
    .modern-card-header-danger {
        padding: 14px 18px;
        font-size: 1rem;
    }
}

/* Improve container spacing */
.container-fluid {
    padding-left: 20px;
    padding-right: 20px;
}

@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }
}
    </style>
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
                                    <a class="nav-link active" href="data-obat/obat.php">Data Obat</a>
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
                    <?php
                    // Query data obat dari database clinic
                    $queryTotalObat = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_obat WHERE status_obat = 'aktif'");
                    $totalObat = mysqli_fetch_assoc($queryTotalObat)['total'];

                    $queryKategori = mysqli_query($koneksi, "SELECT COUNT(DISTINCT kategori) as total FROM tb_obat WHERE status_obat = 'aktif'");
                    $totalKategoriPenyakit = mysqli_fetch_assoc($queryKategori)['total'];

                    $queryBentuk = mysqli_query($koneksi, "SELECT COUNT(DISTINCT bentuk_obat) as total FROM tb_obat WHERE status_obat = 'aktif'");
                    $totalKategoriBentuk = mysqli_fetch_assoc($queryBentuk)['total'];

                    $queryJenisUnik = mysqli_query($koneksi, "SELECT COUNT(DISTINCT nama_obat) as total FROM tb_obat WHERE status_obat = 'aktif'");
                    $totalJenisUnik = mysqli_fetch_assoc($queryJenisUnik)['total'];

                    $queryObatKritis = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_obat WHERE stok <= stok_minimum AND status_obat = 'aktif'");
                    $obatKritis = mysqli_fetch_assoc($queryObatKritis)['total'];

                    $queryObatKadaluarsa = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_obat WHERE expired_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) AND status_obat = 'aktif'");
                    $obatKadaluarsa = mysqli_fetch_assoc($queryObatKadaluarsa)['total'];
                    ?>

                    <!-- 🔵 Row 1: Ringkasan Data Obat -->
                    <h4 class="mb-4 font-weight-bold text-secondary">Ringkasan Data Obat</h4>
                    <div class="row">
                        <!-- Total Obat -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Total Obat</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $totalObat ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-pills"></i></div>
                                <span class="summary-badge badge-green">Stok Tersedia</span>
                            </div>
                        </div>
                        <!-- Kategori Penyakit -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Kategori Penyakit</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $totalKategoriPenyakit ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-stethoscope"></i></div>
                                <span class="summary-badge badge-blue">Kategori Aktif</span>
                            </div>
                        </div>
                        <!-- Bentuk Obat -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Bentuk Obat</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $totalKategoriBentuk ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-capsules"></i></div>
                                <span class="summary-badge badge-orange">Variasi Bentuk</span>
                            </div>
                        </div>
                        <!-- Jenis Unik -->
                        <div class="col-md-3 mb-4">
                            <div class="summary-box">
                                <div class="summary-title">Jenis Unik</div>
                                <div class="summary-value"><span class="counter" data-count="<?= $totalJenisUnik ?>">0</span></div>
                                <div class="summary-icon"><i class="fas fa-boxes"></i></div>
                                <span class="summary-badge badge-red"><?= $obatKritis ?> perlu restok</span>
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

                    <!-- 🟢 Row 3: Visualisasi Distribusi Obat -->
                    <h5 class="mb-3 font-weight-bold text-secondary">Visualisasi Distribusi Obat</h5>
                    <div class="row">
                        <!-- Pie Chart Bentuk Obat -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow demografi-card h-100">
                                <div class="card-body pb-2">
                                    <h6 class="font-weight-bold text-primary">Distribusi Bentuk Obat (%)</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="pieBentukObat" class="demografi-chart-canvas"></canvas>
                                    </div>
                                    <div class="chart-caption">📌 <strong><?php 
                                        // Ambil 2 bentuk obat terbanyak untuk caption
                                        $queryTopBentuk = mysqli_query($koneksi, "SELECT bentuk_obat, COUNT(*) as total FROM tb_obat WHERE status_obat = 'aktif' GROUP BY bentuk_obat ORDER BY total DESC LIMIT 2");
                                        $bentukData = [];
                                        while($bentuk = mysqli_fetch_assoc($queryTopBentuk)) {
                                            $bentukData[] = $bentuk['bentuk_obat'];
                                        }
                                        echo implode(' & ', $bentukData);
                                    ?></strong> mendominasi inventory. Fokuskan supplier relationship untuk kategori ini.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Bar Chart Kategori Penyakit -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow demografi-card h-100">
                                <div class="card-body pb-2">
                                    <h6 class="font-weight-bold text-primary">Distribusi Kategori Obat</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="barKategoriPenyakit" class="demografi-chart-canvas"></canvas>
                                    </div>
                                    <div class="chart-caption">📊 Kategori <strong><?php 
                                        // Ambil kategori terbanyak untuk caption
                                        $queryTopKat = mysqli_query($koneksi, "SELECT kategori, COUNT(*) as total FROM tb_obat WHERE status_obat = 'aktif' GROUP BY kategori ORDER BY total DESC LIMIT 1");
                                        $topKat = mysqli_fetch_assoc($queryTopKat);
                                        echo $topKat['kategori'];
                                    ?></strong> memiliki stok terbanyak. Pastikan supplier selalu optimal.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Script Chart.js -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                    // Query data untuk chart dari database
                    <?php
                    // Data untuk chart bentuk obat
                    $queryBentukObat = mysqli_query($koneksi, "SELECT bentuk_obat, COUNT(*) as jumlah FROM tb_obat WHERE status_obat = 'aktif' GROUP BY bentuk_obat ORDER BY jumlah DESC");
                    $kategoriBentukData = [];
                    while($row = mysqli_fetch_assoc($queryBentukObat)) {
                        $kategoriBentukData[] = $row;
                    }

                    // Data untuk chart kategori penyakit
                    $queryKategoriPenyakit = mysqli_query($koneksi, "SELECT kategori, COUNT(*) as jumlah FROM tb_obat WHERE status_obat = 'aktif' GROUP BY kategori ORDER BY jumlah DESC");
                    $kategoriPenyakitData = [];
                    while($row = mysqli_fetch_assoc($queryKategoriPenyakit)) {
                        $kategoriPenyakitData[] = $row;
                    }
                    ?>

                    const totalObat = <?= $totalObat ?>;
                    const kategoriBentuk = <?= json_encode($kategoriBentukData) ?>;
                    const kategoriPenyakit = <?= json_encode($kategoriPenyakitData) ?>;

                    const donutColors = [
                      'rgba(84,89,172,0.92)', 'rgba(111,195,208,0.92)', 'rgba(8,131,149,0.92)',
                      'rgba(111,195,208,0.65)', 'rgba(84,89,172,0.65)', 'rgba(8,131,149,0.65)',
                      'rgba(255,193,7,0.8)', 'rgba(220,53,69,0.8)'
                    ];

                    // Pie Chart
                    new Chart(document.getElementById('pieBentukObat'), {
                        type: 'doughnut',
                        data: {
                            labels: kategoriBentuk.map(item => item.bentuk_obat),
                            datasets: [{
                                data: kategoriBentuk.map(item => item.jumlah),
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
                                            const total = kategoriBentuk.reduce((a, b) => a + b.jumlah, 0);
                                            const val = kategoriBentuk[ctx.dataIndex].jumlah;
                                            const percent = ((val / total) * 100).toFixed(1);
                                            return `${ctx.label}: ${val} jenis (${percent}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Bar Chart
                    new Chart(document.getElementById('barKategoriPenyakit'), {
                        type: 'bar',
                        data: {
                            labels: kategoriPenyakit.map(item => item.kategori),
                            datasets: [{
                                label: 'Jumlah Jenis Obat',
                                data: kategoriPenyakit.map(item => item.jumlah),
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
                                        label: (ctx) => `Jumlah: ${ctx.raw} jenis obat`
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
                    </script>

                    <!-- 🟠 Row 2: Insight MIS Obat -->
                    <div class="mb-4">
                        <div class="insight-card shadow-sm">
                            <div class="d-flex align-items-start">
                                <div class="insight-icon mr-3">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="insight-title mb-3">🤖 Insight AI Saran Cerdas Obat</h5>
                                    <p class="insight-desc mb-3">
                                        Berdasarkan analisis otomatis seluruh data obat, berikut insight dan rekomendasi strategis untuk pengelolaan inventory klinik:
                                    </p>
                                    <ul class="insight-list">
                                    <?php
                                    // Ambil seluruh data obat dari database
                                    $obatData = [];
                                    $qObat = mysqli_query($koneksi, "SELECT * FROM tb_obat WHERE status_obat = 'aktif'");
                                    while($row = mysqli_fetch_assoc($qObat)) {
                                        $obatData[] = $row;
                                    }

                                    // 1. Stok Kritis
                                    $obatStokKritis = array_filter($obatData, fn($d) => $d['stok'] <= $d['stok_minimum']);
                                    if (count($obatStokKritis) > 0) {
                                        echo '<li><b>Stok Kritis:</b> '.count($obatStokKritis).' obat perlu restok segera: <span class="text-danger">'.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($obatStokKritis,0,5))).(count($obatStokKritis)>5?' ...':'').'</span></li>';
                                    }

                                    // 2. Hampir Kadaluarsa (<= 30 hari)
                                    $obatKadaluarsa = array_filter($obatData, function($d) {
                                        $days = (strtotime($d['expired_date']) - strtotime(date('Y-m-d')))/86400;
                                        return $days <= 30 && $days > 0;
                                    });
                                    if (count($obatKadaluarsa) > 0) {
                                        echo '<li><b>Kadaluarsa &lt; 30 hari:</b> '.count($obatKadaluarsa).' obat perlu diprioritaskan: <span class="text-warning">'.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($obatKadaluarsa,0,5))).(count($obatKadaluarsa)>5?' ...':'').'</span></li>';
                                    }

                                    // 3. Sudah Kadaluarsa (expired)
                                    $obatExpired = array_filter($obatData, function($d) {
                                        $days = (strtotime($d['expired_date']) - strtotime(date('Y-m-d')))/86400;
                                        return $days <= 0;
                                    });
                                    if (count($obatExpired) > 0) {
                                        echo '<li><b>Obat Expired:</b> '.count($obatExpired).' jenis sudah kadaluarsa, segera keluarkan dari stok: <span class="text-danger">'.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($obatExpired,0,5))).(count($obatExpired)>5?' ...':'').'</span></li>';
                                    }

                                    // 4. Prediksi Restok (stok < 2x minimum)
                                    $obatPerluRestok = array_filter($obatData, fn($d) => $d['stok'] < 2*$d['stok_minimum'] && $d['stok'] > $d['stok_minimum']);
                                    if (count($obatPerluRestok) > 0) {
                                        echo '<li><b>Prediksi Restok:</b> '.count($obatPerluRestok).' obat mendekati batas restok: <span class="text-orange">'.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($obatPerluRestok,0,5))).(count($obatPerluRestok)>5?' ...':'').'</span></li>';
                                    }

                                    // 5. Anomali Harga (harga < 1000 atau > 10x median)
                                    $hargaArr = array_column($obatData, 'harga_satuan');
                                    $medianHarga = 0;
                                    if (count($hargaArr) > 0) {
                                        sort($hargaArr);
                                        $mid = floor(count($hargaArr)/2);
                                        $medianHarga = (count($hargaArr)%2) ? $hargaArr[$mid] : ($hargaArr[$mid-1]+$hargaArr[$mid])/2;
                                    }
                                    $obatHargaAnomali = array_filter($obatData, fn($d) => $d['harga_satuan'] < 1000 || $d['harga_satuan'] > 10*$medianHarga);
                                    if (count($obatHargaAnomali) > 0) {
                                        echo '<li><b>Anomali Harga:</b> '.count($obatHargaAnomali).' obat harga tidak wajar: <span class="text-danger">'.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($obatHargaAnomali,0,5))).(count($obatHargaAnomali)>5?' ...':'').'</span></li>';
                                    }

                                    // 6. Supplier Kritis (obat kritis dari supplier sama)
                                    $supplierKritis = [];
                                    foreach ($obatStokKritis as $d) {
                                        $supplierKritis[$d['produsen']][] = $d['nama_obat'];
                                    }
                                    foreach ($supplierKritis as $supp => $list) {
                                        if (count($list) > 2) {
                                            echo '<li><b>Supplier Perlu Dihubungi:</b> '.count($list).' obat dari <span class="text-primary">'.$supp.'</span> stok kritis.</li>';
                                        }
                                    }

                                    // 7. Duplikat Nama Obat (nama sama, kode beda)
                                    $namaMap = [];
                                    foreach ($obatData as $d) {
                                        $namaMap[$d['nama_obat']][] = $d['kode_obat'];
                                    }
                                    $duplikatNama = [];
                                    foreach ($namaMap as $nama => $kodeList) {
                                        if (count(array_unique($kodeList)) > 1) $duplikatNama[] = $nama;
                                    }
                                    if (count($duplikatNama) > 0) {
                                        echo '<li><b>Duplikat Nama Obat:</b> '.implode(', ', array_slice($duplikatNama,0,5)).(count($duplikatNama)>5?' ...':'').'</li>';
                                    }

                                    // 8. Segmentasi Bentuk Obat
                                    $segBentuk = [];
                                    foreach ($obatData as $d) {
                                        $segBentuk[$d['bentuk_obat']] = ($segBentuk[$d['bentuk_obat']] ?? 0) + 1;
                                    }
                                    $segList = [];
                                    foreach ($segBentuk as $bentuk => $jumlah) {
                                        $segList[] = "$bentuk: <span class='text-info'>$jumlah</span>";
                                    }
                                    echo '<li><b>Segmentasi Bentuk:</b> '.implode(', ', $segList).'</li>';

                                    // 9. Segmentasi Kategori Obat
                                    $segKategori = [];
                                    foreach ($obatData as $d) {
                                        $segKategori[$d['kategori']] = ($segKategori[$d['kategori']] ?? 0) + 1;
                                    }
                                    $segListKat = [];
                                    foreach ($segKategori as $kat => $jumlah) {
                                        $segListKat[] = "$kat: <span class='text-info'>$jumlah</span>";
                                    }
                                    echo '<li><b>Segmentasi Kategori:</b> '.implode(', ', $segListKat).'</li>';

                                    // 10. Obat Stok Terbanyak (Top 1)
                                    if (count($obatData) > 0) {
                                        usort($obatData, fn($a,$b) => $b['stok'] - $a['stok']);
                                        $topObat = $obatData[0];
                                        echo '<li><b>Obat Stok Terbanyak:</b> <span class="text-success">'.$topObat['nama_obat'].' ('.$topObat['stok'].')</span></li>';
                                    }

                                    // 11. Obat Stok Paling Sedikit (Top 1, exclude kritis)
                                    $obatStokSedikit = array_filter($obatData, fn($d) => $d['stok'] > $d['stok_minimum']);
                                    if (count($obatStokSedikit) > 0) {
                                        usort($obatStokSedikit, fn($a,$b) => $a['stok'] - $b['stok']);
                                        $minObat = $obatStokSedikit[0];
                                        echo '<li><b>Obat Stok Paling Sedikit (non-kritis):</b> <span class="text-warning">'.$minObat['nama_obat'].' ('.$minObat['stok'].')</span></li>';
                                    }

                                    // 12. Obat Sering Restok (simulasi: stok_minimum < 10)
                                    $seringRestok = array_filter($obatData, fn($d) => $d['stok_minimum'] < 10);
                                    if (count($seringRestok) > 0) {
                                        echo '<li><b>Obat Sering Restok:</b> '.count($seringRestok).' jenis perlu monitoring restok: <span class="text-warning">'.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($seringRestok,0,5))).(count($seringRestok)>5?' ...':'').'</span></li>';
                                    }

                                    // 13. Stok Berlebih (stok > 10x minimum)
                                    $obatStokTinggi = array_filter($obatData, fn($d) => $d['stok'] > 10*$d['stok_minimum']);
                                    if (count($obatStokTinggi) > 0) {
                                        echo '<li><b>Stok Berlebih:</b> '.count($obatStokTinggi).' obat stok berlebih, pertimbangkan promo/rotasi: <span class="text-primary">'.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($obatStokTinggi,0,5))).(count($obatStokTinggi)>5?' ...':'').'</span></li>';
                                    }

                                    // 14. Slow Moving (stok tidak turun dalam 3 bulan, simulasi: stok > 0 dan stok_minimum > 0 dan stok % stok_minimum > 3)
                                    $slowMoving = array_filter($obatData, fn($d) => $d['stok'] > 0 && $d['stok_minimum'] > 0 && ($d['stok']/$d['stok_minimum']) > 3);
                                    if (count($slowMoving) > 0) {
                                        echo '<li><b>Obat Slow Moving:</b> '.count($slowMoving).' jenis jarang bergerak, evaluasi promosi atau pengurangan stok: <span class="text-warning">'.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($slowMoving,0,5))).(count($slowMoving)>5?' ...':'').'</span></li>';
                                    }

                                    // 15. Fast Moving (stok < 1.2x minimum dan stok_minimum > 0)
                                    $fastMoving = array_filter($obatData, fn($d) => $d['stok_minimum'] > 0 && $d['stok'] < 1.2*$d['stok_minimum']);
                                    if (count($fastMoving) > 0) {
                                        echo '<li><b>Obat Fast Moving:</b> '.count($fastMoving).' jenis sering habis, pertimbangkan restok lebih sering: <span class="text-success">'.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($fastMoving,0,5))).(count($fastMoving)>5?' ...':'').'</span></li>';
                                    }

                                    // 16. Tidak Pernah Restok (simulasi: created_at > 90 hari lalu dan stok tetap tinggi)
                                    $neverRestock = array_filter($obatData, function($d) {
                                        if (empty($d['created_at'])) return false;
                                        $days = (strtotime(date('Y-m-d')) - strtotime($d['created_at']))/86400;
                                        return $days > 90 && $d['stok'] > 2*$d['stok_minimum'];
                                    });
                                    if (count($neverRestock) > 0) {
                                        echo '<li><b>Obat Tidak Pernah Restok:</b> '.count($neverRestock).' jenis stok tetap tinggi >3 bulan, evaluasi kebutuhan: <span class="text-info">'.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($neverRestock,0,5))).(count($neverRestock)>5?' ...':'').'</span></li>';
                                    }

                                    // 17. Margin Keuntungan (jika ada harga_beli, tampilkan margin rata-rata)
                                    $marginList = [];
                                    foreach ($obatData as $d) {
                                        if (isset($d['harga_beli']) && $d['harga_beli'] > 0) {
                                            $marginList[] = ($d['harga_satuan'] - $d['harga_beli']) / $d['harga_beli'] * 100;
                                        }
                                    }
                                    if (count($marginList) > 0) {
                                        $avgMargin = round(array_sum($marginList)/count($marginList),1);
                                        echo '<li><b>Margin Keuntungan Rata-rata:</b> <span class="text-success">'.$avgMargin.'%</span> (simulasi dari data harga beli)</li>';
                                    }

                                    // 18. Substitusi Obat (jika stok kritis, tampilkan alternatif dari kategori/bentuk sama)
                                    foreach ($obatStokKritis as $obat) {
                                        $alternatif = array_filter($obatData, fn($d) => $d['kategori'] == $obat['kategori'] && $d['bentuk_obat'] == $obat['bentuk_obat'] && $d['stok'] > $d['stok_minimum'] && $d['kode_obat'] != $obat['kode_obat']);
                                        if (count($alternatif) > 0) {
                                            echo '<li><b>Alternatif untuk '.$obat['nama_obat'].':</b> '.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($alternatif,0,3))).'</li>';
                                        }
                                    }

                                    // 19. Waste/Expired (jumlah obat expired bulan ini)
                                    $waste = array_filter($obatData, function($d) {
                                        $days = (strtotime($d['expired_date']) - strtotime(date('Y-m-d')))/86400;
                                        return $days <= 0 && date('Y-m', strtotime($d['expired_date'])) == date('Y-m');
                                    });
                                    if (count($waste) > 0) {
                                        echo '<li><b>Obat Expired Bulan Ini:</b> '.count($waste).' jenis, evaluasi pengelolaan stok dan pembelian.</li>';
                                    }

                                    // 20. Obat Tidak Pernah Terjual (simulasi: stok tetap sama sejak created_at)
                                    $neverSold = array_filter($obatData, function($d) {
                                        if (empty($d['created_at'])) return false;
                                        $days = (strtotime(date('Y-m-d')) - strtotime($d['created_at']))/86400;
                                        return $days > 60 && $d['stok'] == $d['stok_awal'];
                                    });
                                    if (count($neverSold) > 0) {
                                        echo '<li><b>Obat Tidak Pernah Terjual:</b> '.count($neverSold).' jenis tidak pernah keluar sejak masuk stok: <span class="text-danger">'.implode(', ', array_map(fn($d) => $d['nama_obat'], array_slice($neverSold,0,5))).(count($neverSold)>5?' ...':'').'</span></li>';
                                    }

                                    // 21. Obat Sering Kadaluarsa (simulasi: expired_date < 1 tahun dari created_at)
                                    $seringExpired = array_filter($obatData, function($d) {
                                        if (empty($d['created_at'])) return false;
                                        $exp = strtotime($d['expired_date']);
                                        $crt = strtotime($d['created_at']);
                                        return ($exp - $crt) < (365*86400);
                                    });
                                    if (count($seringExpired) > 0) {
                                        echo '<li><b>Obat Sering Kadaluarsa Cepat:</b> '.count($seringExpired).' jenis expired &lt; 1 tahun dari pembelian, evaluasi supplier/rotasi.</li>';
                                    }

                                    // 22. Obat Sering Promo (simulasi: harga_satuan < 1.1*harga_beli)
                                    $seringPromo = array_filter($obatData, function($d) {
                                        return isset($d['harga_beli']) && $d['harga_beli'] > 0 && $d['harga_satuan'] < 1.1*$d['harga_beli'];
                                    });
                                    if (count($seringPromo) > 0) {
                                        echo '<li><b>Obat Sering Promo:</b> '.count($seringPromo).' jenis sering dijual hampir tanpa margin, evaluasi strategi harga.</li>';
                                    }

                                    // 23. Obat Sering Ganti Supplier (simulasi: nama_obat sama, produsen beda)
                                    $namaSuppMap = [];
                                    foreach ($obatData as $d) {
                                        $namaSuppMap[$d['nama_obat']][] = $d['produsen'];
                                    }
                                    $gantiSupp = [];
                                    foreach ($namaSuppMap as $nama => $suppList) {
                                        if (count(array_unique($suppList)) > 1) $gantiSupp[] = $nama;
                                    }
                                    if (count($gantiSupp) > 0) {
                                        echo '<li><b>Obat Sering Ganti Supplier:</b> '.implode(', ', array_slice($gantiSupp,0,5)).(count($gantiSupp)>5?' ...':'').'</li>';
                                    }

                                    // 24. Obat Sering Ganti Harga (simulasi: harga_satuan != harga_awal)
                                    $gantiHarga = array_filter($obatData, function($d) {
                                        return isset($d['harga_awal']) && $d['harga_awal'] > 0 && $d['harga_satuan'] != $d['harga_awal'];
                                    });
                                    if (count($gantiHarga) > 0) {
                                        echo '<li><b>Obat Sering Ganti Harga:</b> '.count($gantiHarga).' jenis harga berubah dari awal masuk stok.</li>';
                                    }

                                    // 25. Obat Sering Ganti Bentuk (simulasi: nama_obat sama, bentuk_obat beda)
                                    $namaBentukMap = [];
                                    foreach ($obatData as $d) {
                                        $namaBentukMap[$d['nama_obat']][] = $d['bentuk_obat'];
                                    }
                                    $gantiBentuk = [];
                                    foreach ($namaBentukMap as $nama => $bentukList) {
                                        if (count(array_unique($bentukList)) > 1) $gantiBentuk[] = $nama;
                                    }
                                    if (count($gantiBentuk) > 0) {
                                        echo '<li><b>Obat Sering Ganti Bentuk:</b> '.implode(', ', array_slice($gantiBentuk,0,5)).(count($gantiBentuk)>5?' ...':'').'</li>';
                                    }

                                    if (count($obatData) == 0) {
                                        echo '<li>Data obat belum tersedia untuk insight AI.</li>';
                                    }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row Ketiga: Monitoring Kritis -->
                    <h4 class="mb-4 font-weight-bold text-secondary">Monitoring Stok & Pergerakan Obat</h4>

                    <?php
                    // Query untuk Top Obat Terlaris menggunakan data real dari database dengan simulasi penjualan
                    $queryTopObat = mysqli_query($koneksi, "
                        SELECT 
                            nama_obat as nama,
                            kode_obat as sku,
                            kategori,
                            stok,
                            harga_satuan as harga,
                            produsen as supplier,
                            bentuk_obat,
                            satuan,
                            CASE 
                                WHEN kategori IN ('Analgesik', 'Antibiotik') THEN ROUND(120 + (stok/10))
                                WHEN kategori IN ('Antitusif', 'Anti-inflamasi') THEN ROUND(85 + (stok/15))
                                WHEN kategori IN ('Vitamin', 'PPI') THEN ROUND(65 + (stok/8))
                                ELSE ROUND(45 + (stok/12))
                            END as terjual_bulan_ini,
                            CASE 
                                WHEN stok > 100 THEN 'up'
                                WHEN stok > 50 THEN 'stable' 
                                ELSE 'down'
                            END as trend,
                            CASE 
                                WHEN stok > 100 THEN ROUND(8 + (RAND() * 12), 1)
                                WHEN stok > 50 THEN ROUND(-2 + (RAND() * 8), 1)
                                ELSE ROUND(-12 + (RAND() * 8), 1)
                            END as persentase_trend
                        FROM tb_obat 
                        WHERE status_obat = 'aktif' 
                        ORDER BY 
                            CASE 
                                WHEN kategori IN ('Analgesik', 'Antibiotik') THEN 1
                                WHEN kategori IN ('Antitusif', 'Anti-inflamasi') THEN 2
                                ELSE 3
                            END,
                            stok DESC 
                        LIMIT 8
                    ");
                    
                    $topObatTerlaris = [];
                    $colorPalette = ['#e74c3c', '#3498db', '#f39c12', '#9b59b6', '#27ae60', '#16a085', '#f1c40f', '#e91e63'];
                    $iconMapping = [
                        'Tablet' => 'fas fa-tablets',
                        'Kapsul' => 'fas fa-pills', 
                        'Sirup' => 'fas fa-prescription-bottle',
                        'Salep' => 'fas fa-pump-medical',
                        'Suntik' => 'fas fa-syringe',
                        'Tetes' => 'fas fa-eye-dropper',
                        'Inhaler' => 'fas fa-wind',
                        'Suppositoria' => 'fas fa-capsules'
                    ];
                    
                    $index = 0;
                    while($row = mysqli_fetch_assoc($queryTopObat)) {
                        $row['color'] = $colorPalette[$index % count($colorPalette)];
                        $row['icon'] = $iconMapping[$row['bentuk_obat']] ?? 'fas fa-pills';
                        $row['stok_tersisa'] = $row['stok'];
                        $topObatTerlaris[] = $row;
                        $index++;
                    }
                    
                    // Query untuk Obat Kritis (stok di bawah minimum atau akan expired dalam 90 hari)
                    $queryObatKritis = mysqli_query($koneksi, "
                        SELECT 
                            nama_obat as nama,
                            kode_obat as sku,
                            kategori,
                            stok as stok_tersisa,
                            stok_minimum,
                            harga_satuan as harga,
                            expired_date as exp_date,
                            produsen as supplier,
                            bentuk_obat,
                            created_at as last_restock,
                            CASE 
                                WHEN stok <= stok_minimum THEN 'critical'
                                WHEN DATEDIFF(expired_date, CURDATE()) <= 90 AND DATEDIFF(expired_date, CURDATE()) > 0 THEN 'expiring'
                                WHEN DATEDIFF(expired_date, CURDATE()) <= 0 THEN 'expired'
                                ELSE 'warning'
                            END as status
                        FROM tb_obat 
                        WHERE (stok <= stok_minimum OR DATEDIFF(expired_date, CURDATE()) <= 90) 
                              AND status_obat = 'aktif'
                        ORDER BY 
                            CASE 
                                WHEN DATEDIFF(expired_date, CURDATE()) <= 0 THEN 1
                                WHEN stok <= stok_minimum THEN 2
                                WHEN DATEDIFF(expired_date, CURDATE()) <= 90 THEN 3
                                ELSE 4
                            END,
                            (stok/stok_minimum) ASC,
                            expired_date ASC
                        LIMIT 10
                    ");
                    
                    $obatKritis = [];
                    $colorPalette = ['#e74c3c', '#3498db', '#f39c12', '#9b59b6', '#27ae60', '#16a085', '#f1c40f', '#e91e63', '#34495e', '#ff5722'];
                    $iconMapping = [
                        'Tablet' => 'fas fa-tablets',
                        'Kapsul' => 'fas fa-pills', 
                        'Sirup' => 'fas fa-prescription-bottle',
                        'Salep' => 'fas fa-pump-medical',
                        'Suntik' => 'fas fa-syringe',
                        'Tetes' => 'fas fa-eye-dropper',
                        'Inhaler' => 'fas fa-wind',
                        'Suppositoria' => 'fas fa-capsules'
                    ];
                    
                    $index = 0;
                    while($row = mysqli_fetch_assoc($queryObatKritis)) {
                        $row['color'] = $colorPalette[$index % count($colorPalette)];
                        $row['icon'] = $iconMapping[$row['bentuk_obat']] ?? 'fas fa-pills';
                        $obatKritis[] = $row;
                        $index++;
                    }

                    // Extended inventory data for table - Query ALL obat data from database
                    $queryInventoryObat = mysqli_query($koneksi, "
                        SELECT 
                            nama_obat as nama,
                            kode_obat as sku,
                            kategori,
                            stok,
                            stok_minimum,
                            harga_satuan as harga,
                            expired_date as exp_date,
                            produsen as supplier,
                            bentuk_obat,
                            satuan,
                            status_obat,
                            CASE 
                                WHEN stok <= stok_minimum THEN CONCAT('Critical: ', stok, ' ', satuan)
                                WHEN stok <= (stok_minimum * 2) THEN CONCAT('Low: ', stok, ' ', satuan)
                                WHEN stok <= (stok_minimum * 5) THEN CONCAT('Medium: ', stok, ' ', satuan)
                                ELSE CONCAT('Good: ', stok, ' ', satuan)
                            END as status_stok,
                            CASE 
                                WHEN stok <= stok_minimum THEN 'danger'
                                WHEN stok <= (stok_minimum * 2) THEN 'warning'
                                ELSE 'success'
                            END as status_color,
                            CASE 
                                WHEN DATEDIFF(expired_date, CURDATE()) <= 0 THEN 'Expired'
                                WHEN DATEDIFF(expired_date, CURDATE()) <= 30 THEN 'Expiring Soon'
                                WHEN DATEDIFF(expired_date, CURDATE()) <= 90 THEN 'Expires in 3 months'
                                ELSE 'Good'
                            END as expiry_status
                        FROM tb_obat 
                        WHERE status_obat = 'aktif'
                        ORDER BY 
                            CASE 
                                WHEN stok <= stok_minimum THEN 1
                                WHEN stok <= (stok_minimum * 2) THEN 2
                                ELSE 3
                            END,
                            kategori,
                            nama_obat
                    ");
                    
                    $inventoryObat = [];
                    $index = 0;
                    while($row = mysqli_fetch_assoc($queryInventoryObat)) {
                        $row['color'] = $colorPalette[$index % count($colorPalette)];
                        $row['icon'] = $iconMapping[$row['bentuk_obat']] ?? 'fas fa-pills';
                        $inventoryObat[] = $row;
                        $index++;
                    }
                    ?>

                    <div class="row">
                        <!-- Top Obat Terlaris -->
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="card modern-inventory-card shadow-sm h-100">
                                <div class="card-header modern-card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-fire mr-2"></i>
                                            <span class="font-weight-bold">Top Obat Terlaris</span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-light" data-toggle="modal" data-target="#topObatModal">
                                            <i class="fas fa-chart-line mr-1"></i>Lihat Semua
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="scrollable-container" id="topObatContainer">
                                        <?php foreach(array_slice($topObatTerlaris, 0, 6) as $index => $obat): ?>
                                        <div class="inventory-item <?= $index < 5 ? 'border-bottom' : '' ?>">
                                            <div class="d-flex align-items-center">
                                                <div class="inventory-rank">
                                                    <span class="rank-number"><?= $index + 1 ?></span>
                                                </div>
                                                <div class="medicine-icon" style="background-color: <?= $obat['color'] ?>20;">
                                                    <i class="<?= $obat['icon'] ?>" style="color: <?= $obat['color'] ?>;"></i>
                                                </div>
                                                <div class="inventory-details flex-grow-1">
                                                    <div class="inventory-name"><?= $obat['nama'] ?></div>
                                                    <div class="inventory-meta">
                                                        <span class="category-badge"><?= $obat['kategori'] ?></span>
                                                        <span class="sku-text">SKU: <?= $obat['sku'] ?></span>
                                                    </div>
                                                </div>
                                                <div class="inventory-stats text-right">
                                                    <div class="sales-count">
                                                        <span class="count-number"><?= $obat['terjual_bulan_ini'] ?></span>
                                                        <span class="count-unit"><?= $obat['satuan'] ?></span>
                                                    </div>
                                                    <div class="trend-indicator">
                                                        <?php if($obat['trend'] == 'up'): ?>
                                                            <i class="fas fa-arrow-up text-success"></i>
                                                            <span class="trend-text text-success">+<?= $obat['persentase_trend'] ?>%</span>
                                                        <?php elseif($obat['trend'] == 'down'): ?>
                                                            <i class="fas fa-arrow-down text-danger"></i>
                                                            <span class="trend-text text-danger"><?= $obat['persentase_trend'] ?>%</span>
                                                        <?php else: ?>
                                                            <i class="fas fa-minus text-warning"></i>
                                                            <span class="trend-text text-warning"><?= $obat['persentase_trend'] ?>%</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Monitoring Stok Kritis & Kadaluarsa -->
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="card modern-inventory-card shadow-sm h-100">
                                <div class="card-header modern-card-header-danger">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            <span class="font-weight-bold">Stok Kritis & Kadaluarsa</span>
                                        </div>
                                        <span class="badge badge-light"><?= count($obatKritis) ?> Items</span>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="scrollable-container" id="kritisObatContainer">
                                        <?php foreach(array_slice($obatKritis, 0, 6) as $index => $obat): ?>
                                        <div class="inventory-item <?= $index < 5 ? 'border-bottom' : '' ?>">
                                            <div class="d-flex align-items-center">
                                                <div class="medicine-icon" style="background-color: <?= $obat['color'] ?>20;">
                                                    <i class="<?= $obat['icon'] ?>" style="color: <?= $obat['color'] ?>;"></i>
                                                </div>
                                                <div class="inventory-details flex-grow-1">
                                                    <div class="inventory-name"><?= $obat['nama'] ?></div>
                                                    <div class="inventory-meta">
                                                        <span class="category-badge"><?= $obat['kategori'] ?></span>
                                                        <span class="sku-text">SKU: <?= $obat['sku'] ?></span>
                                                    </div>
                                                </div>
                                                <div class="inventory-status text-right">
                                                    <?php if($obat['status'] == 'critical'): ?>
                                                        <div class="status-badge status-critical">
                                                            <span class="status-text">Stok: <?= $obat['stok_tersisa'] ?></span>
                                                            <span class="status-label">Kritis</span>
                                                        </div>
                                                    <?php elseif($obat['status'] == 'expired'): ?>
                                                        <div class="status-badge status-expired">
                                                            <span class="status-text">Exp: <?= date('d M Y', strtotime($obat['exp_date'])) ?></span>
                                                            <span class="status-label">Kadaluarsa</span>
                                                        </div>
                                                    <?php elseif($obat['status'] == 'expiring'): ?>
                                                        <div class="status-badge status-expiring">
                                                            <span class="status-text">Exp: <?= date('d M Y', strtotime($obat['exp_date'])) ?></span>
                                                            <span class="status-label">Segera Kadaluarsa</span>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="status-badge status-warning">
                                                            <span class="status-text">Stok: <?= $obat['stok_tersisa'] ?></span>
                                                            <span class="status-label">Perhatian</span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <button class="btn btn-sm btn-outline-primary mt-1 reorder-btn">
                                                        <i class="fas fa-shopping-cart mr-1"></i>Reorder
                                                        </button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 🎯 Inventory Management Header -->
                    <div class="inventory-management-header">
                        <h1 class="inventory-title">Inventory Management</h1>
                        <p class="inventory-subtitle">Manage your pharmacy inventory, track stock levels, and reorder medicines.</p>
                        
                        <div class="inventory-controls">
                            <div class="inventory-search-container">
                                <i class="fas fa-search inventory-search-icon"></i>
                                <input type="text" class="inventory-search-input" placeholder="Search medicines by name, category, or code..." id="globalInventorySearch">
                            </div>
                            
                            <div class="inventory-filter-tabs">
                                <a href="#" class="filter-tab active" data-filter="all">All</a>
                                <a href="#" class="filter-tab" data-filter="low-stock">Low Stock</a>
                                <a href="#" class="filter-tab" data-filter="expiring">Expiring Soon</a>
                                <a href="#" class="filter-tab" data-filter="recent">Recently Added</a>
                            </div>
                            
                            <div class="inventory-actions">
                                <a href="obat_input.php" class="add-medicine-btn">
                                    <i class="fas fa-plus"></i>
                                    Add Medicine
                                </a>
                                <button class="filter-btn">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Medicine Categories Section -->
                    <div class="mb-5">
                        <div class="category-scroll-container">
                            <?php
                            // Query kategori yang benar-benar ada di database clinic.sql
                            $queryCategoryData = mysqli_query($koneksi, "
                                SELECT 
                                    kategori,
                                    COUNT(*) as count
                                FROM tb_obat 
                                WHERE status_obat = 'aktif' 
                                GROUP BY kategori
                                ORDER BY count DESC
                            ");
                            
                            // Default icon mapping untuk berbagai jenis kategori obat
                            $iconMapping = [
                                'Antibiotik' => 'fas fa-flask',
                                'Analgesik' => 'fas fa-tablets', 
                                'Antitusif' => 'fas fa-prescription-bottle',
                                'Anti-inflamasi' => 'fas fa-shield-alt',
                                'Vitamin' => 'fas fa-capsules',
                                'PPI' => 'fas fa-pills',
                                'Antihistamin' => 'fas fa-leaf',
                                'Antidiare' => 'fas fa-heartbeat',
                                'Antijamur' => 'fas fa-bug',
                                'Dekongestan' => 'fas fa-wind',
                                'Antasida' => 'fas fa-stomach',
                                'Antiseptik' => 'fas fa-shield-virus',
                                'Bronkodilator' => 'fas fa-lungs',
                                'ACE Inhibitor' => 'fas fa-heart',
                                'Kortikosteroid' => 'fas fa-syringe',
                                'Statin' => 'fas fa-chart-line',
                                'Antidiabetik' => 'fas fa-tint',
                                'CCB' => 'fas fa-circle',
                                'H2 Blocker' => 'fas fa-square',
                                'NSAID' => 'fas fa-fire',
                                'Prokinetik' => 'fas fa-arrows-alt',
                                'Antifungi' => 'fas fa-microscope',
                                'Diuretik' => 'fas fa-droplet',
                                'Keratolitik' => 'fas fa-hand-sparkles'
                            ];
                            
                            // Color palette untuk kategori berdasarkan urutan
                            $colorPalette = [
                                ['color' => '#17a2b8', 'bg_color' => 'rgba(23, 162, 184, 0.15)'],
                                ['color' => '#6f42c1', 'bg_color' => 'rgba(111, 66, 193, 0.15)'],
                                ['color' => '#e83e8c', 'bg_color' => 'rgba(232, 62, 140, 0.15)'],
                                ['color' => '#20c997', 'bg_color' => 'rgba(32, 201, 151, 0.15)'],
                                ['color' => '#fd7e14', 'bg_color' => 'rgba(253, 126, 20, 0.15)'],
                                ['color' => '#6610f2', 'bg_color' => 'rgba(102, 16, 242, 0.15)'],
                                ['color' => '#28a745', 'bg_color' => 'rgba(40, 167, 69, 0.15)'],
                                ['color' => '#dc3545', 'bg_color' => 'rgba(220, 53, 69, 0.15)'],
                                ['color' => '#007bff', 'bg_color' => 'rgba(0, 123, 255, 0.15)'],
                                ['color' => '#6c757d', 'bg_color' => 'rgba(108, 117, 125, 0.15)'],
                                ['color' => '#795548', 'bg_color' => 'rgba(121, 85, 72, 0.15)'],
                                ['color' => '#ff5722', 'bg_color' => 'rgba(255, 87, 34, 0.15)'],
                                ['color' => '#00bcd4', 'bg_color' => 'rgba(0, 188, 212, 0.15)'],
                                ['color' => '#f44336', 'bg_color' => 'rgba(244, 67, 54, 0.15)'],
                                ['color' => '#9c27b0', 'bg_color' => 'rgba(156, 39, 176, 0.15)']
                            ];
                            
                            // Build categories array dari data database real
                            $categories = [];
                            $index = 0;
                            while($category = mysqli_fetch_assoc($queryCategoryData)) {
                                $categoryName = $category['kategori'];
                                $colorIndex = $index % count($colorPalette);
                                
                                $categories[] = [
                                    'name' => $categoryName,
                                    'count' => $category['count'],
                                    'icon' => $iconMapping[$categoryName] ?? 'fas fa-pills', // Default icon jika tidak ada mapping
                                    'color' => $colorPalette[$colorIndex]['color'],
                                    'bg_color' => $colorPalette[$colorIndex]['bg_color']
                                ];
                                $index++;
                            }
                            ?>
                            
                            <div class="category-cards-wrapper">
                                <?php foreach($categories as $category): ?>
                                <div class="category-card-item">
                                    <div class="category-card" onclick="filterByCategory('<?= $category['name'] ?>')">
                                        <div class="category-icon-wrapper" style="background-color: <?= $category['bg_color'] ?>;">
                                            <i class="<?= $category['icon'] ?>" style="color: <?= $category['color'] ?>;"></i>
                                        </div>
                                        <div class="category-info">
                                            <h6 class="category-name"><?= $category['name'] ?></h6>
                                            <p class="category-count"><?= $category['count'] ?> items</p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>


                    <!-- Inventory List Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card modern-inventory-table shadow-sm">
                                <div class="card-body p-0">
                                    <div class="inventory-table-container">
                                        <div class="inventory-table-header">
                                            <div class="table-header-row">
                                                <div class="header-cell medicine-col">MEDICINE</div>
                                                <div class="header-cell category-col">CATEGORY</div>
                                                <div class="header-cell stock-col">STOCK</div>
                                                <div class="header-cell price-col">UNIT PRICE</div>
                                                <div class="header-cell expiry-col">EXPIRY DATE</div>
                                                <div class="header-cell supplier-col">SUPPLIER</div>
                                                <div class="header-cell actions-col">ACTIONS</div>
                                            </div>
                                        </div>
                                        <div class="inventory-table-body" id="inventoryTableBody">
                                            <!-- Items will be populated by JavaScript -->
                                        </div>
                                    </div>
                                    <div class="inventory-pagination">
                                        <div class="pagination-info">
                                            <span id="paginationInfo">Loading...</span>
                                        </div>
                                        <div class="pagination-controls">
                                            <button class="btn btn-gradient-outline btn-sm px-3 font-weight-bold shadow-custom" id="prevBtn" disabled>
                                                <i class="fas fa-angle-left mr-1"></i>Previous
                                            </button>
                                            <button class="btn btn-gradient-outline btn-sm px-3 font-weight-bold shadow-custom" id="nextBtn">
                                                Next<i class="fas fa-angle-right ml-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Detail Top Obat Terlaris -->
                    <div class="modal fade" id="topObatModal" tabindex="-1" role="dialog" aria-labelledby="topObatModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content modern-modal">
                                <div class="modal-header modern-modal-header">
                                    <h5 class="modal-title" id="topObatModalLabel">
                                        <i class="fas fa-chart-line mr-2"></i>Detail Semua Obat Terlaris
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <?php foreach($topObatTerlaris as $index => $obat): ?>
                                        <div class="col-md-4 mb-3">
                                            <div class="detail-card">
                                                <div class="detail-header">
                                                    <div class="detail-rank">#<?= $index + 1 ?></div>
                                                    <div class="detail-trend">
                                                        <?php if($obat['trend'] == 'up'): ?>
                                                            <i class="fas fa-arrow-up text-success"></i>
                                                            <span class="text-success">+<?= $obat['persentase_trend'] ?>%</span>
                                                        <?php elseif($obat['trend'] == 'down'): ?>
                                                            <i class="fas fa-arrow-down text-danger"></i>
                                                            <span class="text-danger"><?= $obat['persentase_trend'] ?>%</span>
                                                        <?php else: ?>
                                                            <i class="fas fa-minus text-warning"></i>
                                                            <span class="text-warning"><?= $obat['persentase_trend'] ?>%</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="detail-body">
                                                    <div class="detail-medicine-icon" style="background-color: <?= $obat['color'] ?>20;">
                                                        <i class="<?= $obat['icon'] ?>" style="color: <?= $obat['color'] ?>;"></i>
                                                    </div>
                                                    <h6 class="detail-name"><?= $obat['nama'] ?></h6>
                                                    <div class="detail-info">
                                                        <div class="info-row">
                                                            <span class="info-label">Kategori:</span>
                                                            <span class="info-value"><?= $obat['kategori'] ?></span>
                                                        </div>
                                                        <div class="info-row">
                                                            <span class="info-label">Terjual:</span>
                                                            <span class="info-value"><?= $obat['terjual_bulan_ini'] ?> <?= $obat['satuan'] ?></span>
                                                        </div>
                                                        <div class="info-row">
                                                            <span class="info-label">Stok:</span>
                                                            <span class="info-value"><?= $obat['stok_tersisa'] ?> <?= $obat['satuan'] ?></span>
                                                        </div>
                                                        <div class="info-row">
                                                            <span class="info-label">Harga:</span>
                                                            <span class="info-value">Rp <?= number_format($obat['harga']) ?></span>
                                                        </div>
                                                        <div class="info-row">
                                                            <span class="info-label">Supplier:</span>
                                                            <span class="info-value"><?= $obat['supplier'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-download mr-1"></i>Export Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                // Inventory data from PHP
                const inventoryData = <?= json_encode($inventoryObat) ?>;
                let currentPage = 1;
                const itemsPerPage = 10;
                let filteredData = [...inventoryData];

                // Initialize inventory table
                function initInventoryTable() {
                    renderInventoryTable();
                    updatePaginationInfo();
                    
                    // Global search functionality
                    document.getElementById('globalInventorySearch').addEventListener('input', function(e) {
                        const searchTerm = e.target.value.toLowerCase();
                        filteredData = inventoryData.filter(item => 
                            item.nama.toLowerCase().includes(searchTerm) ||
                            item.kategori.toLowerCase().includes(searchTerm) ||
                            item.sku.toLowerCase().includes(searchTerm) ||
                            item.supplier.toLowerCase().includes(searchTerm)
                        );
                        currentPage = 1;
                        renderInventoryTable();
                        updatePaginationInfo();
                    });
                    
                    // Filter tabs functionality
                    document.querySelectorAll('.filter-tab').forEach(tab => {
                        tab.addEventListener('click', function(e) {
                            e.preventDefault();
                            
                            // Remove active class from all tabs
                            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                            // Add active class to clicked tab
                            this.classList.add('active');
                            
                            const filter = this.getAttribute('data-filter');
                            applyFilter(filter);
                        });
                    });
                    
                    // Pagination controls
                    document.getElementById('prevBtn').addEventListener('click', function() {
                        if (currentPage > 1) {
                            currentPage--;
                            renderInventoryTable();
                            updatePaginationInfo();
                        }
                    });
                    
                    document.getElementById('nextBtn').addEventListener('click', function() {
                        const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                        if (currentPage < totalPages) {
                            currentPage++;
                            renderInventoryTable();
                            updatePaginationInfo();
                        }
                    });
                }

                function applyFilter(filter) {
                    switch(filter) {
                        case 'low-stock':
                            filteredData = inventoryData.filter(item => item.status_color === 'danger' || item.status_color === 'warning');
                            break;
                        case 'expiring':
                            filteredData = inventoryData.filter(item => 
                                item.expiry_status === 'Expired' || 
                                item.expiry_status === 'Expiring Soon' || 
                                item.expiry_status === 'Expires in 3 months'
                            );
                            break;
                        case 'recent':
                            // Sort by newest and take last 20 items
                            filteredData = [...inventoryData].slice(-20);
                            break;
                        default:
                            filteredData = [...inventoryData];
                    }
                    currentPage = 1;
                    renderInventoryTable();
                    updatePaginationInfo();
                }

                // Function to handle reorder medicine
                function reorderMedicine(sku) {
                    alert(`Reorder functionality for SKU: ${sku} will be implemented.`);
                    // TODO: Implement actual reorder functionality
                }

                function renderInventoryTable() {
                    const tableBody = document.getElementById('inventoryTableBody');
                    const startIndex = (currentPage - 1) * itemsPerPage;
                    const endIndex = startIndex + itemsPerPage;
                    const currentItems = filteredData.slice(startIndex, endIndex);
                    
                    tableBody.innerHTML = '';
                    
                    currentItems.forEach(item => {
                        const row = document.createElement('div');
                        row.className = 'inventory-table-row';
                        
                        // Format expiry date and status
                        const expDate = new Date(item.exp_date);
                        const formattedExpDate = expDate.toLocaleDateString('id-ID', { 
                            day: '2-digit', 
                            month: 'short', 
                            year: 'numeric' 
                        });
                        
                        // Format price
                        const formattedPrice = new Intl.NumberFormat('id-ID').format(item.harga);
                        
                        row.innerHTML = `
                            <div class="medicine-cell">
                                <div class="medicine-icon" style="background-color: ${item.color}20;">
                                    <i class="${item.icon}" style="color: ${item.color};"></i>
                                </div>
                                <div class="medicine-info">
                                    <div class="medicine-name">${item.nama}</div>
                                    <div class="medicine-sku">SKU: ${item.sku}</div>
                                </div>
                            </div>
                            <div class="category-cell">${item.kategori}</div>
                            <div class="stock-cell stock-${item.status_color}">
                                ${item.stok} ${item.satuan} 
                                <small class="d-block text-muted">Min: ${item.stok_minimum}</small>
                            </div>
                            <div class="price-cell">Rp ${formattedPrice}</div>
                            <div class="expiry-cell">
                                ${formattedExpDate}
                                <small class="d-block text-muted">${item.expiry_status}</small>
                            </div>
                            <div class="supplier-cell">${item.supplier}</div>
                            <div class="actions-cell">
                                <button class="btn action-btn reorder-action" onclick="reorderMedicine('${item.sku}')">
                                    <i class="fas fa-shopping-cart mr-1"></i>Reorder
                                </button>
                            </div>
                        `;
                        
                        tableBody.appendChild(row);
                    });
                }

                function updatePaginationInfo() {
                    const totalItems = filteredData.length;
                    const startIndex = (currentPage - 1) * itemsPerPage + 1;
                    const endIndex = Math.min(currentPage * itemsPerPage, totalItems);
                    const totalPages = Math.ceil(totalItems / itemsPerPage);
                    
                    document.getElementById('paginationInfo').textContent = 
                        `Showing ${startIndex}-${endIndex} of ${totalItems} items`;
                    
                    // Update button states
                    document.getElementById('prevBtn').disabled = currentPage === 1;
                    document.getElementById('nextBtn').disabled = currentPage === totalPages || totalPages === 0;
                }

                // Function to filter medicines by category
                function filterByCategory(categoryName) {
                    console.log('Filtering by category:', categoryName);
                    
                    // Update search input
                    document.getElementById('globalInventorySearch').value = categoryName;
                    
                    // Filter data
                    filteredData = inventoryData.filter(item => 
                        item.kategori.toLowerCase().includes(categoryName.toLowerCase())
                    );
                    
                    currentPage = 1;
                    renderInventoryTable();
                    updatePaginationInfo();
                    
                    // Scroll to inventory table
                    document.querySelector('.modern-inventory-table').scrollIntoView({ 
                        behavior: 'smooth' 
                    });
                }

                // Initialize when DOM is loaded
                document.addEventListener('DOMContentLoaded', function() {
                    initInventoryTable();
                });
                </script>

                </div>
            </main>
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Apothecary - 2024</div>
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
