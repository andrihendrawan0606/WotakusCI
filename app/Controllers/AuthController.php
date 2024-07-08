<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
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

        $user = $this->userModel->getUserByEmail($email);

        // Debugging
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        // Debugging
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
            'isLoggedIn' => true
        ]);
        session()->setFlashdata('pesan',' Berhasil Login Sensei.');
        return redirect()->to('dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }

    public function index()
    {
        //
    }
}
