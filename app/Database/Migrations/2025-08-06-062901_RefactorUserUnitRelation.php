<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RefactorUserUnitRelation extends Migration
{
    public function up()
    {
        // 1. Hapus foreign key constraint dari users ke sub_units
        // Nama constraint bisa berbeda, cek di database Anda jika error.
        // Format nama default di CI4: {table}_{column}_foreign
        // Coba hapus constraint ini dulu, jika ada.
        try {
            $this->forge->dropForeignKey('users', 'users_sub_units_id_foreign');
        } catch (\Throwable $th) {
            // Abaikan jika constraint tidak ada
        }
        
        // 2. Hapus kolom sub_units_id dari tabel users
        $this->forge->dropColumn('users', 'sub_units_id');

        // 3. Hapus tabel sub_units yang sudah tidak terpakai
        $this->forge->dropTable('sub_units', true); // 'true' agar tidak error jika tabel tidak ada
    }

    public function down()
    {
        // Logika untuk mengembalikan jika di-rollback (opsional tapi baik)
        // 1. Buat kembali tabel sub_units
        $this->forge->addField([
            'id'       => ['type' => 'BIGSERIAL', 'unsigned' => true],
            'nama'     => ['type' => 'VARCHAR', 'constraint' => '255'],
            'units_id' => ['type' => 'BIGINT', 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('units_id', 'units', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sub_units');

        // 2. Tambahkan kembali kolom sub_units_id ke tabel users
        $this->forge->addColumn('users', [
            'sub_units_id' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
    }
}
