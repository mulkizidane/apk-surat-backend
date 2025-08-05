<?php

namespace App\Controllers;

use App\Models\ParafSuratModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\SuratKeluarModel;
use App\Models\TujuanSuratKeluarModel;
use App\Models\SuratMasukModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class VerifikasiController extends BaseController
{
    use ResponseTrait;
    public function update($id = null)
    {
        try {
            $key    = getenv('JWT_SECRET_KEY');
            $header = $this->request->getHeaderLine("Authorization");
            $token  = explode(" ", $header)[1];
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $loggedInUserId = $decoded->uid;
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token tidak valid');
        }
        $parafModel = new ParafSuratModel();
        $suratKeluarModel = new SuratKeluarModel();
        $verifikasi = $parafModel->find($id);
        if (!$verifikasi) {
            return $this->failNotFound('Data verifikasi tidak ditemukan.');
        }
        if ($verifikasi['user_id'] != $loggedInUserId) {
            return $this->failForbidden('Anda tidak memiliki hak untuk melakukan verifikasi ini.');
        }
        $requestData = $this->request->getJSON();
        $dataToUpdate = [
            'status'  => $requestData->status,
            'catatan' => $requestData->catatan ?? null,
            'tanggal' => date('Y-m-d H:i:s'),
        ];

        if ($parafModel->update($id, $dataToUpdate)) {
            
            $suratId = $verifikasi['surat_id'];
            if ($requestData->status === 'setuju') {
                if ($verifikasi['tipe'] === 'paraf') {
                    $suratKeluarModel->update($suratId, ['status' => 'menunggu_ttd']);
                    $parafModel->where(['surat_id' => $suratId, 'tipe' => 'ttd'])
                            ->set(['status' => 'pending'])
                            ->update();
                }
                elseif ($verifikasi['tipe'] === 'ttd') {
                    $suratKeluarModel->update($suratId, ['status' => 'disetujui']);
                    $tujuanModel = new \App\Models\TujuanSuratKeluarModel();
                    $semuaTujuan = $tujuanModel->where('surat_keluar_id', $suratId)->findAll();

                    // 3. Ambil data surat keluar untuk di-copy ke surat masuk
                    $suratKeluarData = $suratKeluarModel->find($suratId);

                    // 4. Buat record baru di surat_masuk untuk setiap tujuan internal
                    $suratMasukModel = new \App\Models\SuratMasukModel();

                    foreach ($semuaTujuan as $tujuan) {
                        // Cek jika tujuannya adalah unit internal (bukan perorangan atau tujuan eksternal)
                        if (!empty($tujuan['unit_id'])) {
                            $dataSuratMasuk = [
                                'nomor_surat_asli' => $suratKeluarData['nomor_surat']?? 'INTERNAL-' . $suratId, // atau nomor lain yang sesuai
                                'tanggal_surat'    => $suratKeluarData['tanggal'],
                                'tanggal_diterima' => date('Y-m-d'),
                                'pengirim'         => 'Unit Internal: ' . $suratKeluarData['unit_id'], // Info pengirim internal
                                'perihal'          => $suratKeluarData['isi'],
                                'path_file'        => '',
                                'status'           => 'baru',
                                'diunggah_oleh'    => 1,
                                'original_surat_keluar_id' => $suratId,
                            ];
                            $suratMasukModel->insert($dataSuratMasuk);
                        }
                    }
                }
            }
            elseif ($requestData->status === 'revisi') {
                $suratKeluarModel->update($suratId, ['status' => 'revisi']);
            }
            elseif ($requestData->status === 'tolak') {
                $suratKeluarModel->update($suratId, ['status' => 'ditolak']);
            }
            return $this->respondUpdated(['message' => 'Verifikasi berhasil disimpan.']);
        }
        
        return $this->fail($parafModel->errors());
    }
}