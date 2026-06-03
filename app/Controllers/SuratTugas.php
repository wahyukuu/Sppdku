<?php

namespace App\Controllers;

use App\Models\SuratTugasModel;
use App\Models\SuratTugasPegawaiModel;
use App\Models\SuratTugasTujuanModel;
use App\Models\PegawaiModel;
use App\Models\PejabatModel;
use App\Models\SppdModel;

class SuratTugas extends BaseController
{
    protected $suratTugasModel;
    protected $suratTugasPegawaiModel;
    protected $suratTugasTujuanModel;
    protected $pegawaiModel;
    protected $pejabatModel;
    protected $sppdModel;

    public function __construct()
    {
        $this->suratTugasModel        = new SuratTugasModel();
        $this->suratTugasPegawaiModel = new SuratTugasPegawaiModel();
        $this->suratTugasTujuanModel  = new SuratTugasTujuanModel();
        $this->pegawaiModel           = new PegawaiModel();
        $this->pejabatModel           = new PejabatModel();
        $this->sppdModel              = new SppdModel();
    }

    /**
     * Menampilkan halaman daftar semua Surat Tugas.
     * Melakukan join ke tabel pejabat dan pegawai untuk menampilkan nama pejabat penandatangan.
     * Untuk setiap surat tugas, juga mengambil daftar nama pegawai yang ditugaskan
     * dari tabel pivot surat_tugas_pegawai.
     * Mengarahkan ke view `surat_tugas/index`.
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $suratTugas = $this->suratTugasModel
            ->select('surat_tugas.*, pegawai.nama as nama_pejabat')
            ->join('pejabat', 'pejabat.id = surat_tugas.id_pejabat_ttd')
            ->join('pegawai', 'pegawai.id_pegawai = pejabat.id_pegawai')
            ->orderBy('surat_tugas.created_at', 'DESC')
            ->findAll();

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
            'title'      => 'Surat Tugas | SPPDKU',
            'activeMenu' => 'surat-tugas',
            'suratTugas' => $suratTugas,
        ];

        return view('surat_tugas/index', $data);
    }

    /**
     * Menampilkan halaman form untuk membuat Surat Tugas baru.
     * Mengambil daftar pejabat (dengan nama pegawai) dan daftar seluruh pegawai
     * untuk ditampilkan di dropdown pilihan.
     * Mengarahkan ke view `surat_tugas/create`.
     */
    public function create()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $pejabat = $this->pejabatModel
            ->select('pejabat.*, pegawai.nama as nama_pegawai')
            ->join('pegawai', 'pegawai.id_pegawai = pejabat.id_pegawai')
            ->findAll();

        $data = [
            'title'      => 'Buat Surat Tugas | SPPDKU',
            'activeMenu' => 'surat-tugas',
            'pejabat'    => $pejabat,
            'pegawai'    => $this->pegawaiModel->findAll(),
        ];

