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
<!-- haloww -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Poli Klinik | Dashboard</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="assets/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
  background: linear-gradient(135deg, #5459AC 50%, rgb(111,195,208) 100%) !important; /* gradasi terbalik, dominan ungu */
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
  color: #fff !important; /* tetap putih saat hover/active */
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

/* Scrollbar sidebar */
.sb-sidenav::-webkit-scrollbar {
  width: 7px;
  background: transparent;
}
.sb-sidenav::-webkit-scrollbar-thumb {
  background: rgba(255,255,255,0.18);
  border-radius: 8px;
}

/* Responsive sidebar */
@media (max-width: 991px) {
  .sb-sidenav {
    background:linear-gradient(135deg, #5459AC 30%, rgb(111,195,208) 100%) !important; 
  }
}

  .summary-box {
    background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 16px rgba(8,131,149,0.10); /* gunakan warna #088395 */
    padding: 20px;
    margin-bottom: 20px;
    transition: box-shadow 0.3s, transform 0.3s;
    height: 100%;
    color: #222;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .summary-box:hover {
    box-shadow: 0 8px 32px rgba(8,131,149,0.25); /* gunakan warna #088395 */
    transform: translateY(-4px) scale(1.03);
  }

  .summary-title {
    font-weight: bold;
    font-size: 14px;
    color: #088395; /* gunakan warna #088395 */
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
  display: inline-block;      /* hanya selebar tulisan */
  min-width: unset;           /* pastikan tidak ada lebar minimum */
  width: auto;                /* pastikan selebar konten */
  max-width: 100%;
  text-align: left;
  box-shadow: 0 1px 4px rgba(8,131,149,0.08);
  color: #5459AC !important;
  vertical-align: top;
  background: transparent;    /* pastikan default transparan */
}
  .custom-bg-success {
    background: rgba(40, 167, 69, 0.18) !important;   /* hijau transparan hanya di belakang teks */
  }
  .custom-bg-danger {
    background: rgba(220, 53, 69, 0.18) !important;   /* merah transparan hanya di belakang teks */
  }

  .summary-icon {
    font-size: 24px;
    background: linear-gradient(135deg,rgb(111, 195, 208) 0%, #5459AC 100%);
    color: #fff;
    border-radius: 10px;
    padding: 10px 14px;
    margin-left: auto;
    margin-right: 0;
    box-shadow: 0 2px 8px rgba(8,131,149,0.15); /* gunakan warna #088395 */
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

  .dash.count {
    transition: box-shadow 0.3s, transform 0.3s;
  }

  .dash.count:hover {
    box-shadow: 0 8px 32px rgba(8,131,149,0.25); /* gunakan warna #088395 */
    transform: translateY(-4px) scale(1.03);
  }

  /* Untuk note-shadow dan card lain */
  .note-shadow {
    border-radius: 14px !important;
    box-shadow: 0 2px 16px rgba(8,131,149,0.10) !important;
    background: #fff !important;
  }

  .card-body ul,
.card-body ul li {
  text-align: left !important;
}

.card-body ul {
  padding-left: 0 !important;
}

.card-body ul li {
  justify-content: flex-start !important;
  align-items: flex-start !important;
  display: flex !important;
  flex-direction: row !important;
  gap: 8px;
}
.card-body ul li .summary-icon {
  margin-left: 0 !important;
  margin-right: 10px !important;
}

.row-aktivitas-hari-ini .card {
  position: relative;
  overflow: hidden;
  transition: box-shadow 0.3s;
}

.row-aktivitas-hari-ini .card::before {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: 0;
  height: 100%;
  background: linear-gradient(180deg, #6fc3d0 0%, #5459AC 100%);
  border-radius: 15px 0 0 15px;
  transition: width 0.25s;
  z-index: 1;
}

.row-aktivitas-hari-ini .card:hover::before {
  width: 8px;
}

.row-aktivitas-hari-ini .card .card-body {
  position: relative;
  z-index: 2;
}

.card,
.note-shadow,
.summary-box,
.row-aktivitas-hari-ini .card {
  box-shadow: 0 2px 16px rgba(111,195,208,0.18) !important;
}

body {
  font-family: 'Poppins', sans-serif;
  background: #fff !important;
  margin: 0 !important;
  padding: 0 !important;
}

.container-fluid {
  margin: 0 !important;
  padding: 0 !important;
  background: transparent !important;
  box-shadow: none !important;
  border-radius: 0 !important;
}

#noteHeader {
  background: #5459AC;
  border-radius: 12px 12px 0 0;
  width: 100%;
  margin: 18px auto 10px auto;
  padding: 14px 12px 12px 12px; /* Tambah padding atas agar lebih tinggi */
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 0;
  max-width: 100%;
  word-break: break-word;
  box-sizing: border-box;
  min-height: 70px; /* Tambah tinggi minimum */
}

#noteHeader h2 {
  color: #fff;
  font-weight: 700;
  font-size: 20px;
  display: flex;
  align-items: center;
  margin: 0;
  gap: 8px;
  width: 100%;
  justify-content: center;
  word-break: break-word;
  flex-wrap: wrap;
}

#noteHeader .fa-sticky-note {
  font-size: 1.3em;
}

#noteYear {
  margin-left: 8px;
  font-size: 18px;
  white-space: nowrap;
}

@media (max-width: 576px) {
  #noteHeader {
    padding: 8px 4px;
    margin: 10px auto 8px auto;
  }
  #noteHeader h2 {
    flex-direction: column;
    font-size: 15px;
    gap: 2px;
    width: 100%;
    text-align: center;
    justify-content: center;
    align-items: center;
  }
  #noteYear {
    margin-left: 0 !important;
    margin-top: 2px;
    font-size: 14px;
    display: block;
  }
}
</style>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="index.php">Clinic 24</a>
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
                        <div class="sb-sidenav-menu-heading">C24</div>
                        <a class="nav-link active" href="index.php">
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
                            <a class="nav-link" href="user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Data User
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pendaftaran') : ?>
                            <a class="nav-link" href="data-master/data-pasien/pasien.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                                
                            </a>
                            <!-- /SIDEBAR END -->

                            <!-- ISI DASHBOARD -->
                            <!-- <a class="nav-link" href="data-pendaftaran/pendaftaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                            Keuntungan
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pemeriksaan') : ?>
                            <a class="nav-link" href="data-pemeriksaan/pemeriksaan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Pengeluaran
                            </a>
                            <a class="nav-link" href="data-resep/resep.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                             Total Kategori Obat
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pembayaran') : ?>
                            <a class="nav-link" href="data-pembayaran/pembayaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Total Dokter
                            </a> -->
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" class="bg-white text-dark">
            <main>
                <div class="container-fluid">
                     <!-- 4 KOLOM -->
                    <div class="row g-4 mt-4">
  <div class="col-md-3">
    <div class="dash count summary-box">
      <div class="summary-title">Keuntugan Tahun Ini</div>
      <div class="summary-value">
        $<span class="counter" data-count="6219384">0</span>
        <span class="summary-icon"><i class="fas fa-dollar-sign"></i></span>
      </div>
      <div class="summary-change custom-bg-success">+12% from yesterday</div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="dash count summary-box">
      <div class="summary-title">Pengeluaran Tahun ini</div>
      <div class="summary-value">
        $<span class="counter" data-count="4231216">0</span>
        <span class="summary-icon"><i class="fas fa-prescription-bottle-alt"></i></span>
      </div>
      <div class="summary-change custom-bg-success">+7% from last week</div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="dash count summary-box">
      <div class="summary-title">Stok Obat Kriris</div>
      <div class="summary-value">
        <span class="counter" data-count="8">0</span>
        <span class="summary-icon"><i class="fas fa-box-open"></i></span>
      </div>
      <div class="summary-change custom-bg-danger">-2 from yesterday</div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="dash count summary-box">
      <div class="summary-title">Total Pasien</div>
      <div class="summary-value">
        <span class="counter" data-count="73">0</span>
        <span class="summary-icon"><i class="fas fa-users"></i></span>
      </div>
      <div class="summary-change custom-bg-success">+22 new this month</div>
    </div>
  </div>
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
                                    $this.text(Math.floor(this.countNum));
                                },
                                complete: function () {
                                    $this.text(this.countNum);
                                }
                            });
                        });
                    </script>
                    <!-- 4 KOLOM END -->
                     
                    <title>Dashboard Klinik Modern</title>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <style>
                        body {
                            font-family: 'Poppins', sans-serif;
                            background: linear-gradient(to right, #e0f7fa, #ffffff);
                            margin: 0;
                            padding: 20px;
                        }
                        .container {
                            width: 100%;
                            max-width: 1400px;
                            margin: auto;
                            background: #ffffff;
                            padding: 20px;
                            border-radius: 20px;
                            box-shadow: 0 0 20px rgba(0,0,0,0.1);
                        }
                        .header {
                            display: flex;
                            flex-wrap: wrap;
                            justify-content: space-between;
                            align-items: center;
                            margin-bottom: 20px;
                        }
                        .header h2 {
                            font-weight: 700;
                            color: #0077b6;
                            margin: 0;
                            font-size: 26px;
                        }
                        .chart-note {
                            display: flex;
                            flex-wrap: wrap;
                            gap: 20px;
                            width: 100%;
                        }
                        .chart-container {
                            flex: 2.9;  /* Lebar chart dipersempit */
                            background: #fff;
                            padding: 15px;
                            border-radius: 15px;
                            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
                            min-height: 450px;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            width: 100%;
                        }
                        .note-container {
                            flex: 1.1;  /* Notes dilebarkan */
                            background: #e0f2ff;
                            border-radius: 15px;
                            padding: 15px;
                            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
                            display: flex;
                            flex-direction: column;
                            justify-content: space-between;
                            width: 100%;
                        }
                        .note-card, .summary-card {
                            background: #ffffff;
                            border-radius: 12px;
                            padding: 15px;
                            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                            flex: 1;
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            text-align: center;
                            margin-bottom: 15px;
                        }
                        .summary-card { margin-bottom: 0; }
                        h3 {
                            margin: 0 0 8px 0;
                            font-size: 20px;
                            color: #0077b6;
                        }
                        p {
                            margin: 4px 0;
                            font-size: 15px;
                            color: #333;
                        }
                        select {
                            padding: 8px 12px;
                            border-radius: 8px;
                            border: 1px solid #ccc;
                            font-size: 15px;
                            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
                        }

                        @media (max-width: 992px) {
                            .chart-note {
                                flex-direction: column;
                            }
                            .chart-container, .note-container {
                                width: 100%;
                                flex: none;
                            }
                        }
                    </style>


                    <!-- ROW: Dashboard Keuangan Klinik & Notes -->
<div class="row mt-4 align-items-stretch"> <!-- TAMBAHKAN align-items-stretch -->
  <!-- Kiri: Dashboard Keuangan Klinik (judul, filter, chart dalam satu container) -->
  <div class="col-lg-9 mb-3 d-flex"> <!-- TAMBAHKAN d-flex -->
    <div class="card shadow-sm border-0 flex-fill" style="border-radius:15px; background:#fff;">
      <div class="card-body">
        <!-- Judul dengan background gradasi hijau -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 p-3 rounded"
             style="background: linear-gradient(90deg, rgb(61, 191, 211) 0%, #5459AC 100%);">
          <h2 class="mb-0" style="font-size:22px;color:#fff;font-weight:700;">Dashboard Keuangan Klinik</h2>
          <div>
            <span style="color:#fff;">Pilih Tahun:</span>
            <select id="yearSelect" class="form-select d-inline-block w-auto ms-2">
              <option value="2021">2021</option>
              <option value="2022">2022</option>
              <option value="2023">2023</option>
              <option value="2024">2024</option>
              <option value="2025" selected>2025</option>
            </select>
          </div>
        </div>
        <div style="min-width:250px; min-height:400px;">
          <canvas id="areaChart"></canvas>
        </div>
      </div>
    </div>
  </div>
  <!-- Kanan: Notes -->
  <div class="col-lg-3 mb-3 d-flex"> <!-- TAMBAHKAN d-flex -->
    <div class="card note-shadow border-0 flex-fill" style="border-radius:15px; background:#fff;">
      <!-- Judul Note: background ungu, teks putih -->
      <div id="noteHeader">
  <h2>
    <i class="fas fa-sticky-note"></i> Catatan Keuangan <span id="noteYear">2025</span>
  </h2>
</div>
      <div class="card-body d-flex flex-column align-items-center justify-content-center" style="min-height:320px; padding:12px 8px 8px 8px;">
        <div id="noteCard" class="w-100"></div>
        <div id="summaryCard" class="w-100 mt-3"></div>
      </div>
    </div>
  </div>
</div>

<style>
  .note-shadow {
    border-radius: 14px !important;
    box-shadow: 0 2px 16px rgba(61,191,211,0.10) !important;
    background: linear-gradient(135deg, #fff 60%, #e6f7fa 100%) !important;
    border: none !important;
  }
  .note-shadow h3 {
    color: #5459AC !important;
  }
  .note-shadow p {
    color: #088395 !important;
  }
</style>

<script>
const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

const dataKeuntungan = {
    2021: [2.2, 3.1, 1.5, 4.8, 3.9, 5.0, 4.1, 2.8, 3.7, 4.0, 4.6, 5.2],
    2022: [4.5, 5.2, 6.0, 5.4, 7.0, 8.5, 7.5, 6.3, 8.2, 9.5, 10.0, 11.5],
    2023: [5.8, 6.5, 7.2, 8.0, 9.5, 10.8, 11.0, 12.3, 13.5, 14.2, 15.0, 16.3],
    2024: [7.0, 8.5, 9.2, 10.5, 11.8, 13.0, 14.5, 15.7, 16.8, 18.0, 19.5, 20.7],
    2025: [9.0, 10.5, 12.2, 13.5, 15.0, 16.5, 18.2, 19.0, 20.8, 21.5, 23.0, 24.7]
};

const dataPengeluaran = {
    2021: [1.5, 2.0, 1.2, 3.0, 2.5, 3.5, 2.8, 2.0, 2.5, 3.0, 3.4, 3.8],
    2022: [3.0, 3.8, 4.2, 3.6, 4.5, 5.0, 4.8, 4.2, 5.5, 6.0, 6.5, 7.2],
    2023: [4.0, 4.5, 5.0, 5.8, 6.5, 7.2, 8.0, 8.5, 9.0, 10.0, 11.0, 12.0],
    2024: [5.5, 6.0, 6.8, 7.5, 8.0, 9.2, 10.0, 10.8, 12.0, 13.5, 14.2, 15.5],
    2025: [7.0, 8.0, 9.0, 10.5, 11.2, 12.5, 13.8, 14.5, 15.8, 16.5, 18.0, 19.0]
};

let tahunAktif = '2025';
let chartInstance = null;

function generateNote(tahun, bulanIndex) {
    const month = labels[bulanIndex];
    const keuntungan = dataKeuntungan[tahun][bulanIndex].toFixed(1);
    const pengeluaran = dataPengeluaran[tahun][bulanIndex].toFixed(1);
    const labaBersih = (keuntungan - pengeluaran).toFixed(1);
    // Semua icon putih, teks ungu (#5459AC)
    return `
      <div class="d-flex align-items-center mb-2" style="gap:8px;">
        <span style="color:#fff;background:#5459AC;border-radius:8px;padding:4px 8px;"><i class="fas fa-coins"></i></span>
        <span style="color:#5459AC;">Keuntungan: <b>Rp ${keuntungan} Juta</b></span>
      </div>
      <div class="d-flex align-items-center mb-2" style="gap:8px;">
        <span style="color:#fff;background:#5459AC;border-radius:8px;padding:4px 8px;"><i class="fas fa-money-bill-wave"></i></span>
        <span style="color:#5459AC;">Pengeluaran: <b>Rp ${pengeluaran} Juta</b></span>
      </div>
      <div class="d-flex align-items-center" style="gap:8px;">
        <span style="color:#fff;background:#5459AC;border-radius:8px;padding:4px 8px;"><i class="fas fa-chart-line"></i></span>
        <span style="color:#5459AC;">Laba Bersih: <b>Rp ${labaBersih} Juta</b></span>
      </div>
      <div style="color:#888;font-size:13px;margin-top:10px;">${month} ${tahun}</div>
    `;
}

function generateSummary(tahun) {
    const keuntungan = dataKeuntungan[tahun].reduce((a,b)=>a+b,0);
    const pengeluaran = dataPengeluaran[tahun].reduce((a,b)=>a+b,0);
    const rataKeuntungan = (keuntungan / 12).toFixed(1);
    const rataPengeluaran = (pengeluaran / 12).toFixed(1);
    // Semua icon putih, teks ungu (#5459AC)
    return `
      <div class="d-flex align-items-center mb-2" style="gap:8px;">
        <span style="color:#fff;background:#5459AC;border-radius:8px;padding:4px 8px;"><i class="fas fa-coins"></i></span>
        <span style="color:#5459AC;">Rata-rata Keuntungan: <b>Rp ${rataKeuntungan} Juta/bln</b></span>
      </div>
      <div class="d-flex align-items-center mb-2" style="gap:8px;">
        <span style="color:#fff;background:#5459AC;border-radius:8px;padding:4px 8px;"><i class="fas fa-money-bill-wave"></i></span>
        <span style="color:#5459AC;">Rata-rata Pengeluaran: <b>Rp ${rataPengeluaran} Juta/bln</b></span>
      </div>
      <div class="d-flex align-items-center" style="gap:8px;">
        <span style="color:#fff;background:#5459AC;border-radius:8px;padding:4px 8px;"><i class="fas fa-chart-line"></i></span>
        <span style="color:#5459AC;">Rata-rata Laba Bersih: <b>Rp ${(rataKeuntungan - rataPengeluaran).toFixed(1)} Juta/bln</b></span>
      </div>
      <div style="color:#888;font-size:13px;margin-top:10px;">Tahun ${tahun}</div>
    `;
}

function createChart(tahun, bulanAwal) {
    tahunAktif = tahun;
    const ctx = document.getElementById('areaChart').getContext('2d');
    if (chartInstance) chartInstance.destroy();

    // Gradien area keuntungan: biru muda transparan
    const gradientKeuntungan = ctx.createLinearGradient(0, 0, 0, 400);
    gradientKeuntungan.addColorStop(0, 'rgba(61,191,211,0.25)');
    gradientKeuntungan.addColorStop(1, 'rgba(255,255,255,0.7)');

    // Gradien area pengeluaran: biru keungu transparan
    const gradientPengeluaran = ctx.createLinearGradient(0, 0, 0, 400);
    gradientPengeluaran.addColorStop(0, 'rgba(84,89,172,0.18)');
    gradientPengeluaran.addColorStop(1, 'rgba(255,255,255,0.7)');

    chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Keuntungan',
                    data: dataKeuntungan[tahun],
                    fill: true,
                    backgroundColor: gradientKeuntungan,
                    borderColor: 'rgb(61,191,211)',
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 10
                },
                {
                    label: 'Pengeluaran',
                    data: dataPengeluaran[tahun],
                    fill: true,
                    backgroundColor: gradientPengeluaran,
                    borderColor: '#5459AC',
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 10
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            onClick: (e, elements) => {
                if (elements.length > 0) {
                    const bulanIndex = elements[0].index;
                    document.getElementById('noteCard').innerHTML = generateNote(tahunAktif, bulanIndex);
                }
            },
            plugins: {
                legend: { labels: { color: '#222' } }, // warna label legend jadi hitam
                tooltip: {
                    callbacks: {
                        label: context => `${context.dataset.label}: Rp ${context.formattedValue} Juta`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#222' } // warna sumbu X jadi hitam
                },
                y: {
                    grid: { display: false },
                    ticks: { callback: val => 'Rp ' + val + 'jt', color: '#222' } // warna sumbu Y jadi hitam
                }
            }
        }
    });
    document.getElementById('noteCard').innerHTML = generateNote(tahun, bulanAwal);
    document.getElementById('summaryCard').innerHTML = generateSummary(tahun);
    document.getElementById('noteYear').textContent = tahun; // Update tahun di judul note
}

