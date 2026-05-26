<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBiayaTable extends Migration
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

            'tingkat' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
            ],

            'transport' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'penginapan' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'harian' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'representative' => [
                'type'     => 'INT',
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

        $this->forge->createTable('biaya');
    }

    public function down()
    {
        $this->forge->dropTable('biaya');
    }
}
