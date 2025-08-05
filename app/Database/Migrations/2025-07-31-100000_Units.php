<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Units extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'=> 'BIGINT',
                'unsigned'=> true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'=> 'VARCHAR',
                'constraint'=> '255',
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
        $this->forge->createTable('units');
    }

    public function down()
    {
        $this->forge->dropTable('units');
    }
}
