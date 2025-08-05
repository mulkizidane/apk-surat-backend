<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnitModel;
use App\Models\SubUnitModel;
use CodeIgniter\API\ResponseTrait;

class UnitController extends BaseController
{
    public function index()
    {
        $unitModel = new unitModel();
        $subUnitModel = new subUnitModel();
        $semuaUnits = $unitModel->findAll();
        $dataLengkap = [];
        foreach ($semuaUnits as $unit) {
            $subUnits = $subUnitModel->where('unit_id', $unit['id'])->findAll();
            $unit['sub_units'] = $subUnits;
            $dataLengkap[] = $unit;
        }
        return $this->respond($dataLengkap);
    }
}
