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

    public function login()
    {
        return view('auth/login');
    }

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

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('login'));
    }
}
