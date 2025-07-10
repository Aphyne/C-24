# 🏥 Database Documentation - Halaman Pasien

## 📋 Overview
Dokumentasi ini menjelaskan struktur database yang mendukung fitur-fitur pada halaman **Data Pasien** (`pasien.php`) di sistem Klinik Dashboard.

## 🗃️ Tabel Utama untuk Fitur Pasien

### 1. **`pasien`** - Data Master Pasien
**Tujuan**: Menyimpan data dasar pasien  
**Fitur yang didukung**: Data master, profil pasien

| Field | Type | Description |
|-------|------|-------------|
| `id` | int(11) | Primary key |
| `no_rm` | varchar(20) | Nomor rekam medis (unique) |
| `nama` | varchar(100) | Nama lengkap pasien |
| `tanggal_lahir` | date | Tanggal lahir untuk hitung usia |
| `jenis_kelamin` | enum('L','P') | Gender untuk statistik demografi |
| `alamat` | text | Alamat lengkap |
| `telepon` | varchar(15) | Nomor telepon |
| `pekerjaan` | varchar(50) | Profesi pasien |
| `status_pernikahan` | enum | Status pernikahan |
| `golongan_darah` | enum('A','B','AB','O') | Golongan darah |
| `alergi` | text | Riwayat alergi |

### 2. **`pasien_ulasan_rating`** - Sistem Rating & Ulasan
**Tujuan**: Menyimpan rating dan ulasan pasien  
**Fitur yang didukung**: Rating bintang, ulasan positif/negatif, mood analysis

| Field | Type | Description |
|-------|------|-------------|
| `id` | int(11) | Primary key |
| `pasien_id` | int(11) | FK ke tabel pasien |
| `rating` | decimal(2,1) | Rating 1-5 bintang |
| `ulasan` | text | Teks ulasan pasien |
| `kategori_ulasan` | enum | Kategori: pelayanan, dokter, fasilitas, dll |
| `status_kunjungan` | enum('Baru','Kembali') | Status kunjungan |
| `tanggal_kunjungan` | date | Tanggal kunjungan |
| `mood_rating` | enum | Mood: sangat_puas, puas, biasa, dll |
| `recommend_to_others` | tinyint(1) | Apakah merekomendasikan |

### 3. **`pasien_kunjungan_history`** - Riwayat Kunjungan
**Tujuan**: Tracking kunjungan pasien  
**Fitur yang didukung**: History kunjungan, tracking pasien baru vs kembali

| Field | Type | Description |
|-------|------|-------------|
| `id` | int(11) | Primary key |
| `pasien_id` | int(11) | FK ke tabel pasien |
| `tanggal_kunjungan` | date | Tanggal kunjungan |
| `jenis_kunjungan` | enum | Baru, Kembali, Kontrol, Emergency |
| `keluhan_utama` | text | Keluhan utama pasien |
| `diagnosa` | text | Hasil diagnosa |
| `dokter_id` | int(11) | FK ke dokter yang menangani |
| `biaya_total` | decimal(10,2) | Total biaya kunjungan |
| `rating_kunjungan` | decimal(2,1) | Rating untuk kunjungan ini |

### 4. **`pasien_demografi_stats`** - Statistik Demografi
**Tujuan**: Menyimpan statistik demografi pasien  
**Fitur yang didukung**: Chart distribusi usia & gender

| Field | Type | Description |
|-------|------|-------------|
| `id` | int(11) | Primary key |
| `periode_bulan` | varchar(7) | Format: YYYY-MM |
| `kelompok_usia` | enum | '0-12', '13-24', '25-45', '46-65', '65+' |
| `jenis_kelamin` | enum('L','P') | Gender |
| `jumlah_pasien` | int(11) | Jumlah pasien di kelompok ini |
| `rata_rating` | decimal(3,2) | Rating rata-rata kelompok |
| `persentase_pasien_baru` | decimal(5,2) | % pasien baru |

### 5. **`pasien_insights_metrics`** - Metrics & Insights
**Tujuan**: Menyimpan summary bulanan untuk MIS  
**Fitur yang didukung**: Ringkasan dashboard, insights MIS

