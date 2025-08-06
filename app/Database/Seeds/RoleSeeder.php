<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['role_name' => 'pimpinan_unit'],
            ['role_name' => 'atasan_terkait'],
            ['role_name' => 'admin_tu'],
            ['role_name' => 'staf'],
        ];

        // Using Query Builder
        $this->db->table('roles')->insertBatch($data);
    }
}
