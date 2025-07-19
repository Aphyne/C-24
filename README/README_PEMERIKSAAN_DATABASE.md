# Database Pemeriksaan - Dokumentasi Lengkap

## Deskripsi
Dokumentasi ini menjelaskan struktur database untuk modul **Pemeriksaan** dalam aplikasi Klinik PHP. Database ini dirancang untuk mendukung sistem pemeriksaan pasien yang komprehensif dengan fitur dashboard analitik, statistik diagnosa, dan manajemen waktu tunggu.

## Tabel Utama

### 1. `tb_pemeriksaan`
**Fungsi**: Menyimpan data pemeriksaan pasien utama
**Kolom Utama**:
- `id_pemeriksaan` (PK) - ID unik pemeriksaan
- `kd_pemeriksaan` - Kode pemeriksaan (e.g., PRK-001)
- `id_pendaftaran` (FK) - Referensi ke pendaftaran
- `keluhan` - Keluhan pasien
- `diagnosa` - Hasil diagnosa dokter
- `status_periksa` - Status (0=Belum resep, 1=Sudah resep)
- `tgl_pemeriksaan` - Tanggal pemeriksaan
- `jam_pemeriksaan` - Jam pemeriksaan
- `durasi_pemeriksaan` - Durasi konsultasi (menit)
- `biaya_pemeriksaan` - Biaya pemeriksaan

### 2. `tb_pendaftaran`
**Fungsi**: Data pendaftaran pasien
**Kolom Utama**:
- `id_pendaftaran` (PK) - ID unik pendaftaran
- `kd_pendaftaran` - Kode pendaftaran (e.g., REG-001)
- `id_pasien` (FK) - Referensi ke pasien
- `id_dokter` (FK) - Referensi ke dokter
- `id_poli` (FK) - Referensi ke poli
- `tgl_pendaftaran` - Tanggal pendaftaran
- `status` - Status pemeriksaan (0=Belum, 1=Sudah)
- `antrian` - Nomor antrian

### 3. `tb_pasien`
**Fungsi**: Master data pasien
**Kolom Utama**:
- `id_pasien` (PK) - ID unik pasien
- `nm_pasien` - Nama pasien
- `jk_pasien` - Jenis kelamin (L/P)
- `umur_pasien` - Umur pasien
- `alamat_pasien` - Alamat lengkap
- `no_hp_pasien` - Nomor HP

### 4. `tb_dokter`
**Fungsi**: Master data dokter
**Kolom Utama**:
- `id_dokter` (PK) - ID unik dokter
- `nm_dokter` - Nama dokter
- `alamat_dokter` - Alamat dokter
- `no_hp_dokter` - Nomor HP dokter
- `id_poli` (FK) - Poli tempat praktik

### 5. `tb_poli`
**Fungsi**: Master data poli/spesialisasi
**Kolom Utama**:
- `id_poli` (PK) - ID unik poli
- `nm_poli` - Nama poli
- `keterangan` - Deskripsi poli

## Tabel Analitik

### 1. `pemeriksaan_detail_analytics`
**Fungsi**: Detail analitik setiap pemeriksaan untuk dashboard
**Data Sample**: 18 record pemeriksaan dengan kategori keluhan, tingkat urgensi, dan rating pelayanan
**Kolom Analitik**:
- `kategori_keluhan` - Demam, Batuk, Pernapasan, Jantung, dll
- `tingkat_urgensi` - Rendah, Sedang, Tinggi, Darurat
- `durasi_konsultasi` - Waktu konsultasi (15-45 menit)
- `rating_pelayanan` - Rating 1-5 dari pasien

### 2. `pemeriksaan_diagnosa_stats`
**Fungsi**: Statistik diagnosa bulanan
**Data Sample**: 14 record statistik untuk ISPA, Demam, Hipertensi, Gastritis, dll
**Metrik Utama**:
- Jumlah kasus per diagnosa
- Persentase dari total pemeriksaan
- Tingkat kesembuhan (82.4% - 100%)
- Rata-rata biaya dan durasi
- Trend bulanan (naik/turun/stabil)

### 3. `pemeriksaan_waktu_tunggu_stats`
**Fungsi**: Analisis waktu tunggu per jam dan hari
**Data Sample**: 26 record waktu tunggu dari jam 08:00-18:00
**Metrik Utama**:
- Rata-rata waktu tunggu (8-27 menit)
- Status antrian (lancar/sedang/padat/sangat_padat)
- Tingkat kepuasan waktu (2.5-4.4)
- Pola: Jam sibuk 17:00-18:00, Hari tersibuk Jumat