document.getElementById('yearSelect').addEventListener('change', () => {
    createChart(document.getElementById('yearSelect').value, 0);
});

createChart(tahunAktif, 0);
</script>

            <!-- ROW 3: Kalender Mini dan Alert & Notifikasi Strategis -->
<div class="row mt-4 align-items-stretch"> <!-- TAMBAHKAN align-items-stretch -->
  <div class="col-md-6 mb-3 d-flex"> <!-- TAMBAHKAN d-flex -->
    <div class="card shadow-sm border-0 flex-fill" style="border-radius:15px;">
      <div class="card-header px-4 py-3" style="background: #3dbfd3; border-radius: 15px 15px 0 0; color:#fff; font-weight:700;">
        <i class="fas fa-calendar-alt me-2"></i> Kalender Mini (Agenda Hari Ini)
      </div>
      <div class="card-body" style="background:#f8fcff; border-radius:0 0 15px 15px;">
        <ul class="mb-0" style="list-style:none;padding-left:0;">
          <li class="mb-2"><span style="font-size:1.2rem;color:#3dbfd3;"><i class="fas fa-user-md"></i></span> <span style="color:#5459AC;">08:00 - Shift Pagi Dokter A</span></li>
          <li class="mb-2"><span style="font-size:1.2rem;color:#3dbfd3;"><i class="fas fa-syringe"></i></span> <span style="color:#5459AC;">10:00 - Penyuluhan Imunisasi</span></li>
          <li class="mb-2"><span style="font-size:1.2rem;color:#3dbfd3;"><i class="fas fa-file-invoice"></i></span> <span style="color:#5459AC;">13:00 - Audit Internal</span></li>
          <li><span style="font-size:1.2rem;color:#3dbfd3;"><i class="fas fa-pills"></i></span> <span style="color:#5459AC;">15:00 - Pengadaan Obat Mingguan</span></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-lg-6 mb-3 d-flex"> <!-- TAMBAHKAN d-flex -->
    <div class="card shadow-sm border-0 flex-fill" style="border-radius:15px;">
      <div class="card-header px-4 py-3" style="background: #05BFDB; border-radius: 15px 15px 0 0;">
        <h5 class="mb-0" style="color:#fff;font-weight:700;">
          <i class="fas fa-bell" style="margin-right:8px;"></i> Insight & Notifikasi Strategis
        </h5>
      </div>
      <div class="card-body px-4 py-3" style="background:#f8fcff;">
        <ul class="mb-0" style="list-style:none;padding-left:0;">
          <li class="d-flex align-items-center mb-2">
            <span class="summary-icon me-2" style="background:linear-gradient(135deg,#088395 0%,#5459AC 100%);font-size:18px;"><i class="fas fa-capsules"></i></span>
            <span style="color:#5459AC;"> <strong>Paracetamol</strong> stok tinggal <strong>5 strip</strong> – segera lakukan pemesanan ulang.</span>
          </li>
          <li class="d-flex align-items-center mb-2">
            <span class="summary-icon me-2" style="background:linear-gradient(135deg,#088395 0%,#5459AC 100%);font-size:18px;"><i class="fas fa-clock"></i></span>
            <span style="color:#5459AC;">Waktu tunggu tertinggi hari <strong>Jumat pukul 18:00</strong> – pertimbangkan tambahan tenaga medis.</span>
          </li>
          <li class="d-flex align-items-center mb-2">
            <span class="summary-icon me-2" style="background:linear-gradient(135deg,#088395 0%,#5459AC 100%);font-size:18px;"><i class="fas fa-chart-line"></i></span>
            <span style="color:#5459AC;">Pemeriksaan harian menurun selama <strong>3 hari berturut-turut</strong>.</span>
          </li>
          <li class="d-flex align-items-center">
            <span class="summary-icon me-2" style="background:linear-gradient(135deg,#088395 0%,#5459AC 100%);font-size:18px;"><i class="fas fa-user-md"></i></span>
            <span style="color:#5459AC;">Dokter A tidak hadir hari ini – sesuaikan jadwal pemeriksaan.</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- ROW 4: Aktivitas Hari Ini (PUTIH, ICON SATU WARNA, SEPERTI SUMMARY) -->
