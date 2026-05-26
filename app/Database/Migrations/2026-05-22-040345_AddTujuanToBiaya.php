<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTujuanToBiaya extends Migration
{
    public function up()
    {
        $this->forge->addColumn('biaya', [
            'tujuan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'jenis'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('biaya', 'tujuan');
    }
}
