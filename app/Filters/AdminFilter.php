<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Pastikan login terlebih dahulu sebelum memeriksa role
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // Cek jika bukan admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki hak akses administratif untuk menu tersebut.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Not used
    }
}
