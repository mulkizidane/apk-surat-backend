<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Disposisi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGSERIAL',
                'unsigned'       => true,
            ],
            'surat_masuk_id' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
            ],
            'pengirim_disposisi_id' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
            ],
            'penerima_disposisi_id' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
            ],
            'jenis_disposisi' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'keterangan_disposisi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_disposisi' => [
                'type' => 'TIMESTAMPTZ',
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
        $this->forge->addForeignKey('surat_masuk_id', 'surat_masuk', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pengirim_disposisi_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('penerima_disposisi_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('disposisi');
    }

    public function down()
    {
        $this->forge->dropTable('disposisi');
    }
}

