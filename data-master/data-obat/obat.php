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
    <title>Poli Klinik | Data Master - Obat</title>
    <link href="../../assets/css/styles.css" rel="stylesheet" />
    <link href="../../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="../../assets/js/all.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="../../index.php">Poli Klinik</a>
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
                        <div class="sb-sidenav-menu-heading">Poli Klinik</div>
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
                                    <a class="nav-link" href="../data-poli/poli.php">Data Poli</a>
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
                    <h1 class="mt-4">Data Obat</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../../index.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Master</li>
                        <li class="breadcrumb-item active">Data Obat</li>
                    </ol>
                    <?php
                    // Data hardcode sementara MIS Obat
                    $totalObat = 152;
                    $totalKategoriPenyakit = 7;
                    $totalKategoriBentuk = 6;
                    $totalJenisUnik = 45;
                    ?>

                    <!-- Ringkasan Data Obat -->
                    <h4 class="mb-4 font-weight-bold text-secondary">Ringkasan Data Obat</h4>
                    <div class="row">

                    <!-- Total Obat -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-primary shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <div class="text-white-50 small">Total Obat</div>
                            <h5 class="mb-0 counter" data-count="<?php echo $totalObat; ?>">0</h5>
                            </div>
                            <i class="fas fa-pills fa-2x"></i>
                        </div>
                        </div>
                    </div>

                    <!-- Total Kategori Penyakit -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-success shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <div class="text-white-50 small">Kategori Obat Berdasarkan Penyakit</div>
                            <h5 class="mb-0 counter" data-count="<?php echo $totalKategoriPenyakit; ?>">0</h5>
                            </div>
                            <i class="fas fa-stethoscope fa-2x"></i>
                        </div>
                        </div>
                    </div>

                    <!-- Total Kategori Bentuk Obat -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-info shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <div class="text-white-50 small">Kategori Bentuk Obat</div>
                            <h5 class="mb-0 counter" data-count="<?php echo $totalKategoriBentuk; ?>">0</h5>
                            </div>
                            <i class="fas fa-capsules fa-2x"></i>
                        </div>
                        </div>
                    </div>

                    <!-- Total Jenis Unik -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-warning shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <div class="text-white-50 small">Total Jenis Unik</div>
                            <h5 class="mb-0 counter" data-count="<?php echo $totalJenisUnik; ?>">0</h5>
                            </div>
                            <i class="fas fa-boxes fa-2x"></i>
                        </div>
                        </div>
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
                            $this.text(new Intl.NumberFormat('id-ID').format(Math.floor(this.countNum)));
                            },
                            complete: function () {
                            $this.text(new Intl.NumberFormat('id-ID').format(this.countNum));
                            }
                        });
                    });
                    </script>


                    <!-- Distribusi Obat -->
                    <h4 class="mb-4 font-weight-bold text-secondary">Distribusi Obat</h4>
                    <div class="row">
                        <!-- Pie Chart Bentuk Obat -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-warning text-white">
                                    <i class="fas fa-chart-pie mr-2"></i> Distribusi Bentuk Obat (%)
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center" style="height: 400px;">
                                    <canvas id="pieBentukObat"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Bar Chart Kategori Penyakit -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-danger text-white">
                                    <i class="fas fa-chart-bar mr-2"></i> Distribusi Kategori Penyakit
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center" style="height: 400px;">
                                    <canvas id="barKategoriPenyakit"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Script Chart.js -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <!-- Tambahkan plugin datalabels -->
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

                    <script>
                    // Hardcode Data Array
                    const totalObat = 152;
                    const kategoriBentuk = [
                        { nama: 'Tablet', jumlah: 60 },
                        { nama: 'Syrup', jumlah: 30 },
                        { nama: 'Kapsul', jumlah: 25 },
                        { nama: 'Salep', jumlah: 15 },
                        { nama: 'Injeksi', jumlah: 12 },
                        { nama: 'Lainnya', jumlah: 10 }
                    ];

                    const kategoriPenyakit = [
                        { nama: 'Demam', jumlah: 40 },
                        { nama: 'Batuk', jumlah: 35 },
                        { nama: 'Asma', jumlah: 25 },
                        { nama: 'Hipertensi', jumlah: 20 },
                        { nama: 'Alergi', jumlah: 15 },
                        { nama: 'Kolesterol', jumlah: 10 },
                        { nama: 'Lainnya', jumlah: 7 }
                    ];

                    // Pie Chart
                    var ctxPie = document.getElementById('pieBentukObat').getContext('2d');
                    var totalBentuk = kategoriBentuk.reduce((acc, item) => acc + item.jumlah, 0);
                    new Chart(ctxPie, {
                        type: 'pie',
                        data: {
                            labels: kategoriBentuk.map(item => item.nama),
                            datasets: [{
                                data: kategoriBentuk.map(item => item.jumlah),
                                backgroundColor: ['#007bff', '#17a2b8', '#ffc107', '#28a745', '#dc3545', '#6c757d']
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                datalabels: {
                                    formatter: (value, context) => {
                                        let percent = (value / totalBentuk * 100).toFixed(1);
                                        return `${context.chart.data.labels[context.dataIndex]} \n${percent}%`;
                                    },
                                    color: '#fff',
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    }
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });

                    // Bar Chart
                    var ctxBar = document.getElementById('barKategoriPenyakit').getContext('2d');
                    new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: kategoriPenyakit.map(item => item.nama),
                            datasets: [{
                                label: 'Jumlah Jenis Obat',
                                data: kategoriPenyakit.map(item => item.jumlah),
                                backgroundColor: [
                                    '#007bff', '#17a2b8', '#ffc107', '#28a745', '#dc3545', '#6c757d', '#8e44ad'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 5
                                    }
                                }
                            }
                        }
                    });
                    </script>

                    <!-- Row Ketiga: Monitoring Kritis -->
                    <h4 class="mb-4 font-weight-bold text-secondary">Monitoring Stok & Pergerakan Obat</h4>
                    <div class="row">

                        <!-- Top 5 Obat Paling Cepat Habis -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-success text-white">
                                    <i class="fas fa-bolt mr-2"></i> Top 5 Obat Paling Cepat Habis
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Paracetamol <span class="badge badge-danger badge-pill">120 Box</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Amoxicillin <span class="badge badge-warning badge-pill">80 Box</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Ibuprofen <span class="badge badge-warning badge-pill">70 Box</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Ambroxol Syrup <span class="badge badge-info badge-pill">50 Botol</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Salep Miconazole <span class="badge badge-secondary badge-pill">30 Tube</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Monitoring Stok Kritis & Kadaluarsa -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-danger text-white">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> Monitoring Stok Kritis & Kadaluarsa
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Paracetamol 
                                            <span class="badge badge-danger badge-pill">Stok: 8 - Hampir Habis</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Salep Miconazole 
                                            <span class="badge badge-danger badge-pill">Stok: 5 - Hampir Habis</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Ibuprofen 
                                            <span class="badge badge-warning badge-pill">Kadaluarsa 20 Hari Lagi</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Row Keempat: Smart Supply Suggestion -->
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card shadow-sm border-left-warning">
                                <div class="card-body d-flex align-items-center">
                                    <i class="fas fa-lightbulb fa-2x text-warning mr-3"></i>
                                    <div>
                                        <h5 class="font-weight-bold mb-1 text-warning">Saran Pengadaan Cerdas</h5>
                                        <p class="mb-0">Lakukan pengadaan ulang untuk <b>12 jenis obat</b> yang diperkirakan habis dalam <b>14 hari ke depan</b>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Array Hardcode -->
                    <script>
                    // Data Top 5 Habis
                    const topHabis = [
                    {nama: 'Paracetamol', jumlah: 120, satuan: 'Box'},
                    {nama: 'Amoxicillin', jumlah: 80, satuan: 'Box'},
                    {nama: 'Ibuprofen', jumlah: 70, satuan: 'Box'},
                    {nama: 'Ambroxol Syrup', jumlah: 50, satuan: 'Botol'},
                    {nama: 'Salep Miconazole', jumlah: 30, satuan: 'Tube'},
                    ];

                    // Data Stok Kritis & Kadaluarsa
                    const stokKritis = [
                    {nama: 'Paracetamol', sisa: 8, keterangan: 'Hampir Habis'},
                    {nama: 'Salep Miconazole', sisa: 5, keterangan: 'Hampir Habis'},
                    {nama: 'Ibuprofen', sisa: 4, keterangan: 'Kadaluarsa 20 Hari Lagi'},
                    ];
                    </script>


                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Tabel Data Obat
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Obat</th>
                                            <th>Nama Obat</th>
                                            <th>Jenis</th>
                                            <th>Stok</th>
                                            <th>Harga</th>
                                            <th>Exp. Obat</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $nomor = 1; ?>
                                        <?php $ambil = $koneksi->query("SELECT * FROM tb_obat"); ?>
                                        <?php while ($pecah = $ambil->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $nomor; ?></td>
                                                <td><?php echo $pecah['kd_obat']; ?></td>
                                                <td><?php echo $pecah['nm_obat']; ?></td>
                                                <td><?php echo $pecah['jenis_obat']; ?></td>
                                                <td><?php echo $pecah['stok']; ?></td>
                                                <td>Rp. <?php echo number_format($pecah['harga_obat']); ?></td>
                                                <td><?php echo $pecah['exp_obat']; ?></td>
                                                <td>
                                                    <?php if ($pecah['stok'] <= 0) { ?>
                                                        <span class="badge badge-danger p-2">Kosong</span>
                                                    <?php } else { ?>
                                                        <span class="badge badge-success p-2">Tersedia</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="obat_view.php?&id_obat=<?php echo $pecah['id_obat']; ?>" class="btn-primary btn-sm btn">
                                                        <i class="fas fa-eye"></i></i>
                                                    </a>
                                                    <a href="obat_ubah.php?&id_obat=<?php echo $pecah['id_obat']; ?>" class="btn-warning btn-sm btn">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="obat_hapus.php?&id_obat=<?php echo $pecah['id_obat']; ?>" class="btn-danger btn-sm btn">
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
                            <a href="obat_tambah.php" class="btn-success btn px-3 font-weight-bold"><i class="fas fa-plus"></i> Tambah Data Obat</a>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Poli Klinik 2021</div>
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