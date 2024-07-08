<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Anya Porger',
                'email' => 'anyaPorger123@gmail.com',
                'password' => password_hash('anyaPorger321', PASSWORD_DEFAULT),
                'ProfileImg' => 'anya.jpg',
                'role' => 'admin',
                'Status' => 'active'
            ],
            [
                'nama' => 'Admin',
                'email' => 'admin@contoh.com',
                'ProfileImg' => 'test.jpg',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'Status' => 'active'
            ]
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
