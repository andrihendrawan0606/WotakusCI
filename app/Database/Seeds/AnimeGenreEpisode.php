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
            ],           
            [
                'anime_id' => 6,
                'genre_id' => 2,
            ],           
            [
                'anime_id' => 6,
                'genre_id' => 19,
            ],           
            [
                'anime_id' => 6,
                'genre_id' => 16,
            ],           
            [
                'anime_id' => 6,
                'genre_id' => 20,
            ],           
            [
                'anime_id' => 6,
                'genre_id' => 1,
            ],           
            [
                'anime_id' => 7,
                'genre_id' => 2,
            ],           
            [
                'anime_id' => 7,
                'genre_id' => 21,
            ],           
            [
                'anime_id' => 7,
                'genre_id' => 1,
            ],          
            [
                'anime_id' => 8,
                'genre_id' => 6,
            ],           
            [
                'anime_id' => 8,
                'genre_id' => 9,
            ],           
            [
                'anime_id' => 8,
                'genre_id' => 20,
            ],           
            [
                'anime_id' => 8,
                'genre_id' => 12,
            ],           
            [
                'anime_id' => 9,
                'genre_id' => 2,
            ],           
            [
                'anime_id' => 9,
                'genre_id' => 5,
            ],           
            [
                'anime_id' => 9,
                'genre_id' => 1,
            ],           
            [
                'anime_id' => 9,
                'genre_id' => 3,
            ],           
            [
                'anime_id' => 10,
                'genre_id' => 5,
            ],           
            [
                'anime_id' => 10,
                'genre_id' => 1,
            ],           
            [
                'anime_id' => 10,
                'genre_id' => 3,
            ],           
            [
                'anime_id' => 10,
                'genre_id' => 2,
            ],           
            [
                'anime_id' => 11,
                'genre_id' => 2,
            ],           
            [
                'anime_id' => 11,
                'genre_id' => 21,
            ],           
            [
                'anime_id' => 11,
                'genre_id' => 15,
            ],           
            [
                'anime_id' => 11,
                'genre_id' => 13,
            ],           
            [
                'anime_id' => 11,
                'genre_id' => 25,
            ],           
            [
                'anime_id' => 11,
                'genre_id' => 3,
            ],           
            [
                'anime_id' => 12,
                'genre_id' => 2,
            ],           
            [
                'anime_id' => 12,
                'genre_id' => 21,
            ],           
            [
                'anime_id' => 12,
                'genre_id' => 15,
            ],           
            [
                'anime_id' => 12,
                'genre_id' => 13,
            ],           
            [
                'anime_id' => 12,
                'genre_id' => 25,
            ],           
            [
                'anime_id' => 13,
                'genre_id' => 2,
            ],           
            [
                'anime_id' => 13,
                'genre_id' => 21,
            ],    
            [
                'anime_id' => 14,
                'genre_id' => 2,
            ],           
            [
                'anime_id' => 14,
                'genre_id' => 19,
            ],           
            [
                'anime_id' => 14,
                'genre_id' => 1,
            ],           
            [
                'anime_id' => 15,
                'genre_id' => 21,
            ],           
            [
                'anime_id' => 15,
                'genre_id' => 8,
            ],           
            [
                'anime_id' => 15,
                'genre_id' => 20,
            ]
            ];
            $this->db->table('AnimeGenre')->insertBatch($data);
    }
}
