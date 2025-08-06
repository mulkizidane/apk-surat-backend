<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddParentIdToUnits extends Migration
{
    public function up()
    {
        $this->forge->addColumn('units', [
            'parent_id' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => true, // Boleh null untuk unit induk
                'after'      => 'nama', // Posisi kolom setelah kolom 'nama'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('units', 'parent_id');
    }
}