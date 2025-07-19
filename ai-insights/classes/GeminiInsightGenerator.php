<?php
/**
 * GeminiInsightGenerator - Class untuk menghasilkan AI insights menggunakan Gemini API
 * Terintegrasi dengan sistem klinik PHP
 */

require_once __DIR__ . '/../config/gemini_config.php';

class GeminiInsightGenerator {
    private $apiKey;
    private $apiUrl;
    private $cacheFile;
    
    public function __construct() {
        $this->apiKey = GEMINI_API_KEY;
        $this->apiUrl = GEMINI_API_URL;
        $this->cacheFile = getCacheFilePath();
        
        // Validasi konfigurasi
        $errors = validateGeminiConfig();
        if (!empty($errors)) {
            error_log('Gemini Config Errors: ' . implode(', ', $errors));
        }
    }
    
    /**
     * Generate single insight berdasarkan tipe dan data
     */
    public function generateInsight($type, $data) {
        try {
            // Cek cache terlebih dahulu
            if (shouldUseCache()) {
                $cached = $this->getCachedInsight($type);
                if ($cached) {
                    return $cached;
                }
            }
            
            // Jika API tidak dikonfigurasi, gunakan fallback
            if (!isAIEnabled()) {
                return $this->getFallbackInsight($type, $data);
            }
            
            // Siapkan prompt
            $prompt = $this->preparePrompt($type, $data);
            
            // Kirim request ke Gemini
            $response = $this->callGeminiAPI($prompt);
            
            // Cache hasil
            $this->cacheInsight($type, $response);
            
            return $response;
            
        } catch (Exception $e) {
            error_log('Gemini API Error: ' . $e->getMessage());
            return $this->getFallbackInsight($type, $data);
        }
    }
    
    /**
     * Generate semua insights sekaligus
     */
    public function generateAllInsights($clinicData) {
        $insights = [];
        
        $insightTypes = [
            'operational' => $this->prepareOperationalData($clinicData),
            'financial' => $this->prepareFinancialData($clinicData),
            'predictive' => $this->preparePredictiveData($clinicData),
            'patient_flow' => $this->preparePatientFlowData($clinicData),
            'inventory' => $this->prepareInventoryData($clinicData)
        ];
        
        foreach ($insightTypes as $type => $data) {
            $insights[$type] = $this->generateInsight($type, $data);
        }
        
        return $insights;
    }
    
    /**
     * Siapkan prompt berdasarkan template dan data
     */
    private function preparePrompt($type, $data) {
        // Jika $type adalah string custom (bukan template default), gunakan langsung sebagai prompt
        $defaultTypes = ['operational', 'financial', 'predictive', 'patient_flow', 'inventory'];
        if (!in_array($type, $defaultTypes)) {
            // $type adalah prompt custom
            $template = $type;
        } else {
            $template = getPromptTemplate($type);
            // Replace placeholders dengan data aktual
            foreach ($data as $key => $value) {
                $placeholder = '{' . $key . '}';
                $template = str_replace($placeholder, $value, $template);
            }
        }
        return $template;
    }
    
