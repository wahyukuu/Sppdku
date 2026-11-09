<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToSuratTugas extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `surat_tugas` ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'aktif' AFTER `id_user`");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `surat_tugas` DROP COLUMN `status`");
    }
}
