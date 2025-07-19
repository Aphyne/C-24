# 📋 Database Staff - Dokumentasi Lengkap

Dokumentasi ini menjelaskan struktur database yang mendukung semua fitur pada halaman **staff.php** dalam aplikasi Klinik PHP Dashboard.

## 🗃️ Tabel Utama

### 1. `staff` - Tabel Master Staff
Menyimpan data dasar staff klinik.

**Kolom:**
- `id` - Primary key
- `kode_staff` - Kode unik staff (STF001, STF002, dst)
- `nama` - Nama lengkap staff
- `jabatan` - Jabatan (Perawat, Apoteker, Administrasi, dll)
- `posisi` - Posisi spesifik (Suster, Admin Apotik, Kasir, dll)
- `telepon`, `email`, `alamat` - Data kontak
- `gaji` - Gaji pokok
- `tanggal_masuk` - Tanggal bergabung
- `jenis_kelamin` - L/P
- `status` - aktif/nonaktif/cuti
- `target_jam_bulan` - Target jam kerja per bulan (default: 176)

**Data Sample:** 18 staff dengan berbagai posisi

### 2. `staff_performance_tracking` - Tracking Performa Staff
Mencatat performa staff per bulan.

**Kolom:**
- `staff_id` - Foreign key ke tabel staff
- `periode_bulan` - Format YYYY-MM
- `jam_kerja_aktual` - Jam kerja yang dicapai
- `target_jam_kerja` - Target jam kerja
- `persentase_kehadiran` - Persentase kehadiran
- `total_shift` - Total shift kerja
- `jam_lembur` - Total jam lembur
- `rating_performa` - Rating 1-5
- `rating_bintang` - Visual bintang (★★★★★)
- `status_performa` - Sangat Baik/Baik/Cukup/Perlu Monitoring/Buruk
- `catatan_performa` - Catatan evaluasi

### 3. `staff_attendance_log` - Log Kehadiran Harian
Mencatat kehadiran staff per hari.

**Kolom:**
- `staff_id` - Foreign key ke tabel staff
- `tanggal` - Tanggal kehadiran
- `jam_masuk`, `jam_keluar` - Waktu masuk/keluar
- `status_kehadiran` - hadir/izin/sakit/alpha/cuti
- `jam_kerja_harian` - Total jam kerja hari itu
- `jam_lembur` - Jam lembur hari itu
- `catatan` - Catatan khusus

### 4. `staff_shift_schedule` - Jadwal Shift Staff
Mengatur jadwal shift staff.

**Kolom:**
- `staff_id` - Foreign key ke tabel staff
- `tanggal` - Tanggal shift
- `shift_type` - Pagi/Sore/Malam/Double Shift/Overload
- `jam_mulai`, `jam_selesai` - Waktu shift
- `status` - scheduled/completed/cancelled

### 5. `staff_monthly_insights` - Insight Bulanan
Ringkasan statistik staff per bulan.

**Kolom:**
- `periode_bulan` - Format YYYY-MM
- `total_staff`, `staff_aktif`, `staff_cuti` - Jumlah staff
- `rata_kehadiran_persen` - Rata-rata kehadiran
- `pertumbuhan_staff_persen` - Pertumbuhan staff
- `staff_kurang_performa` - Jumlah staff perlu perhatian
- `rasio_staff_pria_persen` - Rasio gender
- `total_jam_lembur` - Total jam lembur
- `rata_rating_staff` - Rata-rata rating
- `staff_rating_tinggi` - Staff dengan rating tinggi
- `staff_perlu_training` - Staff perlu training

### 6. `staff_position_stats` - Statistik per Posisi
Statistik performa per posisi kerja.

**Kolom:**
- `periode_bulan` - Format YYYY-MM
- `posisi` - Nama posisi
- `jumlah_staff` - Jumlah staff di posisi ini
- `rata_jam_kerja` - Rata-rata jam kerja
- `rata_kehadiran` - Rata-rata kehadiran
- `rata_rating` - Rata-rata rating
- `total_lembur` - Total jam lembur posisi ini