    /**
     * Kirim request ke Gemini API
     */
    private function callGeminiAPI($prompt) {
        $requestData = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => TEMPERATURE,
                'maxOutputTokens' => MAX_TOKENS,
                'topP' => 0.8,
                'topK' => 40
            ]
        ];
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->apiUrl . '?key=' . $this->apiKey,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($requestData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
            CURLOPT_TIMEOUT => API_TIMEOUT,
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            throw new Exception('CURL Error: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception('API Error: HTTP ' . $httpCode);
        }
        
        $decodedResponse = json_decode($response, true);
        
        if (!isset($decodedResponse['candidates'][0]['content']['parts'][0]['text'])) {
            throw new Exception('Invalid API response format');
        }
        
        return trim($decodedResponse['candidates'][0]['content']['parts'][0]['text']);
    }
    
    /**
     * Cache insight hasil
     */
    private function cacheInsight($type, $insight) {
        $cache = [];
        if (file_exists($this->cacheFile)) {
            $cache = json_decode(file_get_contents($this->cacheFile), true) ?: [];
        }
        
        $cache[$type] = [
            'insight' => $insight,
            'timestamp' => time()
        ];
        
        file_put_contents($this->cacheFile, json_encode($cache));
    }
    
    /**
     * Ambil cached insight
     */
    private function getCachedInsight($type) {
        if (!file_exists($this->cacheFile)) {
            return null;
        }
        
        $cache = json_decode(file_get_contents($this->cacheFile), true);
        
        if (isset($cache[$type]) && (time() - $cache[$type]['timestamp']) < CACHE_DURATION) {
            return $cache[$type]['insight'];
        }
        
        return null;
    }
    
    /**
     * Fallback insights jika AI tidak tersedia
     */
    private function getFallbackInsight($type, $data) {
        $fallbacks = [
            'operational' => 'Sistem beroperasi normal. Pertimbangkan optimasi jadwal dokter pada jam sibuk untuk mengurangi waktu tunggu pasien.',
            'financial' => 'Kondisi keuangan stabil. Lakukan evaluasi pengeluaran bulanan untuk identifikasi area penghematan.',
            'predictive' => 'Monitor stok obat secara berkala untuk mencegah kehabisan stok. Perhatikan tren kunjungan pasien mingguan.',
            'patient_flow' => 'Alur pasien berjalan lancar. Tingkatkan sistem antrian digital untuk pengalaman pasien yang lebih baik.',
            'inventory' => 'Kelola inventori dengan sistem FIFO. Lakukan stock opname rutin setiap akhir bulan.'
        ];
        
        return isset($fallbacks[$type]) ? $fallbacks[$type] : $fallbacks['operational'];
    }
    
    /**
     * Prepare data methods untuk berbagai tipe insight
     */
    private function prepareOperationalData($data) {
        return [
            'data' => sprintf(
                'Dokter aktif: %d, Pemeriksaan selesai: %d, Pasien hari ini: %d',
                $data['dokter_aktif'] ?? 0,
                $data['pemeriksaan_selesai'] ?? 0,
                $data['pasien_hari_ini'] ?? 0
            )
        ];
    }
    
    private function prepareFinancialData($data) {
        return [
            'keuntungan' => number_format($data['keuntungan_tahun'] ?? 0, 0, ',', '.'),
            'pengeluaran' => number_format($data['pengeluaran_tahun'] ?? 0, 0, ',', '.'),
            'trend' => $this->calculateTrend($data['tren_7_hari'] ?? [])
        ];
    }
    
    private function preparePredictiveData($data) {
        return [
            'metrics' => sprintf(
                'Obat kritis: %d, Trend pasien 7 hari: %s, Diagnosis tertinggi: %s',
                $data['obat_kritis'] ?? 0,
                $this->formatTrend($data['tren_7_hari']['pasien'] ?? []),
                $data['diagnosa_tertinggi']['diagnosa'] ?? 'Tidak ada data'
            )
        ];
    }
    
    private function preparePatientFlowData($data) {
        return [
            'total_pasien' => $data['total_pasien'] ?? 0,
            'pasien_baru' => $data['pasien_baru_bulan'] ?? 0,
            'pemeriksaan' => $data['pemeriksaan_selesai'] ?? 0
        ];
    }
    
    private function prepareInventoryData($data) {
        return [
            'obat_kritis' => $data['obat_kritis'] ?? 0,
            'total_obat' => $data['total_obat'] ?? 0
        ];
    }
    
    private function calculateTrend($trendData) {
        if (empty($trendData['keuntungan']) || count($trendData['keuntungan']) < 2) {
            return 'stabil';
        }
        
        $recent = array_slice($trendData['keuntungan'], -3);
        $avg = array_sum($recent) / count($recent);
        $last = end($recent);
        
        if ($last > $avg * 1.1) return 'meningkat';
        if ($last < $avg * 0.9) return 'menurun';
        return 'stabil';
    }
    
    private function formatTrend($data) {
        if (empty($data) || count($data) < 2) {
            return 'data tidak cukup';
        }
        
        $first = $data[0];
        $last = end($data);
        
        if ($last > $first) return 'meningkat';
        if ($last < $first) return 'menurun';
        return 'stabil';
    }
}
?>
