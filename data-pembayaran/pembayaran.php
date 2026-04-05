<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../login/index.php'</script>";
    exit();
}

// Get current year and month
$currentYear = date('Y');
$currentMonth = date('n');

// STEP 1: Tentukan tahun data yang akan digunakan secara konsisten
$tahunData = $currentYear;

// Cek apakah ada data untuk tahun ini
$queryCheckTahun = "SELECT COUNT(*) as count_data FROM pengeluaran WHERE YEAR(tanggal) = $currentYear";
$resultCheckTahun = mysqli_query($koneksi, $queryCheckTahun);
$checkTahunData = mysqli_fetch_assoc($resultCheckTahun);

// Jika tidak ada data tahun ini, gunakan 2024 untuk SEMUA perhitungan
if ($checkTahunData['count_data'] == 0) {
    $tahunData = 2024;
    echo "<!-- Debug: Menggunakan data tahun 2024 untuk SEMUA perhitungan -->";
} else {
    echo "<!-- Debug: Menggunakan data tahun $currentYear untuk SEMUA perhitungan -->";
}

// STEP 2: Get total pengeluaran untuk tahun yang sudah ditentukan
$queryTotalTahun = "SELECT SUM(jumlah) as total_tahun FROM pengeluaran WHERE YEAR(tanggal) = $tahunData";
$resultTotalTahun = mysqli_query($koneksi, $queryTotalTahun);

// Debug: Cek jika query error
if (!$resultTotalTahun) {
    echo "<!-- Error Query Total: " . mysqli_error($koneksi) . " -->";
}

$totalTahunData = mysqli_fetch_assoc($resultTotalTahun);
$totalPengeluaranTahun = $totalTahunData['total_tahun'] ? $totalTahunData['total_tahun'] : 0;

// Debug: Tampilkan nilai untuk testing
echo "<!-- Debug: Total Pengeluaran = " . $totalPengeluaranTahun . " -->";
echo "<!-- Debug: Tahun Data Konsisten = " . $tahunData . " -->";

// Get rata-rata pengeluaran bulanan
$rataPengeluaranBulanan = $totalPengeluaranTahun > 0 ? $totalPengeluaranTahun / 12 : 0;

// Get pengeluaran bulan ini (gunakan tahun data yang konsisten)
$queryBulanIni = "SELECT SUM(jumlah) as total_bulan FROM pengeluaran WHERE YEAR(tanggal) = $tahunData AND MONTH(tanggal) = $currentMonth";
$resultBulanIni = mysqli_query($koneksi, $queryBulanIni);
$bulanIniData = mysqli_fetch_assoc($resultBulanIni);
$pengeluaranBulanIni = $bulanIniData['total_bulan'] ? $bulanIniData['total_bulan'] : 0;

// Get pengeluaran bulan lalu untuk menghitung pertumbuhan (gunakan tahun data yang konsisten)
$bulanLalu = ($currentMonth == 1) ? 12 : $currentMonth - 1;
$tahunBulanLalu = ($currentMonth == 1) ? $tahunData - 1 : $tahunData;
$queryBulanLalu = "SELECT SUM(jumlah) as total_bulan_lalu FROM pengeluaran WHERE YEAR(tanggal) = $tahunBulanLalu AND MONTH(tanggal) = $bulanLalu";
$resultBulanLalu = mysqli_query($koneksi, $queryBulanLalu);
$bulanLaluData = mysqli_fetch_assoc($resultBulanLalu);
$pengeluaranBulanLalu = $bulanLaluData['total_bulan_lalu'] ? $bulanLaluData['total_bulan_lalu'] : 1;

// Hitung pertumbuhan bulanan (dengan validasi untuk menghindari pembagian dengan nol)
if ($pengeluaranBulanLalu > 0) {
    $pertumbuhanPengeluaran = (($pengeluaranBulanIni - $pengeluaranBulanLalu) / $pengeluaranBulanLalu) * 100;
} else {
    $pertumbuhanPengeluaran = 0;
}

// Get data pengeluaran bulanan untuk chart (gunakan tahun data yang konsisten)
$dataPengeluaranBulanan = [];
$dataPengeluaranBulananAsli = [];

$queryBulanan = "SELECT MONTH(tanggal) as bulan, SUM(jumlah) as total 
                 FROM pengeluaran 
                 WHERE YEAR(tanggal) = $tahunData 
                 GROUP BY MONTH(tanggal) 
                 ORDER BY MONTH(tanggal)";
$resultBulanan = mysqli_query($koneksi, $queryBulanan);
$tempBulananData = [];
$tempBulananDataAsli = [];
while ($row = mysqli_fetch_assoc($resultBulanan)) {
    $tempBulananData[$row['bulan']] = round($row['total'] / 1000000, 1); // Untuk chart (jutaan)
    $tempBulananDataAsli[$row['bulan']] = $row['total']; // Untuk AI (nilai asli)
}
// Fill missing months with 0
for ($i = 1; $i <= 12; $i++) {
    $dataPengeluaranBulanan[] = isset($tempBulananData[$i]) ? $tempBulananData[$i] : 0;
    $dataPengeluaranBulananAsli[] = isset($tempBulananDataAsli[$i]) ? $tempBulananDataAsli[$i] : 0;
}

