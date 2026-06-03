<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHitungAkhirPekanToSuratTugas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('surat_tugas', [
            'hitung_sabtu' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'tujuan'
            ],
            'hitung_minggu' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'hitung_sabtu'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('surat_tugas', 'hitung_sabtu');
        $this->forge->dropColumn('surat_tugas', 'hitung_minggu');
    }
}
