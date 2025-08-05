<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisSurat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGSERIAL',
                'unsigned' => true,
            ],
            'kategori_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'nama_jenis' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kategori_id', 'kategori_surat', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jenis_surat');
    }

    public function down()
    {
        $this->forge->dropTable('jenis_surat');
    }
}