<?php
// Test koneksi database dan query pengeluaran
include 'koneksi.php';

echo "<h2>Test Koneksi Database & Data Pengeluaran</h2>";

// Test koneksi
if ($koneksi) {
    echo "✅ Koneksi database berhasil<br><br>";
} else {
    echo "❌ Koneksi database gagal: " . mysqli_connect_error() . "<br><br>";
    exit();
}

// Cek apakah tabel pengeluaran ada
echo "<h3>Cek Tabel Pengeluaran:</h3>";
$queryCheck = "SHOW TABLES LIKE 'pengeluaran'";
$resultCheck = mysqli_query($koneksi, $queryCheck);
if (mysqli_num_rows($resultCheck) > 0) {
    echo "✅ Tabel 'pengeluaran' ditemukan<br><br>";
} else {
    echo "❌ Tabel 'pengeluaran' tidak ditemukan<br>";
    echo "Pastikan file clinic.sql sudah di-import ke database 'clinic'<br><br>";
}

// Test query tabel pengeluaran
echo "<h3>Data Pengeluaran (5 teratas):</h3>";
$query = "SELECT * FROM pengeluaran ORDER BY tanggal DESC LIMIT 5";
$result = mysqli_query($koneksi, $query);

if ($result) {
    echo "✅ Query berhasil. Jumlah data: " . mysqli_num_rows($result) . "<br><br>";
    
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        echo "<tr style='background-color: #f0f0f0;'><th>ID</th><th>Tanggal</th><th>Kategori</th><th>Keterangan</th><th>Jumlah</th></tr>";
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id_pengeluaran'] . "</td>";
            echo "<td>" . $row['tanggal'] . "</td>";
            echo "<td>" . $row['kategori'] . "</td>";
            echo "<td>" . substr($row['keterangan'], 0, 30) . "...</td>";
            echo "<td>Rp " . number_format($row['jumlah'], 0, ',', '.') . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    } else {
        echo "❌ Tidak ada data pengeluaran.<br>";
        echo "Pastikan data sudah di-import dari clinic.sql<br><br>";
    }
} else {
    echo "❌ Query gagal: " . mysqli_error($koneksi) . "<br><br>";
}

// Test summary pengeluaran per tahun
echo "<h3>Summary Pengeluaran per Tahun:</h3>";
$querySummary = "SELECT YEAR(tanggal) as tahun, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total 
                 FROM pengeluaran 
                 GROUP BY YEAR(tanggal) 
                 ORDER BY tahun DESC";
$resultSummary = mysqli_query($koneksi, $querySummary);

if ($resultSummary && mysqli_num_rows($resultSummary) > 0) {
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr style='background-color: #f0f0f0;'><th>Tahun</th><th>Jumlah Transaksi</th><th>Total Pengeluaran</th></tr>";
    
    while ($row = mysqli_fetch_assoc($resultSummary)) {
        echo "<tr>";
        echo "<td>" . $row['tahun'] . "</td>";
        echo "<td>" . $row['jumlah_transaksi'] . "</td>";
        echo "<td>Rp " . number_format($row['total'], 0, ',', '.') . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
} else {
    echo "❌ Tidak ada data summary atau query gagal<br><br>";
}

// Test query per kategori
echo "<h3>Pengeluaran per Kategori (2024):</h3>";
$queryKategori = "SELECT kategori, COUNT(*) as jumlah, SUM(jumlah) as total 
                  FROM pengeluaran 
                  WHERE YEAR(tanggal) = 2024 
                  GROUP BY kategori 
                  ORDER BY total DESC";
$resultKategori = mysqli_query($koneksi, $queryKategori);

if ($resultKategori && mysqli_num_rows($resultKategori) > 0) {
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr style='background-color: #f0f0f0;'><th>Kategori</th><th>Jumlah Transaksi</th><th>Total</th></tr>";
    
    while ($row = mysqli_fetch_assoc($resultKategori)) {
        echo "<tr>";
        echo "<td>" . $row['kategori'] . "</td>";
        echo "<td>" . $row['jumlah'] . "</td>";
        echo "<td>Rp " . number_format($row['total'], 0, ',', '.') . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
} else {
    echo "❌ Tidak ada data kategori untuk tahun 2024<br><br>";
}

// Instruksi jika tidak ada data
if (mysqli_num_rows($result) == 0) {
    echo "<div style='background-color: #fff3cd; padding: 15px; border: 1px solid #ffeaa7; border-radius: 5px;'>";
    echo "<h4>🔧 Langkah-langkah untuk Import Data:</h4>";
    echo "<ol>";
    echo "<li>Buka phpMyAdmin atau MySQL client</li>";
    echo "<li>Pilih database 'clinic'</li>";
    echo "<li>Klik tab 'Import'</li>";
    echo "<li>Pilih file 'clinic.sql'</li>";
    echo "<li>Klik 'Go' untuk import</li>";
    echo "</ol>";
    echo "</div>";
}

mysqli_close($koneksi);
?>
