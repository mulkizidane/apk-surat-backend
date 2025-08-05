<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SuratKeluar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'BIGINT',
                'unsigned'=>true,
                'auto_increment'=>true,
            ],
            'nomor_surat'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255',
                'unique'=> true,
                'null'=> true,
            ],
            'kategori_surat_id'=>[
                'type'=>'BIGINT',
                'unsigned'=>true,
            ],
            'jenis_surat_id'=>[
                'type'=>'BIGINT',
                'unsigned'=>true,
            ],
            'tanggal'=>[
                'type'=>'DATE',
            ],
            'tujuan'=>[
                'type' => 'VARCHAR',
                'constraint'=> '255',
            ],
            'isi'=>[
                'type'=> 'TEXT',
                'null'=>'true',
            ],
            'status'=>[
                'type'=>'VARCHAR',
                'constraint'=>'30',
            ],
            'unit_id'=>[
                'type'=>'BIGINT',
                'unsigned'=> true,
            ],
            'created_by'=>[
                'type'=>'BIGINT',
                'unsigned'=> true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMPTZ',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMPTZ',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('unit_id', 'units', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('jenis_surat_id', 'jenis_surat', 'id', 'CASCADE','CASCADE');
        $this->forge->addForeignKey('kategori_surat_id', 'kategori_surat', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('surat_keluar');
    }

    public function down()
    {
        $this->forge->dropTable('surat_keluar');
    }
}
