<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAtasanIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'atasan_id' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => true, // Boleh null jika dia pimpinan tertinggi
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'atasan_id');
    }
}