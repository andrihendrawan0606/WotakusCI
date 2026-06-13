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
        $validation = $this->validate([
            'email' => 'required|valid_email',
            'password' => 'required'
        ]);
    
        if (!$validation) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $redirectUrl = $this->request->getPost('redirect') ?? $this->request->getGet('redirect'); // Ambil redirect dari form atau URL
    
        // Debugging log untuk redirect URL
        error_log('Redirect URL: ' . $redirectUrl);
    
        // Cek user berdasarkan email
        $user = $this->userModel->getUserByEmail($email);
    
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }
    
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }
    
        if ($user['Status'] !== 'active') {
            return redirect()->back()->with('error', 'Akun Anda tidak aktif.');
        }
    
        // Set session data
        session()->set([
            'id' => $user['id'],
            'nama' => $user['nama'],
            'email' => $user['email'],
            'role' => $user['role'],
            'ProfileImg' => $user['ProfileImg'],
            'level' => $user['level'],
            'isLoggedIn' => true
        ]);
        
        $this->userModel->update($user['id'], [
            'last_login' => date('Y-m-d H:i:s')
        ]);
    
        session()->setFlashdata('pesan', 'Berhasil Login.');
    
        // Redirect berdasarkan role atau redirect URL
        if (!empty($redirectUrl)) {
            return redirect()->to(urldecode($redirectUrl));
        } elseif ($user['role'] === 'admin') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('animes-home');
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
        $validation = $this->validate([
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'age' => 'required|integer|min_length[1]'
        ]);
    
        if (!$validation) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    
        $userData = [
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'age' => $this->request->getPost('age'),
            'status' => 'active', 
            'role' => 'user',
            'nama' => $this->request->getPost('email') 
        ];
    
        // Simpan data user
        $this->userModel->save($userData);
    
        // Ambil ID user yang baru disimpan
        $userId = $this->userModel->insertID();
    
        // Simpan level "Basic" untuk user tersebut
        $this->userLevelModel->insert([
            'user_id' => $userId,
            'level' => 'Basic',
            'coins' => 0,
            'subscription_expiry' => null,
        ]);
    
        session()->setFlashdata('pesan', 'Registrasi berhasil. Silakan login.');
        return redirect()->to('/auth/login');
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