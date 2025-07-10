# DATABASE PENGELUARAN - DOKUMENTASI LENGKAP

## 💰 OVERVIEW SISTEM PENGELUARAN
Database pengeluaran dirancang untuk mendukung manajemen keuangan yang komprehensif, tracking semua pengeluaran operasional, vendor management, budget planning, dan cash flow analysis.

## 🏗️ STRUKTUR TABEL

### 1. Tabel Utama: `pengeluaran`
**Fungsi**: Menyimpan data transaksi pengeluaran harian
**Kolom Utama**:
- `id` - Primary key auto increment
- `tanggal` - Tanggal transaksi pengeluaran
- `kategori_pengeluaran` - Enum: Obat & Alkes, Gaji Karyawan, Operasional, Peralatan, Promosi, Lain-lain
- `sub_kategori` - Detail spesifik kategori
- `jumlah` - Nilai pengeluaran
- `vendor_supplier` - Nama vendor/supplier
- `status_pembayaran` - Pending/Paid/Cancelled/Overdue
- `metode_pembayaran` - Cash/Transfer/Cheque/Credit
- `tanggal_jatuh_tempo` & `tanggal_bayar` - Payment tracking

**Data Sample**: 28+ transaksi dari Januari-Juli 2025

### 2. Tabel Analytics: `pengeluaran_kategori_analytics`
**Fungsi**: Analitik mendalam per kategori pengeluaran
**Highlights**:
- Total pengeluaran per kategori per tahun
- Persentase kontribusi setiap kategori
- Trend pertumbuhan (naik/turun/stabil)
- Vendor utama per kategori
- Bulan tertinggi dan terendah
- Icon dan color theme untuk UI

**Data Sample**: 7 kategori dengan analitik lengkap

### 3. Tabel Summary: `pengeluaran_bulanan_summary`
**Fungsi**: Ringkasan pengeluaran bulanan
**Fitur Analytics**:
- Pertumbuhan vs bulan sebelumnya (MoM)
- Status budget (under/on/over budget)
- Variance analysis vs budget
- Kategori pengeluaran terbesar
- Insight otomatis berdasarkan data

**Data Sample**: 7 bulan dengan trend analysis

### 4. Tabel Vendor: `pengeluaran_vendor_analytics`
**Fungsi**: Management dan analytics vendor/supplier
**Metrics**:
- Performance rating vendor
- Total pembelian dan frekuensi transaksi
- Payment terms dan contract status
- Contact information lengkap
- Notes dan evaluasi performance

**Data Sample**: 11+ vendor dengan data lengkap

### 5. Tabel Budget: `pengeluaran_budget_planning`
**Fungsi**: Budget planning dan monitoring
**Features**:
- Budget tahunan per kategori
- Realisasi vs target tracking
- Variance analysis
- Status budget dengan alert system
- Rekomendasi aksi berdasarkan performance
- PIC responsible untuk setiap kategori

## 🔍 VIEWS ANALITIK

### Dashboard Views
1. **`view_pengeluaran_dashboard_summary`**
   - Total pengeluaran tahun, bulan, hari ini
   - Kategori terbesar
   - Metrics overview untuk dashboard utama

2. **`view_pengeluaran_trend_bulanan`**
   - Trend pengeluaran 12 bulan terakhir
   - Growth rate dan status budget
   - Variance monitoring

3. **`view_pengeluaran_distribusi_kategori`**
   - Kontribusi setiap kategori terhadap total pengeluaran
   - Range analysis per kategori
   - Performance comparison

### Advanced Analytics Views
4. **`view_pengeluaran_top_vendor`**
   - Top 15 vendor berdasarkan nilai transaksi
   - Status pembayaran tracking

5. **`view_pengeluaran_status_pembayaran`**
   - Analysis status pembayaran
   - Overdue tracking dan amount
   - Payment efficiency metrics

6. **`view_pengeluaran_metode_pembayaran`**
   - Preferensi metode pembayaran
   - Success rate per metode
   - Usage distribution

7. **`view_pengeluaran_cash_flow_harian`**
   - Daily cash flow tracking
   - Breakdown per kategori harian

8. **`view_pengeluaran_budget_monitoring`**
   - Real-time budget monitoring
   - Variance tracking per kategori
   - Alert system untuk over budget

