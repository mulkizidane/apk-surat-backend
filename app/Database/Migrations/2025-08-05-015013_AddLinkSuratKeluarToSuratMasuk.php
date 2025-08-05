<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLinkToSuratMasuk extends Migration
{
    public function up()
    {
        $this->forge->addColumn('surat_masuk', [
            'original_surat_keluar_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true, // Boleh kosong, khusus untuk surat eksternal
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('surat_masuk', 'original_surat_keluar_id');
    }
}