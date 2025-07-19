<?php
/**
 * Test Script untuk Gemini AI Integration
 * Jalankan file ini untuk memastikan setup AI berjalan dengan baik
 */

require_once 'config/gemini_config.php';
require_once 'classes/GeminiInsightGenerator.php';

echo "<h2>🤖 Test Gemini AI Integration untuk Klinik</h2>\n\n";

// Test 1: Validasi Konfigurasi
echo "<h3>1. Validasi Konfigurasi</h3>\n";
$errors = validateGeminiConfig();
if (empty($errors)) {
    echo "✅ Konfigurasi valid\n\n";
} else {
    echo "❌ Error dalam konfigurasi:\n";
    foreach ($errors as $error) {
        echo "   - $error\n";
    }
    echo "\n";
}

// Test 2: Cek AI Status
echo "<h3>2. Status AI</h3>\n";
if (isAIEnabled()) {
    echo "✅ API Key Gemini sudah dikonfigurasi\n";
} else {
    echo "⚠️  API Key Gemini belum dikonfigurasi (akan menggunakan fallback)\n";
}
echo "📁 Cache file: " . getCacheFilePath() . "\n";
echo "⏰ Cache duration: " . CACHE_DURATION . " detik\n\n";

// Test 3: Test Cache System
echo "<h3>3. Test Cache System</h3>\n";
if (shouldUseCache()) {
    echo "✅ Cache tersedia dan masih fresh\n";
} else {
    echo "📝 Cache kosong atau expired (normal untuk first run)\n";
}
echo "\n";

// Test 4: Test Fallback Insights
echo "<h3>4. Test Fallback Insights</h3>\n";
$generator = new GeminiInsightGenerator();

$sampleData = [
    'dokter_aktif' => 5,
    'pemeriksaan_selesai' => 150,
    'total_pasien' => 500,
    'keuntungan_tahun' => 500000000,
    'pengeluaran_tahun' => 300000000,
    'obat_kritis' => 3
];

echo "🔮 Testing operational insight:\n";
$operationalInsight = $generator->generateInsight('operational', ['data' => 'Test data']);
echo "   → $operationalInsight\n\n";

echo "💰 Testing financial insight:\n";
$financialInsight = $generator->generateInsight('financial', [
    'keuntungan' => '500.000.000',
    'pengeluaran' => '300.000.000',
    'trend' => 'stabil'
]);
echo "   → $financialInsight\n\n";

// Test 5: Test Format Template
echo "<h3>5. Test Template System</h3>\n";
$templates = PROMPT_TEMPLATES;
foreach ($templates as $type => $template) {
    echo "📝 Template $type: " . substr($template, 0, 80) . "...\n";
}
echo "\n";

// Test 6: Rekomendasi Setup
echo "<h3>6. Langkah Selanjutnya</h3>\n";
if (!isAIEnabled()) {
    echo "🔧 <strong>PENTING:</strong> Untuk mengaktifkan AI, ikuti langkah berikut:\n";
    echo "   1. Buka Google AI Studio: https://makersuite.google.com/\n";
    echo "   2. Buat API Key untuk Gemini\n";
    echo "   3. Edit file: ai-insights/config/gemini_config.php\n";
    echo "   4. Ganti 'GANTI_DENGAN_API_KEY_ANDA_DISINI' dengan API Key Anda\n";
    echo "   5. Refresh halaman ini untuk test ulang\n\n";
}

echo "📋 Setup sudah siap untuk integrasi ke dashboard!\n";
echo "🔄 Silakan lanjut ke langkah berikutnya: integrasi ke index.php\n\n";

// Performance info
echo "<hr>\n";
echo "<small>Generated on: " . date('Y-m-d H:i:s') . "</small>\n";
echo "<small> | Cache file size: " . (file_exists(getCacheFilePath()) ? filesize(getCacheFilePath()) . ' bytes' : '0 bytes') . "</small>\n";
?>
