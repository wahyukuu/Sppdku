<?php

namespace App\Controllers;

use App\Models\BiayaModel;

class Biaya extends BaseController
{
    protected $biayaModel;

    public function __construct()
    {
        $this->biayaModel = new BiayaModel();
    }

    /**
     * Menampilkan halaman daftar Tarif Biaya Perjalanan Dinas.
     * Mengambil seluruh data dari tabel biaya dan mengirimkannya ke view `biaya/index`.
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Data Biaya | SPPDKU',
            'activeMenu' => 'biaya',
            'biaya'      => $this->biayaModel->findAll(),
        ];

        return view('biaya/index', $data);
    }

    /**
     * Menampilkan halaman form untuk menambah data Tarif Biaya baru.
     * Mengarahkan ke view `biaya/create`.
     */
    public function create()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Tambah Biaya | SPPDKU',
            'activeMenu' => 'biaya',
        ];

        return view('biaya/create', $data);
    }

    /**
     * Memproses data yang dikirimkan dari form tambah Tarif Biaya.
     * Menyimpan data (tingkat, jenis, tujuan, dll) ke dalam database melalui BiayaModel.
     */
    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $this->biayaModel->save([
            'tingkat'        => $this->request->getPost('tingkat'),
            'jenis'          => $this->request->getPost('jenis'),
            'tujuan'         => $this->request->getPost('tujuan'),
            'transport'      => $this->request->getPost('transport'),
            'penginapan'     => $this->request->getPost('penginapan'),
            'harian'         => $this->request->getPost('harian'),
            'representative' => $this->request->getPost('representative'),
        ]);

        return redirect()->to(base_url('biaya'))->with('success', 'Data tingkat biaya berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman form untuk mengedit data Tarif Biaya berdasarkan ID.
     * Mengambil data spesifik dari tabel biaya dan mengirimkannya ke view `biaya/edit`.
     */
    public function edit($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $biaya = $this->biayaModel->find($id);
        if (!$biaya) {
            return redirect()->to(base_url('biaya'))->with('error', 'Data tingkat biaya tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Biaya | SPPDKU',
            'activeMenu' => 'biaya',
            'biaya'      => $biaya,
        ];

        return view('biaya/edit', $data);
    }

    /**
     * Memproses pembaruan data Tarif Biaya yang diedit berdasarkan ID.
     * Mengupdate record di dalam database dengan data baru dari form.
     */
    public function update($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $this->biayaModel->update($id, [
            'tingkat'        => $this->request->getPost('tingkat'),
            'jenis'          => $this->request->getPost('jenis'),
            'tujuan'         => $this->request->getPost('tujuan'),
            'transport'      => $this->request->getPost('transport'),
            'penginapan'     => $this->request->getPost('penginapan'),
            'harian'         => $this->request->getPost('harian'),
            'representative' => $this->request->getPost('representative'),
        ]);

        return redirect()->to(base_url('biaya'))->with('success', 'Data tingkat biaya berhasil diubah.');
    }

    /**
     * Menghapus data Tarif Biaya berdasarkan ID.
     * Setelah data dihapus, akan diarahkan kembali ke halaman daftar biaya.
     */
    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $this->biayaModel->delete($id);
        return redirect()->to(base_url('biaya'))->with('success', 'Data tingkat biaya berhasil dihapus.');
    }
}
