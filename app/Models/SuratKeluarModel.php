<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratKeluarModel extends Model
{
    protected $table            = 'surat_keluar';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nomor_surat',
        'kategori_surat_id',
        'jenis_surat_id',
        'tanggal',
        'tujuan',
        'isi',
        'status',
        'unit_id',
        'created_by',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getSuratDetail($id)
    {
        // === PERBAIKAN DI SINI ===
        // Mengganti "users.nama" menjadi "users.name"
        // Mengganti "units.nama" menjadi "units.name"
        $surat = $this->select('surat_keluar.*, users.name as nama_pembuat, units.name as nama_unit_pembuat')
                    ->join('users', 'users.id = surat_keluar.created_by')
                    ->join('units', 'units.id = surat_keluar.unit_id')
                    ->where('surat_keluar.id', $id)
                    ->first();

        if (!$surat) {
            return null;
        }

        $tujuanModel = new \App\Models\TujuanSuratKeluarModel();
        $tujuan = $tujuanModel->select('tujuan_surat_keluar.*, units.name as nama_unit_tujuan, users.name as nama_user_tujuan')
                            ->join('units', 'units.id = tujuan_surat_keluar.unit_id', 'left')
                            ->join('users', 'users.id = tujuan_surat_keluar.user_id', 'left')
                            ->where('surat_keluar_id', $id)
                            ->findAll();
        
        $surat['tujuan'] = $tujuan;

        $parafModel = new \App\Models\ParafSuratModel();
        $approvers = $parafModel->select('paraf_surat.*, users.name as approver_name')
                                ->join('users', 'users.id = paraf_surat.user_id')
                                ->where('surat_id', $id)
                                ->orderBy('id', 'ASC')
                                ->findAll();

        $surat['approvers'] = $approvers;

        return $surat;
    }
}
