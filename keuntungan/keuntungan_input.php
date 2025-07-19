<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../login/index.php'</script>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tahun = intval($_POST['tahun']);
    $bulan = intval($_POST['bulan']);
    $total_keuntungan = intval(str_replace([',', '.'], '', $_POST['total_keuntungan']));
    $pertumbuhan_vs_bulan_lalu = floatval($_POST['pertumbuhan_vs_bulan_lalu']);
    $insight_otomatis = mysqli_real_escape_string($koneksi, $_POST['insight_otomatis']);
    $target_tahunan = intval(str_replace([',', '.'], '', $_POST['target_tahunan']));
    $rekomendasi_strategis = mysqli_real_escape_string($koneksi, $_POST['rekomendasi_strategis']);
    $bulan_terbaik = mysqli_real_escape_string($koneksi, $_POST['bulan_terbaik']);
    $bulan_terburuk = mysqli_real_escape_string($koneksi, $_POST['bulan_terburuk']);
    $layanan_andalan = mysqli_real_escape_string($koneksi, $_POST['layanan_andalan']);

    // Insert into keuntungan_bulanan_analytics
    $sql1 = "INSERT INTO keuntungan_bulanan_analytics (tahun, bulan, total_keuntungan, pertumbuhan_vs_bulan_lalu, insight_otomatis, nama_bulan) VALUES ($tahun, $bulan, $total_keuntungan, $pertumbuhan_vs_bulan_lalu, '$insight_otomatis', '".date('F', mktime(0,0,0,$bulan,1))."')";
    mysqli_query($koneksi, $sql1);

    // Insert into keuntungan_target_kpi
    $sql2 = "INSERT INTO keuntungan_target_kpi (tahun, target_tahunan, rekomendasi_strategis, bulan_terbaik, bulan_terburuk, layanan_andalan) VALUES ($tahun, $target_tahunan, '$rekomendasi_strategis', '$bulan_terbaik', '$bulan_terburuk', '$layanan_andalan')";
    mysqli_query($koneksi, $sql2);

    echo "<script>alert('Data keuntungan berhasil diinput!');location='keuntungan.php'</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Input Data Keuntungan</title>
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <style>
        body { font-family: 'Poppins', Arial, sans-serif; background: #f8fafc; }
        .input-card { background: #fff; border-radius: 18px; box-shadow: 0 4px 24px rgba(8,131,149,0.08); padding: 32px 28px; max-width: 600px; margin: 40px auto; }
        .input-card h4 { color: #5459AC; font-weight: 800; margin-bottom: 24px; }
        .form-group label { font-weight: 600; color: #088395; }
        .form-control { border-radius: 8px; }
        .btn-primary { background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%); border: none; font-weight: 700; border-radius: 8px; }
        .btn-primary:hover { background: #088395; }
    </style>
</head>
<body>
    <div class="input-card">
        <h4>Input Data Keuntungan</h4>
        <form method="post">
            <div class="form-group mb-3">
                <label for="tahun">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" value="<?= date('Y') ?>" required />
            </div>
            <div class="form-group mb-3">
                <label for="bulan">Bulan</label>
                <select class="form-control" id="bulan" name="bulan" required>
                    <?php for($i=1;$i<=12;$i++): ?>
                        <option value="<?= $i ?>" <?= $i==date('n')?'selected':'' ?>><?= date('F', mktime(0,0,0,$i,1)) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="total_keuntungan">Total Keuntungan Bulan Ini (Rp)</label>
                <input type="text" class="form-control" id="total_keuntungan" name="total_keuntungan" required />
            </div>
            <div class="form-group mb-3">
                <label for="pertumbuhan_vs_bulan_lalu">Pertumbuhan vs Bulan Lalu (%)</label>
                <input type="number" step="0.01" class="form-control" id="pertumbuhan_vs_bulan_lalu" name="pertumbuhan_vs_bulan_lalu" required />
            </div>
            <div class="form-group mb-3">
                <label for="insight_otomatis">Insight Otomatis</label>
                <textarea class="form-control" id="insight_otomatis" name="insight_otomatis" rows="2"></textarea>
            </div>
            <hr />
            <div class="form-group mb-3">
                <label for="target_tahunan">Target Keuntungan Tahunan (Rp)</label>
                <input type="text" class="form-control" id="target_tahunan" name="target_tahunan" required />
            </div>
            <div class="form-group mb-3">
                <label for="rekomendasi_strategis">Rekomendasi Strategis</label>
                <textarea class="form-control" id="rekomendasi_strategis" name="rekomendasi_strategis" rows="2"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="bulan_terbaik">Bulan Terbaik</label>
                <input type="text" class="form-control" id="bulan_terbaik" name="bulan_terbaik" />
            </div>
            <div class="form-group mb-3">
                <label for="bulan_terburuk">Bulan Terburuk</label>
                <input type="text" class="form-control" id="bulan_terburuk" name="bulan_terburuk" />
            </div>
            <div class="form-group mb-3">
                <label for="layanan_andalan">Layanan Andalan</label>
                <input type="text" class="form-control" id="layanan_andalan" name="layanan_andalan" />
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan Data Keuntungan</button>
        </form>
    </div>
</body>
</html>
