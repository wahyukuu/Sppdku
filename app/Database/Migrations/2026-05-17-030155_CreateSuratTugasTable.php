<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratTugasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'nomor_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
            ],

            'dasar_surat' => [
                'type' => 'TEXT',
            ],

            'tujuan' => [
                'type' => 'TEXT',
            ],

            'tanggal_mulai' => [
                'type' => 'DATE',
            ],

            'tanggal_selesai' => [
                'type' => 'DATE',
            ],

            'tanggal_surat' => [
                'type' => 'DATE',
            ],

            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['DL', 'DD'],
            ],

            'id_pejabat_ttd' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],

            'id_user' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('surat_tugas');
    }

    public function down()
    {
        $this->forge->dropTable('surat_tugas');
    }
}
