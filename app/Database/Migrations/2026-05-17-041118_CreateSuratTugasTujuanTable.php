<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratTugasTujuanTable extends Migration
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

            'id_surat_tugas' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'tujuan' => [
                'type' => 'TEXT',
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

        $this->forge->createTable('surat_tugas_tujuan');
    }

    public function down()
    {
        $this->forge->dropTable('surat_tugas_tujuan');
    }
}