echo "<!-- Debug: Data Bulanan Chart = " . json_encode($dataPengeluaranBulanan) . " -->";
echo "<!-- Debug: Data Bulanan Asli = " . json_encode($dataPengeluaranBulananAsli) . " -->";

// Get data pengeluaran per kategori untuk pie chart (gunakan tahun data yang konsisten)
$piePengeluaranData = [];
$queryKategori = "SELECT kategori, SUM(jumlah) as total 
                  FROM pengeluaran 
                  WHERE YEAR(tanggal) = $tahunData 
                  GROUP BY kategori 
                  ORDER BY total DESC";
$resultKategori = mysqli_query($koneksi, $queryKategori);
$kategoriColors = [
    'Obat-obatan' => '#FF6384',
    'Gaji Staff' => '#36A2EB', 
    'Alat Medis' => '#FFCE56',
    'Listrik & Air' => '#4BC0C0',
    'Maintenance' => '#9966FF',
    'Marketing' => '#FF9F40',
    'Training' => '#FF638A',
    'Renovasi' => '#36A2FF',
    'Asuransi' => '#FFCE90',
    'IT Support' => '#4BC0FF',
    'Cleaning Service' => '#9966AA'
];
while ($row = mysqli_fetch_assoc($resultKategori)) {
    $color = isset($kategoriColors[$row['kategori']]) ? $kategoriColors[$row['kategori']] : '#CCCCCC';
    $piePengeluaranData[] = [
        'nama' => $row['kategori'],
        'nilai' => round($row['total'] / 1000000, 1), // Convert to millions
        'color' => $color
    ];
}

echo "<!-- Debug: Pie Data = " . json_encode($piePengeluaranData) . " -->";

// Get breakdown pengeluaran untuk tabel (gunakan tahun data yang konsisten)
$breakdownPengeluaran = [];
$queryBreakdown = "SELECT kategori, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total 
                   FROM pengeluaran 
                   WHERE YEAR(tanggal) = $tahunData 
                   GROUP BY kategori 
                   ORDER BY total DESC";
$resultBreakdown = mysqli_query($koneksi, $queryBreakdown);

// Gunakan total dari tahun data yang konsisten untuk perhitungan persentase
$queryTotalBdwn = "SELECT SUM(jumlah) as total_breakdown FROM pengeluaran WHERE YEAR(tanggal) = $tahunData";
$resultTotalBdwn = mysqli_query($koneksi, $queryTotalBdwn);
$totalBdwnData = mysqli_fetch_assoc($resultTotalBdwn);
$totalKeseluruhan = $totalBdwnData['total_breakdown'] > 0 ? $totalBdwnData['total_breakdown'] : 1;

// VALIDASI: Pastikan total breakdown sama dengan total pengeluaran tahun
echo "<!-- Debug: Total Pengeluaran Tahun = " . $totalPengeluaranTahun . " -->";
echo "<!-- Debug: Total Breakdown = " . $totalKeseluruhan . " -->";
echo "<!-- Debug: Konsistensi Data = " . ($totalPengeluaranTahun == $totalKeseluruhan ? 'KONSISTEN' : 'TIDAK KONSISTEN') . " -->";

while ($row = mysqli_fetch_assoc($resultBreakdown)) {
    $persentase = ($row['total'] / $totalKeseluruhan) * 100;
    $color = isset($kategoriColors[$row['kategori']]) ? $kategoriColors[$row['kategori']] : '#CCCCCC';
    
    $breakdownPengeluaran[] = [
        'kategori' => $row['kategori'],
        'detail' => $row['jumlah_transaksi'] . ' transaksi',
        'total' => $row['total'],
        'persentase' => $persentase,
        'color' => $color
    ];
}

echo "<!-- Debug: Breakdown Count = " . count($breakdownPengeluaran) . " -->";
echo "<!-- Debug: Tahun Data = " . $tahunData . " -->";

// ====== AI FEATURE: Insight Otomatis Pengeluaran ======
// 1. Prediksi pengeluaran bulan depan (forecast sederhana)
$prediksiPengeluaranBulanDepan = null;
if (count($dataPengeluaranBulananAsli) >= 2) {
    $growths = [];
    for ($i = 1; $i < count($dataPengeluaranBulananAsli); $i++) {
        if ($dataPengeluaranBulananAsli[$i-1] > 0) {
            $growths[] = ($dataPengeluaranBulananAsli[$i] - $dataPengeluaranBulananAsli[$i-1]) / $dataPengeluaranBulananAsli[$i-1];
        }
    }
    $avgGrowth = count($growths) > 0 ? array_sum($growths) / count($growths) : 0;
    $prediksiPengeluaranBulanDepan = end($dataPengeluaranBulananAsli) * (1 + $avgGrowth);
}