9. **`view_pengeluaran_vendor_performance`**
   - Comprehensive vendor evaluation
   - Contract dan payment tracking
   - Performance scoring

10. **`view_pengeluaran_forecasting`**
    - Expense forecasting berdasarkan trend
    - MoM dan YoY growth analysis
    - Moving average untuk prediction

11. **`view_pengeluaran_insights`**
    - AI-powered insights otomatis
    - Budget status alerts
    - Vendor concentration analysis
    - Payment efficiency reporting

## 📈 FITUR UNGGULAN

### 1. Multi-Category Expense Tracking
- **Obat & Alkes** (50% total pengeluaran)
- **Gaji Karyawan** (39.61% total pengeluaran)
- **Operasional** (6.32% total pengeluaran)
- **Peralatan** (1.84% total pengeluaran)
- **Promosi** (0.53% total pengeluaran)
- **Lain-lain** (0.39% total pengeluaran)

### 2. Budget Management System
- Real-time budget vs actual tracking
- Alert system untuk over budget
- Variance analysis dan forecasting
- Budget planning per kategori
- PIC assignment untuk accountability

### 3. Vendor Management
- Comprehensive vendor database
- Performance rating system
- Contract dan payment terms tracking
- Vendor concentration analysis
- Contact management terintegrasi

### 4. Payment Management
- Multi-method payment tracking
- Due date dan overdue monitoring
- Payment efficiency analysis
- Cash flow management
- Invoice tracking system

## 💡 USE CASES UTAMA

### Untuk Dashboard Keuangan
```sql
-- Total pengeluaran hari ini
SELECT * FROM view_pengeluaran_dashboard_summary;

-- Trend 6 bulan terakhir
SELECT * FROM view_pengeluaran_trend_bulanan 
WHERE tahun = 2025 ORDER BY bulan DESC LIMIT 6;
```

### Untuk Budget Monitoring
```sql
-- Status budget real-time
SELECT * FROM view_pengeluaran_budget_monitoring;

-- Kategori over budget
SELECT * FROM view_pengeluaran_budget_monitoring 
WHERE status_budget = 'over_budget';
```

### Untuk Vendor Management
```sql
-- Top performing vendors
SELECT * FROM view_pengeluaran_vendor_performance 
ORDER BY total_pembelian_tahun DESC;

-- Vendor dengan outstanding payment
SELECT * FROM view_pengeluaran_top_vendor 
WHERE transaksi_pending > 0;
```

### Untuk Financial Analysis
```sql
-- Cash flow analysis
SELECT * FROM view_pengeluaran_cash_flow_harian 
WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 30 DAY);

-- Expense forecasting
SELECT * FROM view_pengeluaran_forecasting;
```

## 🎯 BUDGET METRICS 2025

### Budget vs Actual
- **Obat & Alkes**: Rp 190jt/300jt (63.33% - Over Budget)
- **Gaji Karyawan**: Rp 150.5jt/180jt (83.61% - On Track)
- **Operasional**: Rp 24jt/60jt (40% - Under Budget)
- **Peralatan**: Rp 7jt/30jt (23.33% - Under Budget)
- **Promosi**: Rp 2jt/24jt (8.33% - Under Budget)
- **Lain-lain**: Rp 1.5jt/12jt (12.5% - Under Budget)

### Vendor Performance
- **PT Pharma Medika**: Supplier utama (Rp 120jt, Rating: Excellent)
- **Gaji Staff**: Second largest expense (Rp 150.5jt)
- **Payment Efficiency**: 89.3% transaksi telah dibayar

## 🔐 DATA CONSTRAINTS & VALIDATION
- Pengeluaran harus >= 0
- Bulan valid 1-12
- Tahun 2020-2050
- Tanggal bayar >= tanggal transaksi
- Status pembayaran validation
- Method pembayaran validation

## 🚀 OPTIMASI PERFORMA
- Index pada tanggal, kategori, vendor, status
- Views untuk query kompleks
- Automated calculations
- Efficient aggregations
- Budget alert system

## 📊 DASHBOARD INTEGRATION
- Real-time expense monitoring
- Budget variance alerts
- Vendor performance tracking
- Payment due date reminders
- Cash flow forecasting
- Automated insights generation

Database pengeluaran ini menyediakan foundation yang solid untuk financial management, budget control, vendor relationship management, dan strategic financial planning di sistem klinik.