## 📊 Views untuk Dashboard

### 1. `v_staff_summary` - Ringkasan Utama
```sql
SELECT total_staff, staff_aktif, staff_cuti, rata_kehadiran, staff_kurang_performa
```

### 2. `v_staff_performance_current` - Performa Terkini
```sql
SELECT nama, posisi, jam_kerja_aktual, persentase_kehadiran, rating_performa, status_performa
```

### 3. `v_top_staff_performance` - Top 3 Staff Terbaik
```sql
SELECT nama, posisi, rating_performa, badge ('Teladan'/'Sangat Baik'/'Konsisten')
```

### 4. `v_distribusi_posisi_staff` - Chart Donut Posisi
```sql
SELECT posisi, jumlah_staff, persentase
```

### 5. `v_kehadiran_staff_chart` - Chart Bar Kehadiran
```sql
SELECT nama, posisi, kehadiran_persen
```

### 6. `v_staff_detail_table` - Tabel Detail
```sql
SELECT nama, posisi, jam_kerja, kehadiran_hari, izin, terlambat, sakit, status
```

### 7. `v_staff_insights` - Insight MIS
```sql
SELECT total_staff, rata_kehadiran, staff_kurang_performa, rekomendasi_utama
```

## 🎯 Fitur yang Didukung

### 1. **Ringkasan Dashboard**
- Total staff, staff aktif, staff cuti
- Rata-rata kehadiran dengan persentase
- Indikator pertumbuhan staff bulanan
- Jumlah staff yang perlu perhatian

### 2. **Review Performa Staff**
- Card performa individual dengan progress bar
- Rating bintang dan status performa
- Filter berdasarkan nama, posisi, status
- Pagination untuk menampilkan data

### 3. **Top 3 Staff Terbaik**
- Modal popup dengan ranking
- Badge khusus: Teladan, Sangat Baik, Konsisten
- Metrik jam kerja, kehadiran, rating

### 4. **Visualisasi Data**
- Chart donut distribusi posisi staff
- Chart bar kehadiran per staff
- Filter chart berdasarkan posisi

### 5. **Insight MIS Otomatis**
- Analisis performa dan kehadiran
- Rekomendasi berdasarkan data
- Alert untuk staff yang perlu perhatian
- Saran perbaikan sistem

### 6. **Tabel Detail dengan DataTables**
- Pencarian dan sorting
- Pagination otomatis
- Data kehadiran, izin, terlambat, sakit
- Status performa terkini

## 🔧 Query Penggunaan

### Mendapatkan ringkasan staff:
```sql
SELECT * FROM v_staff_summary;
```

### Top 3 staff terbaik:
```sql
SELECT * FROM v_top_staff_performance;
```

### Data untuk chart donut:
```sql
SELECT posisi, jumlah_staff FROM v_distribusi_posisi_staff;
```

### Data untuk chart bar kehadiran:
```sql
SELECT nama, kehadiran_persen FROM v_kehadiran_staff_chart;
```

### Insight otomatis:
```sql
SELECT rekomendasi_utama FROM v_staff_insights;
```

## 📈 Manfaat

1. **Monitoring Real-time**: Tracking performa staff secara real-time
2. **Data-driven Decision**: Keputusan berdasarkan data objektif
3. **Early Warning**: Deteksi dini staff yang perlu perhatian
4. **Performance Management**: Sistem evaluasi yang komprehensif
5. **Visualisasi Intuitif**: Chart dan graph yang mudah dipahami
6. **Automated Insights**: Rekomendasi otomatis dari sistem

Database ini mendukung seluruh fitur pada halaman staff.php termasuk dashboard summary, review performa, visualisasi, insight MIS, dan tabel detail dengan filtering yang lengkap.
