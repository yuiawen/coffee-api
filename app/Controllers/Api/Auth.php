<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AdminModel;
use Firebase\JWT\JWT;

class Auth extends ResourceController
{
    protected $format = 'json';

    // app/Controllers/Api/Auth.php

public function login()
{
    $json = $this->request->getJSON(true);
    if (!isset($json['username'], $json['password'])) {
        return $this->failValidationErrors('Username & password required');
    }

    $model = new AdminModel();
    $admin = $model->where('username', $json['username'])->first();

    // --- MULAI BLOK DEBUGGING ---
    // Cek apakah admin ditemukan
    if ($admin) {
        // Jika admin ditemukan, catat semua data penting ke file log
        log_message('error', '================== DEBUG LOGIN ==================');
        log_message('error', 'Username dari Frontend: ' . $json['username']);
        log_message('error', 'Password dari Frontend: ' . $json['password']);
        log_message('error', 'Hash dari Database: ' . $admin['password']);

        // Catat hasil dari password_verify()
        $verifikasiBerhasil = password_verify($json['password'], $admin['password']);
        log_message('error', 'Hasil password_verify(): ' . ($verifikasiBerhasil ? 'BENAR' : 'SALAH'));
        log_message('error', '===============================================');
    } else {
        log_message('error', 'Admin dengan username "' . $json['username'] . '" tidak ditemukan di database.');
    }
    // --- AKHIR BLOK DEBUGGING ---

    if (! $admin || ! password_verify($json['password'], $admin['password'])) {
        return $this->fail('Invalid credentials', 401);
    }

    // ... sisa kode untuk membuat token JWT
    $now   = time();
    $exp   = $now + (int)env('JWT_EXPIRE');
    $payload = [
        'iss' => env('JWT_ISSUER'),
        'aud' => env('JWT_AUDIENCE'),
        'iat' => $now,
        'nbf' => $now,
        'exp' => $exp,
        'uid' => $admin['id'],
        'usr' => $admin['username'],
    ];

    $token = \Firebase\JWT\JWT::encode($payload, env('JWT_SECRET'), 'HS256');

    return $this->respond([
        'access_token' => $token,
        'token_type'   => 'Bearer',
        'expires_in'   => $exp - $now,
    ]);
}

    public function register()
    {
        $json = $this->request->getJSON(true);
        // Validasi basic
        if (empty($json['username']) || empty($json['password'])) {
            return $this->failValidationErrors('Username & password wajib diisi');
        }

        $model = new AdminModel();
        // Cek duplikat username
        if ($model->where('username', $json['username'])->first()) {
            return $this->fail('Username sudah terdaftar', 409);
        }

        // Hash password dan simpan
        $data = [
            'username' => $json['username'],
            'password' => password_hash($json['password'], PASSWORD_DEFAULT),
        ];

        $model->insert($data);
        return $this->respondCreated([
            'message'  => 'Register berhasil',
            'username' => $json['username']
        ]);
    }
    
}
