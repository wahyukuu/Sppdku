<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\PejabatModel;
use App\Models\SuratTugasModel;
use App\Models\SppdModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $pegawaiModel    = new PegawaiModel();
        $pejabatModel    = new PejabatModel();
        $suratTugasModel = new SuratTugasModel();
        $sppdModel       = new SppdModel();

        $data = [
            'title'              => 'Dashboard | SPPDKU',
            'activeMenu'         => 'dashboard',
            'total_pegawai'      => $pegawaiModel->countAllResults(),
            'total_pejabat'      => $pejabatModel->countAllResults(),
            'total_surat_tugas'  => $suratTugasModel->countAllResults(),
            'total_sppd'         => $sppdModel->countAllResults(),
            'recent_surat_tugas' => $suratTugasModel->orderBy('created_at', 'DESC')->limit(5)->find(),
        ];

        return view('dashboard', $data);
    }
}
