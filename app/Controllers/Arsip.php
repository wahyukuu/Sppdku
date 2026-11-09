<?php

namespace App\Controllers;

use App\Models\SuratTugasModel;
use App\Models\SuratTugasPegawaiModel;
use App\Models\SppdModel;

class Arsip extends BaseController
{
    protected $suratTugasModel;
    protected $suratTugasPegawaiModel;
    protected $sppdModel;

    public function __construct()
    {
        $this->suratTugasModel        = new SuratTugasModel();
        $this->suratTugasPegawaiModel = new SuratTugasPegawaiModel();
        $this->sppdModel              = new SppdModel();
    }

    /**
     * Menampilkan halaman daftar Surat Tugas yang sudah diarsipkan.
     * Hanya menampilkan dokumen dengan status = 'diarsipkan'.
     * Bersifat read-only (tidak ada tombol edit/hapus).
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $keyword = $this->request->getGet('q');

        $builder = $this->suratTugasModel
            ->select('surat_tugas.*, pegawai.nama as nama_pejabat')
            ->join('pejabat', 'pejabat.id = surat_tugas.id_pejabat_ttd')
            ->join('pegawai', 'pegawai.id_pegawai = pejabat.id_pegawai')
            ->where('surat_tugas.status', 'diarsipkan')
            ->orderBy('surat_tugas.updated_at', 'DESC');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('surat_tugas.nomor_surat', $keyword)
                ->orLike('surat_tugas.tujuan', $keyword)
                ->orLike('surat_tugas.maksud', $keyword)
                ->groupEnd();
        }

        $suratTugas = $builder->findAll();

        // Ambil daftar pegawai untuk masing-masing surat tugas
        foreach ($suratTugas as &$st) {
            $pegawaiList = $this->suratTugasPegawaiModel
                ->select('pegawai.nama')
                ->join('pegawai', 'pegawai.id_pegawai = surat_tugas_pegawai.id_pegawai')
                ->where('id_surat_tugas', $st['id'])
                ->findAll();

            $st['pegawai'] = array_column($pegawaiList, 'nama');
        }

        $data = [
            'title'      => 'Arsip Dokumen | SPPDKU',
            'activeMenu' => 'arsip',
            'suratTugas' => $suratTugas,
            'keyword'    => $keyword,
        ];

        return view('arsip/index', $data);
    }

    /**
     * Membuka kembali arsip — mengubah status dari 'diarsipkan' ke 'aktif'.
     */
    public function restore($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $st = $this->suratTugasModel->find($id);
        if (!$st) {
            return redirect()->to(base_url('arsip'))->with('error', 'Dokumen tidak ditemukan.');
        }

        $this->suratTugasModel->update($id, ['status' => 'aktif']);

        return redirect()->to(base_url('arsip'))->with('success', 'Dokumen berhasil dibuka dari arsip dan kembali ke status Aktif.');
    }
}