<div class="row mt-4 row-aktivitas-hari-ini">
  <div class="col-md-3">
    <div class="card shadow-sm border-0 text-center" style="border-radius:15px; background:#fff; color:#222;">
      <div class="card-body py-4">
        <div class="mb-2" style="font-size:2rem; color:#088395;"><i class="fas fa-user-injured"></i></div>
        <h6 class="mb-1" style="font-weight:600;">Pasien Hari Ini</h6>
        <h4 class="mb-0" style="font-weight:700;">28</h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm border-0 text-center" style="border-radius:15px; background:#fff; color:#222;">
      <div class="card-body py-4">
        <div class="mb-2" style="font-size:2rem; color:#088395;"><i class="fas fa-stethoscope"></i></div>
        <h6 class="mb-1" style="font-weight:600;">Pemeriksaan Selesai</h6>
        <h4 class="mb-0" style="font-weight:700;">22</h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm border-0 text-center" style="border-radius:15px; background:#fff; color:#222;">
      <div class="card-body py-4">
        <div class="mb-2" style="font-size:2rem; color:#088395;"><i class="fas fa-user-md"></i></div>
        <h6 class="mb-1" style="font-weight:600;">Dokter Aktif</h6>
        <h4 class="mb-0" style="font-weight:700;">5</h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm border-0 text-center" style="border-radius:15px; background:#fff; color:#222;">
      <div class="card-body py-4">
        <div class="mb-2" style="font-size:2rem; color:#088395;"><i class="fas fa-money-bill-wave"></i></div>
        <h6 class="mb-1" style="font-weight:600;">Pengeluaran Hari Ini</h6>
        <h4 class="mb-0" style="font-weight:700;">Rp 4.2 Juta</h4>
      </div>
    </div>
  </div>
