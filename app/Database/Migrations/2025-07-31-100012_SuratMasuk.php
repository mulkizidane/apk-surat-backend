<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SuratMasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGSERIAL',
                'unsigned'       => true,
            ],
            'nomor_surat_asli' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'tanggal_surat' => [
                'type' => 'DATE',
            ],
            'tanggal_diterima' => [
                'type' => 'DATE',
            ],
            'pengirim' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'perihal' => [
                'type' => 'TEXT',
            ],
            'path_file' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'diunggah_oleh' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMPTZ',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMPTZ',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('diunggah_oleh', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('surat_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('surat_masuk');
    }
}

