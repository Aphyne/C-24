<?php
// Test koneksi database dan data dokter
include 'koneksi.php';

echo "<h2>Test Koneksi Database dan Data Dokter</h2>";

// Test koneksi
if ($koneksi) {
    echo "<p style='color: green;'>✓ Koneksi database berhasil</p>";
} else {
    echo "<p style='color: red;'>✗ Koneksi database gagal: " . mysqli_connect_error() . "</p>";
    exit();
}

// Test data dokter
echo "<h3>Data Dokter dari Database:</h3>";
$query = mysqli_query($koneksi, "SELECT * FROM tb_dokter ORDER BY nama_dokter ASC");

if (mysqli_num_rows($query) > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>ID</th>
            <th>Nama Dokter</th>
            <th>Spesialisasi</th>
            <th>No SIP</th>
            <th>No HP</th>
            <th>Status</th>
            <th>Tarif Konsultasi</th>
          </tr>";
    
    while($row = mysqli_fetch_array($query)) {
        echo "<tr>";
        echo "<td>" . $row['id_dokter'] . "</td>";
        echo "<td>" . $row['nama_dokter'] . "</td>";
        echo "<td>" . $row['spesialisasi'] . "</td>";
        echo "<td>" . $row['no_sip'] . "</td>";
        echo "<td>" . $row['no_hp'] . "</td>";
        echo "<td>" . $row['status_dokter'] . "</td>";
        echo "<td>Rp. " . number_format($row['tarif_konsultasi'], 0, ',', '.') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Statistik
    $totalDokter = mysqli_num_rows($query);
    $queryAktif = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_dokter WHERE status_dokter = 'aktif'");
    $totalAktif = mysqli_fetch_array($queryAktif)['total'];
    $queryNonaktif = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_dokter WHERE status_dokter = 'nonaktif'");
    $totalNonaktif = mysqli_fetch_array($queryNonaktif)['total'];
    
    echo "<h3>Statistik:</h3>";
    echo "<ul>";
    echo "<li>Total Dokter: $totalDokter</li>";
    echo "<li>Dokter Aktif: $totalAktif</li>";
    echo "<li>Dokter Nonaktif: $totalNonaktif</li>";
    echo "</ul>";
    
} else {
    echo "<p style='color: red;'>✗ Tidak ada data dokter dalam database</p>";
    echo "<p>Silakan import file clinic.sql ke database MySQL terlebih dahulu</p>";
}

// Test table structure
echo "<h3>Struktur Tabel tb_dokter:</h3>";
$structure = mysqli_query($koneksi, "DESCRIBE tb_dokter");
if ($structure) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while($field = mysqli_fetch_array($structure)) {
        echo "<tr>";
        echo "<td>" . $field['Field'] . "</td>";
        echo "<td>" . $field['Type'] . "</td>";
        echo "<td>" . $field['Null'] . "</td>";
        echo "<td>" . $field['Key'] . "</td>";
        echo "<td>" . $field['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

mysqli_close($koneksi);
?>
