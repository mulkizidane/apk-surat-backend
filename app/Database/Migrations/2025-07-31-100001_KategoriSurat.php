<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KategoriSurat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'BIGSERIAL',
                'unsigned'=>true
            ],
            'nama_kategori'=>[
                'type'=> 'VARCHAR',
                'constraint'=>'255'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kategori_surat');
    }

    public function down()
    {
        $this->forge->dropTable('kategori_surat');
    }
}
