<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. KATEGORI SURAT
        $kategori = [
            ['id' => 1, 'nama_kategori' => 'Surat Administrasi'],
            ['id' => 2, 'nama_kategori' => 'Surat Keputusan dan Penugasan'],
            ['id' => 3, 'nama_kategori' => 'Surat Legal / Formal'],
        ];
        $this->db->table('kategori_surat')->insertBatch($kategori);

        // 2. JENIS SURAT
        $jenis = [
            ['kategori_id' => 1, 'nama_jenis' => 'Biasa'],
            ['kategori_id' => 1, 'nama_jenis' => 'Undangan'],
            ['kategori_id' => 2, 'nama_jenis' => 'Keputusan'],
            ['kategori_id' => 2, 'nama_jenis' => 'Penugasan'],
        ];
        $this->db->table('jenis_surat')->insertBatch($jenis);

        // 3. UNITS (INDUK DAN ANAK)
        $parentUnits = [
            ['id' => 1, 'nama' => 'Rektorat'],
            ['id' => 2, 'nama' => 'Biro Administrasi Akademik'],
            ['id' => 3, 'nama' => 'Fakultas Teknologi Komunikasi dan Informatika'],
        ];
        $this->db->table('units')->insertBatch($parentUnits);

        $subUnits = [
            ['nama' => 'Bagian Tata Usaha Rektorat', 'parent_id' => 1],
            ['nama' => 'Program Sarjana Informatika', 'parent_id' => 3],
            ['nama' => 'Program Sarjana Sistem Informasi', 'parent_id' => 3],
        ];
        $this->db->table('units')->insertBatch($subUnits);

        // 4. USERS
        $rektorat = $this->db->table('units')->where('nama', 'Rektorat')->get()->getRow();
        $prodiTI = $this->db->table('units')->where('nama', 'Program Sarjana Informatika')->get()->getRow();
        $dekanFTKI = $this->db->table('units')->where('nama', 'Fakultas Teknologi Komunikasi dan Informatika')->get()->getRow();

        $users = [
            [
                'nama' => 'Rektor', 'email' => 'rektor@test.com', 'password' => password_hash('123456', PASSWORD_DEFAULT),
                'role' => 'pimpinan', 'unit_id' => $rektorat->id, 'atasan_id' => null
            ],
            [
                'nama' => 'Dekan FTKI', 'email' => 'dekan.ftki@test.com', 'password' => password_hash('123456', PASSWORD_DEFAULT),
                'role' => 'pimpinan_unit', 'unit_id' => $dekanFTKI->id, 'atasan_id' => 1 // Atasannya Rektor
            ],
            [
                'nama' => 'Kaprodi TI', 'email' => 'kaprodi.ti@test.com', 'password' => password_hash('123456', PASSWORD_DEFAULT),
                'role' => 'atasan_terkait', 'unit_id' => $prodiTI->id, 'atasan_id' => 2 // Atasannya Dekan FTKI
            ],
            [
                'nama' => 'Staf Prodi TI', 'email' => 'staf.ti@test.com', 'password' => password_hash('123456', PASSWORD_DEFAULT),
                'role' => 'staf', 'unit_id' => $prodiTI->id, 'atasan_id' => 3 // Atasannya Kaprodi TI
            ],
        ];
        $this->db->table('users')->insertBatch($users);
    }
}
