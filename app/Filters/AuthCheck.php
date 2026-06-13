<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthCheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            $currentURL = current_url(); // URL sekarang
            $queryString = http_build_query($request->getGet()); // Ambil query string (GET parameter)
            $redirectUrl = $queryString ? $currentURL . '?' . $queryString : $currentURL;
    
            return redirect()->to('/auth/login?redirect=' . urlencode($redirectUrl))
                ->with('alert', [
                    'type' => 'error',
                    'title' => 'Akses Ditolak',
                    'message' => 'Login dulu untuk menonton video.',
                    'timer' => 5000,
                ]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan setelah filter
    }
}
