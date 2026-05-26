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

    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $this->pegawaiModel->delete($id);
        return redirect()->to(base_url('pegawai'))->with('success', 'Data pegawai berhasil dihapus.');
    }
}
