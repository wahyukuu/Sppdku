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

    /**
     * Menampilkan halaman daftar semua User.
     * Mengambil seluruh data user dari database dan mengirimkannya ke view `user/index`.
     */
    public function index()
    {
        $data = [
            'title'      => 'Manajemen User | SPPDKU',
            'activeMenu' => 'user',
            'users'      => $this->userModel->findAll(),
        ];

        return view('user/index', $data);
    }

    /**
     * Menampilkan halaman form untuk menambah User baru.
     * Mengarahkan ke view `user/create`.
     */
    public function create()
    {
        $data = [
            'title'      => 'Tambah User | SPPDKU',
            'activeMenu' => 'user',
        ];

        return view('user/create', $data);
    }

    /**
     * Memproses data yang dikirimkan dari form tambah User.
     * Mengecek duplikasi username terlebih dahulu.
     * Password di-hash menggunakan algoritma bcrypt sebelum disimpan.
     * Menyimpan data (nama, username, password, role) ke database melalui UserModel.
     */
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

    /**
     * Menampilkan halaman form untuk mengedit data User berdasarkan ID.
     * Mengambil data spesifik user dan mengirimkannya ke view `user/edit`.
     */
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

    /**
     * Memproses pembaruan data User yang diedit berdasarkan ID.
     * Mengecek duplikasi username jika username diubah.
     * Password hanya diperbarui jika field password diisi (tidak kosong).
     * Mengupdate record di database dengan data baru dari form.
     */
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

    /**
     * Menghapus data User berdasarkan ID.
     * Terdapat pengecekan agar user yang sedang login tidak bisa menghapus akunnya sendiri.
     * Setelah data dihapus, diarahkan kembali ke halaman daftar user.
     */
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
