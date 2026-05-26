<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed User
        $user_data = [
            [
                'nama'       => 'Administrator SPPDKU',
                'username'   => 'admin',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'User Biasa',
                'username'   => 'user',
                'password'   => password_hash('user123', PASSWORD_DEFAULT),
                'role'       => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('user')->insertBatch($user_data);

        // 2. Seed Biaya
        $biaya_data = [
            [
                'tingkat'        => 'Tingkat A',
                'transport'      => 2500000,
                'penginapan'     => 1500000,
                'harian'         => 500000,
                'representative' => 300000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'tingkat'        => 'Tingkat B',
                'transport'      => 1800000,
                'penginapan'     => 1000000,
                'harian'         => 400000,
                'representative' => 200000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'tingkat'        => 'Tingkat C',
                'transport'      => 1200000,
                'penginapan'     => 700000,
                'harian'         => 350000,
                'representative' => 0,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'tingkat'        => 'Tingkat D',
                'transport'      => 800000,
                'penginapan'     => 450000,
                'harian'         => 300000,
                'representative' => 0,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('biaya')->insertBatch($biaya_data);

        // 3. Seed Pegawai
        $pegawai_data = [
            [
                'nip'           => '199001012015011001',
                'nama'          => 'Ahmad Wahyudi, S.Kom.',
                'pangkat'       => 'Penata',
                'golongan'      => 'III/c',
                'jabatan'       => 'Pranata Komputer Ahli Muda',
                'unit_kerja'    => 'Dinas Komunikasi dan Informatika',
                'tingkat_biaya' => 'Tingkat C',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'nip'           => '198505122010032002',
                'nama'          => 'Siti Aminah, M.Si.',
                'pangkat'       => 'Pembina',
                'golongan'      => 'IV/a',
                'jabatan'       => 'Kepala Bidang Aplikasi Informatika',
                'unit_kerja'    => 'Dinas Komunikasi dan Informatika',
                'tingkat_biaya' => 'Tingkat B',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'nip'           => '199508202020011003',
                'nama'          => 'Budi Santoso',
                'pangkat'       => 'Pengatur',
                'golongan'      => 'II/c',
                'jabatan'       => 'Staf Bidang Aplikasi Informatika',
                'unit_kerja'    => 'Dinas Komunikasi dan Informatika',
                'tingkat_biaya' => 'Tingkat D',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('pegawai')->insertBatch($pegawai_data);

        // 4. Seed Pejabat (mengacu ke Pegawai ID 2: Siti Aminah)
        $pejabat_data = [
            [
                'id_pegawai'  => 2,
                'golongan'    => 'IV/a',
                'jabatan'     => 'Kepala Dinas Komunikasi dan Informatika',
                'tanggal_nd'  => '2026-01-02',
                'nomor_nd'    => '800/123/ND-Diskominfo/2026',
                'status'      => 'Plt.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('pejabat')->insertBatch($pejabat_data);
    }
}