### 4. `pemeriksaan_monthly_insights`
**Fungsi**: Insight bulanan komprehensif
**Data Sample**: 4 bulan data (April-Juli 2025)
**Metrik Utama**:
- Total pemeriksaan (155-200 per bulan)
- Tingkat kepuasan (3.9-4.2)
- Efisiensi pelayanan (83.9%-87.2%)
- Diagnosa terbanyak dan jam tersibuk

## Views Dashboard

### 1. `view_pemeriksaan_summary`
Ringkasan pemeriksaan bulan berjalan: total, selesai, pending, rata-rata durasi, pendapatan

### 2. `view_diagnosa_popular`
Top 10 diagnosa terpopuler dengan persentase, rata-rata biaya dan durasi

### 3. `view_waktu_tunggu_jam`
Analisis waktu tunggu per jam dengan status antrian

### 4. `view_dokter_performance_pemeriksaan`
Performance dokter: total pemeriksaan, completion rate, pendapatan

### 5. `view_keluhan_stats`
Statistik 15 keluhan terbanyak dengan persentase

### 6. `view_pemeriksaan_trend_harian`
Trend pemeriksaan harian 30 hari terakhir

### 7. `view_poli_popular_pemeriksaan`
Analisis popularitas poli berdasarkan jumlah pemeriksaan

### 8. `view_pemeriksaan_insights`
Insight bulanan 6 bulan terakhir dengan completion rate

## Fitur Dashboard Utama

### 📊 Cards Statistik
- **Total Pemeriksaan**: 200 bulan ini
- **Rata-rata Durasi**: 25 menit
- **Tingkat Kepuasan**: 4.2/5.0
- **Efisiensi Pelayanan**: 87.2%

### 📈 Charts & Grafik
1. **Diagnosa per Hari**: Bar chart diagnosa Senin-Jumat
2. **Waktu Tunggu**: Line chart waktu tunggu jam 08:00-18:00
3. **Trend Bulanan**: Area chart pemeriksaan 6 bulan

### 🔍 Insights Otomatis
- Deteksi jam sibuk (17:00-20:00) untuk tambahan dokter
- Alert pasien batal dalam 2 minggu terakhir
- Peningkatan keluhan pencernaan 20%
- Monitoring stok obat untuk diagnosa populer

### 📋 Tabel Data
1. **Ringkasan Pemeriksaan**: Data sample dengan durasi dan status
2. **Database Pemeriksaan**: Tabel utama dengan join ke pasien, poli, dokter

## Query Optimization

### Indexes Utama
- Primary keys semua tabel
- Foreign keys untuk relasi
- Index pada tanggal pemeriksaan
- Index pada status pemeriksaan
- Index pada kategori keluhan

### Foreign Key Constraints
- `tb_pemeriksaan` → `tb_pendaftaran`
- `tb_pendaftaran` → `tb_pasien`, `tb_dokter`, `tb_poli`
- `tb_dokter` → `tb_poli`

## Data Sample Summary

### Distribusi Data
- **10 Pasien** dengan variasi umur dan gender
- **7 Dokter** di 7 poli berbeda
- **10 Pendaftaran** dengan status bervariasi
- **10 Pemeriksaan** dengan diagnosa beragam
- **18 Analytics** detail dengan rating dan durasi
- **14 Diagnosa Stats** untuk 2 bulan
- **26 Waktu Tunggu** records berbagai jam
- **4 Monthly Insights** untuk trend analisis

### Pattern Recognition
- **Jam Sibuk**: 17:00-18:00 (waktu tunggu 21-27 menit)
- **Hari Tersibuk**: Jumat (waktu tunggu tertinggi)
- **Diagnosa Populer**: ISPA (22.5%), Demam (19%), Hipertensi (16%)
- **Durasi Optimal**: 15-30 menit untuk kepuasan tinggi
- **Trend Positif**: Tingkat kesembuhan 85-100%

## Integrasi Sistem

### Kompatibilitas PHP
- Nama tabel dengan prefix `tb_` sesuai kode PHP
- Field names sesuai dengan query dalam aplikasi
- Support untuk multiple query execution
- Date format Indonesia (d M Y)

### Dashboard Features
- Real-time counter animation
- Interactive filter buttons
- Chart.js integration
- Responsive table design
- Modern UI components
- Status badges dengan color coding

Database ini menyediakan foundation lengkap untuk sistem pemeriksaan klinik yang modern, analitik, dan user-friendly dengan kemampuan insight otomatis untuk optimasi pelayanan.
