<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='login/index.php'</script>";
    exit();
}

// Get current date and time info
$currentYear = date('Y');
$currentMonth = date('n');
$currentDate = date('Y-m-d');
$currentDateTime = date('Y-m-d H:i:s');

// ==== SUMMARY BOX DATA CALCULATIONS ====
// 1. Keuntungan Tahun Ini (sama dengan halaman keuntungan.php)
// Menggunakan data dari keuntungan_layanan_summary seperti di keuntungan.php
$queryTotalKeuntungan = "SELECT SUM(total_keuntungan_tahun) as total_tahun FROM keuntungan_layanan_summary WHERE tahun = $currentYear";
$resultTotalKeuntungan = mysqli_query($koneksi, $queryTotalKeuntungan);
$totalKeuntunganData = mysqli_fetch_assoc($resultTotalKeuntungan);
$keuntunganTahunIni = $totalKeuntunganData['total_tahun'] ? $totalKeuntunganData['total_tahun'] : 320000000;

// 2. Pengeluaran Tahun Ini (sama dengan halaman pembayaran.php)
// Menggunakan logika konsistensi data seperti di pembayaran.php
$tahunDataPengeluaran = $currentYear;

// Cek apakah ada data untuk tahun ini
$queryCheckTahunPengeluaran = "SELECT COUNT(*) as count_data FROM pengeluaran WHERE YEAR(tanggal) = $currentYear";
$resultCheckTahunPengeluaran = mysqli_query($koneksi, $queryCheckTahunPengeluaran);
$checkTahunPengeluaranData = mysqli_fetch_assoc($resultCheckTahunPengeluaran);

// Jika tidak ada data tahun ini, gunakan 2024 untuk SEMUA perhitungan (sama seperti pembayaran.php)
if ($checkTahunPengeluaranData['count_data'] == 0) {
    $tahunDataPengeluaran = 2024;
}

$queryPengeluaranTahun = "SELECT SUM(jumlah) as total_pengeluaran FROM pengeluaran WHERE YEAR(tanggal) = $tahunDataPengeluaran";
$resultPengeluaranTahun = mysqli_query($koneksi, $queryPengeluaranTahun);
$pengeluaranTahunData = mysqli_fetch_assoc($resultPengeluaranTahun);
$pengeluaranTahunIni = $pengeluaranTahunData['total_pengeluaran'] ? $pengeluaranTahunData['total_pengeluaran'] : 0;

// 3. Stok Obat Kritis (stok <= stok_minimum)
$queryObatKritis = "SELECT COUNT(*) as jumlah_obat_kritis FROM tb_obat WHERE stok <= stok_minimum AND status_obat = 'aktif'";
$resultObatKritis = mysqli_query($koneksi, $queryObatKritis);
$obatKritisData = mysqli_fetch_assoc($resultObatKritis);
$jumlahObatKritis = $obatKritisData['jumlah_obat_kritis'];

// 4. Total Pasien
$queryTotalPasien = "SELECT COUNT(*) as total_pasien FROM tb_pasien";
$resultTotalPasien = mysqli_query($koneksi, $queryTotalPasien);
$totalPasienData = mysqli_fetch_assoc($resultTotalPasien);
$totalPasien = $totalPasienData['total_pasien'];

// Pasien baru bulan ini
$queryPasienBaru = "SELECT COUNT(*) as pasien_baru FROM tb_pasien WHERE YEAR(created_at) = $currentYear AND MONTH(created_at) = $currentMonth";
$resultPasienBaru = mysqli_query($koneksi, $queryPasienBaru);
$pasienBaruData = mysqli_fetch_assoc($resultPasienBaru);
$pasienBaruBulanIni = $pasienBaruData['pasien_baru'];

// ==== AKTIVITAS HARI INI ====
// Pasien hari ini (menggunakan data yang sama dengan pasien.php - berdasarkan tb_pasien created_at)
$queryPasienHariIni = "SELECT COUNT(*) as pasien_hari_ini FROM tb_pasien WHERE DATE(created_at) = '$currentDate'";
$resultPasienHariIni = mysqli_query($koneksi, $queryPasienHariIni);
$pasienHariIniData = mysqli_fetch_assoc($resultPasienHariIni);
$pasienHariIni = $pasienHariIniData['pasien_hari_ini'];

// Pemeriksaan selesai (total keseluruhan seperti pemeriksaan.php)
$queryPemeriksaanSelesai = "SELECT COUNT(*) as pemeriksaan_selesai FROM tb_pemeriksaan WHERE status_pemeriksaan = 'selesai'";
$resultPemeriksaanSelesai = mysqli_query($koneksi, $queryPemeriksaanSelesai);
$pemeriksaanSelesaiData = mysqli_fetch_assoc($resultPemeriksaanSelesai);
$pemeriksaanSelesai = $pemeriksaanSelesaiData['pemeriksaan_selesai'];

// Dokter aktif (total keseluruhan seperti dokter.php)
$queryDokterAktif = "SELECT COUNT(*) as dokter_aktif FROM tb_dokter WHERE status_dokter = 'aktif'";
$resultDokterAktif = mysqli_query($koneksi, $queryDokterAktif);
$dokterAktifData = mysqli_fetch_assoc($resultDokterAktif);
$dokterAktif = $dokterAktifData['dokter_aktif'];

// Staff aktif (menggunakan query yang sama dengan staff.php)
$queryStaffAktif = "SELECT COUNT(*) as staff_aktif FROM tb_staff WHERE status_staff = 'aktif'";
$resultStaffAktif = mysqli_query($koneksi, $queryStaffAktif);
$staffAktifData = mysqli_fetch_assoc($resultStaffAktif);
$staffAktif = $staffAktifData['staff_aktif'] ? $staffAktifData['staff_aktif'] : 0;

// ==== DATA KEUANGAN UNTUK CHART ====
// Get monthly profit data for current year (sama seperti di keuntungan.php)
$dataKeuntunganChart = [];
$dataPengeluaranChart = [];

// Cek apakah ada data keuntungan untuk tahun ini
$queryCheckTahunKeuntungan = "SELECT COUNT(*) as count_data FROM keuntungan_bulanan_analytics WHERE tahun = $currentYear";
$resultCheckTahunKeuntungan = mysqli_query($koneksi, $queryCheckTahunKeuntungan);
$checkTahunKeuntunganData = mysqli_fetch_assoc($resultCheckTahunKeuntungan);

