<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePejabatTable extends Migration
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

            'id_pegawai' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
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

            'tanggal_nd' => [
                'type' => 'DATE',
            ],

            'nomor_nd' => [
                'type' => 'VARCHAR',
                'constraint' => 48,
                'null' => true,
            ],

            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Plh.', 'Plt.'],
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

        $this->forge->createTable('pejabat');
    }

    public function down()
    {
        $this->forge->dropTable('pejabat');
    }
}
