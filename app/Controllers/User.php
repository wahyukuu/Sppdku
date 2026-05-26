<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Manajemen User | SPPDKU',
            'activeMenu' => 'user',
            'users'      => $this->userModel->findAll(),
        ];

        return view('user/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah User | SPPDKU',
            'activeMenu' => 'user',
        ];

        return view('user/create', $data);
    }

    public function store()
    {
        $username = $this->request->getPost('username');
        
        // Cek duplikasi username
        $existing = $this->userModel->where('username', $username)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Username sudah terdaftar di sistem.');
        }

        $passwordRaw = $this->request->getPost('password');
        $passwordHash = password_hash($passwordRaw, PASSWORD_BCRYPT);

        $this->userModel->save([
            'nama'     => $this->request->getPost('nama'),
            'username' => $username,
            'password' => $passwordHash,
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->to(base_url('user'))->with('success', 'User baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(base_url('user'))->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit User | SPPDKU',
            'activeMenu' => 'user',
            'user'       => $user,
        ];

        return view('user/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(base_url('user'))->with('error', 'User tidak ditemukan.');
        }

        $username = $this->request->getPost('username');
        
        // Cek duplikasi username jika diubah
        if ($username !== $user['username']) {
            $existing = $this->userModel->where('username', $username)->first();
            if ($existing) {
                return redirect()->back()->withInput()->with('error', 'Username sudah terdaftar.');
            }
        }

        $dataUpdate = [
            'nama'     => $this->request->getPost('nama'),
            'username' => $username,
            'role'     => $this->request->getPost('role'),
        ];

        // Jika password diisi, perbarui password
        $passwordRaw = $this->request->getPost('password');
        if (!empty($passwordRaw)) {
            $dataUpdate['password'] = password_hash($passwordRaw, PASSWORD_BCRYPT);
        }

        $this->userModel->update($id, $dataUpdate);

        return redirect()->to(base_url('user'))->with('success', 'Data user berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Cegah menghapus diri sendiri yang sedang login
        if (session()->get('id_user') == $id) {
            return redirect()->to(base_url('user'))->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $this->userModel->delete($id);
        return redirect()->to(base_url('user'))->with('success', 'User berhasil dihapus.');
    }
}
