<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LogSurat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=> [
                'type'=> 'BIGSERIAL',
                'unsigned'=>true,
            ],
            'surat_id'=>[
                'type'=>'BIGINT',
                'unsigned'=>true,
            ],
            'user_id'=>[
                'type'=>'BIGINT',
                'unsigned'=>true,
            ],
            'aksi'=>[
                'type' => 'VARCHAR',
                'constraint'=>'100',
            ],
            'waktu'=>[
                'type' =>'TIMESTAMPTZ',
                'null'=>true,
            ],
            'keterangan'=>[
                'type'=>'TEXT',
                'null'=>true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('surat_id', 'surat_keluar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('log_surat');
    }

    public function down()
    {
        $this->forge->dropTable('log_surat');
    }
}