// Tahun data untuk keuntungan
$tahunDataKeuntungan = $currentYear;
if ($checkTahunKeuntunganData['count_data'] == 0) {
    $tahunDataKeuntungan = 2024;
}

// Menggunakan data dari keuntungan_bulanan_analytics seperti di keuntungan.php
$queryKeuntunganBulanAnalytics = "SELECT bulan, total_keuntungan FROM keuntungan_bulanan_analytics 
                                   WHERE tahun = $tahunDataKeuntungan ORDER BY bulan";
$resultKeuntunganBulanAnalytics = mysqli_query($koneksi, $queryKeuntunganBulanAnalytics);

// Inisialisasi array dengan 0 untuk semua bulan
for ($i = 0; $i < 12; $i++) {
    $dataKeuntunganChart[$i] = 0;
}

// Isi data keuntungan dari database
while ($row = mysqli_fetch_assoc($resultKeuntunganBulanAnalytics)) {
    $dataKeuntunganChart[$row['bulan'] - 1] = round($row['total_keuntungan'] / 1000000, 1);
}

// Data pengeluaran per bulan (menggunakan tahun yang konsisten)
for ($month = 1; $month <= 12; $month++) {
    $queryPengeluaranBulan = "SELECT SUM(jumlah) as pengeluaran_bulan FROM pengeluaran WHERE YEAR(tanggal) = $tahunDataPengeluaran AND MONTH(tanggal) = $month";
    $resultPengeluaranBulan = mysqli_query($koneksi, $queryPengeluaranBulan);
    $pengeluaranBulanData = mysqli_fetch_assoc($resultPengeluaranBulan);
    $dataPengeluaranChart[] = $pengeluaranBulanData['pengeluaran_bulan'] ? round($pengeluaranBulanData['pengeluaran_bulan'] / 1000000, 1) : 0;
}

// ==== DATA TREN 7 HARI ====
$dataTren7Hari = ['pasien' => [], 'pemeriksaan' => [], 'pengeluaran' => [], 'keuntungan' => []];
$hari7Terakhir = [];

for ($i = 6; $i >= 0; $i--) {
    $tanggal = date('Y-m-d', strtotime("-$i days"));
    $hari7Terakhir[] = date('D', strtotime($tanggal));
    
    // Pasien per hari (menggunakan data yang sama dengan pasien.php - berdasarkan tb_pasien created_at)
    $queryPasienHari = "SELECT COUNT(*) as jumlah FROM tb_pasien WHERE DATE(created_at) = '$tanggal'";
    $resultPasienHari = mysqli_query($koneksi, $queryPasienHari);
    $pasienHariData = mysqli_fetch_assoc($resultPasienHari);
    $dataTren7Hari['pasien'][] = $pasienHariData['jumlah'];
    
    // Pemeriksaan per hari (menggunakan data yang sama dengan pemeriksaan.php - status_pemeriksaan = 'selesai')
    $queryPemeriksaanHari = "SELECT COUNT(*) as jumlah FROM tb_pemeriksaan WHERE tanggal_pemeriksaan = '$tanggal' AND status_pemeriksaan = 'selesai'";
    $resultPemeriksaanHari = mysqli_query($koneksi, $queryPemeriksaanHari);
    $pemeriksaanHariData = mysqli_fetch_assoc($resultPemeriksaanHari);
    $dataTren7Hari['pemeriksaan'][] = $pemeriksaanHariData['jumlah'];
    
    // Pengeluaran per hari (menggunakan data yang sama dengan pembayaran.php - SUM dari tabel pengeluaran dalam juta)
    $queryPengeluaranHari = "SELECT SUM(jumlah) as jumlah FROM pengeluaran WHERE tanggal = '$tanggal'";
    $resultPengeluaranHari = mysqli_query($koneksi, $queryPengeluaranHari);
    $pengeluaranHariData = mysqli_fetch_assoc($resultPengeluaranHari);
    $dataTren7Hari['pengeluaran'][] = $pengeluaranHariData['jumlah'] ? round($pengeluaranHariData['jumlah'] / 1000000, 1) : 0;
    
    // Keuntungan per hari (menggunakan data yang sama dengan keuntungan.php - SUM dari tabel keuntungan dalam juta)
    $queryKeuntunganHari = "SELECT SUM(keuntungan_bersih) as jumlah FROM keuntungan WHERE DATE(tanggal) = '$tanggal'";
    $resultKeuntunganHari = mysqli_query($koneksi, $queryKeuntunganHari);
    $keuntunganHariData = mysqli_fetch_assoc($resultKeuntunganHari);
    $dataTren7Hari['keuntungan'][] = $keuntunganHariData['jumlah'] ? round($keuntunganHariData['jumlah'] / 1000000, 1) : 0;
}

// ==== INSIGHT & NOTIFIKASI ====
// Obat dengan stok paling kritis
$queryObatKritisDetail = "SELECT nama_obat, stok FROM tb_obat WHERE stok <= stok_minimum AND status_obat = 'aktif' ORDER BY stok ASC LIMIT 1";
$resultObatKritisDetail = mysqli_query($koneksi, $queryObatKritisDetail);
$obatKritisDetail = mysqli_fetch_assoc($resultObatKritisDetail);

// Dokter yang tidak hadir hari ini (assumsi: dokter yang tidak ada pemeriksaan hari ini)
$queryDokterTidakHadir = "SELECT nama_dokter FROM tb_dokter WHERE status_dokter = 'aktif' AND id_dokter NOT IN (SELECT DISTINCT id_dokter FROM tb_pemeriksaan WHERE tanggal_pemeriksaan = '$currentDate') LIMIT 1";
$resultDokterTidakHadir = mysqli_query($koneksi, $queryDokterTidakHadir);
$dokterTidakHadir = mysqli_fetch_assoc($resultDokterTidakHadir);

// Pemeriksaan harian 3 hari terakhir untuk deteksi penurunan
$pemeriksaan3Hari = [];
for ($i = 2; $i >= 0; $i--) {
    $tanggalCek = date('Y-m-d', strtotime("-$i days"));
    $queryPemeriksaanCek = "SELECT COUNT(*) as jumlah FROM tb_pemeriksaan WHERE tanggal_pemeriksaan = '$tanggalCek' AND status_pemeriksaan = 'selesai'";
    $resultPemeriksaanCek = mysqli_query($koneksi, $queryPemeriksaanCek);
    $pemeriksaanCekData = mysqli_fetch_assoc($resultPemeriksaanCek);
    $pemeriksaan3Hari[] = $pemeriksaanCekData['jumlah'];
}

