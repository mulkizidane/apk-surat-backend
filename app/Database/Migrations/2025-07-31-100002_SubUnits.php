<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubUnits extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'BIGINT',
                'unsigned'=>true,
            ],
            'nama'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255'
            ],
            'units_id'=>[
                'type'=>'BIGINT',
                'unisgned'=>true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('units_id', 'units', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sub_units');
    }

    public function down()
    {
        $this->forge->dropTable('sub_units');
    }
}
