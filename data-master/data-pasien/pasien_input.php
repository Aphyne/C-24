<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../../login/index.php'</script>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pasien = mysqli_real_escape_string($koneksi, $_POST['nama_pasien']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $created_at = $_POST['created_at'] ? $_POST['created_at'] : date('Y-m-d');

    // Insert pasien
    $sql = "INSERT INTO tb_pasien (nama_pasien, tanggal_lahir, jenis_kelamin, alamat, no_hp, created_at) VALUES ('$nama_pasien', '$tanggal_lahir', '$jenis_kelamin', '$alamat', '$no_hp', '$created_at')";
    $result = mysqli_query($koneksi, $sql);

    // Optional: laporan waktu tunggu
    if (!empty($_POST['hari']) && !empty($_POST['jam_laporan']) && isset($_POST['waktu_tunggu_rata'])) {
        $hari = mysqli_real_escape_string($koneksi, $_POST['hari']);
        $jam_laporan = $_POST['jam_laporan'];
        $waktu_tunggu_rata = floatval($_POST['waktu_tunggu_rata']);
        $tanggal_laporan = $_POST['tanggal_laporan'] ? $_POST['tanggal_laporan'] : date('Y-m-d');
        $sql2 = "INSERT INTO tb_laporan_waktu_tunggu (hari, jam_laporan, waktu_tunggu_rata, tanggal_laporan) VALUES ('$hari', '$jam_laporan', $waktu_tunggu_rata, '$tanggal_laporan')";
        mysqli_query($koneksi, $sql2);
    }

    if ($result) {
        echo "<script>alert('Data pasien berhasil diinput!');location='pasien.php'</script>";
        exit();
    } else {
        echo "<script>alert('Gagal input data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Input Data Pasien</title>
    <link href="../../assets/css/styles.css" rel="stylesheet" />
    <link href="../../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
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
        <h4>Input Data Pasien</h4>
        <form method="post">
            <div class="form-group mb-3">
                <label for="nama_pasien">Nama Pasien</label>
                <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" required />
            </div>
            <div class="form-group mb-3">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required />
            </div>
            <div class="form-group mb-3">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required />
            </div>
            <div class="form-group mb-3">
                <label for="no_hp">No. HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" required />
            </div>
            <div class="form-group mb-3">
                <label for="created_at">Tanggal Daftar</label>
                <input type="date" class="form-control" id="created_at" name="created_at" value="<?= date('Y-m-d') ?>" />
            </div>
            <hr />
            <h5 class="mb-3 mt-3 font-weight-bold text-secondary">Laporan Waktu Tunggu (Opsional)</h5>
            <div class="form-group mb-3">
                <label for="hari">Hari</label>
                <select class="form-control" id="hari" name="hari">
                    <option value="">-- Pilih Hari --</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="jam_laporan">Jam Laporan</label>
                <input type="time" class="form-control" id="jam_laporan" name="jam_laporan" />
            </div>
            <div class="form-group mb-3">
                <label for="waktu_tunggu_rata">Waktu Tunggu Rata-rata (menit)</label>
                <input type="number" step="0.1" class="form-control" id="waktu_tunggu_rata" name="waktu_tunggu_rata" />
            </div>
            <div class="form-group mb-3">
                <label for="tanggal_laporan">Tanggal Laporan</label>
                <input type="date" class="form-control" id="tanggal_laporan" name="tanggal_laporan" value="<?= date('Y-m-d') ?>" />
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan Data Pasien</button>
        </form>
    </div>
</body>
</html>
