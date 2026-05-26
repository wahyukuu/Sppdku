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

    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $this->pejabatModel->delete($id);
        return redirect()->to(base_url('pejabat'))->with('success', 'Data pejabat berhasil dihapus.');
    }
}
