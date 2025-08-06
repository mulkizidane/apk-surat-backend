<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriSuratModel;
use CodeIgniter\API\ResponseTrait;

class KategoriSuratController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new KategoriSuratModel();
        $data = $model->findAll();
        return $this->respond($data);
    }
}
