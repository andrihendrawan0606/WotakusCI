<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run()
    {
        // Pastikan tabel anime_ratings, users, dan animes sudah ada isinya
        // Kita akan mengambil beberapa ID secara dinamis agar tidak error Foreign Key
        $db = \Config\Database::connect();
        
        // Ambil semua ID User yang ada
        $users = $db->table('users')->select('id')->get()->getResultArray();
        // Ambil semua ID Anime yang ada
        $animes = $db->table('animes')->select('id')->get()->getResultArray();

        // Jika data user atau anime kosong, jangan jalankan seeder
        if (empty($users) || empty($animes)) {
            echo "Gagal menjalankan seeder: Pastikan tabel users dan animes sudah ada datanya!";
            return;
        }

        $data = [
            [
                'user_id'    => $users[array_rand($users)]['id'],
                'anime_id'   => $animes[array_rand($animes)]['id'],
                'rating'     => 5,
                'review'     => 'Animenya sangat bagus! Plot twistnya tidak terduga.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'    => $users[array_rand($users)]['id'],
                'anime_id'   => $animes[array_rand($animes)]['id'],
                'rating'     => 4,
                'review'     => 'Grafisnya luar biasa, tapi ceritanya sedikit lambat di awal.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'    => $users[array_rand($users)]['id'],
                'anime_id'   => $animes[array_rand($animes)]['id'],
                'rating'     => 3,
                'review'     => 'Biasa saja, standar anime shounen pada umumnya.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'    => $users[array_rand($users)]['id'],
                'anime_id'   => $animes[array_rand($animes)]['id'],
                'rating'     => 5,
                'review'     => 'Karakter utamanya sangat relatable. Wajib tonton!',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'    => $users[array_rand($users)]['id'],
                'anime_id'   => $animes[array_rand($animes)]['id'],
                'rating'     => 2,
                'review'     => 'Kurang sreg sama endingnya, terlalu dipaksakan.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Masukkan data ke database
        $this->db->table('anime_ratings')->insertBatch($data);
        
        echo "RatingSeeder: Berhasil menambahkan 5 data rating dummy.\n";
    }
}
