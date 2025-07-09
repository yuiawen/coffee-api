<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class JwtAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // --- PERBAIKAN ---
        // Gunakan env() untuk mengambil nilai dari file .env
        $secret = env('JWT_SECRET');

        // Log untuk debugging (ini sudah bagus)
        log_message('debug', 'JWT_SECRET=' . ($secret ?: 'NULL'));

        $authHeader = $request->getHeaderLine('Authorization');
        log_message('debug', 'Auth Header=' . $authHeader);

        if (empty($authHeader) || ! preg_match('/Bearer\s(\S+)/', $authHeader, $m)) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['error'=>'Unauthorized']);
        }

        $token = $m[1];

        try {
            // Logika decode Anda sudah benar menggunakan 'new Key'
            $payload = JWT::decode($token, new Key($secret, 'HS256'));
            $request->user = $payload;

        } catch (\Throwable $e) {
            log_message('error', 'JWT decode error: '.$e->getMessage());
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['error'=>'Invalid or expired token']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu ada kode di sini
    }
}