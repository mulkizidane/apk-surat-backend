<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SubUnitSeeder extends Seeder
{
    public function run()
    {

        $data = [
            // Rektorat (ID: 1)
            ['id' => 1, 'nama' => 'Bagian Tata Usaha Rektorat', 'units_id' => 1],
            ['id' => 2, 'nama' => 'Bagian Protokoler', 'units_id' => 1],

            // Biro Administrasi Akademik (ID: 2)
            ['id' => 3, 'nama' => 'Sub Bagian Registrasi', 'units_id' => 2],
            ['id' => 4, 'nama' => 'Sub Bagian Perkuliahan dan Ujian', 'units_id' => 2],

            // Biro Administrasi Umum (ID: 3)
            ['id' => 5, 'nama' => 'Sub Bagian Rumah Tangga', 'units_id' => 3],
            ['id' => 6, 'nama' => 'Sub Bagian Perlengkapan', 'units_id' => 3],

            // Fakultas Ilmu Kesehatan (ID: 18)
            ['id' => 7, 'nama' => 'Program Sarjana Keperawatan', 'units_id' => 18],
            ['id' => 8, 'nama' => 'Program Sarjana Kesehatan Masyarakat', 'units_id' => 18],
            ['id' => 9, 'nama' => 'Pendidikan Profesi Ners', 'units_id' => 18],

            // Fakultas Hukum (ID: 34)
            ['id' => 10, 'nama' => 'Program Sarjana Ilmu Hukum', 'units_id' => 34],
            ['id' => 11, 'nama' => 'Program Magister Ilmu Hukum', 'units_id' => 34],

            // Fakultas Ekonomi dan Bisnis (ID: 24)
            ['id' => 12, 'nama' => 'Program Sarjana Akuntansi', 'units_id' => 24],
            ['id' => 13, 'nama' => 'Program Sarjana Manajemen', 'units_id' => 24],
            ['id' => 14, 'nama' => 'Program Magister Akuntansi', 'units_id' => 24],
            ['id' => 15, 'nama' => 'Program Magister Manajemen', 'units_id' => 24],
            ['id' => 16, 'nama' => 'Program Doktor Ilmu Manajemen', 'units_id' => 24],

            // Fakultas Ilmu Sosial dan Ilmu Politik (ID: 25)
            ['id' => 17, 'nama' => 'Program Sarjana Ilmu Politik', 'units_id' => 25],
            ['id' => 18, 'nama' => 'Program Sarjana Ilmu Komunikasi', 'units_id' => 25],
            ['id' => 19, 'nama' => 'Program Sarjana Hubungan Internasional', 'units_id' => 25],
            ['id' => 20, 'nama' => 'Program Sarjana Administrasi Publik', 'units_id' => 25],
            ['id' => 21, 'nama' => 'Program Magister Ilmu Politik', 'units_id' => 25],

            // Fakultas Bahasa dan Sastra (ID: 26)
            ['id' => 22, 'nama' => 'Program Sarjana Sastra Indonesia', 'units_id' => 26],
            ['id' => 23, 'nama' => 'Program Sarjana Sastra Inggris', 'units_id' => 26],
            ['id' => 24, 'nama' => 'Program Sarjana Sastra Jepang', 'units_id' => 26],
            ['id' => 25, 'nama' => 'Program Sarjana Bahasa Korea', 'units_id' => 26],
            ['id' => 26, 'nama' => 'Program Magister Linguistik', 'units_id' => 26],

            // Fakultas Teknologi Komunikasi dan Informatika (ID: 30)
            ['id' => 27, 'nama' => 'Program Sarjana Sistem Informasi', 'units_id' => 30],
            ['id' => 28, 'nama' => 'Program Sarjana Informatika', 'units_id' => 30],
            ['id' => 29, 'nama' => 'Program Magister Teknologi Informasi', 'units_id' => 30],

            // Fakultas Teknik dan Sains (ID: 32)
            ['id' => 30, 'nama' => 'Program Sarjana Teknik Mesin', 'units_id' => 32],
            ['id' => 31, 'nama' => 'Program Sarjana Teknik Elektro', 'units_id' => 32],
            ['id' => 32, 'nama' => 'Program Sarjana Fisika', 'units_id' => 32],
            ['id' => 33, 'nama' => 'Program Magister Teknik Fisika', 'units_id' => 32],

            // Fakultas Biologi dan Pertanian (ID: 33)
            ['id' => 34, 'nama' => 'Program Sarjana Biologi', 'units_id' => 33],
            ['id' => 35, 'nama' => 'Program Sarjana Agroteknologi', 'units_id' => 33],
            ['id' => 36, 'nama' => 'Program Magister Biologi', 'units_id' => 33],
        ];

        // Memasukkan semua data sub unit ke tabel
        // Menggunakan loop insert karena insertBatch dengan ID manual kadang bermasalah
        foreach ($data as $row) {
            $this->db->table('sub_units')->insert($row);
        }
    }
}