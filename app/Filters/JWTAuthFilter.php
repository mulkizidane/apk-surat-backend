<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeaderLine('Authorization');
        $token = null;

        // Ekstrak token dari header
        if (!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }

        // Cek jika token tidak ada
        if (is_null($token) || empty($token)) {
            $response = Services::response();
            $response->setJSON(['message' => 'Akses ditolak: Token tidak ada']);
            $response->setStatusCode(401);
            return $response;
        }

        try {
            $key = getenv('JWT_SECRET_KEY');
            JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            $response = Services::response();
            $response->setJSON(['message' => 'Akses ditolak: Token tidak valid']);
            $response->setStatusCode(401);
            return $response;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa-apa setelah request
    }
}