<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Menampilkan halaman form Login.
     * Mengarahkan ke view `auth/login`.
     */
    public function login()
    {
        return view('auth/login');
    }

    /**
     * Memproses data login yang dikirimkan dari form.
     * Mengecek username di database, lalu memverifikasi password menggunakan bcrypt.
     * Jika berhasil, menyimpan data session (id_user, nama, role, logged_in)
     * dan mengarahkan user ke halaman dashboard.
     * Jika gagal, mengarahkan kembali ke halaman login dengan pesan error.
     */
    public function processLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel
            ->where('username', $username)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }

        $cekPassword = password_verify($password, $user['password']);

        if (!$cekPassword) {
            return redirect()->back()->with('error', 'Password salah');
        }

        session()->set([
            'id_user' => $user['id_user'],
            'nama' => $user['nama'],
            'role' => $user['role'],
            'logged_in' => true,
        ]);

        return redirect()->to(base_url('dashboard'));
    }

    /**
     * Menghancurkan (destroy) session pengguna yang sedang aktif,
     * lalu mengarahkan kembali ke halaman login.
     */
    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('login'));
    }
}
