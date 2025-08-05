<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Surat Administrasi (kategori_id = 1)
            ['id' => 1, 'kategori_id' => 1, 'nama_jenis' => 'Biasa'],
            ['id' => 2, 'kategori_id' => 1, 'nama_jenis' => 'Undangan'],
            ['id' => 3, 'kategori_id' => 1, 'nama_jenis' => 'Pemberitahuan / Edaran'],
            ['id' => 4, 'kategori_id' => 1, 'nama_jenis' => 'Pengajuan / Permohonan'],
            ['id' => 5, 'kategori_id' => 1, 'nama_jenis' => 'Peminjaman'],
            // Surat Keputusan (kategori_id = 2)
            ['id' => 6, 'kategori_id' => 2, 'nama_jenis' => 'Keputusan'],
            ['id' => 7, 'kategori_id' => 2, 'nama_jenis' => 'Penugasan'],
        ];
        $this->db->table('jenis_surat')->insertBatch($data);
    }
}