</div>

<!-- ROW 5: Grafik Tren 7 Hari & Tindakan Cepat -->
<div class="row mt-4 align-items-stretch">
  <!-- Grafik Tren 7 Hari (perkecil lebar, misal col-lg-8) -->
  <div class="col-lg-8 mb-3 d-flex">
    <div class="card shadow-sm border-0 flex-fill" style="border-radius:15px;">
      <!-- Judul dengan gradasi -->
      <div class="card-header px-4 py-3" style="background: linear-gradient(90deg, rgb(61,191,211) 0%, #5459AC 60%, #088395 100%); border-radius: 15px 15px 0 0;">
        <h5 class="mb-0" style="color:#fff;font-weight:700;">
          <i class="fas fa-chart-area" style="margin-right:8px;"></i> Tren 7 Hari Terakhir: Pasien, Pemeriksaan, Pengeluaran
        </h5>
      </div>
      <div class="card-body" style="min-height:340px; display:flex; align-items:center; justify-content:center;">
        <canvas id="chartTren7Hari" style="width:100% !important; max-width:100% !important; height:260px !important; max-height:100% !important; display:block;"></canvas>
      </div>
    </div>
  </div>
  <!-- Tindakan Cepat -->
  <div class="col-lg-4 mb-3 d-flex">
    <div class="card shadow-sm border-0 flex-fill" style="border-radius:15px;">
      <div class="card-header px-4 py-3" style="background: #088395; border-radius: 15px 15px 0 0; color:#fff; font-weight:700;">
        <i class="fas fa-bolt me-2"></i> Tindakan Cepat
      </div>
      <div class="card-body d-flex flex-wrap gap-3" style="background:#f8fcff; border-radius:0 0 15px 15px;">
        <a href="data-pemeriksaan/pemeriksaan.php" class="btn btn-outline-primary flex-fill mb-2" style="min-width:180px;"><i class="fas fa-plus me-1"></i> Diagnosa Tertinggi</a>
        <a href="data-master/data-pasien/pasien.php" class="btn btn-outline-secondary flex-fill mb-2" style="min-width:180px;"><i class="fas fa-file-alt me-1"></i> Lihat Ulasan Pasien</a>
        <a href="data-master/data-obat/obat.php" class="btn btn-outline-danger flex-fill mb-2" style="min-width:180px;"><i class="fas fa-box-open me-1"></i> Total Jumlah Obat</a>
        <a href="keuntungan/keuntungan.php" class="btn btn-outline-success flex-fill" style="min-width:180px;"><i class="fas fa-chart-line me-1"></i> Keuntungan Bulanan</a>
      </div>
    </div>
  </div>
