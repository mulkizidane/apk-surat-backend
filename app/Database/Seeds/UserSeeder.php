<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ID akan di-generate otomatis oleh database (auto-increment)
        // Perkiraan ID: 1.Andi, 2.Budi, 3.Citra, 4.Dian, 5.Eka, 6.Fajar, 7.Gilang, 8.Hasan
        $data = [
            // --- Staf ---
            // Staf Prodi Informatika (unit_id = 4), atasan mereka adalah Kaprodi Informatika (ID: 4)
            [
                'nim' => '0987', 'name' => 'sari (admin Informatika)', 'password' => password_hash('123456', PASSWORD_DEFAULT),
                'unit_id' => 1, 'role_id' => 3, 'atasan_id' => 6
            ],
            [
                'nim' => '0827', 'name' => 'randy (admin BAU)', 'password' => password_hash('123456', PASSWORD_DEFAULT),
                'unit_id' => 2, 'role_id' => 3, 'atasan_id' => 8
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
