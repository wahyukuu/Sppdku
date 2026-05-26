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

    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $this->biayaModel->delete($id);
        return redirect()->to(base_url('biaya'))->with('success', 'Data tingkat biaya berhasil dihapus.');
    }
}
