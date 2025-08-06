<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnitsModel;
use App\Models\SubUnitsModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class UnitController extends BaseController
{
    use ResponseTrait;

    public function getTujuanData()
    {
        $unitModel = new UnitsModel();
        $subUnitModel = new SubUnitsModel();
        $userModel = new UserModel();

        // Ambil HANYA unit utama (induk)
        $units = $unitModel->where('parent_id', null)->findAll();
        $dataLengkap = [];

        foreach ($units as $unit) {
            // Ambil sub-unit yang berada di bawah unit ini
            $subUnits = $subUnitModel->where('units_id', $unit['id'])->findAll();
            $unit['sub_units'] = [];

            foreach ($subUnits as $subUnit) {
                // Ambil user yang ada di dalam sub-unit ini
                $users = $userModel->where('sub_units_id', $subUnit['id'])->findAll();
                $subUnit['users'] = $users;
                $unit['sub_units'][] = $subUnit;
            }

            // BARU: Ambil juga user yang langsung di bawah unit (tidak punya sub-unit)
            $usersInUnit = $userModel
                ->where('units_id', $unit['id'])
                ->where('sub_units_id', null)
                ->findAll();
            $unit['users'] = $usersInUnit;
            
            $dataLengkap[] = $unit;
        }

        return $this->respond($dataLengkap);
    }

}
