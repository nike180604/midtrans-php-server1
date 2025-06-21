<?php
$server_key = 'SB-Mid-server-ojDn7cgXmlrJSOFIaZeji6wv';
$is_production = false;
$api_url = $is_production ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

if (!strpos($_SERVER['REQUEST_URI'], '/charge') || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(404);
    echo json_encode(["error" => "Wrong path or method"]);
    exit();
}

$request_body = file_get_contents('php://input');
header('Content-Type: application/json');
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Basic ' . base64_encode($server_key . ':')
    ],
    CURLOPT_POSTFIELDS => $request_body
]);
$body = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
http_response_code($code);
echo $body;
