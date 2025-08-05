<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ParafSurat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGSERIAL',
                'unsigned' => true,
            ],
            'surat_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'tipe' => [
                'type' => "VARCHAR",
                'constraint' => '30',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal' => [
                'type' => 'TIMESTAMPTZ',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('surat_id', 'surat_keluar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('paraf_surat');
    }

    public function down()
    {
        $this->forge->dropTable('paraf_surat');
    }
}