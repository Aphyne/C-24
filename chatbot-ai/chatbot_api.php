<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'] ?? '';
    $apiKey = 'AIzaSyBoNULmbCHw1DOVWyEXZbFi-ILjyWD4-O4';
$url = 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key=' . $apiKey;

    $data = [
        'contents' => [
            ['parts' => [['text' => $message]]]
        ]
    ];


    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15); // timeout 15 detik
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7); // timeout koneksi 7 detik
    $result = curl_exec($ch);
    $curlErr = curl_error($ch);
    curl_close($ch);

    $response = json_decode($result, true);
    if ($curlErr) {
        echo "Maaf, terjadi kesalahan koneksi ke server AI.<br>Error: " . htmlspecialchars($curlErr);
    } elseif (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
        echo nl2br(htmlspecialchars($response['candidates'][0]['content']['parts'][0]['text']));
    } else {
        echo "Maaf, terjadi kesalahan atau jawaban tidak tersedia.<br>";
        if (isset($response['error']['message'])) {
            echo 'Error: ' . htmlspecialchars($response['error']['message']);
        } else {
            echo 'Raw response: ' . htmlspecialchars($result);
        }
    }
}
?>
