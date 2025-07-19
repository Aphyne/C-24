# 🤖 AI Insights Integration - Sistem Klinik

Modul ini mengintegrasikan Gemini AI untuk menghasilkan insights cerdas pada dashboard klinik.

## 📁 Struktur Folder

```
ai-insights/
├── config/
│   └── gemini_config.php          # Konfigurasi API dan settings
├── classes/
│   └── GeminiInsightGenerator.php # Class utama AI generator
├── cache/
│   └── insights_cache.json        # Cache insights (auto-generated)
└── test_ai_setup.php              # Script test setup
```

## 🚀 Quick Start

### 1. Setup API Key
1. Buka [Google AI Studio](https://makersuite.google.com/)
2. Buat API Key untuk Gemini
3. Edit `config/gemini_config.php`
4. Ganti `GANTI_DENGAN_API_KEY_ANDA_DISINI` dengan API Key Anda

### 2. Test Setup
Jalankan: `http://localhost/KlinikPHP-main/ai-insights/test_ai_setup.php`

### 3. Integrasi ke Dashboard
Tambahkan kode berikut ke `index.php` setelah bagian `// ==== INSIGHT & NOTIFIKASI ====`:

```php
// ==== AI INSIGHTS INTEGRATION ====
require_once 'ai-insights/config/gemini_config.php';
require_once 'ai-insights/classes/GeminiInsightGenerator.php';

// Prepare data for AI
$clinicMetrics = [
    'keuntungan_tahun' => $keuntunganTahunIni,
    'pengeluaran_tahun' => $pengeluaranTahunIni,
    'total_pasien' => $totalPasien,
    'pasien_baru_bulan' => $pasienBaruBulanIni,
    'obat_kritis' => $jumlahObatKritis,
    'dokter_aktif' => $dokterAktif,
    'pemeriksaan_selesai' => $pemeriksaanSelesai,
    'tren_7_hari' => $dataTren7Hari,
    'diagnosa_tertinggi' => $diagnosaTertinggi
];

// Generate AI Insights
$aiInsights = [];
if (isAIEnabled()) {
    try {
        $gemini = new GeminiInsightGenerator();
        $aiInsights = $gemini->generateAllInsights($clinicMetrics);
    } catch (Exception $e) {
        error_log('AI Error: ' . $e->getMessage());
        $aiInsights = null;
    }
}
```

## ⚙️ Konfigurasi

### Pengaturan Cache
- `CACHE_DURATION`: Durasi cache (default: 30 menit)
- `CACHE_FILE_PATH`: Lokasi file cache

### Pengaturan AI
- `MAX_TOKENS`: Maksimal token response (default: 150)
- `TEMPERATURE`: Kreativitas AI 0.0-1.0 (default: 0.7)
- `API_TIMEOUT`: Timeout request (default: 10 detik)

### Safety Features
- ✅ **Fallback System**: Jika AI gagal, gunakan insights statis
- ✅ **Cache System**: Menghemat API calls
- ✅ **Error Handling**: Robust error handling
- ✅ **Data Sanitization**: Membersihkan data sebelum dikirim ke AI

## 🔧 Troubleshooting

### AI Tidak Berfungsi
1. Pastikan API Key sudah benar
2. Cek koneksi internet
3. Periksa log error di browser console
4. Jalankan `test_ai_setup.php` untuk diagnosis

### Cache Issues
1. Hapus file `cache/insights_cache.json`
2. Pastikan folder cache writable (chmod 755)

### Performance
- Cache akan otomatis refresh setiap 30 menit
- Fallback insights akan ditampilkan jika AI lambat (>10 detik)

## 📊 Jenis Insights yang Dihasilkan

1. **Operational**: Optimasi operasional harian
2. **Financial**: Analisis keuangan dan trend
3. **Predictive**: Prediksi risiko dan solusi preventif
4. **Patient Flow**: Analisis alur pasien
5. **Inventory**: Manajemen stok obat

## 🔐 Keamanan

- Data klinik di-sanitasi sebelum dikirim ke AI
- API Key tersimpan aman di config file
- Cache disimpan lokal (tidak ada data sensitif di cloud)
- Timeout protection untuk mencegah hanging requests

## 📝 Logging

Semua aktivitas AI dicatat di:
- PHP Error Log (untuk errors)
- Cache file (untuk successful insights)

## 🚀 Update & Maintenance

### Update Template Prompts
Edit `PROMPT_TEMPLATES` di `config/gemini_config.php`

### Update AI Model
Ganti `GEMINI_API_URL` ke model terbaru

### Clear Cache
Hapus `cache/insights_cache.json` untuk force refresh

---

**Dibuat untuk Sistem Klinik PHP**  
*Powered by Google Gemini AI*
