<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToTujuanSurat extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tujuan_surat_keluar', [
            'status_penerimaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'terkirim', // Status awal saat surat dibuat
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tujuan_surat_keluar', 'status_penerimaan');
    }
}