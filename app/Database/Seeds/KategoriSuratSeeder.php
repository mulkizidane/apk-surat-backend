<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSuratSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'nama_kategori' => 'Surat Administrasi'],
            ['id' => 2, 'nama_kategori' => 'Surat Keputusan dan Penugasan'],
            ['id' => 3, 'nama_kategori' => 'Surat Legal / Formal'],
        ];
        $this->db->table('kategori_surat')->insertBatch($data);
    }
}