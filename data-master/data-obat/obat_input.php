<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../../login/index.php'</script>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_obat = $_POST['nama_obat'];
    $jenis_obat = $_POST['jenis_obat'];
    $kode_obat = $_POST['kode_obat'];
    $kategori = $_POST['kategori'];
    $bentuk_obat = $_POST['bentuk_obat'];
    $stok = $_POST['stok'];
    $stok_minimum = $_POST['stok_minimum'];
    $satuan = $_POST['satuan'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $harga_satuan = $_POST['harga_satuan'];
    $harga_awal = $_POST['harga_awal'];
    $stok_awal = $_POST['stok_awal'];
    $expired_date = $_POST['expired_date'];
    $produsen = $_POST['produsen'];
    $supplier = $_POST['supplier'];
    $status_obat = $_POST['status_obat'];
    $deskripsi = $_POST['deskripsi'];
    $created_at = date('Y-m-d');

    $query = "INSERT INTO tb_obat (nama_obat, jenis_obat, kode_obat, kategori, bentuk_obat, stok, stok_minimum, satuan, harga_beli, harga_jual, harga_satuan, harga_awal, stok_awal, expired_date, produsen, supplier, status_obat, deskripsi, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssissddddssssss', $nama_obat, $jenis_obat, $kode_obat, $kategori, $bentuk_obat, $stok, $stok_minimum, $satuan, $harga_beli, $harga_jual, $harga_satuan, $harga_awal, $stok_awal, $expired_date, $produsen, $supplier, $status_obat, $deskripsi, $created_at);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<script>alert('Data obat berhasil ditambahkan!');location='obat.php'</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Obat</title>
    <link href="../../assets/css/styles.css" rel="stylesheet" />
    <link href="../../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="input-card">
        <h4>Input Data Obat</h4>
        <form method="POST" autocomplete="off">
            <div class="form-group mb-3">
                <label for="nama_obat">Nama Obat</label>
                <input type="text" class="form-control" id="nama_obat" name="nama_obat" required />
            </div>
            <div class="form-group mb-3">
                <label for="jenis_obat">Jenis Obat (Golongan/Fungsi)</label>
                <input type="text" class="form-control" id="jenis_obat" name="jenis_obat" required />
            </div>
            <div class="form-group mb-3">
                <label for="kode_obat">Kode Obat</label>
                <input type="text" class="form-control" id="kode_obat" name="kode_obat" required />
            </div>
            <div class="form-group mb-3">
                <label for="kategori">Kategori Obat</label>
                <input type="text" class="form-control" id="kategori" name="kategori" required />
            </div>
            <div class="form-group mb-3">
                <label for="bentuk_obat">Bentuk Obat</label>
                <input type="text" class="form-control" id="bentuk_obat" name="bentuk_obat" required />
            </div>
            <div class="form-group mb-3">
                <label for="stok">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="stok_minimum">Stok Minimum</label>
                <input type="number" class="form-control" id="stok_minimum" name="stok_minimum" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="satuan">Satuan</label>
                <input type="text" class="form-control" id="satuan" name="satuan" required />
            </div>
            <div class="form-group mb-3">
                <label for="harga_beli">Harga Beli (Rp)</label>
                <input type="number" class="form-control" id="harga_beli" name="harga_beli" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="harga_jual">Harga Jual (Rp)</label>
                <input type="number" class="form-control" id="harga_jual" name="harga_jual" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="harga_satuan">Harga Satuan (Rp)</label>
                <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="harga_awal">Harga Awal (Rp)</label>
                <input type="number" class="form-control" id="harga_awal" name="harga_awal" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="stok_awal">Stok Awal</label>
                <input type="number" class="form-control" id="stok_awal" name="stok_awal" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="expired_date">Tanggal Expired</label>
                <input type="date" class="form-control" id="expired_date" name="expired_date" required />
            </div>
            <div class="form-group mb-3">
                <label for="produsen">Produsen</label>
                <input type="text" class="form-control" id="produsen" name="produsen" required />
            </div>
            <div class="form-group mb-3">
                <label for="supplier">Supplier</label>
                <input type="text" class="form-control" id="supplier" name="supplier" required />
            </div>
            <div class="form-group mb-3">
                <label for="status_obat">Status Obat</label>
                <select class="form-control" id="status_obat" name="status_obat" required>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan Data Obat</button>
            <a href="obat.php" class="btn btn-secondary w-100 mt-2">Batal</a>
        </form>
    </div>
    <style>
        body { font-family: 'Poppins', Arial, sans-serif; background: #f8fafc; }
        .input-card { background: #fff; border-radius: 18px; box-shadow: 0 4px 24px rgba(8,131,149,0.08); padding: 32px 28px; max-width: 600px; margin: 40px auto; }
        .input-card h4 { color: #5459AC; font-weight: 800; margin-bottom: 24px; }
        .form-group label { font-weight: 600; color: #088395; }
        .form-control { border-radius: 8px; }
        .btn-primary { background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%); border: none; font-weight: 700; border-radius: 8px; }
        .btn-primary:hover { background: #088395; }
        .btn-secondary { border-radius: 8px; font-weight: 700; }
    </style>
</body>
</html>
