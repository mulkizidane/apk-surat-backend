<?php

namespace App\Controllers;

use App\Models\ParafSuratModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\SuratKeluarModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class VerifikasiController extends BaseController
{
    use ResponseTrait;

    /**
     * Mengupdate status verifikasi (paraf/ttd).
     * @param int|null $id ID dari tabel paraf_surat
     */
    public function update($id = null)
    {
        // 1. Validasi Token JWT
        try {
            $key    = getenv('JWT_SECRET_KEY');
            $header = $this->request->getHeaderLine("Authorization");
            $token  = explode(" ", $header)[1];
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $loggedInUserId = $decoded->uid;
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token tidak valid atau sudah kedaluwarsa.');
        }

        // Inisialisasi Model
        $parafModel = new ParafSuratModel();
        $suratKeluarModel = new SuratKeluarModel();
        
        // 2. Cari data verifikasi berdasarkan ID yang dikirim
        $verifikasi = $parafModel->find($id);

        // 3. Lakukan validasi
        if (!$verifikasi) {
            return $this->failNotFound('Data verifikasi tidak ditemukan.');
        }
        if ($verifikasi['user_id'] != $loggedInUserId) {
            return $this->failForbidden('Anda tidak memiliki hak untuk melakukan verifikasi ini.');
        }
        if ($verifikasi['status'] !== 'pending') {
            return $this->fail('Surat ini tidak sedang menunggu persetujuan Anda.', 400);
        }

        // Ambil data dari request frontend
        $requestData = $this->request->getJSON();
        $suratId = $verifikasi['surat_id'];

        // Mulai transaksi database untuk memastikan semua query berhasil
        $this->db->transStart();

        // 4. (FUNGSI BARU) Update Nomor Surat jika ada
        // Ini hanya akan berjalan jika frontend mengirim 'nomor_surat' dan statusnya 'setuju'
        if ($requestData->status === 'setuju' && !empty($requestData->nomor_surat)) {
            // Update nomor surat di tabel surat_keluar
            $suratKeluarModel->update($suratId, ['nomor_surat' => $requestData->nomor_surat]);
        }
        
        // 5. Update status di tabel paraf_surat
        $dataToUpdate = [
            'status'  => $requestData->status,
            'catatan' => $requestData->catatan ?? null,
            'tanggal' => date('Y-m-d H:i:s'),
        ];
        $parafModel->update($id, $dataToUpdate);
            
        // 6. Logika Alur Kerja (Workflow)
        if ($requestData->status === 'setuju') {
            // Cek apakah ada approver selanjutnya yang masih 'menunggu'
            $nextApprover = $parafModel
                ->where('surat_id', $suratId)
                ->where('status', 'menunggu')
                ->orderBy('id', 'ASC')
                ->first();

            if ($nextApprover) {
                // Jika ada, aktifkan approver selanjutnya dengan mengubah statusnya menjadi 'pending'
                $parafModel->update($nextApprover['id'], ['status' => 'pending']);
                $suratKeluarModel->update($suratId, ['status' => 'diproses']);
            } else {
                // Jika tidak ada lagi, berarti surat sudah disetujui sepenuhnya
                $suratKeluarModel->update($suratId, ['status' => 'disetujui']);
                
                // Di sini bisa ditambahkan logika untuk membuat surat masuk internal secara otomatis
            }

        } elseif ($requestData->status === 'revisi') {
            // Jika direvisi, update status surat utama menjadi 'revisi'
            $suratKeluarModel->update($suratId, ['status' => 'revisi']);
        } elseif ($requestData->status === 'tolak') {
            // Jika ditolak, update status surat utama menjadi 'ditolak'
            $suratKeluarModel->update($suratId, ['status' => 'ditolak']);
        }
        
        // Selesaikan transaksi database
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return $this->fail('Gagal menyimpan data verifikasi.');
        } else {
            $this->db->transCommit();
            return $this->respondUpdated(['message' => 'Verifikasi berhasil disimpan.']);
        }
    }
}
