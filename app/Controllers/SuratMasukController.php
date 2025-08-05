<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\SuratMasukModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class SuratMasukController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $model = new SuratMasukModel();
        $data = $model->orderBy('tanggal_diterima', 'DESC')->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $suratMasukModel = new SuratMasukModel();
        $surat = $suratMasukModel->find($id);

        if (!$surat) {
            return $this->failNotFound('Surat masuk tidak ditemukan.');
        }

        // Ambil riwayat disposisi untuk surat ini
        $disposisiModel = new \App\Models\DisposisiModel();
        $disposisi = $disposisiModel->where('surat_masuk_id', $id)->findAll();

        // Gabungkan data surat dengan riwayat disposisinya
        $surat['disposisi'] = $disposisi;

        return $this->respond($surat);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        try {
            $key    = getenv('JWT_SECRET_KEY');
            $header = $this->request->getHeaderLine("Authorization");
            $token  = explode(" ", $header)[1];
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            
            if ($decoded->role !== 'admin_tu') {
                return $this->failForbidden('Hanya Admin TU yang dapat mengupload surat masuk.');
            }
            $loggedInUserId = $decoded->uid;
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token tidak valid');
        }
        $file = $this->request->getFile('file_surat');
        if (!$file->isValid() || $file->getMimeType() !== 'application/pdf') {
            return $this->fail('File tidak valid atau bukan PDF.', 400);
        }
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/surat-masuk', $newName);
        $data = [
            'nomor_surat_asli' => $this->request->getPost('nomor_surat_asli'),
            'tanggal_surat'    => $this->request->getPost('tanggal_surat'),
            'tanggal_diterima' => date('Y-m-d'),
            'pengirim'         => $this->request->getPost('pengirim'),
            'perihal'          => $this->request->getPost('perihal'),
            'path_file'        => $newName,
            'status'           => 'baru',
            'diunggah_oleh'    => $loggedInUserId,
        ];
        $model = new SuratMasukModel();
        if ($model->insert($data)) {
            return $this->respondCreated(['message' => 'Surat masuk berhasil diunggah.']);
        }
        return $this->fail($model->errors());
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
