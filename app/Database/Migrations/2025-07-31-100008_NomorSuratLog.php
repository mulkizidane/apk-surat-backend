<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NomorSuratLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'BIGSERIAL',
                'unsigned'=>true,
            ],
            'surat_id'=>[
                'type'=>'BIGINT',
                'unsigned'=>true,
            ],
            'nomor'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255',
            ],
            'dibuat_oleh'=>[
                'type'=>'BIGINT',
                'unsigned'=> true,
            ],
            'tanggal'=>[
                'type'=>'TIMESTAMPTZ',
                'null'=> true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('surat_id', 'surat_keluar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('nomor_surat_log');
    }

    public function down()
    {
        $this->forge->dropTable('nomor_surat_log');
    }
}
