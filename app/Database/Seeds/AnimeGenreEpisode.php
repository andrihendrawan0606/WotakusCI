<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnimeGenreEpisode extends Seeder
{
    public function run()
    {
        $data = [
            [
                'anime_id' => 1,
                'genre_id' => 1,
            ],
            [
                'anime_id' => 1,
                'genre_id' => 2,
            ],
            
            [
                'anime_id' => 1,
                'genre_id' => 3,
            ],
            
            [
                'anime_id' => 2,
                'genre_id' => 1,
            ],           
            [
                'anime_id' => 3,
                'genre_id' => 5,
            ],           
            [
                'anime_id' => 4,
                'genre_id' => 20,
            ],           
            [
                'anime_id' => 5,
                'genre_id' => 17,
            ],           
            [
                'anime_id' => 5,
                'genre_id' => 16,
            ]
            ];
            $this->db->table('AnimeGenreEpisode')->insertBatch($data);
    }
}
