<?php
// Izinkan akses dari origin frontend Anda
header("Access-Control-Allow-Origin: http://localhost:8000");
// Izinkan semua header yang umum digunakan
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
// Izinkan semua metode yang umum digunakan
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
// Izinkan pengiriman kredensial (seperti cookie atau header Authorization)
header("Access-Control-Allow-Credentials: true");

// Jika ini adalah preflight request (OPTIONS), kirim respons OK dan hentikan script
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Jika bukan preflight, kirim respons JSON sederhana
http_response_code(200);
echo json_encode(['status' => 'success', 'message' => 'Test CORS berhasil!']);
?>