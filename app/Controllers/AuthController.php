<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\UserLevelModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
        $this->userLevelModel  = new userLevelModel();
    }

    public function login()
    {
        return view('auth/login');
    }


    public function attemptLogin()
    {
        // 1. TAMBAHKAN PESAN ERROR KUSTOM (Bahasa Indonesia)
        $validation = $this->validate([
            'email' => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.'
                ]
            ],
            'password' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.'
                ]
            ]
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $redirectUrl = $this->request->getPost('redirect') ?? $this->request->getGet('redirect'); 

        // Cek user berdasarkan email
        $user = $this->userModel->getUserByEmail($email);

        // 2. KEAMANAN: Jangan beritahu hacker apakah email atau password yang salah
        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau Password salah.');
        }

        // 3. Cek Status Akun
        if ($user['Status'] !== 'active') {
            return redirect()->back()->with('error', 'Akun Anda ditangguhkan atau tidak aktif. Silakan hubungi Admin.');
        }

        // Set session data
        session()->set([
            'id'         => $user['id'],
            'nama'       => $user['nama'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'ProfileImg' => $user['ProfileImg'],
            'level'      => $user['level'],
            'isLoggedIn' => true
        ]);
        
        // Update last login
        $this->userModel->update($user['id'], [
            'last_login' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('pesan', 'Selamat datang kembali, ' . $user['nama'] . '!');

        // Redirect berdasarkan role atau redirect URL
        if (!empty($redirectUrl)) {
            return redirect()->to(urldecode($redirectUrl));
        } elseif ($user['role'] === 'admin') {
            return redirect()->to(url_to('dashboard'));
        } else {
            return redirect()->to(url_to('animes-home'));
        }
    }
    
    
    

    public function logout()
    {
        $role = session()->get('role'); 
    
        // Hancurkan session
        session()->destroy();
    
        // Redirect berdasarkan role
        if ($role === 'admin') {
            return redirect()->to('/auth/login');
        } elseif ($role === 'user') {
            return redirect()->to('/animes-home');
        } else {
            // Jika role tidak dikenali, redirect ke halaman default
            return redirect()->to('/auth/login');
        }
    }
    public function register()
    {
        return view('auth/register');
    }

    public function attemptRegister()
    {
        // 1. TAMBAHKAN PESAN ERROR KUSTOM (Bahasa Indonesia)
        $validation = $this->validate([
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email ini sudah terdaftar. Silakan gunakan email lain atau Login.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal harus 6 karakter.'
                ]
            ],
            'confirm_password' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches'  => 'Konfirmasi password tidak cocok dengan password di atas.'
                ]
            ],
            'age' => [
                'rules'  => 'required|integer|greater_than_equal_to[13]', // Tambahkan batas usia minimal (Misal: 13 thn)
                'errors' => [
                    'required'              => 'Umur wajib diisi.',
                    'integer'               => 'Umur harus berupa angka.',
                    'greater_than_equal_to' => 'Anda harus berusia minimal 13 tahun untuk mendaftar.'
                ]
            ]
        ]);
    
        if (!$validation) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    
        $email = $this->request->getPost('email');
        
        // 2. EKSTRAK NAMA DARI EMAIL (Misal: andri@gmail.com -> Andri)
        $emailParts = explode('@', $email);
        $defaultNama = ucfirst($emailParts[0]); 
    
        // 3. GUNAKAN DATABASE TRANSACTION UNTUK KEAMANAN DATA RELASIONAL
        $db = \Config\Database::connect();
        $db->transStart();
    
        try {
            $userData = [
                'email'    => $email,
                'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                'age'      => $this->request->getPost('age'),
                'status'   => 'active', 
                'role'     => 'user',
                'nama'     => $defaultNama // Menggunakan nama yang sudah diekstrak
            ];
    
            // Simpan data user
            $this->userModel->insert($userData);
            $userId = $this->userModel->getInsertID();
    
            // Simpan level "Basic" untuk user tersebut
            $this->userLevelModel->insert([
                'user_id'             => $userId,
                'level'               => 'Basic',
                'coins'               => 0,
                'subscription_expiry' => null,
            ]);
    
            $db->transComplete();
    
            // Jika transaksi gagal (rollback terjadi)
            if ($db->transStatus() === FALSE) {
                log_message('error', 'Gagal mendaftar user baru karena DB error.');
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat mendaftar. Silakan coba lagi.');
            }
    
            session()->setFlashdata('pesan', 'Registrasi berhasil! Silakan login untuk memulai.');
            return redirect()->to(url_to('login'));
    
        } catch (\Exception $e) {
            // Tangkap jika ada error tak terduga (misal database mati)
            return redirect()->back()->withInput()->with('error', 'Error sistem: ' . $e->getMessage());
        }
    }

    public function checkSession()
    {
        $isLoggedIn = session()->get('isLoggedIn');
        return $this->response->setJSON(['isLoggedIn' => $isLoggedIn]);
    }

    public function index()
    {
        // Default method
    }
}