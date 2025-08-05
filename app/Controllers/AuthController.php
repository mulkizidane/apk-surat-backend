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
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Email atau Password salah');
        }

        $key = getenv('JWT_SECRET_KEY');
        $iat = time();
        $exp = $iat + 3600;

        $payload = [
            'iat' => $iat,
            'exp' => $exp,
            'uid' => $user['id'],
            'email' => $user['email'],
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