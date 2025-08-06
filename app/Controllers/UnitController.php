<?php

namespace App\Controllers;

use App\Models\UnitsModel;
use App\Models\UserModel; // Tambahkan UserModel
use CodeIgniter\API\ResponseTrait;

class UnitController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // ... (method index yang sudah ada)
    }

    /**
     * Method baru untuk mengambil data unit, sub-unit, dan user
     * dalam format pohon (tree) untuk dropdown.
     */
    public function getUnitUserTree()
    {
        $unitModel = new UnitsModel();
        $userModel = new UserModel();

        $units = $unitModel->findAll();
        $users = $userModel->select('id, name, unit_id')->findAll();

        // Kelompokkan user berdasarkan unit_id mereka
        $usersByUnit = [];
        foreach ($users as $user) {
            $usersByUnit[$user['unit_id']][] = $user;
        }

        // Buat struktur pohon
        $unitTree = [];
        $subUnits = [];

        // Pisahkan unit utama dan sub-unit
        foreach ($units as $unit) {
            if ($unit['parent_id'] === null) {
                $unit['sub_units'] = [];
                $unit['users'] = [];
                $unitTree[$unit['id']] = $unit;
            } else {
                $subUnits[] = $unit;
            }
        }

        // Masukkan sub-unit ke dalam unit utamanya
        foreach ($subUnits as $subUnit) {
            if (isset($unitTree[$subUnit['parent_id']])) {
                // Ambil user untuk sub-unit ini
                $subUnit['users'] = $usersByUnit[$subUnit['id']] ?? [];
                $unitTree[$subUnit['parent_id']]['sub_units'][] = $subUnit;
            }
        }

        // Masukkan user ke unit utama yang tidak punya sub-unit
        foreach ($unitTree as &$mainUnit) {
            if (empty($mainUnit['sub_units'])) {
                $mainUnit['users'] = $usersByUnit[$mainUnit['id']] ?? [];
            }
        }
        
        // Mengembalikan array yang sudah diindeks ulang
        return $this->respond(array_values($unitTree));
    }
}