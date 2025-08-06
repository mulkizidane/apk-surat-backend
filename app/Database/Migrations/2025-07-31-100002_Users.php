<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {// Migration for: users
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'nim'     => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'password'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'unit_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'role_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'atasan_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('unit_id', 'units', 'id');
        $this->forge->addForeignKey('role_id', 'roles', 'id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
