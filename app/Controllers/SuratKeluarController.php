<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TujuanSuratKeluarModel;
use App\Models\SuratKeluarModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SuratKeluarController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $model = new SuratKeluarModel();
        $data = $model->findAll();
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
        $model = new SuratKeluarModel();
        $data = $model ->getSuratDetail($id);

        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Surat dengan ID '. $id . 'tidak ditemukan.');
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
            $key = getenv('JWT_SECRET_KEY');
            $header = $this->request->getHeaderLine("Authorization");
            $token  = explode(" ", $header)[1];
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $loggedInUserId = $decoded->uid;
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token SALAH!!!');
        }

        $requestData = $this->request->getJSON();
        $db = \Config\Database::connect();
        $db->transStart();


        $suratKeluarModel = new SuratKeluarModel();
        $suratData = [
            'nomor_surat'    => $requestData->nomor_surat ?? null,
            'kategori_surat_id'       => $requestData->kategori_surat_id,
            'jenis_surat_id'          => $requestData->jenis_surat_id,
            'tanggal'        => $requestData->tanggal,
            'isi'            => $requestData->isi,
            'status'         => 'menunggu_verifikasi',
            'unit_id'        => $requestData->unit_id,
            'created_by'     => $loggedInUserId,
        ];

        $suratKeluarModel->insert($suratData);

        $suratKeluarId = $suratKeluarModel->getInsertID();

        $tujuanModel = new TujuanSuratKeluarModel();
        foreach ($requestData->tujuan as $tujuan) {
            $tujuanData = [
                'surat_keluar_id' => $suratKeluarId,
                'unit_id'         => $tujuan->unit_id ?? null,
                'user_id'         => $tujuan->user_id ?? null,
                'tipe_tujuan'     => $tujuan->tipe_tujuan,
            ];
            $tujuanModel->insert($tujuanData);
        }
        $parafModel = new \App\Models\ParafSuratModel();

        foreach ($requestData->approvers as $index => $approver) {
        $parafModel->insert([
                'surat_id' => $suratKeluarId,
                'user_id'  => $approver->user_id,
                'tipe'     => $approver->tipe, // 'paraf' atau 'ttd'
                'status'   => ($index === 0) ? 'pending' : 'menunggu', // Hanya approver pertama yang langsung 'pending'
            ]);
        }
        if ($db->transStatus() === false) {
        $db->transRollback();
        return $this->fail('Gagal menyimpan data surat.');
        } else {
            $db->transCommit();
            return $this-> respondCreated(['message' => 'Surat keluar berhasil dibuat.']);
        }
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
        $model = new SuratKeluarModel();
    $surat = $model->find($id);

    if (!$surat) {
        return $this->failNotFound('Surat dengan ID ' . $id . ' tidak ditemukan.');
    }
    $requestData = $this->request->getJSON();
    $dataToUpdate = [
        'isi'    => $requestData->isi,
        'status' => 'menunggu_verifikasi',
    ];

    if ($model->update($id, $dataToUpdate)) {
        return $this->respondUpdated(['message' => 'Surat berhasil di-update.']);
    }

    return $this->fail($model->errors());
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
        $model = new SuratKeluarModel();
        $surat = $model->find($id);

        if (!$surat) {
            return $this->failNotFound('Surat dengan ID ' . $id . ' tidak ditemukan.');
        }

        if ($model->delete($id)) {
            return $this->respondDeleted(['message' => 'Surat berhasil dihapus.']);
        }

        return $this->fail('Gagal menghapus surat.');
    }
}
