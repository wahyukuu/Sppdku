<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSppdTable extends Migration
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

            'id_pegawai' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['DL', 'DD'],
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

        $this->forge->createTable('sppd');
    }

    public function down()
    {
        $this->forge->dropTable('sppd');
    }
}
