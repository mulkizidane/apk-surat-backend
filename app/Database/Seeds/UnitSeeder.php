<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Main Units (parent_id = null)
            ['id' => 1, 'name' => 'Fakultas Teknologi Komunikasi dan Informatika', 'parent_id' => null],
            ['id' => 2, 'name' => 'Biro Administrasi Umum', 'parent_id' => null],
            ['id' => 3, 'name' => 'Rektorat', 'parent_id' => null],

            // Sub Units for FTKI (parent_id = 1)
            ['id' => 4, 'name' => 'Prodi Informatika', 'parent_id' => 1],
            ['id' => 5, 'name' => 'Prodi Sistem Informasi', 'parent_id' => 1],
        ];

        $this->db->table('units')->insertBatch($data);
    }
}
