<?php namespace App\Controllers;

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

        $approvers = [];

        // 1. Tambahkan "Diri Sendiri"
        $approvers['diri_sendiri'] = $currentUser;

        // 2. Cari "Atasan Langsung"
        if (!empty($currentUser['atasan_id'])) {
            $approvers['atasan_langsung'] = $userModel->find($currentUser['atasan_id']);
        }

        // 3. Cari "Pimpinan Unit"
        $pimpinanUnit = $userModel
            ->where('unit_id', $currentUser['unit_id'])
            ->where('role', 'pimpinan_unit')
            ->first();

        if ($pimpinanUnit) {
            $approvers['pimpinan_unit'] = $pimpinanUnit;
        }

        return $this->respond($approvers);
    }
}