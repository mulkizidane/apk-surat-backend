<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TUjuanSuratKeluar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'BIGSERIAL',
                'unsigned'=> true,
            ],
            'surat_keluar_id'=>[
                'type'=>'BIGINT',
                'unsigned'=> true,
            ],
            'unit_id'=>[
                'type'=> 'BIGINT',
                'unsigned'=> true,
                'null'=>true
            ],
            'user_id'=>[
                'type'=>'BIGINT',
                'unsigned'=>true,
                'null'=>true,
            ],
            'tipe_tujuan'=>[
                'type' => 'VARCHAR',
                'constraint'=>'50',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('surat_keluar_id', 'surat_keluar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('unit_id', 'units', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tujuan_surat_keluar');
    }

    public function down()
    {
        $this->forge->dropTable('tujuan_surat_keluar');
    }
}
