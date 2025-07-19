# DATABASE KEUNTUNGAN - DOKUMENTASI LENGKAP

## 📊 OVERVIEW SISTEM KEUNTUNGAN
Database keuntungan dirancang untuk mendukung analitik keuangan yang komprehensif, tracking revenue, margin profit, dan KPI bisnis klinik.

## 🏗️ STRUKTUR TABEL

### 1. Tabel Utama: `keuntungan`
**Fungsi**: Menyimpan data transaksi keuntungan harian/bulanan
**Kolom Utama**:
- `id` - Primary key auto increment
- `tanggal` - Tanggal transaksi keuntungan
- `sumber_keuntungan` - Enum: Penjualan Obat, Konsultasi Dokter, Pemeriksaan Cepat, Vaksinasi, dll
- `sub_layanan` - Detail spesifik layanan
- `jumlah_keuntungan` - Total pendapatan kotor
- `keuntungan_bersih` - Keuntungan setelah dikurangi biaya operasional
- `persentase_margin` - Margin profit dalam persen
- `bulan`, `tahun` - Untuk grouping dan filtering

**Data Sample**: 40+ record transaksi dari Januari-Juli 2025

### 2. Tabel Summary: `keuntungan_layanan_summary`
**Fungsi**: Ringkasan keuntungan per jenis layanan
**Highlights**:
- Total keuntungan per layanan per tahun
- Persentase kontribusi setiap layanan
- Trend pertumbuhan (naik/turun/stabil)
- Margin profit rata-rata
- Icon dan color theme untuk UI

**Data Sample**: 6 layanan utama dengan analitik lengkap

### 3. Tabel Analytics: `keuntungan_bulanan_analytics`
**Fungsi**: Analitik mendalam per bulan
**Fitur Analitik**:
- Pertumbuhan vs bulan sebelumnya (MoM)
- Pencapaian target bulanan
- Ranking performa bulanan
- Insight otomatis berdasarkan data
- Rata keuntungan per transaksi

**Data Sample**: 12+ bulan dengan trend analysis

### 4. Tabel KPI: `keuntungan_target_kpi`
**Fungsi**: Management target dan KPI
**Metrics**:
- Target tahunan dan pencapaian
- Proyeksi akhir tahun
- Gap analysis vs target
- Identifikasi bulan terbaik/terburuk
- Rekomendasi strategis otomatis
- Status target (ahead/on_track/behind/critical)

## 🔍 VIEWS ANALITIK

### Dashboard Views
1. **`view_keuntungan_dashboard_summary`**
   - Total keuntungan tahun, bulan, hari ini
   - Layanan terlaris
   - Metrics overview untuk dashboard utama

2. **`view_keuntungan_trend_bulanan`**
   - Trend keuntungan 12 bulan terakhir
   - Growth rate dan pencapaian target
   - Ranking bulanan

3. **`view_keuntungan_distribusi_layanan`**
   - Kontribusi setiap layanan terhadap total revenue
   - Margin analysis per layanan
   - Performance comparison

### Advanced Analytics Views
4. **`view_keuntungan_top_hari`**
   - Top 10 hari dengan keuntungan tertinggi
   - Analysis per hari dalam seminggu

5. **`view_keuntungan_margin_analysis`**
   - Deep dive margin profit per layanan
   - Variasi margin dan optimasi potential

6. **`view_keuntungan_yoy_comparison`**
   - Year-over-Year comparison
   - Growth analysis antar tahun

7. **`view_keuntungan_proyeksi`**
   - Proyeksi berdasarkan trend historis
   - Moving average dan forecasting

8. **`view_keuntungan_kpi_dashboard`**
   - KPI monitoring dan target tracking
   - Performance metrics overview

9. **`view_keuntungan_insights`**
   - AI-powered insights otomatis
   - Rekomendasi berdasarkan data pattern

## 📈 FITUR UNGGULAN

### 1. Multi-Source Revenue Tracking
- Penjualan Obat (50% kontribusi)
- Konsultasi Dokter (16.67% kontribusi) 
- Pemeriksaan Cepat (11.11% kontribusi)
- Kesehatan Korporat (9.72% kontribusi)
- Vaksinasi (6.94% kontribusi)
- Alat Kesehatan & Vitamin (5.56% kontribusi)

### 2. Automated Insights
- Trend analysis otomatis
- Alert untuk pencapaian target
- Rekomendasi strategis berbasis data
- Seasonal pattern detection

### 3. Performance Benchmarking
- Target vs actual comparison
- Ranking performa bulanan
- Best/worst month identification
- YoY growth tracking

### 4. Margin Optimization
- Margin tracking per layanan
- Cost analysis dan profitability
- ROI calculation
- Efficiency metrics

## 💡 USE CASES UTAMA

### Untuk Dashboard Keuangan
```sql
-- Total keuntungan hari ini
SELECT * FROM view_keuntungan_dashboard_summary;

-- Trend 6 bulan terakhir
SELECT * FROM view_keuntungan_trend_bulanan 
WHERE tahun = 2025 ORDER BY bulan DESC LIMIT 6;
```

### Untuk Laporan Manajemen
```sql
-- KPI dan pencapaian target
SELECT * FROM view_keuntungan_kpi_dashboard;

-- Top performing services
SELECT * FROM view_keuntungan_distribusi_layanan 
ORDER BY total_keuntungan_bersih DESC;
```

### Untuk Strategic Planning
```sql
-- YoY growth analysis
SELECT * FROM view_keuntungan_yoy_comparison;

-- Insights dan rekomendasi
SELECT * FROM view_keuntungan_insights;
```

## 🎯 TARGET METRICS 2025
- Target Tahunan: **Rp 320,000,000**
- Target Bulanan Rata-rata: **Rp 26,666,667**
- Current Achievement: **98.59%** (Ahead of target)
- Projected Year-End: **Rp 380,000,000**

## 🔐 DATA CONSTRAINTS
- Keuntungan harus >= 0
- Margin 0-100%
- Bulan valid 1-12
- Tahun 2020-2050
- Relational integrity terjaga

## 🚀 OPTIMASI PERFORMA
- Index pada tanggal, sumber_keuntungan, bulan_tahun
- Views untuk query kompleks
- Automated calculations
- Efficient aggregations

Database keuntungan ini menyediakan foundation yang solid untuk financial analytics, business intelligence, dan strategic decision making di sistem klinik.
