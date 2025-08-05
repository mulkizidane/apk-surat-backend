<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {

        $data =
        [
            'nama' => 'Rektorat',
            'email' => 'rektorat@test.com',
            'password' => password_hash('123456', PASSWORD_DEFAULT), // Password di-hash
            'role' => 'pimpinan',
            'unit_id' => 1, // Pastikan ID 1 ada di tabel units
            'sub_units_id'=> 2,
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}