// 2. Deteksi anomali pengeluaran bulanan (outlier)
$anomaliPengeluaranBulan = null;
if (count($dataPengeluaranBulananAsli) >= 3) {
    $mean = array_sum($dataPengeluaranBulananAsli) / count($dataPengeluaranBulananAsli);
    $variance = array_sum(array_map(function($v) use ($mean) { return pow($v - $mean, 2); }, $dataPengeluaranBulananAsli)) / count($dataPengeluaranBulananAsli);
    $stddev = sqrt($variance);
    foreach ($dataPengeluaranBulananAsli as $idx => $val) {
        if ($stddev > 0 && (abs($val - $mean) > 2 * $stddev)) {
            $anomaliPengeluaranBulan = $idx + 1; // bulan ke-n
            break;
        }
    }
}

// 3. Kategori dengan pertumbuhan tertinggi/terendah dibanding tahun lalu
$kategoriTertinggi = null;
$kategoriTerendah = null;
if (!empty($breakdownPengeluaran)) {
    $queryLastYear = "SELECT kategori, SUM(jumlah) as total FROM pengeluaran WHERE YEAR(tanggal) = ".($tahunData-1)." GROUP BY kategori";
    $resultLastYear = mysqli_query($koneksi, $queryLastYear);
    $lastYearData = [];
    while ($row = mysqli_fetch_assoc($resultLastYear)) {
        $lastYearData[$row['kategori']] = $row['total'];
    }
    $maxGrowth = null;
    $maxGrowthKategori = null;
    $minGrowth = null;
    $minGrowthKategori = null;
    foreach ($breakdownPengeluaran as $item) {
        $nama = $item['kategori'];
        $now = $item['total'];
        $last = isset($lastYearData[$nama]) ? $lastYearData[$nama] : null;
        if ($last && $last > 0) {
            $growth = ($now - $last) / $last;
            if ($maxGrowth === null || $growth > $maxGrowth) {
                $maxGrowth = $growth;
                $maxGrowthKategori = $nama;
            }
            if ($minGrowth === null || $growth < $minGrowth) {
                $minGrowth = $growth;
                $minGrowthKategori = $nama;
            }
        }
    }
    if ($maxGrowthKategori && $maxGrowth > 0.05) {
        $kategoriTertinggi = [$maxGrowthKategori, $maxGrowth];
    }
    if ($minGrowthKategori && $minGrowth < -0.05) {
        $kategoriTerendah = [$minGrowthKategori, $minGrowth];
    }
}

// 4. Kategori dominan (>50% total pengeluaran)
$kategoriDominan = null;
if (!empty($breakdownPengeluaran)) {
    $totalAll = array_sum(array_column($breakdownPengeluaran, 'total'));
    foreach ($breakdownPengeluaran as $item) {
        if ($totalAll > 0 && $item['total']/$totalAll > 0.5) {
            $kategoriDominan = [$item['kategori'], $item['total']/$totalAll];
            break;
        }
    }
}

