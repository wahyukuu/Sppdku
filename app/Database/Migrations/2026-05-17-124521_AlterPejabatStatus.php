<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPejabatStatus extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
        ];
        $this->forge->modifyColumn('pejabat', $fields);
    }

    public function down()
    {
        $fields = [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Plh.', 'Plt.'],
            ],
        ];
        $this->forge->modifyColumn('pejabat', $fields);
    }
}
