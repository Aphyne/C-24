<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../login/index.php'</script>";
    exit();
}

// Ambil data pasien untuk dropdown
$pasienList = [];
$queryPasien = mysqli_query($koneksi, "SELECT id_pasien, nama_pasien FROM tb_pasien ORDER BY nama_pasien");
while ($row = mysqli_fetch_assoc($queryPasien)) {
    $pasienList[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pasien = intval($_POST['id_pasien']);
    $tanggal_pemeriksaan = $_POST['tanggal_pemeriksaan'];
    $keluhan = mysqli_real_escape_string($koneksi, $_POST['keluhan']);
    $diagnosa = mysqli_real_escape_string($koneksi, $_POST['diagnosa']);
    $status_pemeriksaan = mysqli_real_escape_string($koneksi, $_POST['status_pemeriksaan']);

    $sql = "INSERT INTO tb_pemeriksaan (id_pasien, tanggal_pemeriksaan, keluhan, diagnosa, status_pemeriksaan) VALUES ($id_pasien, '$tanggal_pemeriksaan', '$keluhan', '$diagnosa', '$status_pemeriksaan')";
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data pemeriksaan berhasil diinput!');location='pemeriksaan.php'</script>";
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
    <title>Input Data Pemeriksaan</title>
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
        <h4>Input Data Pemeriksaan</h4>
        <form method="post">
            <div class="form-group mb-3">
                <label for="id_pasien">Nama Pasien</label>
                <select class="form-control" id="id_pasien" name="id_pasien" required>
                    <option value="">-- Pilih Pasien --</option>
                    <?php foreach($pasienList as $pasien): ?>
                        <option value="<?= $pasien['id_pasien'] ?>"><?= htmlspecialchars($pasien['nama_pasien']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="tanggal_pemeriksaan">Tanggal Pemeriksaan</label>
                <input type="date" class="form-control" id="tanggal_pemeriksaan" name="tanggal_pemeriksaan" value="<?= date('Y-m-d') ?>" required />
            </div>
            <div class="form-group mb-3">
                <label for="keluhan">Keluhan</label>
                <input type="text" class="form-control" id="keluhan" name="keluhan" required />
            </div>
            <div class="form-group mb-3">
                <label for="diagnosa">Diagnosa</label>
                <input type="text" class="form-control" id="diagnosa" name="diagnosa" required />
            </div>
            <div class="form-group mb-3">
                <label for="status_pemeriksaan">Status Pemeriksaan</label>
                <select class="form-control" id="status_pemeriksaan" name="status_pemeriksaan" required>
                    <option value="selesai">Selesai</option>
                    <option value="proses">Proses</option>
                    <option value="batal">Batal</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan Data Pemeriksaan</button>
        </form>
    </div>
</body>
</html>
