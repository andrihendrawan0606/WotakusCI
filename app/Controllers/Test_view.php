<?php
namespace App\Controllers;
use CodeIgniter\Controller;
 
class Test_view extends Controller
{
    public function index()
    {
        $data['title']  = 'Niagahoster Tutorial';
        $data['msg1']    = 'Selamat datang di Niagahoster Tutorial';
        $data['msg2']    = 'Membuat aplikasi CRUD sederhana dengan CodeIgniter 4';
        echo view('test_view', $data);
    }
}