</div>

<script>
const ctxTren = document.getElementById('chartTren7Hari').getContext('2d');

// Gradien area untuk Pasien (biru muda)
const gradientPasien = ctxTren.createLinearGradient(0, 0, 0, 300);
gradientPasien.addColorStop(0, 'rgba(61,191,211,0.25)');
gradientPasien.addColorStop(1, 'rgba(255,255,255,0.7)');

// Gradien area untuk Pemeriksaan (biru keunguan)
const gradientPemeriksaan = ctxTren.createLinearGradient(0, 0, 0, 300);
gradientPemeriksaan.addColorStop(0, 'rgba(84,89,172,0.18)');
gradientPemeriksaan.addColorStop(1, 'rgba(255,255,255,0.7)');

// Gradien area untuk Pengeluaran (hijau muda #00FFCA)
const gradientPengeluaran = ctxTren.createLinearGradient(0, 0, 0, 300);
gradientPengeluaran.addColorStop(0, 'rgba(0,255,202,0.35)');
gradientPengeluaran.addColorStop(1, 'rgba(255,255,255,0.7)');

const chartTren7Hari = new Chart(ctxTren, {
  type: 'line',
  data: {
    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
    datasets: [
      {
        label: 'Pasien',
        data: [25, 28, 30, 29, 32, 27, 20],
        borderColor: 'rgb(61,191,211)',
        backgroundColor: gradientPasien,
        fill: true,
        tension: 0.4,
        pointRadius: 5,
        pointHoverRadius: 10
      },
      {
        label: 'Pemeriksaan',
        data: [18, 20, 22, 21, 25, 19, 15],
        borderColor: '#5459AC',
        backgroundColor: gradientPemeriksaan,
        fill: true,
        tension: 0.4,
        pointRadius: 5,
        pointHoverRadius: 10
      },
      {
        label: 'Pengeluaran (juta)',
        data: [3.5, 4.0, 3.8, 4.2, 4.5, 4.1, 3.9],
        borderColor: '#00FFCA',
        backgroundColor: gradientPengeluaran,
        fill: true,
        tension: 0.4,
        pointRadius: 5,
        pointHoverRadius: 10
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: 'bottom', labels: { color: '#222' } }
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { color: '#222' }
      },
      y: {
        grid: { display: false },
        ticks: { color: '#222' }
      }
    }
  }
});
</script>

            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Poli Klinik 2021 | Repost by <a href='https://stokcoding.com/' title='StokCoding.com' target='_blank'>StokCoding.com</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

</html>