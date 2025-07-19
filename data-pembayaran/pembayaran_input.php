<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../login/index.php'</script>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $jumlah = intval(str_replace([',', '.'], '', $_POST['jumlah']));
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    $sql = "INSERT INTO pengeluaran (tanggal, kategori, jumlah, keterangan) VALUES ('$tanggal', '$kategori', $jumlah, '$keterangan')";
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data pengeluaran berhasil diinput!');location='pembayaran.php'</script>";
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
    <title>Input Data Pengeluaran</title>
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
        <h4>Input Data Pengeluaran</h4>
        <form method="post">
            <div class="form-group mb-3">
                <label for="tanggal">Tanggal Pengeluaran</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" required />
            </div>
            <div class="form-group mb-3">
                <label for="kategori">Kategori Pengeluaran</label>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="Obat-obatan">Obat-obatan</option>
                    <option value="Gaji Staff">Gaji Staff</option>
                    <option value="Alat Medis">Alat Medis</option>
                    <option value="Listrik & Air">Listrik & Air</option>
                    <option value="Maintenance">Maintenance</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Training">Training</option>
                    <option value="Renovasi">Renovasi</option>
                    <option value="Asuransi">Asuransi</option>
                    <option value="IT Support">IT Support</option>
                    <option value="Cleaning Service">Cleaning Service</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="jumlah">Jumlah Pengeluaran (Rp)</label>
                <input type="text" class="form-control" id="jumlah" name="jumlah" required />
            </div>
            <div class="form-group mb-3">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan Data Pengeluaran</button>
        </form>
    </div>
</body>
</html>
