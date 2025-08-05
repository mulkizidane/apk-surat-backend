<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropTujuanFromSuratKeluar extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('surat_keluar', 'tujuan');
    }

    public function down()
    {
        // Menambahkan kembali kolom jika di-rollback
        $this->forge->addColumn('surat_keluar', [
            'tujuan' => ['type' => 'VARCHAR', 'constraint' => 255]
        ]);
    }
}