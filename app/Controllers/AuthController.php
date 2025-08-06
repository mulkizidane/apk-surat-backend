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
        $nim = $this->request->getVar('nim');
        $password = $this->request->getVar('password');

        $userModel = new UserModel();
        $user = $userModel->where('nim', $nim)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Nim atau Password salah');
        }

        $key = getenv('JWT_SECRET_KEY');
        $iat = time();
        $exp = $iat + 3600;

        $payload = [
            'iat' => $iat,
            'exp' => $exp,
            'uid' => $user['id'],
            'nim' => $user['nim'],
            'role' => $user['role'],
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        return $this->respond([
            'message' => 'Login Berhasil',
            'token' => $token
        ]);
        return $this->respond(['message' => 'Tes CORS berhasil!']);
    }
}