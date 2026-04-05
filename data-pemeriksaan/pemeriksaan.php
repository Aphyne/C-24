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
    <title>Apothecary | Data Pemeriksaan</title>
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
            
            /* Mobile chart adjustments */
            .chart-container {
                min-height: 450px;
                margin-bottom: 20px;
            }
            .chart-wrapper {
                height: 300px;
            }
            .chart-body {
                padding: 12px 16px 20px 16px;
                min-height: 350px;
            }
            .chart-header {
                padding: 16px 20px 12px 20px;
            }
            .chart-title {
                font-size: 1rem;
            }
            .chart-subtitle {
                font-size: 0.8rem;
            }
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
            height: 350px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            width: 100%;
            overflow: hidden;
            flex: 1;
            margin-bottom: 16px;
        }
        
        /* Responsive chart canvas */
        .chart-wrapper canvas {
            max-width: 100% !important;
            max-height: 100% !important;
        }
        .chart-caption {
            margin-top: 0.75rem;
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        /* ===== Modern Chart Container ===== */
        .chart-container {
            background: #fff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            padding: 0;
            margin-bottom: 24px;
            overflow: visible;
            min-height: 520px;
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
            min-height: 420px;
            position: relative;
            overflow: visible;
            display: flex;
            flex-direction: column;
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
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 4px solid #6fc3d0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-top: 0;
            font-size: 0.85rem;
            color: #495057;
            font-weight: 500;
            border: 1px solid #dee2e6;
            margin-left: 0;
            margin-right: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: relative;
            flex-shrink: 0;
        }

        /* Enhanced Chart Body */
        .chart-body {
            position: relative;
            height: 280px;
            padding: 15px;
        }
        
        .chart-body canvas {
            max-height: 100% !important;
        }

        /* Style untuk Visualisasi Chart seperti obat.php */
        .demografi-chart-canvas {
            width: 100% !important;
            height: 100% !important;
            max-height: 100%;
        }
        
        .chart-wrapper {
            height: 350px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }
        
        /* Responsive chart canvas */
        .chart-wrapper canvas {
            max-width: 100% !important;
            max-height: 100% !important;
        }
        
        .chart-caption {
            margin-top: 0.75rem;
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* Chart Animation */
        @keyframes chartFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chart-container {
            animation: chartFadeIn 0.6s ease-out;
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
            padding: 20px 24px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
            gap: 20px;
        }
        
        .header-left {
            flex: 1;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }
        
        .search-filter input {
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 0.875rem;
            color: #495057;
            background-color: #fff;
            min-width: 250px;
            transition: all 0.3s ease;
        }
        
        .search-filter input:focus {
            border-color: #5459AC;
            box-shadow: 0 0 0 0.2rem rgba(84, 89, 172, 0.25);
            outline: none;
        }
        
        .search-filter input::placeholder {
            color: #adb5bd;
            font-style: italic;
        }
        .modern-table-title {
            color: #495057;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
        .modern-table-title i {
            color: #6fc3d0;
            margin-right: 8px;
            font-size: 1.2rem;
        }
        .modern-table-title small {
            font-size: 0.8rem;
            font-weight: 400;
            color: #6c757d;
            margin-left: 8px;
        }
        .add-btn {
            background: linear-gradient(135deg, #5459AC 30%, rgb(111,195,208) 100%);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(84, 89, 172, 0.3);
            white-space: nowrap;
        }
        .add-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(84, 89, 172, 0.4);
            color: #fff;
            text-decoration: none;
        }
        
        .table-responsive {
            border: none;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 0;
            box-shadow: none;
        }
        
        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }
        
        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .table-responsive::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        .modern-table {
            width: 100%;
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            table-layout: fixed;
        }
        .modern-table thead th {
            background: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 8px;
            border: none;
            border-bottom: 2px solid #e9ecef;
            text-align: left;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 10;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .modern-table tbody td {
            padding: 12px 8px;
            border: none;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
            color: #495057;
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 0.65rem;
            font-weight: 500;
            text-transform: capitalize;
            display: inline-block;
            white-space: nowrap;
            text-align: center;
            min-width: 60px;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Kolom khusus untuk teks panjang */
        .modern-table tbody td:nth-child(2),
        .modern-table tbody td:nth-child(3),
        .modern-table tbody td:nth-child(4),
        .modern-table tbody td:nth-child(5) {
            white-space: normal;
            word-wrap: break-word;
            max-width: 150px;
        }
        
        /* Kolom nomor tetap kecil */
        .modern-table tbody td:nth-child(1) {
            text-align: center;
            font-weight: 600;
            width: 4%;
            min-width: 40px;
        }
        
        /* Kolom biaya dan status lebih kompak */
        .modern-table tbody td:nth-child(7),
        .modern-table tbody td:nth-child(8) {
            text-align: center;
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
        .status-danger {
            background: #fee2e2;
            color: #dc2626;
        }
        
        /* Patient Name Styling */
        .patient-name {
            font-weight: 600;
            color: #2c3e50;
        }
        
        /* Doctor Name Styling */
        .text-primary {
            color: #5459AC !important;
            font-weight: 500;
        }
        
        /* Currency Styling */
        .text-success {
            color: #16a34a !important;
        }
        
        /* Bootstrap Badge Styles */
        .badge {
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: capitalize;
            display: inline-block;
        }
        .badge-success {
            background: #28a745;
            color: white;
        }
        .badge-primary {
            background: #007bff;
            color: white;
        }
        .badge-warning {
            background: #ffc107;
            color: #212529;
        }
        .badge-danger {
            background: #dc3545;
            color: white;
        }

        /* Padding atas main agar tidak menempel headbar */
        #layoutSidenav_content main > .container-fluid,
        #layoutSidenav_content main > .container {
            padding-top: 1.5rem;
        }

        /* Custom DataTable Styling */
        .dataTables_wrapper {
            padding: 20px;
        }
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
            display: inline-block;
        }
        
        .dataTables_wrapper .dataTables_length {
            float: left;
        }
        
        .dataTables_wrapper .dataTables_filter {
            float: right;
        }
        
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            font-weight: 500;
            color: #495057;
            font-size: 0.9rem;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 0.875rem;
            color: #495057;
            background-color: #fff;
            min-width: 80px;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 0.875rem;
            color: #495057;
            background-color: #fff;
            min-width: 200px;
        }
        
        .dataTables_wrapper .dataTables_info {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 20px;
            padding-top: 10px;
            float: left;
        }
        
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 20px;
            padding-top: 10px;
            float: right;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 1px solid #e9ecef;
            background: #fff;
            color: #495057 !important;
            padding: 10px 20px;
            margin: 0 6px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            min-width: 100px;
            text-align: center;
            outline: none !important;
            box-shadow: none !important;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:focus {
            outline: none !important;
            box-shadow: none !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(135deg, #5459AC 30%, rgb(111,195,208) 100%) !important;
            border-color: #5459AC;
            color: #fff !important;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(84, 89, 172, 0.3) !important;
            outline: none !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #5459AC 30%, rgb(111,195,208) 100%) !important;
            border-color: #5459AC;
            color: #fff !important;
            box-shadow: 0 2px 8px rgba(84, 89, 172, 0.3) !important;
            outline: none !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            background: #f8f9fa !important;
            border-color: #e9ecef;
            color: #adb5bd !important;
            cursor: not-allowed;
            opacity: 0.6;
            outline: none !important;
            box-shadow: none !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: #f8f9fa !important;
            border-color: #e9ecef;
            color: #adb5bd !important;
            transform: none;
            box-shadow: none !important;
            outline: none !important;
        }
        
        /* Clear floats */
        .dataTables_wrapper::after {
            content: "";
            display: table;
            clear: both;
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
        
        .dataTables_wrapper .row {
            margin: 0;
        }
        
        .dataTables_wrapper .row::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="../index.php">Apothecary</a>
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
                        <div class="sb-sidenav-menu-heading">Apothecary</div>
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
                            <!-- <a class="nav-link" href="../chatbot-ai/chatbot.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Chatbot AI
                            </a> -->
                            <a class="nav-link active" href="../data-pemeriksaan/pemeriksaan.php">
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
                    // Ambil data dari database clinic.sql dengan error handling
                    $queryTotalPemeriksaan = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_pemeriksaan WHERE status_pemeriksaan = 'selesai'");
                    $totalPemeriksaan = ($queryTotalPemeriksaan) ? mysqli_fetch_assoc($queryTotalPemeriksaan)['total'] : 0;
                    
                    $queryPasienBatal = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_pendaftaran WHERE status_pendaftaran = 'batal'");
                    $pasienBatal = ($queryPasienBatal) ? mysqli_fetch_assoc($queryPasienBatal)['total'] : 0;
                    
                    // Hitung rata-rata durasi berdasarkan waktu pemeriksaan (simulasi durasi 10-30 menit per pemeriksaan)
                    $queryRataDurasi = mysqli_query($koneksi, "SELECT AVG(15 + (id_pemeriksaan % 16)) as rata_durasi FROM tb_pemeriksaan WHERE status_pemeriksaan = 'selesai'");
                    $rataDurasi = ($queryRataDurasi) ? mysqli_fetch_assoc($queryRataDurasi)['rata_durasi'] : 18;
                    
                    // Ambil keluhan terbanyak dari database
                    $queryKeluhanTerbanyak = mysqli_query($koneksi, "SELECT keluhan, COUNT(*) as jumlah FROM tb_pemeriksaan WHERE keluhan IS NOT NULL AND keluhan != '' GROUP BY keluhan ORDER BY jumlah DESC LIMIT 1");
                    $dataKeluhanTerbanyak = ($queryKeluhanTerbanyak && mysqli_num_rows($queryKeluhanTerbanyak) > 0) ? mysqli_fetch_assoc($queryKeluhanTerbanyak) : null;
                    $keluhanTerbanyak = $dataKeluhanTerbanyak ? $dataKeluhanTerbanyak['keluhan'] : 'Tidak ada data';
                    $jumlahKeluhanTerbanyak = $dataKeluhanTerbanyak ? $dataKeluhanTerbanyak['jumlah'] : 0;
                    
                    // Ambil data pemeriksaan untuk keperluan lainnya
                    $queryDataPemeriksaan = mysqli_query($koneksi, "SELECT tp.*, tpa.nama_pasien, tp.keluhan, tp.diagnosa, tp.tanggal_pemeriksaan, tp.status_pemeriksaan 
                                                                   FROM tb_pemeriksaan tp 
                                                                   JOIN tb_pasien tpa ON tp.id_pasien = tpa.id_pasien 
                                                                   WHERE tp.status_pemeriksaan = 'selesai' 
                                                                   ORDER BY tp.tanggal_pemeriksaan DESC");
                    $dataPemeriksaan = [];
                    if($queryDataPemeriksaan && mysqli_num_rows($queryDataPemeriksaan) > 0) {
                        while($row = mysqli_fetch_assoc($queryDataPemeriksaan)) {
                            $dataPemeriksaan[] = [
                                "nama" => $row['nama_pasien'],
                                "keluhan" => $row['keluhan'],
                                "diagnosa" => $row['diagnosa'],
                                "tanggal" => $row['tanggal_pemeriksaan'],
                                "durasi" => 15 + ($row['id_pemeriksaan'] % 16), // simulasi durasi 15-30 menit
                                "status" => ucfirst($row['status_pemeriksaan'])
                            ];
                        }
                    }

                    // Ambil data diagnosa per hari dari database (HARUS sebelum AI Insight)
                    $dataDiagnosaPerHari = [];
                    $hariArray = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
                    foreach($hariArray as $hari) {
                        $dayNumberMap = [
                            "Minggu" => 1,
                            "Senin" => 2, 
                            "Selasa" => 3,
                            "Rabu" => 4,
                            "Kamis" => 5,
                            "Jumat" => 6,
                            "Sabtu" => 7
                        ];
                        $dayNumber = $dayNumberMap[$hari];
                        $queryDiagnosa = mysqli_query($koneksi,
                            "SELECT diagnosa, COUNT(*) as jumlah " .
                            " FROM tb_pemeriksaan " .
                            " WHERE DAYOFWEEK(tanggal_pemeriksaan) = $dayNumber " .
                            " AND diagnosa IS NOT NULL AND diagnosa != '' " .
                            " AND status_pemeriksaan = 'selesai' " .
                            " GROUP BY diagnosa " .
                            " ORDER BY jumlah DESC " .
                            " LIMIT 5"
                        );
                        $dataDiagnosaPerHari[$hari] = [];
                        if($queryDiagnosa && mysqli_num_rows($queryDiagnosa) > 0) {
                            while($row = mysqli_fetch_assoc($queryDiagnosa)) {
                                $dataDiagnosaPerHari[$hari][$row['diagnosa']] = $row['jumlah'];
                            }
                        }
                        if(empty($dataDiagnosaPerHari[$hari])) {
                            $dataDiagnosaPerHari[$hari] = ["Tidak ada data" => 0];
                        }
                    }

                    // Ambil data waktu tunggu dari database tb_laporan_waktu_tunggu
                    $waktuTungguPerHari = [];
                    foreach($hariArray as $hari) {
                        $queryWaktuTunggu = mysqli_query($koneksi,
                            "SELECT TIME_FORMAT(jam_laporan, '%H:%i') as jam, " .
                            "waktu_tunggu_rata as rata_tunggu " .
                            "FROM tb_laporan_waktu_tunggu " .
                            "WHERE hari = '$hari' " .
                            "ORDER BY jam_laporan"
                        );
                        $waktuTungguPerHari[$hari] = [];
                        if($queryWaktuTunggu && mysqli_num_rows($queryWaktuTunggu) > 0) {
                            while($row = mysqli_fetch_assoc($queryWaktuTunggu)) {
                                $waktuTungguPerHari[$hari][$row['jam']] = round($row['rata_tunggu'], 1);
                            }
                        }
                        if(empty($waktuTungguPerHari[$hari])) {
                            $waktuTungguPerHari[$hari] = ["08:00" => 0, "17:00" => 0];
                        }
                    }

                    // Implementasi AI Insight (khusus pemeriksaan.php)
                    $ai_insight = null;
                    if (file_exists(__DIR__ . '/../ai-insights/classes/GeminiInsightGenerator.php')) {
                        include_once __DIR__ . '/../ai-insights/classes/GeminiInsightGenerator.php';
                        if (class_exists('GeminiInsightGenerator')) {
                            $generator = new GeminiInsightGenerator();
                            // Kumpulkan seluruh data statistik yang sudah dihitung
                            $topDiagnosaQuery = mysqli_query($koneksi, "SELECT diagnosa, COUNT(*) as total, MIN(tanggal_pemeriksaan) as first_date, MAX(tanggal_pemeriksaan) as last_date FROM tb_pemeriksaan WHERE diagnosa IS NOT NULL AND diagnosa != '' AND status_pemeriksaan = 'selesai' GROUP BY diagnosa ORDER BY total DESC LIMIT 1");
                            $topDiagnosa = ($topDiagnosaQuery && mysqli_num_rows($topDiagnosaQuery) > 0) ? mysqli_fetch_assoc($topDiagnosaQuery) : null;

                            $maxWaktuQuery = mysqli_query($koneksi, "SELECT hari, TIME_FORMAT(jam_laporan, '%H:%i') as jam, waktu_tunggu_rata FROM tb_laporan_waktu_tunggu ORDER BY waktu_tunggu_rata DESC LIMIT 1");
                            $maxWaktu = ($maxWaktuQuery && mysqli_num_rows($maxWaktuQuery) > 0) ? mysqli_fetch_assoc($maxWaktuQuery) : null;

                            $data_ai = [
                                'total_pemeriksaan' => $totalPemeriksaan,
                                'pasien_batal' => $pasienBatal,
                                'rata_durasi' => round($rataDurasi, 1),
                                'keluhan_terbanyak' => $keluhanTerbanyak,
                                'jumlah_keluhan_terbanyak' => $jumlahKeluhanTerbanyak,
                                'diagnosa_per_hari' => $dataDiagnosaPerHari,
                                'waktu_tunggu_per_hari' => $waktuTungguPerHari,
                                'diagnosa_teratas' => $topDiagnosa,
                                'waktu_tunggu_tertinggi' => $maxWaktu,
                                'data_pemeriksaan' => $dataPemeriksaan,
                                // Anda bisa menambah data lain yang relevan di sini
                            ];
                            // Prompt lebih detail agar insight AI lebih actionable dan spesifik
                            $prompt = "Berdasarkan data statistik klinik berikut, berikan insight operasional yang spesifik dan actionable. Analisa tren penyakit, jam sibuk, waktu tunggu tertinggi, keluhan terbanyak, dan rekomendasikan tindakan nyata untuk efisiensi klinik, pengelolaan stok obat, serta peningkatan pelayanan pasien. Sertakan minimal 3 insight yang benar-benar relevan dan berbasis data real berikut. Jangan hanya menyimpulkan normal, berikan saran konkret dan analisis mendalam.";
                            // Buat ringkasan statistik utama untuk prompt
                            $stat_summary = "\nRingkasan statistik:\n" .
                                "- Total pemeriksaan: {$totalPemeriksaan}\n" .
                                "- Pasien batal: {$pasienBatal}\n" .
                                "- Rata-rata durasi konsultasi: " . round($rataDurasi, 1) . " menit\n" .
                                "- Keluhan terbanyak: {$keluhanTerbanyak} ({$jumlahKeluhanTerbanyak} kasus)\n" .
                                "- Diagnosa teratas: " . ($topDiagnosa ? $topDiagnosa['diagnosa'] . " ({$topDiagnosa['total']} kasus)" : '-') . "\n" .
                                "- Waktu tunggu tertinggi: " . ($maxWaktu ? $maxWaktu['hari'] . " jam " . $maxWaktu['jam'] . " ({$maxWaktu['waktu_tunggu_rata']} menit)" : '-') . "\n";

                            // Format data per hari (diagnosa dan waktu tunggu)
                            $stat_summary .= "\nDiagnosa per hari:\n";
                            foreach($dataDiagnosaPerHari as $hari => $diagnosaList) {
                                $stat_summary .= "- {$hari}: ";
                                $diagnosaStr = [];
                                foreach($diagnosaList as $diag => $jumlah) {
                                    if($diag !== "Tidak ada data") $diagnosaStr[] = "$diag ($jumlah)";
                                }
                                $stat_summary .= (count($diagnosaStr) ? implode(', ', $diagnosaStr) : 'Tidak ada data') . "\n";
                            }

                            $stat_summary .= "\nWaktu tunggu per hari:\n";
                            foreach($waktuTungguPerHari as $hari => $jamList) {
                                $stat_summary .= "- {$hari}: ";
                                $jamStr = [];
                                foreach($jamList as $jam => $rata) {
                                    $jamStr[] = "$jam ($rata menit)";
                                }
                                $stat_summary .= (count($jamStr) ? implode(', ', $jamStr) : 'Tidak ada data') . "\n";
                            }

                            // Gabungkan prompt dan statistik
                            $full_prompt = $prompt . "\n" . $stat_summary;
                            $ai_insight = $generator->generateInsight($full_prompt, []);
                        }
                    }
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
                                    <?php
                                    // Tampilkan hanya insight AI
                                    if (!empty($ai_insight)) {
                                        echo '<li>' . htmlspecialchars($ai_insight) . '</li>';
                                    } else {
                                        echo '<li><em>Insight AI tidak tersedia.</em></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Ambil data diagnosa per hari dari database
                    $dataDiagnosaPerHari = [];
                    $hariArray = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
                    
                    foreach($hariArray as $hari) {
                        // Map nama hari ke nomor hari MySQL (1=Sunday, 2=Monday, dst.)
                        $dayNumberMap = [
                            "Minggu" => 1,
                            "Senin" => 2, 
                            "Selasa" => 3,
                            "Rabu" => 4,
                            "Kamis" => 5,
                            "Jumat" => 6,
                            "Sabtu" => 7
                        ];
                        $dayNumber = $dayNumberMap[$hari];
                        
                        $queryDiagnosa = mysqli_query($koneksi, "SELECT diagnosa, COUNT(*) as jumlah 
                                                               FROM tb_pemeriksaan 
                                                               WHERE DAYOFWEEK(tanggal_pemeriksaan) = $dayNumber 
                                                               AND diagnosa IS NOT NULL AND diagnosa != ''
                                                               AND status_pemeriksaan = 'selesai'
                                                               GROUP BY diagnosa 
                                                               ORDER BY jumlah DESC 
                                                               LIMIT 5");
                        
                        $dataDiagnosaPerHari[$hari] = [];
                        
                        // Periksa apakah query berhasil dan ada data
                        if($queryDiagnosa && mysqli_num_rows($queryDiagnosa) > 0) {
                            while($row = mysqli_fetch_assoc($queryDiagnosa)) {
                                $dataDiagnosaPerHari[$hari][$row['diagnosa']] = $row['jumlah'];
                            }
                        }
                        
                        // Jika tidak ada data, buat data default
                        if(empty($dataDiagnosaPerHari[$hari])) {
                            $dataDiagnosaPerHari[$hari] = ["Tidak ada data" => 0];
                        }
                    }

                    // Ambil data waktu tunggu dari database tb_laporan_waktu_tunggu
                    $waktuTungguPerHari = [];
                    foreach($hariArray as $hari) {
                        $queryWaktuTunggu = mysqli_query($koneksi, "SELECT TIME_FORMAT(jam_laporan, '%H:%i') as jam, 
                                                                   waktu_tunggu_rata as rata_tunggu 
                                                                   FROM tb_laporan_waktu_tunggu 
                                                                   WHERE hari = '$hari' 
                                                                   ORDER BY jam_laporan");
                        
                        $waktuTungguPerHari[$hari] = [];
                        
                        // Periksa apakah query berhasil dan ada data
                        if($queryWaktuTunggu && mysqli_num_rows($queryWaktuTunggu) > 0) {
                            while($row = mysqli_fetch_assoc($queryWaktuTunggu)) {
                                $waktuTungguPerHari[$hari][$row['jam']] = round($row['rata_tunggu'], 1);
                            }
                        }
                        
                        // Jika tidak ada data real, tampilkan pesan kosong
                        if(empty($waktuTungguPerHari[$hari])) {
                            $waktuTungguPerHari[$hari] = ["08:00" => 0, "17:00" => 0];
                        }
                    }
                    ?>

                    <!-- 🔵 Charts Section -->
                    <div class="row mb-4">
                        <!-- 📊 Kiri: Diagnosa & Keluhan -->
                        <div class="col-md-6">
                            <div class="chart-container">
                                <div class="chart-header">
                                    <h6 class="chart-title">Analisis Diagnosa & Keluhan</h6>
                                    <p class="chart-subtitle">
                                        Mengidentifikasi pola penyakit untuk penyesuaian layanan dan stok obat
                                        <?php 
                                        // Tambahkan info periode data
                                        $firstDateQuery = mysqli_query($koneksi, "SELECT MIN(tanggal_pemeriksaan) as min_date, MAX(tanggal_pemeriksaan) as max_date FROM tb_pemeriksaan WHERE status_pemeriksaan = 'selesai'");
                                        if($firstDateQuery && mysqli_num_rows($firstDateQuery) > 0) {
                                            $dateRange = mysqli_fetch_assoc($firstDateQuery);
                                            if($dateRange['min_date'] && $dateRange['max_date']) {
                                                $minDate = date('d M Y', strtotime($dateRange['min_date']));
                                                $maxDate = date('d M Y', strtotime($dateRange['max_date']));
                                                echo "<br><small class='text-muted'><i class='fas fa-calendar-alt'></i> Periode: {$minDate} - {$maxDate}</small>";
                                            }
                                        }
                                        ?>
                                    </p>
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
                                        <?php 
                                        // Analisis diagnosa tersering (status selesai saja) dengan info tanggal
                                        $topDiagnosaQuery = mysqli_query($koneksi, "SELECT diagnosa, COUNT(*) as total, 
                                                                                   MIN(tanggal_pemeriksaan) as first_date,
                                                                                   MAX(tanggal_pemeriksaan) as last_date
                                                                                   FROM tb_pemeriksaan 
                                                                                   WHERE diagnosa IS NOT NULL AND diagnosa != ''
                                                                                   AND status_pemeriksaan = 'selesai'
                                                                                   GROUP BY diagnosa 
                                                                                   ORDER BY total DESC LIMIT 1");
                                        if($topDiagnosaQuery && mysqli_num_rows($topDiagnosaQuery) > 0) {
                                            $topDiagnosa = mysqli_fetch_assoc($topDiagnosaQuery);
                                            $firstDate = date('d M Y', strtotime($topDiagnosa['first_date']));
                                            $lastDate = date('d M Y', strtotime($topDiagnosa['last_date']));
                                            echo "Diagnosa <strong>\"{$topDiagnosa['diagnosa']}\"</strong> paling sering terjadi ({$topDiagnosa['total']} kasus, {$firstDate} - {$lastDate}). Pastikan stok obat terkait selalu optimal.";
                                        } else {
                                            echo "Data diagnosa pemeriksaan selesai belum tersedia untuk analisis stok obat.";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 🕒 Kanan: Waktu Tunggu -->
                        <div class="col-md-6">
                            <div class="chart-container">
                                <div class="chart-header">
                                    <h6 class="chart-title">Laporan Waktu Tunggu</h6>
                                    <p class="chart-subtitle">
                                        Optimasi pelayanan & efisiensi tenaga medis berdasarkan jam operasional
                                        <?php 
                                        // Tambahkan info periode data waktu tunggu
                                        $waktuTungguDateQuery = mysqli_query($koneksi, "SELECT MIN(tanggal_laporan) as min_date, MAX(tanggal_laporan) as max_date FROM tb_laporan_waktu_tunggu");
                                        if($waktuTungguDateQuery && mysqli_num_rows($waktuTungguDateQuery) > 0) {
                                            $waktuTungguDateRange = mysqli_fetch_assoc($waktuTungguDateQuery);
                                            if($waktuTungguDateRange['min_date'] && $waktuTungguDateRange['max_date']) {
                                                $minDateWaktu = date('d M Y', strtotime($waktuTungguDateRange['min_date']));
                                                $maxDateWaktu = date('d M Y', strtotime($waktuTungguDateRange['max_date']));
                                                echo "<br><small class='text-muted'><i class='fas fa-calendar-alt'></i> Periode: {$minDateWaktu} - {$maxDateWaktu}</small>";
                                            }
                                        }
                                        ?>
                                    </p>
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
                                        <?php 
                                        // Analisis waktu tunggu tertinggi berdasarkan data real
                                        $maxWaktuQuery = mysqli_query($koneksi, "SELECT hari, TIME_FORMAT(jam_laporan, '%H:%i') as jam, waktu_tunggu_rata 
                                                                                FROM tb_laporan_waktu_tunggu 
                                                                                ORDER BY waktu_tunggu_rata DESC LIMIT 1");
                                        if($maxWaktuQuery && mysqli_num_rows($maxWaktuQuery) > 0) {
                                            $maxWaktu = mysqli_fetch_assoc($maxWaktuQuery);
                                            echo "Waktu tunggu tertinggi: <strong>{$maxWaktu['hari']} jam {$maxWaktu['jam']}</strong> ({$maxWaktu['waktu_tunggu_rata']} menit). Pertimbangkan penambahan tenaga medis.";
                                        } else {
                                            echo "Data waktu tunggu belum tersedia. Pastikan sistem monitoring berjalan dengan baik.";
                                        }
                                        ?>
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
                                layout: {
                                    padding: {
                                        top: 10,
                                        right: 15,
                                        bottom: 10,
                                        left: 15
                                    }
                                },
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
                                    label: 'Waktu Tunggu Aktual',
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
                                    label: 'Target Ideal',
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
                                layout: {
                                    padding: {
                                        top: 10,
                                        right: 15,
                                        bottom: 10,
                                        left: 15
                                    }
                                },
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
                                        enabled: true,
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleColor: '#fff',
                                        bodyColor: '#fff',
                                        borderColor: '#6fc3d0',
                                        borderWidth: 1,
                                        callbacks: {
                                            label: function(context) {
                                                return context.dataset.label + ': ' + context.parsed.y + ' menit';
                                            }
                                        }
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
                                            stepSize: 5,
                                            callback: function(value) {
                                                return value + ' min';
                                            }
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

                    <h4 class="mb-4 font-weight-bold text-secondary mt-5">Detail Tabel Pemeriksaan</h4>
                    
                    <!-- Tabel Database Pemeriksaan -->
                    <div class="modern-table-wrapper">
                        <div class="modern-table-header">
                            <div class="header-left">
                                <h6 class="modern-table-title">
                                    <i class="fas fa-database"></i>
                                    Database Pemeriksaan Klinik
                                    <?php 
                                    $totalDataQuery = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_pemeriksaan");
                                    $totalData = mysqli_fetch_assoc($totalDataQuery)['total'];
                                    ?>
                                    <small class="text-muted ml-2">(Total <?= $totalData ?> data)</small>
                                </h6>
                            </div>
                            <div class="header-right">
                                <div class="search-filter">
                                    <input type="text" id="tableSearch" class="form-control" placeholder="Cari data pemeriksaan..." style="width: 250px; margin-right: 15px;">
                                </div>
                                <a href="pemeriksaan_input.php" class="add-btn">
                                    <i class="fas fa-plus mr-1"></i> Tambah Data Periksa
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="modern-table" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pasien</th>
                                        <th>Dokter</th>
                                        <th>Keluhan</th>
                                        <th>Diagnosa</th>
                                        <th>Tanggal Periksa</th>
                                        <th>Biaya</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $queryTabelPemeriksaan = mysqli_query($koneksi, "SELECT tp.*, tpa.nama_pasien, td.nama_dokter 
                                                                                     FROM tb_pemeriksaan tp 
                                                                                     JOIN tb_pasien tpa ON tp.id_pasien = tpa.id_pasien 
                                                                                     JOIN tb_dokter td ON tp.id_dokter = td.id_dokter 
                                                                                     ORDER BY tp.id_pemeriksaan ASC");
                                    
                                    if (!$queryTabelPemeriksaan) {
                                        echo "<tr><td colspan='8' class='text-center text-danger'>Error: " . mysqli_error($koneksi) . "</td></tr>";
                                    } elseif (mysqli_num_rows($queryTabelPemeriksaan) == 0) {
                                        echo "<tr><td colspan='8' class='text-center text-muted'>Tidak ada data pemeriksaan</td></tr>";
                                    } else {
                                        $no = 1;
                                        while($tabel = mysqli_fetch_assoc($queryTabelPemeriksaan)):
                                    ?>
                                    <tr>
                                        <td><strong><?= $no++ ?></strong></td>
                                        <td><span class="patient-name"><?= $tabel['nama_pasien'] ?></span></td>
                                        <td><span class="text-primary"><?= $tabel['nama_dokter'] ?></span></td>
                                        <td><span class="status-badge status-info"><?= $tabel['keluhan'] ?: 'Tidak ada' ?></span></td>
                                        <td><?= $tabel['diagnosa'] ?: 'Belum ada' ?></td>
                                        <td><?= date('d M Y H:i', strtotime($tabel['tanggal_pemeriksaan'] . ' ' . $tabel['jam_pemeriksaan'])) ?></td>
                                        <td>
                                            <span class="font-weight-bold text-success">
                                                Rp <?= number_format($tabel['biaya_pemeriksaan'], 0, ',', '.') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if($tabel['status_pemeriksaan'] == 'selesai'): ?>
                                                <span class="status-badge status-success">Selesai</span>
                                            <?php elseif($tabel['status_pemeriksaan'] == 'berlangsung'): ?>
                                                <span class="status-badge status-warning">Berlangsung</span>
                                            <?php elseif($tabel['status_pemeriksaan'] == 'menunggu'): ?>
                                                <span class="status-badge status-info">Menunggu</span>
                                            <?php else: ?>
                                                <span class="status-badge status-danger">Batal</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php 
                                        endwhile; 
                                    } // end else
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Button Input Data Pemeriksaan -->
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Apothecary - 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/Chart.min.js"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Custom DataTable Configuration -->
    <script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            "pageLength": 15,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "language": {
                "zeroRecords": "Tidak ada data ditemukan",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "search": "Cari:",
                "paginate": {
                    "next": "Next",
                    "previous": "Previous"
                }
            },
            "order": [[ 0, "asc" ]],
            "columnDefs": [
                { "orderable": false, "targets": [7] },
                { "type": "num", "targets": 0 },
                { "width": "4%", "targets": 0 },
                { "width": "16%", "targets": 1 },
                { "width": "14%", "targets": 2 },
                { "width": "16%", "targets": 3 },
                { "width": "14%", "targets": 4 },
                { "width": "13%", "targets": 5 },
                { "width": "12%", "targets": 6 },
                { "width": "11%", "targets": 7 }
            ],
            "responsive": false,
            "autoWidth": false,
            "processing": true,
            "deferRender": true,
            "scrollX": false,
            "fixedHeader": false,
            "dom": 'rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            "pagingType": "simple"
        });
        
        // Custom search functionality
        $('#tableSearch').on('keyup input', function() {
            var searchValue = this.value;
            table.search(searchValue).draw();
        });
        
        // Clear search when input is empty
        $('#tableSearch').on('search', function() {
            if (this.value === '') {
                table.search('').draw();
            }
        });
    });
    </script>
    
    <!-- Responsive Mobile Table Fix -->
    <style>
    @media (max-width: 768px) {
        .modern-table-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        
        .header-right {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        
        .search-filter input {
            min-width: 100%;
            font-size: 0.8rem;
        }
        
        .modern-table-title {
            font-size: 1rem;
        }
        
        .modern-table-title small {
            display: block;
            margin-left: 0;
            margin-top: 4px;
        }
        
        .add-btn {
            padding: 8px 16px;
            font-size: 0.8rem;
            text-align: center;
        }
        
        .dataTables_wrapper {
            padding: 15px;
        }
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            float: none !important;
            text-align: center;
            margin-bottom: 15px;
        }
        
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            float: none !important;
            text-align: center;
            margin-top: 15px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 16px;
            margin: 0 3px;
            font-size: 0.75rem;
            min-width: 80px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            transform: translateY(-1px);
        }
        
        .modern-table thead th {
            padding: 8px 4px;
            font-size: 0.6rem;
        }
        
        .modern-table tbody td {
            padding: 8px 4px;
            font-size: 0.7rem;
            white-space: normal;
        }
        
        .modern-table tbody td:nth-child(2),
        .modern-table tbody td:nth-child(3),
        .modern-table tbody td:nth-child(4),
        .modern-table tbody td:nth-child(5) {
            max-width: 100px;
            font-size: 0.65rem;
        }
        
        .status-badge {
            padding: 2px 6px;
            font-size: 0.6rem;
            min-width: 50px;
        }
    }
    </style>
</body>

</html>
