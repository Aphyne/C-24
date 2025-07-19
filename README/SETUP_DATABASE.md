# 🚀 Panduan Setup Database Pengeluaran

## Langkah 1: Import Database
1. Buka **phpMyAdmin** di `http://localhost/phpmyadmin`
2. Buat database baru bernama `clinic` (jika belum ada)
3. Pilih database `clinic`
4. Klik tab **Import**
5. Pilih file `clinic.sql`
6. Klik **Go** untuk import

## Langkah 2: Verifikasi Data
1. Akses `http://localhost/xampp/htdocs/KlinikPHP-main/test_pengeluaran.php`
2. Pastikan muncul data pengeluaran
3. Harus ada data tahun 2024 dengan berbagai kategori

## Langkah 3: Akses Dashboard
1. Login ke sistem dengan admin
2. Akses menu **Pengeluaran** 
3. Data akan muncul dari database

## ⚠️ Troubleshooting

### Jika tidak ada data yang muncul:
1. **Cek koneksi database** di `koneksi.php`
2. **Pastikan database name = 'clinic'**
3. **Import ulang file clinic.sql**
4. **Cek error di browser console**

### Jika error "Table doesn't exist":
```sql
USE clinic;
SHOW TABLES;
```
Pastikan tabel `pengeluaran` ada dalam list.

### Jika data kosong:
```sql
SELECT COUNT(*) FROM pengeluaran;
```
Harus return > 0

## 📊 Expected Output
- **Total Pengeluaran 2024**: ~Rp 572,300,000
- **Kategori Terbesar**: Gaji Staff, Obat-obatan
- **Jumlah Transaksi**: 22 records
- **Grafik**: Menampilkan data per bulan
- **Pie Chart**: Distribusi per kategori

## 🔧 File yang Dimodifikasi
- `clinic.sql` - Added CREATE DATABASE
- `pembayaran.php` - Integrated with database
- `test_pengeluaran.php` - Testing script
