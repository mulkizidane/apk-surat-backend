<?php

namespace App\Controllers;

use App\Models\JenisSuratModel;
use CodeIgniter\API\ResponseTrait;

class JenisSuratController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new JenisSuratModel();
        $kategoriId = $this->request->getVar('kategori_id');

        if ($kategoriId) {
            $data = $model->where('kategori_id', $kategoriId)->findAll();
        } else {
            $data = $model->findAll();
        }

        return $this->respond($data);
    }
}