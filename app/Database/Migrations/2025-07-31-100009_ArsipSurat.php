<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ArsipSurat extends Migration
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
                'unsigned'=> true,
            ],
            'path_file'=>[
                'type'=>'TEXT',
                'null'=>true,
            ],
            'tipe_arsip'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('surat_id', 'surat_keluar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('arsip_surat');
    }

    public function down()
    {
        $this->forge->dropTable('arsip_surat');
    }
}