// ==== DATA UNTUK TINDAKAN CEPAT ====
// Diagnosa tertinggi
$queryDiagnosaTertinggi = "SELECT diagnosa, COUNT(*) as jumlah FROM tb_pemeriksaan WHERE status_pemeriksaan = 'selesai' GROUP BY diagnosa ORDER BY jumlah DESC LIMIT 1";
$resultDiagnosaTertinggi = mysqli_query($koneksi, $queryDiagnosaTertinggi);
$diagnosaTertinggi = mysqli_fetch_assoc($resultDiagnosaTertinggi);

// Total jumlah obat
$queryTotalObat = "SELECT COUNT(*) as total_obat FROM tb_obat WHERE status_obat = 'aktif'";
$resultTotalObat = mysqli_query($koneksi, $queryTotalObat);
$totalObatData = mysqli_fetch_assoc($resultTotalObat);
$totalObat = $totalObatData['total_obat'];

// ==== DATA UNTUK KALENDER MINI ====
// Pemeriksaan yang dijadwalkan hari ini
$queryJadwalHariIni = "SELECT COUNT(*) as jumlah_jadwal FROM tb_pendaftaran WHERE tanggal_pendaftaran = '$currentDate' AND status_pendaftaran IN ('menunggu', 'dipanggil')";
$resultJadwalHariIni = mysqli_query($koneksi, $queryJadwalHariIni);
$jadwalHariIniData = mysqli_fetch_assoc($resultJadwalHariIni);
$jadwalHariIni = $jadwalHariIniData['jumlah_jadwal'];

// Total dokter aktif hari ini
$queryDokterAktifHariIni = "SELECT COUNT(DISTINCT d.id_dokter) as dokter_aktif 
                            FROM tb_dokter d 
                            JOIN tb_pemeriksaan p ON d.id_dokter = p.id_dokter 
                            WHERE d.status_dokter = 'aktif' AND p.tanggal_pemeriksaan = '$currentDate'";
$resultDokterAktifHariIni = mysqli_query($koneksi, $queryDokterAktifHariIni);
$dokterAktifHariIniData = mysqli_fetch_assoc($resultDokterAktifHariIni);
$dokterAktifHariIni = $dokterAktifHariIniData['dokter_aktif'] ? $dokterAktifHariIniData['dokter_aktif'] : 0;

// ==== DATA UNTUK TINDAKAN CEPAT ====

// ==== AI INSIGHTS GENERATION ====
// Include AI configuration and classes
require_once 'ai-insights/config/gemini_config.php';
require_once 'ai-insights/classes/GeminiInsightGenerator.php';

// Prepare comprehensive clinic data for AI analysis
$clinicMetrics = [
    'keuntungan_tahun' => $keuntunganTahunIni,
    'pengeluaran_tahun' => $pengeluaranTahunIni,
    'total_pasien' => $totalPasien,
    'pasien_baru_bulan' => $pasienBaruBulanIni,
    'pasien_hari_ini' => $pasienHariIni,
    'obat_kritis' => $jumlahObatKritis,
    'total_obat' => $totalObat,
    'dokter_aktif' => $dokterAktif,
    'staff_aktif' => $staffAktif,
    'pemeriksaan_selesai' => $pemeriksaanSelesai,
    'jadwal_hari_ini' => $jadwalHariIni,
    'dokter_aktif_hari_ini' => $dokterAktifHariIni,
    'tren_7_hari' => $dataTren7Hari,
    'diagnosa_tertinggi' => $diagnosaTertinggi,
    'obat_kritis_detail' => $obatKritisDetail,
    'dokter_tidak_hadir' => $dokterTidakHadir,
    'pemeriksaan_3_hari' => $pemeriksaan3Hari
];

// Generate AI Insights with fallback to static content
$aiInsights = [];
if (isAIEnabled()) {
    try {
        $gemini = new GeminiInsightGenerator();
        $aiInsights = $gemini->generateAllInsights($clinicMetrics);
    } catch (Exception $e) {
        // Log error but continue with static insights
        error_log('AI Insights Error: ' . $e->getMessage());
        $aiInsights = null;
    }
}

// Prepare insight contents (AI or fallback static)
$insightStokKritis = $aiInsights['inventory'] ?? 
    ('<strong>' . ($obatKritisDetail['nama_obat'] ?? 'Paracetamol') . '</strong> hanya tersisa <strong>' . ($obatKritisDetail['stok'] ?? '5') . ' unit</strong>. Segera lakukan pemesanan ulang sebelum stok habis.');

$insightOperasional = $aiInsights['operational'] ?? 
    'Antrian tertinggi biasanya pada <strong>Senin 08:00-10:00</strong>. Pertimbangkan menambah 1 dokter pada jam tersebut.';

$insightTren = $aiInsights['predictive'] ?? 
    (count($pemeriksaan3Hari) >= 3 && $pemeriksaan3Hari[2] < $pemeriksaan3Hari[1] && $pemeriksaan3Hari[1] < $pemeriksaan3Hari[0] ? 
        'Tren pemeriksaan menurun <strong>3 hari berturut-turut</strong>. Evaluasi strategi pemasaran diperlukan.' : 
        'Tren pemeriksaan stabil. Diagnosis tertinggi: <strong>' . ($diagnosaTertinggi['diagnosa'] ?? 'Flu') . '</strong> (' . ($diagnosaTertinggi['jumlah'] ?? '25') . ' kasus).');

$insightTimMedis = $aiInsights['patient_flow'] ?? 
    ($dokterTidakHadir ? 
        '<strong>' . $dokterTidakHadir['nama_dokter'] . '</strong> tidak hadir hari ini. Pastikan coverage pemeriksaan tetap optimal.' : 
        'Semua <strong>' . $dokterAktif . ' dokter aktif</strong> bertugas hari ini. Tim medis lengkap dan siap melayani.');

// AI status indicator for UI
$aiPoweredBadge = ($aiInsights ? '<span style="font-size:9px;background:linear-gradient(45deg,#5459AC,#6fc3d0);color:white;padding:1px 4px;border-radius:8px;margin-left:5px;font-weight:600;">AI</span>' : '');

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
    <title>Apothecary | Dashboard</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="assets/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
/* Perbaikan Layout dan Spacing */
.container-fluid {
  padding-left: 25px !important;
  padding-right: 25px !important;
}

