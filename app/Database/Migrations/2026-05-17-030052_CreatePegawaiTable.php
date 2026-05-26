<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePegawaiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pegawai' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],

            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
            ],

            'pangkat' => [
                'type' => 'VARCHAR',
                'constraint' => 48,
                'null' => true,
            ],

            'golongan' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => true,
            ],

            'jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],

            'unit_kerja' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],

            'tingkat_biaya' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
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

        $this->forge->addKey('id_pegawai', true);

        $this->forge->createTable('pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('pegawai');
    }
}
