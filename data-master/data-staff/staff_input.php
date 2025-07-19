<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../../login/index.php'</script>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = $_POST['nip'];
    $nama_staff = $_POST['nama_staff'];
    $jabatan = $_POST['jabatan'];
    $departemen = $_POST['departemen'];
    $status_staff = $_POST['status_staff'];
    $total_jam_kerja = $_POST['total_jam_kerja'];
    $target_jam_kerja = $_POST['target_jam_kerja'];
    $total_shift_bulan_ini = $_POST['total_shift_bulan_ini'];
    $total_lembur_jam = $_POST['total_lembur_jam'];
    $jumlah_review = $_POST['jumlah_review'];
    $catatan_kinerja = $_POST['catatan_kinerja'];
    $created_at = date('Y-m-d');

    $query = "INSERT INTO tb_staff (nip, nama_staff, jabatan, departemen, status_staff, created_at) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'ssssss', $nip, $nama_staff, $jabatan, $departemen, $status_staff, $created_at);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Insert performance data (tanpa rating, persentase kehadiran, status kinerja)
    $id_staff = mysqli_insert_id($koneksi);
    $queryPerf = "INSERT INTO tb_performance_staff (id_staff, total_jam_kerja, target_jam_kerja, total_shift_bulan_ini, total_lembur_jam, jumlah_review, catatan_kinerja, bulan_periode, tahun_periode) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmtPerf = mysqli_prepare($koneksi, $queryPerf);
    $bulan = date('n');
    $tahun = date('Y');
    mysqli_stmt_bind_param($stmtPerf, 'iiddiisii', $id_staff, $total_jam_kerja, $target_jam_kerja, $total_shift_bulan_ini, $total_lembur_jam, $jumlah_review, $catatan_kinerja, $bulan, $tahun);
    mysqli_stmt_execute($stmtPerf);
    mysqli_stmt_close($stmtPerf);

    echo "<script>alert('Data staff berhasil ditambahkan!');location='staff.php'</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Staff</title>
    <link href="../../assets/css/styles.css" rel="stylesheet" />
    <link href="../../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="input-card">
        <h4>Input Data Staff</h4>
        <form method="POST" autocomplete="off">
            <div class="form-group mb-3">
                <label for="nip">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" required />
            </div>
            <div class="form-group mb-3">
                <label for="nama_staff">Nama Staff</label>
                <input type="text" class="form-control" id="nama_staff" name="nama_staff" required />
            </div>
            <div class="form-group mb-3">
                <label for="jabatan">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" required />
            </div>
            <div class="form-group mb-3">
                <label for="departemen">Departemen</label>
                <input type="text" class="form-control" id="departemen" name="departemen" required />
            </div>
            <div class="form-group mb-3">
                <label for="status_staff">Status Staff</label>
                <select class="form-control" id="status_staff" name="status_staff" required>
                    <option value="aktif">Aktif</option>
                    <option value="cuti">Cuti</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="total_jam_kerja">Total Jam Kerja</label>
                <input type="number" class="form-control" id="total_jam_kerja" name="total_jam_kerja" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="target_jam_kerja">Target Jam Kerja</label>
                <input type="number" class="form-control" id="target_jam_kerja" name="target_jam_kerja" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="total_shift_bulan_ini">Total Shift Bulan Ini</label>
                <input type="number" class="form-control" id="total_shift_bulan_ini" name="total_shift_bulan_ini" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="total_lembur_jam">Total Lembur (Jam)</label>
                <input type="number" class="form-control" id="total_lembur_jam" name="total_lembur_jam" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="jumlah_review">Jumlah Review</label>
                <input type="number" class="form-control" id="jumlah_review" name="jumlah_review" min="0" required />
            </div>
            <div class="form-group mb-3">
                <label for="catatan_kinerja">Catatan Kinerja</label>
                <textarea class="form-control" id="catatan_kinerja" name="catatan_kinerja" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan Data Staff</button>
            <a href="staff.php" class="btn btn-secondary w-100 mt-2">Batal</a>
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
