<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        // 1. Ambil input nim dan password dari request
        $nim = $this->request->getVar('nim');
        $password = $this->request->getVar('password');

        if (!$nim || !$password) {
            return $this->fail('NIM dan Password harus diisi.', 400);
        }

        $userModel = new UserModel();

        // 2. Cari user berdasarkan NIM, join dengan tabel roles untuk mendapatkan nama peran
        $user = $userModel
            ->select('users.*, roles.role_name')
            ->join('roles', 'roles.id = users.role_id', 'left') // LEFT JOIN untuk jaga-jaga jika role_id null
            ->where('nim', $nim)
            ->first();

        // 3. Verifikasi user dan password
        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('NIM atau Password salah');
        }

        // 4. Buat payload untuk JWT
        $key = getenv('JWT_SECRET_KEY');
        $iat = time();
        $exp = $iat + 3600; // Token berlaku 1 jam

        $payload = [
            'iat'   => $iat,
            'exp'   => $exp,
            'uid'   => $user['id'],
            'nim'   => $user['nim'],
            'name'  => $user['name'],
            'role'  => $user['role_name'] ?? 'guest', // Mengambil role_name dari hasil JOIN
        ];

        // 5. Generate token dan kirim response
        $token = JWT::encode($payload, $key, 'HS256');

        return $this->respond([
            'message' => 'Login Berhasil',
            'token'   => $token,
            'user'    => [ // Kirim juga info user agar frontend bisa langsung pakai
                'id'   => $user['id'],
                'nim'  => $user['nim'],
                'name' => $user['name'],
                'role' => $user['role_name'] ?? 'guest',
            ]
        ]);
    }
    
    // Anda bisa menambahkan method profile di sini jika dibutuhkan
    public function profile()
    {
        try {
            $key    = getenv('JWT_SECRET_KEY');
            $header = $this->request->getHeaderLine("Authorization");
            $token  = explode(" ", $header)[1];
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // Kirim kembali data dari token sebagai profil
            return $this->respond([
                'id' => $decoded->uid,
                'nim' => $decoded->nim,
                'name' => $decoded->name,
                'role' => $decoded->role
            ]);

        } catch (\Exception $e) {
            return $this->failUnauthorized('Token tidak valid atau sudah kedaluwarsa.');
        }
    }
}
