<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\ParafSuratModel;
use App\Models\SuratMasukModel;
use App\Models\DisposisiModel;
use App\Models\SuratKeluarModel;

class DashboardController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // 1. Ambil data user yang sedang login dari token
        try {
            $key    = getenv('JWT_SECRET_KEY');
            $header = $this->request->getHeaderLine("Authorization");
            $token  = explode(" ", $header)[1];
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token tidak valid');
        }

        $userRole = $decoded->role;
        $userId   = $decoded->uid;
        $data = [];

        // 2. Siapkan data berdasarkan role user
        switch ($userRole) {
            case 'pimpinan_unit':
            case 'atasan_terkait':
                // Ambil data surat yang perlu persetujuan
                $parafModel = new ParafSuratModel();
                $data['perlu_persetujuan'] = $parafModel
                    ->where('user_id', $userId)
                    ->where('status', 'pending')
                    ->findAll();
                
                // Ambil data surat masuk yang baru
                $suratMasukModel = new SuratMasukModel();
                $data['surat_masuk_baru'] = $suratMasukModel
                    ->where('status', 'baru')
                    ->findAll();
                break;

            case 'admin_tu':
                // Ambil data surat keluar yang siap dikirim/diarsipkan
                $suratKeluarModel = new SuratKeluarModel();
                $data['siap_kirim'] = $suratKeluarModel
                    ->where('status', 'disetujui')
                    ->findAll();

                // Ambil data surat masuk yang sudah didisposisi
                $suratMasukModel = new SuratMasukModel();
                $data['sudah_disposisi'] = $suratMasukModel
                    ->where('status', 'didisposisi')
                    ->findAll();
                break;

            default: // Untuk role 'staf' atau lainnya
                // Ambil data disposisi yang ditujukan ke user ini
                $disposisiModel = new DisposisiModel();
                $data['disposisi_untuk_anda'] = $disposisiModel
                    ->where('penerima_disposisi_id', $userId)
                    ->findAll();
                break;
        }

        // 3. Kirim response
        return $this->respond($data);
    }
}