.card {
  margin-bottom: 15px !important;
  border: none !important;
  box-shadow: 0 2px 15px rgba(0,0,0,0.08) !important;
}

.card-body {
  padding: 25px !important;
}

.card-header {
  padding: 20px 25px !important;
  border-bottom: none !important;
}

/* Row spacing */
.row {
  margin-bottom: 8px;
}

.row [class*="col-"] {
  padding-left: 12px !important;
  padding-right: 12px !important;
}

/* Chart containers */
.chart-container {
  padding: 20px;
  background: #fff;
  border-radius: 15px;
  box-shadow: 0 2px 15px rgba(0,0,0,0.08);
}

canvas {
  max-height: 400px !important;
}

/* Section spacing */
.mt-4 {
  margin-top: 2rem !important;
}

.mb-4 {
  margin-bottom: 2rem !important;
}

/* Header title consistency with keuntungan.php */
h4.mb-4.font-weight-bold.text-secondary {
  font-size: 1.5rem !important;
  font-weight: 700 !important;
  color: #6c757d !important;
  margin-bottom: 1rem !important;
  font-family: inherit !important;
}

/* Responsive spacing */
@media (max-width: 768px) {
  .container-fluid {
    padding-left: 15px !important;
    padding-right: 15px !important;
  }
  
  main {
    padding: 15px !important;
  }
  
  .card-body {
    padding: 20px !important;
  }
  
  .card-header {
    padding: 15px 20px !important;
  }
}

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
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(8,131,149,0.12); /* gunakan warna #088395 */
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
                            <!-- <a class="nav-link" href="chatbot-ai/chatbot.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Chatbot AI
                            </a> -->
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
            <main style="padding: 15px;">
                <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 15px;">
                    
                    <!-- Header Dashboard dengan alignment yang sejajar -->
                    <div class="row" style="margin-left: 0; margin-right: 0; margin-bottom: 0.5rem;">
                        <div class="col-lg-9" style="padding-left: 12px; padding-right: 12px;">
                            <h4 class="mb-1 font-weight-bold text-secondary">Dashboard</h4>
                        </div>
                        <div class="col-lg-3" style="padding-left: 12px; padding-right: 12px;">
                            <!-- Space for alignment with right column -->
                        </div>
                    </div>
                    
                     <!-- 4 KOLOM -->
                    <div class="row" style="margin-left: 0; margin-right: 0; margin-top: 0.2rem;">
                        <!-- Left side: 3 summary boxes aligned with Dashboard Keuangan Klinik -->
                        <div class="col-lg-9">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="dash count summary-box">
                                        <div class="summary-title">Keuntungan Tahun Ini</div>
                                        <div class="summary-value">
                                            Rp<span class="counter" data-count="<?php echo round($keuntunganTahunIni / 1000000, 1); ?>"><?php echo round($keuntunganTahunIni / 1000000, 1); ?></span>M
                                            <span class="summary-icon"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <div class="summary-change custom-bg-success">Tahun <?php echo $currentYear; ?></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="dash count summary-box">
                                        <div class="summary-title">Pengeluaran Tahun ini</div>
                                        <div class="summary-value">
                                            Rp<span class="counter" data-count="<?php echo round($pengeluaranTahunIni / 1000000, 1); ?>"><?php echo round($pengeluaranTahunIni / 1000000, 1); ?></span>M
                                            <span class="summary-icon"><i class="fas fa-prescription-bottle-alt"></i></span>
                                        </div>
                                        <div class="summary-change custom-bg-success">Tahun <?php echo $currentYear; ?></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="dash count summary-box">
                                        <div class="summary-title">Stok Obat Kritis</div>
                                        <div class="summary-value">
                                            <span class="counter" data-count="<?php echo $jumlahObatKritis; ?>"><?php echo $jumlahObatKritis; ?></span>
                                            <span class="summary-icon"><i class="fas fa-box-open"></i></span>
                                        </div>
                                        <div class="summary-change custom-bg-danger">Perlu restok segera</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right side: 1 summary box aligned with Catatan Keuangan -->
                        <div class="col-lg-3">
                            <div class="dash count summary-box">
                                <div class="summary-title">Total Pasien</div>
                                <div class="summary-value">
                                    <span class="counter" data-count="<?php echo $totalPasien; ?>"><?php echo $totalPasien; ?></span>
                                    <span class="summary-icon"><i class="fas fa-users"></i></span>
                                </div>
                                <div class="summary-change custom-bg-success">+<?php echo $pasienBaruBulanIni; ?> bulan ini</div>
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
                                    if (countTo.indexOf('.') > -1) {
                                        $this.text(parseFloat(this.countNum).toFixed(1));
                                    } else {
                                        $this.text(Math.floor(this.countNum));
                                    }
                                },
                                complete: function () {
                                    if (countTo.indexOf('.') > -1) {
                                        $this.text(parseFloat(this.countNum).toFixed(1));
                                    } else {
                                        $this.text(this.countNum);
                                    }
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
<div class="row mt-2 align-items-stretch" style="margin-left: 0; margin-right: 0;"> <!-- TAMBAHKAN align-items-stretch -->
  <!-- Kiri: Dashboard Keuangan Klinik (judul, filter, chart dalam satu container) -->
  <div class="col-lg-9 mb-3 d-flex"> <!-- TAMBAHKAN d-flex -->
    <div class="card shadow-sm border-0 flex-fill" style="border-radius:15px; background:#fff;">
      <div class="card-body">
        <!-- Judul dengan background gradasi hijau -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 p-3 rounded"
             style="background: linear-gradient(90deg, rgb(61, 191, 211) 0%, #5459AC 100%);">
          <h2 class="mb-0" style="font-size:22px;color:#fff;font-weight:700;">Dashboard Keuangan Klinik</h2>
          <div>
            <span style="color:#fff;">Tahun: <?php echo $currentYear; ?></span>
          </div>
        </div>
        <div style="min-width:250px; min-height:400px;">
          <canvas id="areaChart"></canvas>
        </div>
      </div>
    </div>
  </div>
  <!-- Kanan: Notes (tanpa container background) -->
  <div class="col-lg-3 mb-3 d-flex flex-column" style="height: 100%;"> <!-- Perbaiki height -->
    <!-- Note Card: Detail Bulanan (langsung tanpa container) -->
    <div id="noteCard" class="note-detail-card mb-2 flex-fill" style="height: calc(50% - 6px);"></div>
    <!-- Summary Card: Ringkasan Tahunan (langsung tanpa container) -->
    <div id="summaryCard" class="summary-detail-card flex-fill" style="height: calc(50% - 6px);"></div>
  </div>
</div>

<style>
  .note-shadow {
    border-radius: 14px !important;
    box-shadow: 0 2px 16px rgba(61,191,211,0.10) !important;
    background: linear-gradient(135deg, #fff 60%, #e6f7fa 100%) !important;
    border: none !important;
  }
  
  /* Styling untuk Note Card dan Summary Card */
  .note-detail-card, .summary-detail-card {
    background: linear-gradient(135deg, #f8fcff 0%, #ffffff 100%);
    border: 1px solid rgba(61,191,211,0.15);
    border-radius: 12px;
    padding: 12px; /* Kurangi padding lebih banyak untuk menghemat ruang */
    box-shadow: 0 3px 10px rgba(61,191,211,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: visible; /* Ubah dari hidden ke visible untuk menghindari terpotong */
    margin-top: 0; /* Hilangkan margin top untuk alignment yang sempurna */
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Distribusi ruang secara merata */
    word-wrap: break-word; /* Pastikan text wrap dengan baik */
    word-break: break-word; /* Pastikan word break jika diperlukan */
  }
  
  .note-detail-card:hover, .summary-detail-card:hover {
    box-shadow: 0 5px 20px rgba(61,191,211,0.15);
    transform: translateY(-2px);
    border-color: rgba(61,191,211,0.25);
  }
  
  .note-detail-card::before, .summary-detail-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #3dbfd3 0%, #5459AC 100%);
    border-radius: 12px 12px 0 0;
  }
  
  /* Data item styling */
  .data-item {
    display: flex;
    align-items: center;
    gap: 5px; /* Kurangi gap lebih banyak untuk menghemat ruang */
    margin-bottom: 8px; /* Kurangi margin untuk menghemat ruang */
    padding: 5px 0; /* Kurangi padding untuk menghemat ruang */
    border-bottom: 1px solid rgba(61,191,211,0.08);
    transition: all 0.2s ease;
    width: 100%; /* Pastikan lebar penuh */
    box-sizing: border-box; /* Include padding dalam perhitungan lebar */
  }
  
  .data-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
  }
  
  .data-item:hover {
    background: rgba(61,191,211,0.05);
    border-radius: 8px;
    padding: 4px 6px; /* Sesuaikan dengan padding yang baru */
    margin: 0 -6px 6px -6px; /* Sesuaikan dengan margin yang baru */
  }
  
  .data-item:last-child:hover {
    margin-bottom: -6px; /* Sesuaikan dengan margin yang baru */
  }
  
  .data-icon {
    color: #fff;
    background: linear-gradient(135deg, #3dbfd3 0%, #5459AC 100%);
    border-radius: 6px; /* Kurangi border radius */
    padding: 5px 6px; /* Kurangi padding icon */
    font-size: 10px; /* Kurangi font size icon */
    min-width: 24px; /* Kurangi min-width icon */
    text-align: center;
    box-shadow: 0 2px 5px rgba(61,191,211,0.15);
  }
  
  .data-text {
    color: #2c3e50;
    font-size: 11px; /* Kurangi lebih banyak font size untuk mencegah overflow */
    font-weight: 500;
    flex: 1;
    white-space: nowrap; /* Pastikan text tidak wrap untuk mencegah terpotong */
    overflow: hidden; /* Hide overflow jika terlalu panjang */
    text-overflow: ellipsis; /* Tambahkan ellipsis jika terpotong */
  }
  
  .data-value {
    font-weight: 700;
    color: #5459AC;
  }
  
  .data-subtitle {
    color: #7f8c8d;
    font-size: 9px; /* Kurangi font size lebih banyak untuk menghemat ruang */
    margin-top: 6px; /* Kurangi margin untuk menghemat ruang */
    text-align: center;
    font-style: italic;
  }
  
  /* Source info styling */
  .source-info {
    background: rgba(84,89,172,0.05);
    border: 1px solid rgba(84,89,172,0.1);
    border-radius: 5px; /* Kurangi border radius lebih banyak */
    padding: 4px 6px; /* Kurangi padding lebih banyak untuk menghemat ruang */
    margin-top: 6px; /* Kurangi margin untuk menghemat ruang */
    font-size: 8px; /* Kurangi font size lebih banyak untuk menghemat ruang */
    color: #5459AC;
    text-align: center;
    font-weight: 500;
  }
  
  .source-info i {
    color: #3dbfd3;
    margin-right: 5px;
  }
  
  /* Title untuk setiap section */
  .section-title {
    color: #5459AC;
    font-size: 11px; /* Kurangi lebih banyak untuk hemat ruang */
    font-weight: 700;
    margin-bottom: 6px; /* Kurangi margin lebih banyak untuk menghemat ruang */
    text-align: center;
    padding-bottom: 3px; /* Kurangi padding untuk menghemat ruang */
    border-bottom: 2px solid rgba(61,191,211,0.15);
  }
</style>

<script>
const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

const dataKeuntungan = {
    <?php echo $tahunDataKeuntungan; ?>: [<?php echo implode(',', $dataKeuntunganChart); ?>]
};

const dataPengeluaran = {
    <?php echo $tahunDataPengeluaran; ?>: [<?php echo implode(',', $dataPengeluaranChart); ?>]
};

const tahunDataKeuntungan = <?php echo $tahunDataKeuntungan; ?>;
const tahunDataPengeluaran = <?php echo $tahunDataPengeluaran; ?>;

let tahunAktif = '<?php echo $currentYear; ?>';
let chartInstance = null;

function generateNote(tahun, bulanIndex) {
    const month = labels[bulanIndex];
    const keuntungan = dataKeuntungan[tahunDataKeuntungan][bulanIndex].toFixed(1);
    const pengeluaran = dataPengeluaran[tahunDataPengeluaran][bulanIndex].toFixed(1);
    const labaBersih = (keuntungan - pengeluaran).toFixed(1);
    
    return `
      <div class="section-title">Detail Bulan ${month}</div>
      <div class="data-item">
        <span class="data-icon"><i class="fas fa-coins"></i></span>
        <span class="data-text">Keuntungan: <span class="data-value">Rp ${keuntungan} Juta</span></span>
      </div>
      <div class="data-item">
        <span class="data-icon"><i class="fas fa-money-bill-wave"></i></span>
        <span class="data-text">Pengeluaran: <span class="data-value">Rp ${pengeluaran} Juta</span></span>
      </div>
      <div class="data-item">
        <span class="data-icon"><i class="fas fa-chart-line"></i></span>
        <span class="data-text">Laba Bersih: <span class="data-value">Rp ${labaBersih} Juta</span></span>
      </div>
      <div class="data-subtitle">${month} ${tahun}</div>
      <div class="source-info">
        <i class="fas fa-info-circle"></i>
        Data: Keuntungan ${tahunDataKeuntungan} | Pengeluaran ${tahunDataPengeluaran}
      </div>
    `;
}

function generateSummary(tahun) {
    const keuntungan = dataKeuntungan[tahunDataKeuntungan].reduce((a,b)=>a+b,0);
    const pengeluaran = dataPengeluaran[tahunDataPengeluaran].reduce((a,b)=>a+b,0);
    const rataKeuntungan = (keuntungan / 12).toFixed(1);
    const rataPengeluaran = (pengeluaran / 12).toFixed(1);
    const totalLabaBersih = (keuntungan - pengeluaran).toFixed(1);
    const rataLabaBersih = (rataKeuntungan - rataPengeluaran).toFixed(1);
    
    return `
      <div class="section-title">Ringkasan Tahunan</div>
      <div class="data-item">
        <span class="data-icon"><i class="fas fa-calculator"></i></span>
        <span class="data-text">Total Keuntungan: <span class="data-value">Rp ${keuntungan.toFixed(1)} Juta</span></span>
      </div>
      <div class="data-item">
        <span class="data-icon"><i class="fas fa-receipt"></i></span>
        <span class="data-text">Total Pengeluaran: <span class="data-value">Rp ${pengeluaran.toFixed(1)} Juta</span></span>
      </div>
      <div class="data-item">
        <span class="data-icon"><i class="fas fa-trophy"></i></span>
        <span class="data-text">Total Laba Bersih: <span class="data-value">Rp ${totalLabaBersih} Juta</span></span>
      </div>
      <div class="data-item">
        <span class="data-icon"><i class="fas fa-chart-bar"></i></span>
        <span class="data-text">Rata-rata/bulan: <span class="data-value">Rp ${rataLabaBersih} Juta</span></span>
      </div>
      <div class="source-info">
        <i class="fas fa-database"></i>
        Sumber: Keuntungan tahun ${tahunDataKeuntungan} | Pengeluaran tahun ${tahunDataPengeluaran}
      </div>
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
                    label: 'Keuntungan (Tahun ' + tahunDataKeuntungan + ')',
                    data: dataKeuntungan[tahunDataKeuntungan],
                    fill: true,
                    backgroundColor: gradientKeuntungan,
                    borderColor: 'rgb(61,191,211)',
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 10
                },
                {
                    label: 'Pengeluaran (Tahun ' + tahunDataPengeluaran + ')',
                    data: dataPengeluaran[tahunDataPengeluaran],
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
                legend: { 
                    labels: { 
                        color: '#222',
                        usePointStyle: true,
                        padding: 15
                    } 
                },
                tooltip: {
                    callbacks: {
                        label: context => `${context.dataset.label}: Rp ${context.formattedValue} Juta`
                    },
                    backgroundColor: 'rgba(255,255,255,0.95)',
                    titleColor: '#333',
                    bodyColor: '#333',
                    borderColor: '#3dbfd3',
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#222' }
                },
                y: {
                    grid: { display: false },
                    ticks: { 
                        callback: val => 'Rp ' + val + 'jt', 
                        color: '#222' 
                    }
                }
            }
        }
    });
    
    document.getElementById('noteCard').innerHTML = generateNote(tahun, bulanAwal);
    document.getElementById('summaryCard').innerHTML = generateSummary(tahun);
}

// Initialize chart with current year data
createChart(tahunAktif, <?php echo ($currentMonth - 1); ?>);
</script>

            <!-- ROW 3: Kalender Mini dan Alert & Notifikasi Strategis -->
<div class="row mt-1 align-items-stretch" style="margin-left: 0; margin-right: 0;"> <!-- TAMBAHKAN align-items-stretch -->
  <div class="col-md-6 mb-3 d-flex"> <!-- TAMBAHKAN d-flex -->
    <div class="card shadow-sm border-0 flex-fill" style="border-radius:15px;">
      <div class="card-header px-4 py-3" style="background: linear-gradient(135deg, #3dbfd3 0%, #5459AC 100%); border-radius: 15px 15px 0 0; color:#fff; font-weight:700;">
        <i class="fas fa-calendar-alt me-2"></i> Kalender Mini - <?php echo date('d F Y'); ?>
      </div>
      <div class="card-body" style="background:#f8fcff; border-radius:0 0 15px 15px;">
        <!-- Tanggal Header -->
        <div class="text-center mb-3 p-2" style="background: rgba(61,191,211,0.1); border-radius: 10px;">
          <h6 class="mb-1" style="color: #5459AC; font-weight: 700;"><?php echo strtoupper(date('l')); ?></h6>
          <div style="color: #3dbfd3; font-size: 1.5rem; font-weight: 700;"><?php echo date('d'); ?></div>
          <small style="color: #5459AC;"><?php echo date('F Y'); ?></small>
        </div>
        
        <!-- Agenda List -->
        <ul class="mb-0" style="list-style:none;padding-left:0;">
          <li class="mb-3 p-2" style="background: rgba(255,255,255,0.7); border-radius: 8px; border-left: 4px solid #3dbfd3;">
            <div class="d-flex align-items-center">
              <span style="background: linear-gradient(135deg, #3dbfd3, #5459AC); color: white; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                <i class="fas fa-user-md" style="font-size: 14px;"></i>
              </span>
              <div>
                <div style="color:#5459AC; font-weight: 600;">08:00 - Shift Pagi</div>
                <small style="color:#6c757d;"><?php echo $dokterAktifHariIni; ?> Dokter bertugas hari ini</small>
              </div>
            </div>
          </li>
          
          <li class="mb-3 p-2" style="background: rgba(255,255,255,0.7); border-radius: 8px; border-left: 4px solid #5459AC;">
            <div class="d-flex align-items-center">
              <span style="background: linear-gradient(135deg, #5459AC, #3dbfd3); color: white; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                <i class="fas fa-calendar-check" style="font-size: 14px;"></i>
              </span>
              <div>
                <div style="color:#5459AC; font-weight: 600;">Antrian Aktif</div>
                <small style="color:#6c757d;"><?php echo $jadwalHariIni; ?> pemeriksaan menunggu</small>
              </div>
            </div>
          </li>
          
          <li class="mb-3 p-2" style="background: rgba(255,255,255,0.7); border-radius: 8px; border-left: 4px solid #00FFCA;">
            <div class="d-flex align-items-center">
              <span style="background: linear-gradient(135deg, #00FFCA, #3dbfd3); color: white; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                <i class="fas fa-pills" style="font-size: 14px;"></i>
              </span>
              <div>
                <div style="color:#5459AC; font-weight: 600;">15:00 - Cek Stok</div>
                <small style="color:#6c757d;"><?php echo $jumlahObatKritis; ?> obat perlu restok</small>
              </div>
            </div>
          </li>
          
          <li class="p-2" style="background: rgba(255,255,255,0.7); border-radius: 8px; border-left: 4px solid #FFD700;">
            <div class="d-flex align-items-center">
              <span style="background: linear-gradient(135deg, #FFD700, #5459AC); color: white; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                <i class="fas fa-chart-line" style="font-size: 14px;"></i>
              </span>
              <div>
                <div style="color:#5459AC; font-weight: 600;">17:00 - Laporan Harian</div>
                <small style="color:#6c757d;"><?php echo $pasienHariIni; ?> pasien terdaftar hari ini</small>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="col-lg-6 mb-3 d-flex"> <!-- TAMBAHKAN d-flex -->
    <div class="card shadow-sm border-0 flex-fill" style="border-radius:15px;">
      <div class="card-header px-4 py-3" style="background: linear-gradient(135deg, #088395 0%, #5459AC 100%); border-radius: 15px 15px 0 0;">
        <h5 class="mb-0" style="color:#fff;font-weight:700;">
          <i class="fas fa-bell" style="margin-right:8px;"></i> Insight & Notifikasi Strategis
        </h5>
      </div>
      <div class="card-body px-4 py-3" style="background:#f8fcff;">
        <ul class="mb-0" style="list-style:none;padding-left:0;">
          <!-- Alert Stok Obat Kritis -->
          <li class="mb-3 p-3" style="background: rgba(220, 53, 69, 0.1); border-radius: 10px; border-left: 4px solid #dc3545;">
            <div class="d-flex align-items-start">
              <span style="background: linear-gradient(135deg,#dc3545 0%,#5459AC 100%); color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                <i class="fas fa-exclamation-triangle" style="font-size: 16px;"></i>
              </span>
              <div>
                <div style="color:#dc3545; font-weight: 700; margin-bottom: 5px;">🚨 URGENT - Stok Kritis!<?php echo $aiPoweredBadge; ?></div>
                <span style="color:#5459AC; font-size: 14px;">
                  <?php echo $insightStokKritis; ?>
                </span>
              </div>
            </div>
          </li>
          
          <!-- Insight Operasional -->
          <li class="mb-3 p-3" style="background: rgba(255, 193, 7, 0.1); border-radius: 10px; border-left: 4px solid #ffc107;">
            <div class="d-flex align-items-start">
              <span style="background: linear-gradient(135deg,#ffc107 0%,#5459AC 100%); color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                <i class="fas fa-clock" style="font-size: 16px;"></i>
              </span>
              <div>
                <div style="color:#ffc107; font-weight: 700; margin-bottom: 5px;">⏰ Optimasi Jadwal<?php echo $aiPoweredBadge; ?></div>
                <span style="color:#5459AC; font-size: 14px;">
                  <?php echo $insightOperasional; ?>
                </span>
              </div>
            </div>
          </li>
          
          <!-- Insight Tren -->
          <li class="mb-3 p-3" style="background: rgba(61, 191, 211, 0.1); border-radius: 10px; border-left: 4px solid #3dbfd3;">
            <div class="d-flex align-items-start">
              <span style="background: linear-gradient(135deg,#3dbfd3 0%,#5459AC 100%); color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                <i class="fas fa-chart-line" style="font-size: 16px;"></i>
              </span>
              <div>
                <div style="color:#3dbfd3; font-weight: 700; margin-bottom: 5px;">📈 Analisis Tren<?php echo $aiPoweredBadge; ?></div>
                <span style="color:#5459AC; font-size: 14px;">
                  <?php echo $insightTren; ?>
                </span>
              </div>
            </div>
          </li>
          
          <!-- Status Dokter -->
          <li class="p-3" style="background: rgba(40, 167, 69, 0.1); border-radius: 10px; border-left: 4px solid #28a745;">
            <div class="d-flex align-items-start">
              <span style="background: linear-gradient(135deg,#28a745 0%,#5459AC 100%); color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                <i class="fas fa-user-check" style="font-size: 16px;"></i>
              </span>
              <div>
                <div style="color:#28a745; font-weight: 700; margin-bottom: 5px;">👨‍⚕️ Status Tim Medis<?php echo $aiPoweredBadge; ?></div>
                <span style="color:#5459AC; font-size: 14px;">
                  <?php echo $insightTimMedis; ?>
                </span>
              </div>
            </div>
          </li>
        </ul>
        
        <!-- AI Refresh Button (hanya muncul jika AI aktif) -->
        <?php if ($aiInsights): ?>
        <div class="text-center mt-3" style="border-top: 1px solid rgba(84,89,172,0.1); padding-top: 15px;">
          <button class="btn btn-outline-primary btn-sm" onclick="refreshAIInsights()" style="font-size: 12px; padding: 4px 12px; border-radius: 15px;">
            <i class="fas fa-sync-alt" style="font-size: 11px;"></i> Refresh AI Insights
          </button>
        </div>
        <?php endif; ?>
        
      </div>
    </div>
  </div>
</div>

<!-- ROW 4: Aktivitas Hari Ini (PUTIH, ICON SATU WARNA, SEPERTI SUMMARY) -->
<div class="row mt-1 row-aktivitas-hari-ini" style="margin-left: 0; margin-right: 0;">
  <div class="col-md-3">
    <div class="card shadow-sm border-0 text-center" style="border-radius:15px; background:#fff; color:#222;">
      <div class="card-body py-4">
        <div class="mb-2" style="font-size:2rem; color:#088395;"><i class="fas fa-user-injured"></i></div>
        <h6 class="mb-1" style="font-weight:600;">Pasien Hari Ini</h6>
        <h4 class="mb-0" style="font-weight:700;"><?php echo $pasienHariIni; ?></h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm border-0 text-center" style="border-radius:15px; background:#fff; color:#222;">
      <div class="card-body py-4">
        <div class="mb-2" style="font-size:2rem; color:#088395;"><i class="fas fa-stethoscope"></i></div>
        <h6 class="mb-1" style="font-weight:600;">Pemeriksaan Selesai</h6>
        <h4 class="mb-0" style="font-weight:700;"><?php echo $pemeriksaanSelesai; ?></h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm border-0 text-center" style="border-radius:15px; background:#fff; color:#222;">
      <div class="card-body py-4">
        <div class="mb-2" style="font-size:2rem; color:#088395;"><i class="fas fa-user-md"></i></div>
        <h6 class="mb-1" style="font-weight:600;">Dokter Aktif</h6>
        <h4 class="mb-0" style="font-weight:700;"><?php echo $dokterAktif; ?></h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm border-0 text-center" style="border-radius:15px; background:#fff; color:#222;">
      <div class="card-body py-4">
        <div class="mb-2" style="font-size:2rem; color:#088395;"><i class="fas fa-user-check"></i></div>
        <h6 class="mb-1" style="font-weight:600;">Staff Aktif</h6>
        <h4 class="mb-0" style="font-weight:700;"><?php echo $staffAktif; ?> Staff</h4>
      </div>
    </div>
  </div>
</div>

<!-- ROW 5: Grafik Tren 7 Hari & Tindakan Cepat -->
<div class="row mt-1 align-items-stretch" style="margin-left: 0; margin-right: 0;">
  <!-- Grafik Tren 7 Hari (perkecil lebar, misal col-lg-8) -->
  <div class="col-lg-8 mb-3 d-flex">
    <div class="card shadow-sm border-0 flex-fill" style="border-radius:15px;">
      <!-- Judul dengan gradasi -->
      <div class="card-header px-4 py-3" style="background: linear-gradient(90deg, rgb(61,191,211) 0%, #5459AC 60%, #088395 100%); border-radius: 15px 15px 0 0;">
        <h5 class="mb-0" style="color:#fff;font-weight:700;">
          <i class="fas fa-chart-area" style="margin-right:8px;"></i> Tren 7 Hari Terakhir: Pasien, Pemeriksaan, Pengeluaran & Keuntungan
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
        <a href="data-pemeriksaan/pemeriksaan.php" class="btn btn-outline-primary flex-fill mb-2" style="min-width:180px;"><i class="fas fa-plus me-1"></i> Diagnosa: <?php echo $diagnosaTertinggi['diagnosa'] ?? 'ISPA'; ?> (<?php echo $diagnosaTertinggi['jumlah'] ?? '15'; ?>x)</a>
        <a href="data-master/data-pasien/pasien.php" class="btn btn-outline-secondary flex-fill mb-2" style="min-width:180px;"><i class="fas fa-file-alt me-1"></i> Lihat Data <?php echo $totalPasien; ?> Pasien</a>
        <a href="data-master/data-obat/obat.php" class="btn btn-outline-danger flex-fill mb-2" style="min-width:180px;"><i class="fas fa-box-open me-1"></i> Total <?php echo $totalObat; ?> Jenis Obat</a>
        <a href="keuntungan/keuntungan.php" class="btn btn-outline-success flex-fill" style="min-width:180px;"><i class="fas fa-chart-line me-1"></i> Laporan Keuntungan</a>
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

// Gradien area untuk Keuntungan (emas #FFD700)
const gradientKeuntungan = ctxTren.createLinearGradient(0, 0, 0, 300);
gradientKeuntungan.addColorStop(0, 'rgba(255,215,0,0.30)');
gradientKeuntungan.addColorStop(1, 'rgba(255,255,255,0.7)');

const chartTren7Hari = new Chart(ctxTren, {
  type: 'line',
  data: {
    labels: [<?php echo "'" . implode("', '", $hari7Terakhir) . "'"; ?>],
    datasets: [
      {
        label: 'Pasien',
        data: [<?php echo implode(',', $dataTren7Hari['pasien']); ?>],
        borderColor: 'rgb(61,191,211)',
        backgroundColor: gradientPasien,
        fill: true,
        tension: 0.4,
        pointRadius: 5,
        pointHoverRadius: 10
      },
      {
        label: 'Pemeriksaan',
        data: [<?php echo implode(',', $dataTren7Hari['pemeriksaan']); ?>],
        borderColor: '#5459AC',
        backgroundColor: gradientPemeriksaan,
        fill: true,
        tension: 0.4,
        pointRadius: 5,
        pointHoverRadius: 10
      },
      {
        label: 'Pengeluaran (juta)',
        data: [<?php echo implode(',', $dataTren7Hari['pengeluaran']); ?>],
        borderColor: '#00FFCA',
        backgroundColor: gradientPengeluaran,
        fill: true,
        tension: 0.4,
        pointRadius: 5,
        pointHoverRadius: 10
      },
      {
        label: 'Keuntungan (juta)',
        data: [<?php echo implode(',', $dataTren7Hari['keuntungan']); ?>],
        borderColor: '#FFD700',
        backgroundColor: gradientKeuntungan,
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
            <footer class="py-4 bg-light mt-auto" style="margin-top: 40px !important;">
                <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 40px;">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Apothecary 2025 | Sistem Manajemen Klinik
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-heart text-danger"></i> Dibuat dengan penuh dedikasi
                        </div>
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
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/demo/datatables-demo.js"></script>
    
    <!-- AI Insights JavaScript -->
    <script>
    // AI Insights Management Functions
    function refreshAIInsights() {
        // Show loading state
        const refreshBtn = document.querySelector('button[onclick="refreshAIInsights()"]');
        if (refreshBtn) {
            refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="font-size: 11px;"></i> Loading...';
            refreshBtn.disabled = true;
        }
        
        // Simple page reload for fresh AI insights
        // In production, you could implement AJAX for smoother UX
        setTimeout(() => {
            location.reload();
        }, 500);
    }
    
    // Auto-refresh AI insights every 30 minutes (if enabled)
    const autoRefreshAI = false; // Set to true to enable auto-refresh
    if (autoRefreshAI && <?php echo ($aiInsights ? 'true' : 'false'); ?>) {
        setInterval(() => {
            // Silent refresh in background
            fetch(window.location.href)
                .then(() => console.log('AI insights refreshed in background'))
                .catch(err => console.log('AI refresh failed:', err));
        }, 30 * 60 * 1000); // 30 minutes
    }
    </script>

</body>
</html>