// 5. Korelasi jumlah transaksi vs total pengeluaran per kategori
$korelasiTransaksiPengeluaran = null;
if (!empty($breakdownPengeluaran)) {
    $arrTransaksi = [];
    $arrTotal = [];
    foreach ($breakdownPengeluaran as $item) {
        $arrTotal[] = $item['total'];
        $arrTransaksi[] = (int) filter_var($item['detail'], FILTER_SANITIZE_NUMBER_INT);
    }
    $n = count($arrTotal);
    if ($n > 1) {
        $meanT = array_sum($arrTotal)/$n;
        $meanN = array_sum($arrTransaksi)/$n;
        $cov = 0; $varT = 0; $varN = 0;
        for ($i=0;$i<$n;$i++) {
            $cov += ($arrTotal[$i]-$meanT)*($arrTransaksi[$i]-$meanN);
            $varT += pow($arrTotal[$i]-$meanT,2);
            $varN += pow($arrTransaksi[$i]-$meanN,2);
        }
        $corr = ($varT > 0 && $varN > 0) ? $cov / sqrt($varT*$varN) : 0;
        $korelasiTransaksiPengeluaran = $corr;
    }
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
    <title>Apothecary | Kasir Pembayaran</title>
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
            padding: 20px 18px 16px 18px;
            display: flex;
            flex-direction: column;
            min-height: 150px;
            position: relative;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            height: 100%;
            justify-content: space-between;
            cursor: pointer;
        }
        .summary-box:hover {
            transform: translateY(-3px);
            border-color: rgba(8,131,149,0.15);
        }
        .summary-box .summary-title {
            color: #088395;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 12px;
            letter-spacing: 0.2px;
            line-height: 1.3;
            padding-right: 50px;
            word-wrap: break-word;
        }
        .summary-box .summary-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: #222;
            margin-bottom: 12px;
            line-height: 1.1;
            letter-spacing: 1px;
            margin-top: auto;
            display: flex;
            align-items: baseline;
            justify-content: flex-start;
        }
        
        .summary-value .currency {
            font-size: 1.2rem;
            margin-right: 4px;
            color: #666;
            font-weight: 600;
        }
        .summary-box .summary-icon {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff;
            box-shadow: 0 2px 8px rgba(8,131,149,0.10);
            transition: transform 0.3s ease;
        }
        .summary-box:hover .summary-icon {
            transform: scale(1.1);
        }
        .summary-box .summary-badge {
            margin-top: 0;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 8px;
            padding: 8px 12px;
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
        .review-mini-card,
        .service-card,
        .demografi-card {
            box-shadow: 0 4px 24px rgba(8,131,149,0.08) !important;
        }
        
        /* Override untuk hover effects */
        .summary-box:hover,
        .insight-card:hover,
        .service-card:hover {
            box-shadow: 0 8px 32px rgba(8,131,149,0.13) !important;
        }

        /* ==== Insight Card Keuntungan ==== */
        .insight-card {
            background: #fff;
            border-radius: 18px;
            border-left: 8px solid #5459AC;
            padding: 28px 28px 22px 28px;
            transition: box-shadow 0.2s;
            margin-bottom: 0;
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

        /* === TABEL KEUNTUNGAN MODERN === */
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

        /* Padding atas main agar tidak menempel headbar */
        #layoutSidenav_content main > .container-fluid,
        #layoutSidenav_content main > .container {
            padding-top: 1.5rem;
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
                            <!-- <a class="nav-link " href="../chatbot-ai/chatbot.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Chatbot AI
                            </a> -->
                            <a class="nav-link" href="../data-pemeriksaan/pemeriksaan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Data Pemeriksaan
                            </a>
                            <a class="nav-link" href="../keuntungan/keuntungan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                                Keuntungan
                            </a>
                            <a class="nav-link active" href="../data-pembayaran/pembayaran.php">
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
                <h4 class="mb-4 font-weight-bold text-secondary">Ringkasan Data Pengeluaran</h4>

                <!-- Summary Box Pengeluaran -->
                <div class="row">
                    <!-- Total Pengeluaran Tahun Ini -->
                    <div class="col-md-3 mb-4">
                        <div class="summary-box">
                            <div class="summary-title">Total Pengeluaran Tahun Ini</div>
                            <div class="summary-value"><span class="currency">Rp</span><span class="counter" data-count="<?php echo $totalPengeluaranTahun; ?>">0</span></div>
                            <div class="summary-icon"><i class="fas fa-coins"></i></div>
                            <span class="summary-badge badge-red">Perlu Monitoring</span>
                        </div>
                    </div>

                    <!-- Rata-rata Pengeluaran Bulanan -->
                    <div class="col-md-3 mb-4">
                        <div class="summary-box">
                            <div class="summary-title">Rata-rata / Bulan</div>
                            <div class="summary-value"><span class="currency">Rp</span><span class="counter" data-count="<?php echo $rataPengeluaranBulanan; ?>">0</span></div>
                            <div class="summary-icon"><i class="fas fa-chart-line"></i></div>
                            <span class="summary-badge badge-orange">Dalam Batas</span>
                        </div>
                    </div>

                    <!-- Pengeluaran Bulan Ini -->
                    <div class="col-md-3 mb-4">
                        <div class="summary-box">
                            <div class="summary-title">Pengeluaran Bulan Ini</div>
                            <div class="summary-value"><span class="currency">Rp</span><span class="counter" data-count="<?php echo $pengeluaranBulanIni; ?>">0</span></div>
                            <div class="summary-icon"><i class="fas fa-calendar-alt"></i></div>
                            <span class="summary-badge badge-blue">Bulan Berjalan</span>
                        </div>
                    </div>

                    <!-- Pertumbuhan Bulanan Pengeluaran -->
                    <div class="col-md-3 mb-4">
                        <div class="summary-box">
                            <div class="summary-title">Pertumbuhan Bulanan</div>
                            <div class="summary-value"><span class="counter" data-count="<?php echo round($pertumbuhanPengeluaran, 1); ?>">0</span>%</div>
                            <div class="summary-icon"><i class="fas fa-percentage"></i></div>
                            <span class="summary-badge <?php echo $pertumbuhanPengeluaran > 10 ? 'badge-red' : 'badge-green'; ?>"><?php echo $pertumbuhanPengeluaran > 10 ? 'Tinggi' : 'Terkendali'; ?></span>
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
                        $this.text(val % 1 === 0 ? new Intl.NumberFormat('id-ID').format(val.toFixed(0)) : new Intl.NumberFormat('id-ID').format(val.toFixed(1)));
                    },
                    complete: function () {
                        let val = parseFloat(this.countNum);
                        $this.text(val % 1 === 0 ? new Intl.NumberFormat('id-ID').format(val.toFixed(0)) : new Intl.NumberFormat('id-ID').format(val.toFixed(1)));
                    }
                    });
                });
                </script>


                <!-- � Row 2: Insight Pengeluaran Otomatis -->
                <div class="mb-4">
                    <div class="insight-card shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="insight-icon mr-3">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div>
                                <h6 class="insight-title mb-2">Insight Saran Cerdas Pengeluaran</h6>
                                <p class="insight-desc mb-2">
                                    📊 Sistem mendeteksi pertumbuhan pengeluaran bulanan sebesar <strong><?= round($pertumbuhanPengeluaran, 1) ?>%</strong>.
                                    <?php if (!empty($piePengeluaranData)): ?>
                                    Kategori pengeluaran terbesar adalah <strong><?= $piePengeluaranData[0]['nama'] ?></strong><?= isset($piePengeluaranData[1]) ? ' dan <strong>'.$piePengeluaranData[1]['nama'].'</strong>' : '' ?>.
                                    <?php endif; ?>
                                    Pengeluaran bulan ini <strong>Rp <?= number_format($pengeluaranBulanIni, 0, ',', '.') ?></strong> <?= $pertumbuhanPengeluaran > 10 ? 'perlu dipantau lebih ketat' : 'masih dalam batas wajar' ?>.
                                </p>
                                <ul class="insight-list mb-0">
                                    <!-- AI Insight Tambahan -->
                                    <li>🤖 <strong>Prediksi AI:</strong> Estimasi pengeluaran bulan depan sekitar <strong>Rp <?php
                                        if ($prediksiPengeluaranBulanDepan !== null && $prediksiPengeluaranBulanDepan > 0) {
                                            echo number_format($prediksiPengeluaranBulanDepan*1000000, 0, ',', '.');
                                        } elseif (count($dataPengeluaranBulanan) >= 2) {
                                            // Data ada, tapi prediksi 0, tampilkan 0
                                            echo '0';
                                        } else {
                                            echo 'Data belum cukup';
                                        }
                                    ?></strong></li>
                                    <li>🚨 <strong>Anomali Terdeteksi:</strong> <?php if ($anomaliPengeluaranBulan) { ?>Pengeluaran bulan <?= date('F', mktime(0,0,0,$anomaliPengeluaranBulan,1)) ?> berbeda signifikan dari rata-rata. Perlu analisis lebih lanjut.<?php } else { ?>Tidak ada anomali signifikan terdeteksi.<?php } ?></li>
                                    <li>📈 <strong>Kategori dengan pertumbuhan tertinggi:</strong> <?php
                                        if ($kategoriTertinggi) {
                                            echo $kategoriTertinggi[0] . ' (naik ' . number_format($kategoriTertinggi[1]*100,1) . '% dibanding tahun lalu)';
                                        } elseif (!empty($breakdownPengeluaran) && isset($resultLastYear) && mysqli_num_rows($resultLastYear) > 0) {
                                            echo 'Tidak ada pertumbuhan signifikan.';
                                        } else {
                                            echo 'Data tahun lalu belum tersedia.';
                                        }
                                    ?></li>
                                    <li>🔻 <strong>Kategori dengan penurunan terbesar:</strong> <?php
                                        if ($kategoriTerendah) {
                                            echo $kategoriTerendah[0] . ' (turun ' . number_format(abs($kategoriTerendah[1]*100),1) . '% dibanding tahun lalu)';
                                        } elseif (!empty($breakdownPengeluaran) && isset($resultLastYear) && mysqli_num_rows($resultLastYear) > 0) {
                                            echo 'Tidak ada penurunan signifikan.';
                                        } else {
                                            echo 'Data tahun lalu belum tersedia.';
                                        }
                                    ?></li>
                                    <li>🏅 <strong>Kategori Dominan:</strong> <?php if ($kategoriDominan) { ?><?= $kategoriDominan[0] ?> menyumbang lebih dari <?= number_format($kategoriDominan[1]*100,1) ?>% total pengeluaran tahun ini.<?php } else { ?>Belum ada kategori yang menyumbang lebih dari 50% total pengeluaran tahun ini.<?php } ?></li>
                                    <li>🔗 <strong>Korelasi Transaksi-Pengeluaran:</strong> <?php if (isset($korelasiTransaksiPengeluaran)) { ?><?= ($korelasiTransaksiPengeluaran > 0.7 ? 'Sangat kuat' : ($korelasiTransaksiPengeluaran > 0.4 ? 'Cukup kuat' : ($korelasiTransaksiPengeluaran < -0.4 ? 'Negatif' : 'Lemah'))) ?> (<?= number_format($korelasiTransaksiPengeluaran,2) ?>). <?= $korelasiTransaksiPengeluaran > 0.4 ? 'Semakin banyak transaksi, semakin besar pengeluaran.' : ($korelasiTransaksiPengeluaran < -0.4 ? 'Volume transaksi tinggi tidak selalu berarti pengeluaran tinggi.' : 'Hubungan transaksi dan pengeluaran tidak signifikan.') ?><?php } else { ?>Data transaksi dan pengeluaran per kategori belum cukup untuk analisis korelasi.<?php } ?></li>
                                    <li>🎯 <strong>Saran:</strong> <?= $pertumbuhanPengeluaran > 15 ? 'Evaluasi mendesak diperlukan untuk mengendalikan pengeluaran' : 'Evaluasi supplier dan pertimbangkan kontrak jangka panjang untuk harga lebih baik' ?>.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- �🟢 Row 3: Visualisasi Distribusi Pengeluaran -->
                <h5 class="mb-3 font-weight-bold text-secondary">Visualisasi Distribusi Pengeluaran</h5>
                <div class="row">
                    <!-- Bar Chart Pengeluaran Bulanan -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow demografi-card h-100">
                            <div class="card-body pb-2">
                                <h6 class="font-weight-bold text-primary">Grafik Pengeluaran Bulanan</h6>
                                <div class="chart-wrapper">
                                    <canvas id="pengeluaranChart" class="demografi-chart-canvas"></canvas>
                                </div>
                                <div class="chart-caption">📈 <strong><?php 
                                    $bulanNama = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    if (!empty($dataPengeluaranBulanan) && max($dataPengeluaranBulanan) > 0) {
                                        $maxValue = max($dataPengeluaranBulanan);
                                        $maxIndex = array_search($maxValue, $dataPengeluaranBulanan);
                                        echo $bulanNama[$maxIndex + 1];
                                        echo '</strong> menunjukkan pengeluaran tertinggi. Monitor anggaran dengan ketat.';
                                    } else {
                                        echo 'Data</strong> pengeluaran belum tersedia. Mulai input data untuk analisis.';
                                    }
                                ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Pie Chart Kategori Pengeluaran -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow demografi-card h-100">
                            <div class="card-body pb-2">
                                <h6 class="font-weight-bold text-primary">Distribusi Kategori Pengeluaran (%)</h6>
                                <div class="chart-wrapper">
                                    <canvas id="piePengeluaranChart" class="demografi-chart-canvas"></canvas>
                                </div>
                                <div class="chart-caption">💊 <strong><?= !empty($piePengeluaranData) ? $piePengeluaranData[0]['nama'] : 'Belum ada data' ?></strong> <?= !empty($piePengeluaranData) ? 'mendominasi pengeluaran. Evaluasi efisiensi pengadaan.' : 'Mulai input data pengeluaran untuk analisis.' ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🎯 Row 4: Service Cards Kategori Pengeluaran -->
                <h5 class="mb-3 font-weight-bold text-secondary">Kategori Pengeluaran</h5>
                <div class="row mb-4">
                    <!-- Service Card 1: Obat & Alkes -->
                    <div class="col-md-2 mb-3">
                        <div class="service-card shadow-sm text-center p-3" style="border-radius: 16px; background: #fff; transition: all 0.3s ease; cursor: pointer; height: 100%;">
                            <div class="service-icon mx-auto mb-2" style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #FF638420 0%, #FF638410 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-pills" style="color: #FF6384; font-size: 1.5rem;"></i>
                            </div>
                            <h6 class="service-title mb-1" style="color: #2c3e50; font-size: 0.85rem; font-weight: 700; font-family: 'Poppins', Arial, sans-serif;">Obat & Alkes</h6>
                            <p class="service-desc text-muted mb-0" style="font-size: 0.75rem; line-height: 1.3;">Pengadaan & Stok</p>
                        </div>
                    </div>
                    <!-- Service Card 2: Gaji Karyawan -->
                    <div class="col-md-2 mb-3">
                        <div class="service-card shadow-sm text-center p-3" style="border-radius: 16px; background: #fff; transition: all 0.3s ease; cursor: pointer; height: 100%;">
                            <div class="service-icon mx-auto mb-2" style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #36A2EB20 0%, #36A2EB10 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-users" style="color: #36A2EB; font-size: 1.5rem;"></i>
                            </div>
                            <h6 class="service-title mb-1" style="color: #2c3e50; font-size: 0.85rem; font-weight: 700; font-family: 'Poppins', Arial, sans-serif;">Gaji Karyawan</h6>
                            <p class="service-desc text-muted mb-0" style="font-size: 0.75rem; line-height: 1.3;">Dokter & Staff</p>
                        </div>
                    </div>
                    <!-- Service Card 3: Operasional -->
                    <div class="col-md-2 mb-3">
                        <div class="service-card shadow-sm text-center p-3" style="border-radius: 16px; background: #fff; transition: all 0.3s ease; cursor: pointer; height: 100%;">
                            <div class="service-icon mx-auto mb-2" style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #FFCE5620 0%, #FFCE5610 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-bolt" style="color: #FFCE56; font-size: 1.5rem;"></i>
                            </div>
                            <h6 class="service-title mb-1" style="color: #2c3e50; font-size: 0.85rem; font-weight: 700; font-family: 'Poppins', Arial, sans-serif;">Operasional</h6>
                            <p class="service-desc text-muted mb-0" style="font-size: 0.75rem; line-height: 1.3;">Listrik & Air</p>
                        </div>
                    </div>
                    <!-- Service Card 4: Peralatan -->
                    <div class="col-md-2 mb-3">
                        <div class="service-card shadow-sm text-center p-3" style="border-radius: 16px; background: #fff; transition: all 0.3s ease; cursor: pointer; height: 100%;">
                            <div class="service-icon mx-auto mb-2" style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #4BC0C020 0%, #4BC0C010 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-tools" style="color: #4BC0C0; font-size: 1.5rem;"></i>
                            </div>
                            <h6 class="service-title mb-1" style="color: #2c3e50; font-size: 0.85rem; font-weight: 700; font-family: 'Poppins', Arial, sans-serif;">Peralatan</h6>
                            <p class="service-desc text-muted mb-0" style="font-size: 0.75rem; line-height: 1.3;">Maintenance</p>
                        </div>
                    </div>
                    <!-- Service Card 5: Promosi -->
                    <div class="col-md-2 mb-3">
                        <div class="service-card shadow-sm text-center p-3" style="border-radius: 16px; background: #fff; transition: all 0.3s ease; cursor: pointer; height: 100%;">
                            <div class="service-icon mx-auto mb-2" style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #9966FF20 0%, #9966FF10 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-bullhorn" style="color: #9966FF; font-size: 1.5rem;"></i>
                            </div>
                            <h6 class="service-title mb-1" style="color: #2c3e50; font-size: 0.85rem; font-weight: 700; font-family: 'Poppins', Arial, sans-serif;">Promosi</h6>
                            <p class="service-desc text-muted mb-0" style="font-size: 0.75rem; line-height: 1.3;">Marketing</p>
                        </div>
                    </div>
                    <!-- Service Card 6: Lain-lain -->
                    <div class="col-md-2 mb-3">
                        <div class="service-card shadow-sm text-center p-3" style="border-radius: 16px; background: #fff; transition: all 0.3s ease; cursor: pointer; height: 100%;">
                            <div class="service-icon mx-auto mb-2" style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #FF9F4020 0%, #FF9F4010 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-ellipsis-h" style="color: #FF9F40; font-size: 1.5rem;"></i>
                            </div>
                            <h6 class="service-title mb-1" style="color: #2c3e50; font-size: 0.85rem; font-weight: 700; font-family: 'Poppins', Arial, sans-serif;">Lain-lain</h6>
                            <p class="service-desc text-muted mb-0" style="font-size: 0.75rem; line-height: 1.3;">Tak Terduga</p>
                        </div>
                    </div>
                </div>

                <!-- Service Cards Section -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-secondary mb-0">Breakdown Pengeluaran per Kategori</h5>
                    <div class="d-flex align-items-center">
                        <div class="input-group" style="width: 280px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0" style="border: 1px solid #e3e6f0; border-right: none;">
                                    <i class="fas fa-search text-muted" style="font-size: 0.9rem;"></i>
                                </span>
                            </div>
                            <input type="text" id="pengeluaranDetailSearch" class="form-control border-left-0 pl-0" placeholder="Cari kategori pengeluaran..." style="border: 1px solid #e3e6f0; border-left: none; font-size: 0.9rem;">
                        </div>
                    </div>
                </div>
                <!-- Breakdown Table -->
                <div class="card mb-4 shadow-sm" style="border: none; border-radius: 12px; overflow: hidden;">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: linear-gradient(90deg, #5459AC 85%, #6fc3d0 100%);">
                                    <tr>
                                        <th style="border: none; padding: 16px 20px; font-weight: 700; color: #fff; font-size: 0.95rem;">Kategori</th>
                                        <th style="border: none; padding: 16px 20px; font-weight: 700; color: #fff; font-size: 0.95rem;">Detail</th>
                                        <th style="border: none; padding: 16px 20px; font-weight: 700; color: #fff; font-size: 0.95rem;">Total Pengeluaran</th>
                                        <th style="border: none; padding: 16px 20px; font-weight: 700; color: #fff; font-size: 0.95rem;">Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($breakdownPengeluaran)): ?>
                                    <?php 
                                    $iconMapping = [
                                        'Obat-obatan' => 'fas fa-pills',
                                        'Gaji Staff' => 'fas fa-users', 
                                        'Alat Medis' => 'fas fa-stethoscope',
                                        'Listrik & Air' => 'fas fa-bolt',
                                        'Maintenance' => 'fas fa-tools',
                                        'Marketing' => 'fas fa-bullhorn',
                                        'Training' => 'fas fa-graduation-cap',
                                        'Renovasi' => 'fas fa-hammer',
                                        'Asuransi' => 'fas fa-shield-alt',
                                        'IT Support' => 'fas fa-laptop',
                                        'Cleaning Service' => 'fas fa-broom'
                                    ];
                                    
                                    foreach ($breakdownPengeluaran as $item): 
                                        $icon = isset($iconMapping[$item['kategori']]) ? $iconMapping[$item['kategori']] : 'fas fa-ellipsis-h';
                                        $bgColor = $item['color'] . '20';
                                        $bgColorLight = $item['color'] . '10';
                                    ?>
                                    <tr style="border-bottom: 1px solid #f1f3f4;">
                                        <td style="border: none; padding: 18px 20px;">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3" style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, <?= $bgColor ?> 0%, <?= $bgColorLight ?> 100%); display: flex; align-items: center; justify-content: center;">
                                                    <i class="<?= $icon ?>" style="color: <?= $item['color'] ?>; font-size: 1.2rem;"></i>
                                                </div>
                                                <strong style="color: #2c3e50; font-size: 0.95rem;"><?= $item['kategori'] ?></strong>
                                            </div>
                                        </td>
                                        <td style="border: none; padding: 18px 20px; color: #6c757d; font-size: 0.9rem;"><?= $item['detail'] ?></td>
                                        <td style="border: none; padding: 18px 20px;">
                                            <strong style="color: #2c3e50; font-size: 0.95rem;">Rp <?= number_format($item['total'], 0, ',', '.') ?></strong>
                                        </td>
                                        <td style="border: none; padding: 18px 20px;">
                                            <div class="d-flex align-items-center">
                                                <div class="progress mr-2" style="width: 60px; height: 6px; border-radius: 3px; background: #f1f3f4;">
                                                    <div class="progress-bar" style="background: <?= $item['color'] ?>; width: <?= min($item['persentase'], 100) ?>%; border-radius: 3px;"></div>
                                                </div>
                                                <span style="color: <?= $item['color'] ?>; font-weight: 700; font-size: 0.85rem;"><?= number_format($item['persentase'], 1) ?>%</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="4" style="border: none; padding: 40px 20px; text-align: center; color: #6c757d;">
                                            <i class="fas fa-database" style="font-size: 3rem; margin-bottom: 10px; opacity: 0.3;"></i><br>
                                            <strong>Belum ada data pengeluaran</strong><br>
                                            <small>Mulai input data pengeluaran untuk melihat breakdown kategori</small>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Button Input Data Pengeluaran -->
                <div class="d-flex justify-content-end mb-4">
                    <a href="pembayaran_input.php" class="btn btn-primary btn-lg font-weight-bold" style="border-radius: 10px; background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%); border: none;">
                        <i class="fas fa-plus-circle mr-2"></i> Input Data Pengeluaran
                    </a>
                </div>
            <!-- Script Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Data Bar Chart dari database
                const barData = <?= json_encode($dataPengeluaranBulanan) ?>;
                const barLabels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
                const barColors = [
                    '#5A9BFF', '#5ACF85', '#4BBFC9', '#FFD350',
                    '#E35B5B', '#8A5BFF', '#3ED1AA', '#FF9240',
                    '#9356A3', '#FF70A6', '#FFB347', '#FF8F8F'
                ];

                const ctxBar = document.getElementById("pengeluaranChart").getContext('2d');
                const pengeluaranChart = new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: barLabels,
                        datasets: [{
                            label: 'Pengeluaran (Juta)',
                            data: barData,
                            backgroundColor: 'rgba(8,131,149,0.85)',
                            borderRadius: 12,
                            borderSkipped: false,
                            maxBarThickness: 38
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#5459AC',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: '#6fc3d0',
                                borderWidth: 1,
                                callbacks: {
                                    label: (ctx) => `Pengeluaran: Rp ${ctx.raw} juta`
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { color: 'rgba(8,131,149,0.08)' },
                                ticks: {
                                    color: '#5459AC',
                                    font: { weight: 'bold', family: 'Poppins' },
                                    callback: function(value) { return 'Rp ' + value + 'jt'; }
                                }
                            },
                            y: {
                                grid: { display: false },
                                ticks: {
                                    color: '#5459AC',
                                    font: { weight: 'bold', family: 'Poppins' }
                                }
                            }
                        }
                    }
                });

                // Data Pie Chart dari database
                const pieLabels = <?= !empty($piePengeluaranData) ? json_encode(array_column($piePengeluaranData, 'nama')) : '["Belum ada data"]' ?>;
                const pieData = <?= !empty($piePengeluaranData) ? json_encode(array_column($piePengeluaranData, 'nilai')) : '[0]' ?>;
                const pieColors = [
                  'rgba(84,89,172,0.92)', 'rgba(111,195,208,0.92)', 'rgba(8,131,149,0.92)',
                  'rgba(111,195,208,0.65)', 'rgba(84,89,172,0.65)', 'rgba(8,131,149,0.65)'
                ];

                const ctxPie = document.getElementById("piePengeluaranChart").getContext('2d');
                const pieChart = new Chart(ctxPie, {
                    type: 'doughnut',
                    data: {
                        labels: pieLabels,
                        datasets: [{
                            data: pieData,
                            backgroundColor: pieColors,
                            borderColor: '#fff',
                            borderWidth: 3,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        cutout: '68%',
                        responsive: true,
                        maintainAspectRatio: false,
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
                                        const total = pieData.reduce((a, b) => a + b, 0);
                                        const val = pieData[ctx.dataIndex];
                                        const percent = ((val / total) * 100).toFixed(1);
                                        return `${ctx.label}: Rp ${val} juta (${percent}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            </script>

            <!-- Search filter functionality -->
            <script>
            document.getElementById('pengeluaranDetailSearch').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('tbody tr');
                
                tableRows.forEach(row => {
                    const categoryCell = row.querySelector('td:nth-child(1)');
                    const detailCell = row.querySelector('td:nth-child(2)');
                    
                    if (categoryCell && detailCell) {
                        const categoryText = categoryCell.textContent.toLowerCase();
                        const detailText = detailCell.textContent.toLowerCase();
                        
                        if (categoryText.includes(searchTerm) || detailText.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            });
            </script>
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
    <script src="../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/Chart.min.js"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/demo/datatables-demo.js"></script>
</body>

</html>