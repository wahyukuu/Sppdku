<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMaksudToSuratTugas extends Migration
{
    public function up()
    {
        $fields = [
            'maksud' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'tujuan',
            ],
        ];
        $this->forge->addColumn('surat_tugas', $fields);
        
        // Copy existing 'tujuan' to 'maksud' so we don't lose any data
        $this->db->query("UPDATE surat_tugas SET maksud = tujuan");
    }

    public function down()
    {
        $this->forge->dropColumn('surat_tugas', 'maksud');
    }
}
