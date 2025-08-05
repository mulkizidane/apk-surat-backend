<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifySubUnitsIdInUsers extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('users', [
            'sub_units_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true, // Mengubah kolom menjadi boleh null
            ],
        ]);
    }

    public function down()
    {
        // Perintah untuk mengembalikan jika di-rollback
        $this->forge->modifyColumn('users', [
            'sub_units_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => false, // Mengembalikan menjadi tidak boleh null
            ],
        ]);
    }
}