| Field | Type | Description |
|-------|------|-------------|
| `id` | int(11) | Primary key |
| `periode_bulan` | varchar(7) | Periode bulan (YYYY-MM) |
| `total_pasien` | int(11) | Total pasien |
| `pasien_baru` | int(11) | Jumlah pasien baru |
| `pasien_kembali` | int(11) | Jumlah pasien kembali |
| `pertumbuhan_pasien_persen` | decimal(5,2) | % pertumbuhan |
| `rata_rating` | decimal(3,2) | Rating rata-rata |
| `rating_kurang_3` | int(11) | Jumlah rating < 3 |
| `rasio_pasien_pria_persen` | decimal(5,2) | % pasien pria |
| `tingkat_kepuasan_persen` | decimal(5,2) | % kepuasan |
| `rekomendasi_persen` | decimal(5,2) | % yang merekomendasikan |

---

## 📊 View untuk Dashboard Pasien

### 1. **`v_pasien_summary`** - Ringkasan Utama
Menghitung total pasien, pasien baru, pasien kembali, rata rating, dan growth rate.

### 2. **`v_distribusi_usia_pasien`** - Chart Usia
Data untuk chart distribusi usia dengan 5 kelompok usia.

### 3. **`v_distribusi_gender_pasien`** - Chart Gender
Data untuk chart distribusi gender (Laki-laki vs Perempuan).

### 4. **`v_ulasan_pasien_terbaru`** - Ulasan Terbaru
Daftar ulasan terbaru dengan data pasien lengkap.

### 5. **`v_ulasan_positif`** - Ulasan Rating ≥ 4
Filter ulasan dengan rating tinggi (4-5 bintang).

### 6. **`v_ulasan_negatif`** - Ulasan Rating < 4
Filter ulasan dengan rating rendah (1-3 bintang).

### 7. **`v_pasien_insights`** - MIS Insights
Summary insights untuk manajemen dengan kategori dan rekomendasi.

### 8. **`v_kunjungan_hari_ini`** - Kunjungan Hari Ini
Daftar kunjungan pada hari aktif.

### 9. **`v_statistik_pasien_bulanan`** - Trend Bulanan
Statistik bulanan untuk tracking performa 12 bulan terakhir.

---

## 🎯 Fitur Pasien.php yang Didukung

### 🔵 **Ringkasan Data Pasien**
- **Total Pasien** dengan counter animation
- **Pasien Baru** bulan ini
- **Pasien Kembali** dengan status stable
- **Rating Rata-rata** dengan ⭐ 
- **Indikator** rating < 3 (perlu perbaikan)

**Query menggunakan**: `v_pasien_summary`

### 🟠 **Insight MIS (Management Information System)**
- **Analisis Pertumbuhan**: kategori tinggi/sedang/rendah
- **Analisis Kepuasan**: sangat puas/puas/perlu perbaikan  
- **Rekomendasi Gender**: program khusus pria/wanita
- **Alert** jika pasien baru turun
- **Rasio Gender** dengan persentase

**Query menggunakan**: `v_pasien_insights`, `pasien_insights_metrics`

### 🟢 **Ulasan & Rating Pasien**
- **Pagination** 6 ulasan per halaman
- **Avatar** dengan inisial nama
- **Badge** Active (rating ≥4) / Pending (rating <4)
- **Metadata**: tanggal, status kunjungan
- **Star Rating** dengan format decimal
- **Modal** top 5 ulasan positif & negatif

**Query menggunakan**: `v_ulasan_pasien_terbaru`, `v_ulasan_positif`, `v_ulasan_negatif`

### 🔄 **Analisis Demografi**
- **Chart Usia**: Bar chart 5 kelompok usia
- **Chart Gender**: Pie chart distribusi gender  
- **Insights**: rekomendasi fokus layanan
- **Color scheme**: gradient blue theme

**Query menggunakan**: `v_distribusi_usia_pasien`, `v_distribusi_gender_pasien`

### 📋 **Tabel Data Lengkap**
- **DataTables** dengan pagination
- **Search** dan sorting  
- **Fields**: nama, usia, gender, kunjungan, rating, ulasan, tanggal
- **10 rows** per page

