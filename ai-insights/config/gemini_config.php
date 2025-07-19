<?php
/**
 * Konfigurasi Gemini AI untuk Sistem Klinik
 * Dibuat untuk integrasi AI Insights pada dashboard
 */

// ===== KONFIGURASI GEMINI API =====
<<<<<<< HEAD
define('GEMINI_API_KEY', 'AIzaSyDrIVvYfs3WBnmlD7v9Hnn3Oi-OTRCZBD0');
=======
define('GEMINI_API_KEY', 'AIzaSyBoNULmbCHw1DOVWyEXZbFi-ILjyWD4-O4');
>>>>>>> f706d57de93ab7aa35703a147589c57671771ff3
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent');

// ===== KONFIGURASI CACHE =====
define('CACHE_DURATION', 1800); // 30 menit cache untuk menghemat API calls
define('CACHE_FILE_PATH', __DIR__ . '/../cache/insights_cache.json');

// ===== KONFIGURASI AI RESPONSE =====
define('MAX_TOKENS', 150); // Maksimal token untuk response singkat
define('TEMPERATURE', 0.7); // Kreativitas AI (0.0 - 1.0)

// ===== KONFIGURASI BAHASA & FORMAT =====
define('AI_LANGUAGE', 'Indonesian');
define('RESPONSE_FORMAT', 'casual_professional'); // casual_professional, formal, friendly

// ===== KONFIGURASI ERROR HANDLING =====
define('ENABLE_FALLBACK', true); // Jika true, gunakan insights statis saat AI gagal
define('API_TIMEOUT', 10); // Timeout dalam detik
define('MAX_RETRY_ATTEMPTS', 2); // Maksimal percobaan ulang

// ===== KONFIGURASI KEAMANAN =====
define('ENABLE_DATA_SANITIZATION', true); // Sanitasi data sebelum dikirim ke AI
define('LOG_AI_REQUESTS', true); // Log semua request AI untuk monitoring

// ===== TEMPLATES PROMPT =====
define('PROMPT_TEMPLATES', [
    'operational' => 'Berdasarkan data operasional klinik berikut: {data}, analisis penyebab utama masalah yang muncul dan berikan 2 rekomendasi tindakan nyata yang bisa langsung dilakukan oleh manajemen klinik. Jawab dengan bahasa Indonesia yang jelas dan ringkas.',
    
    'financial' => 'Analisis data keuangan klinik: Keuntungan tahun ini Rp{keuntungan}, Pengeluaran Rp{pengeluaran}, Trend {trend}. Sebutkan masalah utama dan berikan 2 rekomendasi strategis yang bisa langsung dijalankan untuk meningkatkan efisiensi keuangan klinik.',
    
    'predictive' => 'Data klinik menunjukkan: {metrics}. Identifikasi risiko utama dan berikan 2 solusi preventif yang konkret dan bisa langsung diterapkan oleh tim klinik.',
    
    'patient_flow' => 'Data pasien: Total {total_pasien}, Baru bulan ini {pasien_baru}, Pemeriksaan selesai {pemeriksaan}. Analisis pola kunjungan, sebutkan masalah utama, dan berikan 2 rekomendasi nyata untuk meningkatkan layanan pasien.',
    
    'inventory' => 'Data inventori obat: {obat_kritis} obat dalam status kritis, Total obat aktif {total_obat}. Analisis penyebab stok kritis dan berikan 2 strategi manajemen stok yang bisa langsung dijalankan oleh bagian farmasi klinik.'
]);

// ===== VALIDASI KONFIGURASI =====
function validateGeminiConfig() {
    $errors = [];
    
    if (GEMINI_API_KEY === 'GANTI_DENGAN_API_KEY_ANDA_DISINI' || empty(GEMINI_API_KEY)) {
        $errors[] = 'API Key Gemini belum dikonfigurasi. Silakan atur GEMINI_API_KEY di file ini.';
    }
    
    if (!is_dir(dirname(CACHE_FILE_PATH))) {
        $errors[] = 'Direktori cache tidak ditemukan: ' . dirname(CACHE_FILE_PATH);
    }
    
    if (!is_writable(dirname(CACHE_FILE_PATH))) {
        $errors[] = 'Direktori cache tidak dapat ditulis: ' . dirname(CACHE_FILE_PATH);
    }
    
    return $errors;
}

// ===== HELPER FUNCTIONS =====
function getPromptTemplate($type) {
    $templates = PROMPT_TEMPLATES;
    return isset($templates[$type]) ? $templates[$type] : $templates['operational'];
}

function isAIEnabled() {
    return GEMINI_API_KEY !== 'GANTI_DENGAN_API_KEY_ANDA_DISINI' && !empty(GEMINI_API_KEY);
}

function getCacheFilePath() {
    return CACHE_FILE_PATH;
}

function shouldUseCache() {
    if (!file_exists(CACHE_FILE_PATH)) {
        return false;
    }
    
    $cacheTime = filemtime(CACHE_FILE_PATH);
    return (time() - $cacheTime) < CACHE_DURATION;
}

?>
