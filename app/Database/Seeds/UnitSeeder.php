<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {

        $data = [
            ['nama' => 'Rektorat'],
            ['nama' => 'Biro Administrasi Akademik'],
            ['nama' => 'Biro Administrasi Umum'],
            ['nama' => 'Biro Administrasi Keuangan'],
            ['nama' => 'Biro Penelitian dan Pengabdian Kepada Masyarakat'],
            ['nama' => 'Biro Administrasi Kemahasiswaan'],
            ['nama' => 'Biro Administrasi Sumber Daya Manusia'],
            ['nama' => 'Biro Administrasi Kerjasama'],
            ['nama' => 'Badan Pengembangan Kurikulum'],
            ['nama' => 'Badan Penjaminan Mutu'],
            ['nama' => 'Inkubator Wirausaha Mandiri UNAS'],
            ['nama' => 'Perpustakaan'],
            ['nama' => 'Lembaga Penelitian dan Pengabdian kepada Masyarakat'],
            ['nama' => 'Kantor Urusan Internasional'],
            ['nama' => 'Badan Konseling UNAS'],
            ['nama' => 'Badan Pengelola Sistem Informasi'],
            ['nama' => 'Marketing Public Relations'],
            ['nama' => 'Fakultas Ilmu Kesehatan'],
            ['nama' => 'Program Sarjana Hubungan Internasional'],
            ['nama' => 'Badan Pengembangan Profesi'],
            ['nama' => 'Program Doktor Ilmu Politik'],
            ['nama' => 'Program Sarjana Teknik Elektro'],
            ['nama' => 'Program Sarjana Akuntansi'],
            ['nama' => 'Fakultas Ekonomi dan Bisnis'],
            ['nama' => 'Fakultas Ilmu Sosial dan Ilmu Politik'],
            ['nama' => 'Fakultas Bahasa dan Sastra'],
            ['nama' => 'Badan Pengembangan Teknologi dan Sistem Informasi'],
            ['nama' => 'Program Magister Teknologi Informasi'],
            ['nama' => 'Lembaga Penerbitan UNAS'],
            ['nama' => 'Fakultas Teknologi Komunikasi dan Informatika'],
            ['nama' => 'Program Sarjana Bahasa Korea'],
            ['nama' => 'Fakultas Teknik dan Sains'],
            ['nama' => 'Fakultas Biologi dan Pertanian'],
            ['nama' => 'Fakultas Hukum'],
            ['nama' => 'Program Sarjana Sistem Informasi'],
            ['nama' => 'Program Sarjana Manajemen'],
            ['nama' => 'Program Magister Akuntansi'],
            ['nama' => 'Program Sarjana Agroteknologi'],
            ['nama' => 'Program Sarjana Hukum'],
            ['nama' => 'Program Magister Ilmu Politik'],
            ['nama' => 'Program Sarjana Sastra Jepang'],
            ['nama' => 'Program Sarjana Sastra Inggris'],
            ['nama' => 'Program Sarjana Sastra Indonesia'],
            ['nama' => 'Program Sarjana Biologi'],
            ['nama' => 'Program Doktor Ilmu Manajemen'],
            ['nama' => 'Program Sarjana Teknik Mesin'],
            ['nama' => 'Program Sarjana Fisika'],
            ['nama' => 'Program Magister Linguistik'],
            ['nama' => 'Program Sarjana Ilmu Komunikasi'],
            ['nama' => 'Program Magister Manajemen'],
            ['nama' => 'Program Sarjana Informatika'],
            ['nama' => 'Program Sarjana Keperawatan'],
            ['nama' => 'Program Magister Ilmu Hukum'],
            ['nama' => 'Program Sarjana Ilmu Politik'],
            ['nama' => 'Program Magister Teknik Fisika'],
            ['nama' => 'Program Magister Kebidanan'],
            ['nama' => 'Klinik UNAS'],
            ['nama' => 'Program Sarjana Kebidanan'],
            ['nama' => 'Pendidikan Profesi Ners'],
            ['nama' => 'Program Sarjana Sosiologi'],
            ['nama' => 'Program Sarjana Administrasi Publik'],
            ['nama' => 'Program Sarjana Bisnis Digital'],
            ['nama' => 'Pendidikan Profesi Bidan'],
            ['nama' => 'Program Sarjana Pariwisata'],
            ['nama' => 'Program Magister Biologi'],
            ['nama' => 'Program Magister Administrasi Publik'],
            ['nama' => 'Komisi Disiplin'],
        ];

        // Memasukkan data ke tabel 'units'
        $this->db->table('units')->insertBatch($data);
    }
}