**Query menggunakan**: Hardcode data + dapat diintegrasikan dengan views

---

## 🚀 Sample Data Summary

### Data Pasien: **25 pasien** dengan variasi:
- **Usia**: 18-65 tahun (5 kelompok usia)
- **Gender**: Mix laki-laki dan perempuan
- **Profesi**: Beragam (dokter, guru, mahasiswa, dll)

### Rating & Ulasan: **15+ ulasan** dengan:
- **Rating range**: 1.8 - 5.0 bintang
- **Kategori**: pelayanan, dokter, fasilitas, administrasi
- **Status**: Baru dan Kembali
- **Mood**: Dari sangat puas hingga sangat tidak puas

### Kunjungan History: **15+ kunjungan** dengan:
- **Jenis**: Baru, Kembali, Kontrol, Emergency
- **Biaya**: Rp 50.000 - Rp 350.000
- **Dokter**: Terintegrasi dengan tabel dokter

### Insights Metrics: **4 bulan data** dengan:
- **Growth rate**: -5% hingga +20%
- **Rating rata-rata**: 3.9 - 4.4
- **Kepuasan**: 72% - 87%

---

## 🎨 Design Features Supported

### **Modern UI Components**:
- ✅ **Gradient colors**: #5459AC, #6fc3d0
- ✅ **Shadow effects**: box-shadow dengan blur
- ✅ **Animation**: counter, hover, scale transforms
- ✅ **Icons**: FontAwesome dengan semantic meaning
- ✅ **Charts**: Chart.js untuk visualisasi
- ✅ **Typography**: Poppins font family

### **Interactive Elements**:
- ✅ **Modals**: Top ulasan dengan smooth transitions
- ✅ **Pagination**: Custom pagination controls
- ✅ **DataTables**: Search, sort, dan responsive
- ✅ **Badges**: Color-coded status indicators
- ✅ **Cards**: Modern card design dengan hover effects

---

## 📈 Performance & Indexing

### **Database Indexes**:
- ✅ **Primary keys** semua tabel
- ✅ **Foreign keys** dengan CASCADE/SET NULL
- ✅ **Composite indexes** untuk queries sering dipakai
- ✅ **Date indexes** untuk filtering tanggal
- ✅ **Rating indexes** untuk sorting performance

### **Query Optimization**:
- ✅ **Views** untuk complex queries
- ✅ **Aggregation** di database level
- ✅ **Efficient JOINs** dengan proper indexing
- ✅ **Pagination** di database level

---

## 🔧 Integration Notes

### **PHP Integration**:
```php
// Contoh query untuk summary pasien
$summary = $koneksi->query("SELECT * FROM v_pasien_summary")->fetch_assoc();

// Contoh query untuk ulasan terbaru  
$ulasan = $koneksi->query("SELECT * FROM v_ulasan_pasien_terbaru LIMIT 12");

// Contoh query untuk distribusi usia (chart)
$usia_data = $koneksi->query("SELECT * FROM v_distribusi_usia_pasien");
```

### **JavaScript Integration**:
```javascript
// Chart data dari PHP
const usiaData = <?= json_encode($usia_chart_data) ?>;
const genderData = <?= json_encode($gender_chart_data) ?>;

// Counter animation
$('.counter').each(function() {
    $(this).prop('Counter', 0).animate({
        Counter: $(this).text()
    }, {
        duration: 1500,
        easing: 'swing',
        step: function(now) {
            $(this).text(Math.ceil(now));
        }
    });
});
```

---

## ✅ Testing Checklist

- [x] **Data Consistency**: Foreign key constraints
- [x] **Sample Data**: Representative test data
- [x] **View Performance**: Optimized views
- [x] **Chart Integration**: JSON data format
- [x] **Pagination**: Database-level pagination  
- [x] **Filtering**: Date dan rating filters
- [x] **Aggregation**: Summary calculations
- [x] **Security**: SQL injection prevention

---

*Database ini dirancang untuk mendukung semua fitur pada halaman pasien.php dengan performa optimal dan skalabilitas yang baik.*
