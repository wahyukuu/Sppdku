<?php

namespace App\Controllers;

use App\Models\PejabatModel;
use App\Models\PegawaiModel;

class Pejabat extends BaseController
{
    protected $pejabatModel;
    protected $pegawaiModel;

    public function __construct()
    {
        $this->pejabatModel = new PejabatModel();
        $this->pegawaiModel = new PegawaiModel();
    }

    /**
     * Menampilkan halaman daftar Pejabat (Penandatangan dsb).
     * Melakukan join dengan tabel pegawai untuk menampilkan nama dan nip.
     * Mengarahkan ke view `pejabat/index`.
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $pejabat = $this->pejabatModel
            ->select('pejabat.*, pegawai.nama as nama_pegawai, pegawai.nip')
            ->join('pegawai', 'pegawai.id_pegawai = pejabat.id_pegawai')
            ->findAll();

        $data = [
            'title'      => 'Data Pejabat | SPPDKU',
            'activeMenu' => 'pejabat',
            'pejabat'    => $pejabat,
        ];

        return view('pejabat/index', $data);
    }

    /**
     * Menampilkan halaman form untuk menambah data Pejabat baru.
     * Mengambil daftar pegawai untuk dipilih menjadi pejabat, mengarah ke view `pejabat/create`.
     */
    public function create()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Tambah Pejabat | SPPDKU',
            'activeMenu' => 'pejabat',
            'pegawai'    => $this->pegawaiModel->findAll(),
        ];

        return view('pejabat/create', $data);
    }

    /**
     * Memproses data yang dikirimkan dari form tambah Pejabat.
     * Menyimpan data pejabat dan atribut pendukung (status Plh/Plt) ke database.
     */
    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $tanggal_nd = $this->request->getPost('tanggal_nd');
        $nomor_nd = $this->request->getPost('nomor_nd');

        $this->pejabatModel->save([
            'id_pegawai' => $this->request->getPost('id_pegawai'),
            'golongan'   => $this->request->getPost('golongan'),
            'jabatan'    => $this->request->getPost('jabatan'),
            'tanggal_nd' => !empty($tanggal_nd) ? $tanggal_nd : null,
            'nomor_nd'   => !empty($nomor_nd) ? $nomor_nd : null,
            'status'     => $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('pejabat'))->with('success', 'Data pejabat berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit Pejabat berdasarkan ID.
     * Memuat record spesifik dan daftar seluruh pegawai untuk mengubah data.
     * Mengarahkan ke view `pejabat/edit`.
     */
    public function edit($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $pejabat = $this->pejabatModel->find($id);
        if (!$pejabat) {
            return redirect()->to(base_url('pejabat'))->with('error', 'Data pejabat tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Pejabat | SPPDKU',
            'activeMenu' => 'pejabat',
            'pejabat'    => $pejabat,
            'pegawai'    => $this->pegawaiModel->findAll(),
        ];

        return view('pejabat/edit', $data);
    }

    /**
     * Memproses pembaruan data Pejabat di database.
     */
    public function update($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $tanggal_nd = $this->request->getPost('tanggal_nd');
        $nomor_nd = $this->request->getPost('nomor_nd');

        $this->pejabatModel->update($id, [
            'id_pegawai' => $this->request->getPost('id_pegawai'),
            'golongan'   => $this->request->getPost('golongan'),
            'jabatan'    => $this->request->getPost('jabatan'),
            'tanggal_nd' => !empty($tanggal_nd) ? $tanggal_nd : null,
            'nomor_nd'   => !empty($nomor_nd) ? $nomor_nd : null,
            'status'     => $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('pejabat'))->with('success', 'Data pejabat berhasil diubah.');
    }

    /**
     * Menghapus data Pejabat dari database.
     */
    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $this->pejabatModel->delete($id);
        return redirect()->to(base_url('pejabat'))->with('success', 'Data pejabat berhasil dihapus.');
    }
}
