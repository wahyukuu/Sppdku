<?php

namespace App\Controllers;

use App\Models\PegawaiModel;

class Pegawai extends BaseController
{
    protected $pegawaiModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
    }

    /**
     * Menampilkan halaman daftar Pegawai.
     * Mengambil seluruh data pegawai dari database dan mengirimkannya ke view `pegawai/index`.
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Data Pegawai | SPPDKU',
            'activeMenu' => 'pegawai',
            'pegawai'    => $this->pegawaiModel->findAll(),
        ];

        return view('pegawai/index', $data);
    }

    /**
     * Menampilkan halaman form untuk menambah data Pegawai baru.
     * Mengarahkan ke view `pegawai/create`.
     */
    public function create()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Tambah Pegawai | SPPDKU',
            'activeMenu' => 'pegawai',
        ];

        return view('pegawai/create', $data);
    }

    /**
     * Memproses data yang dikirimkan dari form tambah Pegawai.
     * Menyimpan data (NIP, nama, pangkat, dll) ke dalam database melalui PegawaiModel.
     */
    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $this->pegawaiModel->save([
            'nip'           => $this->request->getPost('nip'),
            'nama'          => $this->request->getPost('nama'),
            'pangkat'       => $this->request->getPost('pangkat'),
            'golongan'      => $this->request->getPost('golongan'),
            'jabatan'       => $this->request->getPost('jabatan'),
            'unit_kerja'    => $this->request->getPost('unit_kerja'),
            'tingkat_biaya' => $this->request->getPost('tingkat_biaya'),
        ]);

        return redirect()->to(base_url('pegawai'))->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman form untuk mengedit data Pegawai berdasarkan ID.
     * Mengambil data spesifik pegawai dan mengirimkannya ke view `pegawai/edit`.
     */
    public function edit($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $pegawai = $this->pegawaiModel->find($id);
        if (!$pegawai) {
            return redirect()->to(base_url('pegawai'))->with('error', 'Data pegawai tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Pegawai | SPPDKU',
            'activeMenu' => 'pegawai',
            'pegawai'    => $pegawai,
        ];

        return view('pegawai/edit', $data);
    }

    /**
     * Memproses pembaruan data Pegawai yang diedit berdasarkan ID.
     * Mengupdate record di database dengan data baru dari form.
     */
    public function update($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $this->pegawaiModel->update($id, [
            'nip'           => $this->request->getPost('nip'),
            'nama'          => $this->request->getPost('nama'),
            'pangkat'       => $this->request->getPost('pangkat'),
            'golongan'      => $this->request->getPost('golongan'),
            'jabatan'       => $this->request->getPost('jabatan'),
            'unit_kerja'    => $this->request->getPost('unit_kerja'),
            'tingkat_biaya' => $this->request->getPost('tingkat_biaya'),
        ]);

        return redirect()->to(base_url('pegawai'))->with('success', 'Data pegawai berhasil diubah.');
    }

    /**
     * Menghapus data Pegawai berdasarkan ID.
     * Setelah data dihapus, akan diarahkan kembali ke halaman daftar pegawai.
     */
    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $this->pegawaiModel->delete($id);
        return redirect()->to(base_url('pegawai'))->with('success', 'Data pegawai berhasil dihapus.');
    }
}
