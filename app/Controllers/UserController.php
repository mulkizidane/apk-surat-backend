<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserController extends BaseController
{
    use ResponseTrait;

    public function getApprovers()
    {
        // Ambil data user yang sedang login dari token
        try {
            $key    = getenv('JWT_SECRET_KEY');
            $header = $this->request->getHeaderLine("Authorization");
            $token  = explode(" ", $header)[1];
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $loggedInUserId = $decoded->uid;
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token tidak valid');
        }

        $userModel = new UserModel();
        $currentUser = $userModel->find($loggedInUserId);

        if (!$currentUser) {
            return $this->failNotFound('User tidak ditemukan.');
        }

        $approvers = [];

        // 1. Tambahkan "Diri Sendiri" (jika diperlukan untuk paraf)
        // $approvers['diri_sendiri'] = $currentUser;

        // 2. Cari "Atasan Langsung"
        if (!empty($currentUser['atasan_id'])) {
            $atasanLangsung = $userModel->find($currentUser['atasan_id']);
            if ($atasanLangsung) {
                $approvers['atasan_langsung'] = $atasanLangsung;
            }
        }

        // 3. Cari "Pimpinan Unit"
        // Query ini mencari user di unit yang sama, lalu join ke tabel roles
        // untuk memastikan perannya adalah 'pimpinan_unit'
        $pimpinanUnit = $userModel
            ->select('users.*')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.unit_id', $currentUser['unit_id'])
            ->where('roles.role_name', 'pimpinan_unit') // Mencari berdasarkan nama peran
            ->first();

        if ($pimpinanUnit) {
            // Pastikan pimpinan unit bukan orang yang sama dengan atasan langsung
            if (!isset($approvers['atasan_langsung']) || $approvers['atasan_langsung']['id'] !== $pimpinanUnit['id']) {
                 $approvers['pimpinan_unit'] = $pimpinanUnit;
            }
        }

        return $this->respond($approvers);
    }
}