        return view('surat_tugas/create', $data);
    }

    /**
     * Memproses penyimpanan Surat Tugas baru dari data form.
     * Alur proses:
     * 1. Menyimpan data utama surat tugas (nomor, dasar, maksud, tujuan, tanggal, jenis, pejabat TTD, opsi Sabtu/Minggu).
     * 2. Menyimpan daftar pegawai yang ditugaskan ke tabel pivot surat_tugas_pegawai,
     *    dan secara otomatis membuat dokumen SPPD untuk setiap pegawai.
     * 3. Menyimpan daftar tujuan perjalanan ke tabel surat_tugas_tujuan.
     */
    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $nomorSurat  = $this->request->getPost('nomor_surat');
        $dasarSurat  = $this->request->getPost('dasar_surat');
        $maksudText  = $this->request->getPost('maksud');
        $tujuanArray = $this->request->getPost('tujuan');
        $idPejabat   = $this->request->getPost('id_pejabat_ttd');
        $idPegawai   = $this->request->getPost('id_pegawai'); // array of pegawai IDs

        $tujuanArray = array_values(array_filter($tujuanArray ?? [], 'strlen'));
        if (empty($tujuanArray)) {
            $tujuanArray = ['Banda Aceh'];
        }
        $tujuanText = implode(' - ', $tujuanArray);

        // 1. Simpan Surat Tugas Utama
        $stData = [
            'nomor_surat'     => $nomorSurat,
            'dasar_surat'     => $dasarSurat,
            'maksud'          => $maksudText,
            'tujuan'          => $tujuanText,
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'tanggal_surat'   => $this->request->getPost('tanggal_surat'),
            'jenis'           => $this->request->getPost('jenis'),
            'id_pejabat_ttd'  => $idPejabat,
            'id_user'         => session()->get('id_user') ?? 1,
            'hitung_sabtu'    => $this->request->getPost('hitung_sabtu') ? 1 : 0,
            'hitung_minggu'   => $this->request->getPost('hitung_minggu') ? 1 : 0,
        ];

        $this->suratTugasModel->insert($stData);
        $stId = $this->suratTugasModel->getInsertID();

        // 2. Simpan Pegawai yang Ditugaskan & Otomatis Buat SPPD
        if (!empty($idPegawai) && is_array($idPegawai)) {
            foreach ($idPegawai as $pegId) {
                // Simpan ke Surat Tugas Pegawai
                $this->suratTugasPegawaiModel->insert([
                    'id_surat_tugas' => $stId,
                    'id_pegawai'     => $pegId,
                ]);

                // Otomatis buat SPPD untuk pegawai ini
                $this->sppdModel->insert([
                    'id_surat_tugas' => $stId,
                    'id_pegawai'     => $pegId,
                    'jenis'          => $stData['jenis'],
                ]);
            }
        }

        // 3. Simpan Ke Surat Tugas Tujuan
        foreach ($tujuanArray as $t) {
            $this->suratTugasTujuanModel->insert([
                'id_surat_tugas' => $stId,
                'tujuan'         => trim($t),
            ]);
        }

        return redirect()->to(base_url('surat-tugas'))->with('success', 'Surat Tugas dan SPPD berhasil diterbitkan.');
    }

    /**
     * Menampilkan halaman form untuk mengedit Surat Tugas berdasarkan ID.
     * Mengambil data surat tugas yang ada, daftar pegawai yang sudah ditugaskan (assignedIds),
     * daftar pejabat, seluruh pegawai, dan daftar tujuan yang sudah disimpan.
     * Mengarahkan ke view `surat_tugas/edit`.
     */
    public function edit($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $suratTugas = $this->suratTugasModel->find($id);
        if (!$suratTugas) {
            return redirect()->to(base_url('surat-tugas'))->with('error', 'Data Surat Tugas tidak ditemukan.');
        }

        // Dapatkan daftar pegawai yang sedang ditugaskan saat ini
        $assignedPegawai = $this->suratTugasPegawaiModel
            ->where('id_surat_tugas', $id)
            ->findAll();
        $assignedIds = array_column($assignedPegawai, 'id_pegawai');

        $pejabat = $this->pejabatModel
            ->select('pejabat.*, pegawai.nama as nama_pegawai')
            ->join('pegawai', 'pegawai.id_pegawai = pejabat.id_pegawai')
            ->findAll();

        $destinations = $this->suratTugasTujuanModel
            ->where('id_surat_tugas', $id)
            ->orderBy('id', 'ASC')
            ->findAll();

        $data = [
            'title'        => 'Edit Surat Tugas | SPPDKU',
            'activeMenu'   => 'surat-tugas',
            'suratTugas'   => $suratTugas,
            'pejabat'      => $pejabat,
            'pegawai'      => $this->pegawaiModel->findAll(),
            'assignedIds'  => $assignedIds,
            'destinations' => $destinations,
        ];

        return view('surat_tugas/edit', $data);
    }

    /**
     * Memproses pembaruan data Surat Tugas berdasarkan ID.
     * Alur proses:
     * 1. Mengupdate data utama surat tugas.
     * 2. Sinkronisasi pegawai: menghapus semua assignment pegawai dan SPPD lama,
     *    lalu memasukkan ulang pegawai baru dan membuat SPPD baru (delete + re-insert).
     * 3. Sinkronisasi tujuan: menghapus tujuan lama dan memasukkan tujuan baru.
     */
    public function update($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $nomorSurat  = $this->request->getPost('nomor_surat');
        $dasarSurat  = $this->request->getPost('dasar_surat');
        $maksudText  = $this->request->getPost('maksud');
        $tujuanArray = $this->request->getPost('tujuan');
        $idPejabat   = $this->request->getPost('id_pejabat_ttd');
        $idPegawai   = $this->request->getPost('id_pegawai'); // array of pegawai IDs

        $tujuanArray = array_values(array_filter($tujuanArray ?? [], 'strlen'));
        if (empty($tujuanArray)) {
            $tujuanArray = ['Banda Aceh'];
        }
        $tujuanText = implode(' - ', $tujuanArray);

        // 1. Update Surat Tugas Utama
        $stData = [
            'nomor_surat'     => $nomorSurat,
            'dasar_surat'     => $dasarSurat,
            'maksud'          => $maksudText,
            'tujuan'          => $tujuanText,
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'tanggal_surat'   => $this->request->getPost('tanggal_surat'),
            'jenis'           => $this->request->getPost('jenis'),
            'id_pejabat_ttd'  => $idPejabat,
            'hitung_sabtu'    => $this->request->getPost('hitung_sabtu') ? 1 : 0,
            'hitung_minggu'   => $this->request->getPost('hitung_minggu') ? 1 : 0,
        ];
        $this->suratTugasModel->update($id, $stData);

        // 2. Sinkronisasi Pegawai & SPPD (Hapus yang lama lalu masukkan yang baru)
        $this->suratTugasPegawaiModel->where('id_surat_tugas', $id)->delete();
        
        // Hapus SPPD yang belum dicetak/dimutasi (atau bersihkan semua SPPD lama dari surat tugas ini)
        $this->sppdModel->where('id_surat_tugas', $id)->delete();

        if (!empty($idPegawai) && is_array($idPegawai)) {
            foreach ($idPegawai as $pegId) {
                // Simpan ke Surat Tugas Pegawai
                $this->suratTugasPegawaiModel->insert([
                    'id_surat_tugas' => $id,
                    'id_pegawai'     => $pegId,
                ]);

                // Regenerate SPPD
                $this->sppdModel->insert([
                    'id_surat_tugas' => $id,
                    'id_pegawai'     => $pegId,
                    'jenis'          => $stData['jenis'],
                ]);
            }
        }

        // 3. Update Surat Tugas Tujuan
        $this->suratTugasTujuanModel->where('id_surat_tugas', $id)->delete();
        foreach ($tujuanArray as $t) {
            $this->suratTugasTujuanModel->insert([
                'id_surat_tugas' => $id,
                'tujuan'         => trim($t),
            ]);
        }

        return redirect()->to(base_url('surat-tugas'))->with('success', 'Surat Tugas dan SPPD berhasil diperbarui.');
    }

    /**
     * Menghapus Surat Tugas beserta semua data terkait berdasarkan ID.
     * Data yang dihapus meliputi:
     * - Pegawai yang ditugaskan (surat_tugas_pegawai)
     * - Tujuan perjalanan (surat_tugas_tujuan)
     * - Dokumen SPPD terkait
     * - Surat Tugas itu sendiri
     */
    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Hapus detail terkait
        $this->suratTugasPegawaiModel->where('id_surat_tugas', $id)->delete();
        $this->suratTugasTujuanModel->where('id_surat_tugas', $id)->delete();
        $this->sppdModel->where('id_surat_tugas', $id)->delete();

        // Hapus Surat Tugas Utama
        $this->suratTugasModel->delete($id);

        return redirect()->to(base_url('surat-tugas'))->with('success', 'Surat Tugas beserta dokumen SPPD terkait berhasil dihapus.');
    }

    /**
     * Mencetak dokumen Surat Tugas berdasarkan ID.
     * Mengambil data surat tugas, pejabat penandatangan (dengan nama, NIP, pangkat, golongan),
     * dan daftar pegawai yang ditugaskan.
     * Data dikirimkan ke view `surat_tugas/print` untuk dicetak.
     */
    public function print($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $suratTugas = $this->suratTugasModel->find($id);
        if (!$suratTugas) {
            return redirect()->to(base_url('surat-tugas'))->with('error', 'Data Surat Tugas tidak ditemukan.');
        }

        // Dapatkan pejabat penandatangan
        $pejabat = $this->pejabatModel
            ->select('pejabat.*, pegawai.nama, pegawai.nip, pegawai.pangkat, pegawai.golongan')
            ->join('pegawai', 'pegawai.id_pegawai = pejabat.id_pegawai')
            ->where('pejabat.id', $suratTugas['id_pejabat_ttd'])
            ->first();

        // Dapatkan daftar pegawai yang ditugaskan
        $pegawaiList = $this->suratTugasPegawaiModel
            ->select('pegawai.*')
            ->join('pegawai', 'pegawai.id_pegawai = surat_tugas_pegawai.id_pegawai')
            ->where('id_surat_tugas', $id)
            ->findAll();

        $data = [
            'title'       => 'Cetak SPT | SPPDKU',
            'suratTugas'  => $suratTugas,
            'pejabat'     => $pejabat,
            'pegawaiList' => $pegawaiList,
        ];

        return view('surat_tugas/print', $data);
    }
}
