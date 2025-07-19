<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../../login/index.php'</script>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_dokter = $_POST['nama_dokter'];
    $spesialisasi = $_POST['spesialisasi'];
    $no_str = $_POST['no_str'];
    $no_sip = $_POST['no_sip'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $status_dokter = $_POST['status_dokter'];
    $tarif_konsultasi = $_POST['tarif_konsultasi'];
    $jadwal_praktek = $_POST['jadwal_praktek'];
    $kehadiran = $_POST['kehadiran'];
    $pertumbuhan_pasien = $_POST['pertumbuhan_pasien'];
    $jam_praktik = $_POST['jam_praktik'];
    $total_pasien = $_POST['total_pasien'];

    $query = "INSERT INTO tb_dokter (nama_dokter, spesialisasi, no_str, no_sip, no_hp, alamat, status_dokter, tarif_konsultasi, jadwal_praktek, kehadiran, pertumbuhan_pasien, jam_praktik, total_pasien) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'sssssssisidii', $nama_dokter, $spesialisasi, $no_str, $no_sip, $no_hp, $alamat, $status_dokter, $tarif_konsultasi, $jadwal_praktek, $kehadiran, $pertumbuhan_pasien, $jam_praktik, $total_pasien);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<script>alert('Data dokter berhasil ditambahkan!');location='dokter.php'</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Dokter</title>
    <link href="../../assets/css/styles.css" rel="stylesheet" />
    <link href="../../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="input-card">
        <h4>Input Data Dokter</h4>
        <form method="POST" autocomplete="off">
            <div class="form-group mb-3">
                <label for="nama_dokter">Nama Dokter</label>
                <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" required />
            </div>
            <div class="form-group mb-3">
                <label for="spesialisasi">Spesialisasi</label>
                <input type="text" class="form-control" id="spesialisasi" name="spesialisasi" required />
            </div>
            <div class="form-group mb-3">
                <label for="no_str">No. STR</label>
                <input type="text" class="form-control" id="no_str" name="no_str" required />
            </div>
            <div class="form-group mb-3">
                <label for="no_sip">No. SIP</label>
                <input type="text" class="form-control" id="no_sip" name="no_sip" required />
            </div>
            <div class="form-group mb-3">
                <label for="no_hp">No. HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" required />
            </div>
            <div class="form-group mb-3">
                <label for="alamat">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="status_dokter">Status Dokter</label>
                <select class="form-control" id="status_dokter" name="status_dokter" required>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="tarif_konsultasi">Tarif Konsultasi (Rp)</label>
                <input type="number" class="form-control" id="tarif_konsultasi" name="tarif_konsultasi" required />
            </div>
            <div class="form-group mb-3">
                <label for="jadwal_praktek">Jadwal Praktik</label>
                <input type="text" class="form-control" id="jadwal_praktek" name="jadwal_praktek" placeholder="Contoh: Senin-Jumat 08:00-12:00" required />
            </div>
            <div class="form-group mb-3">
                <label for="kehadiran">Kehadiran (%)</label>
                <input type="number" class="form-control" id="kehadiran" name="kehadiran" min="0" max="100" required />
            </div>
            <div class="form-group mb-3">
                <label for="pertumbuhan_pasien">Pertumbuhan Pasien (%)</label>
                <input type="number" class="form-control" id="pertumbuhan_pasien" name="pertumbuhan_pasien" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="jam_praktik">Jam Praktik</label>
                <input type="number" class="form-control" id="jam_praktik" name="jam_praktik" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="total_pasien">Total Pasien (bulan ini)</label>
                <input type="number" class="form-control" id="total_pasien" name="total_pasien" min="0" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan Data Dokter</button>
            <a href="dokter.php" class="btn btn-secondary w-100 mt-2">Batal</a>
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
