<?php
header("Access-Control-Allow-Origin: *");
$ean = preg_replace('/[^0-9]/', '', $_GET['ean'] ?? '');
if (!$ean) {
    http_response_code(400);
    echo json_encode(['erro' => 'EAN não informado.']);
    exit;
}

$url = "http://www.eanpictures.com.br:9000/api/gtin/{$ean}";

// Faz download direto do binário
$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 20,
]);
$data = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

if ($httpCode != 200 || !$data) {
    http_response_code(404);
    echo json_encode(['erro' => "Imagem não encontrada ({$httpCode})"]);
    exit;
}

header("Content-Type: {$contentType}");
echo $data;
