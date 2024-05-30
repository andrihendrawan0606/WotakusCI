<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GenreAnimeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'genre_id' => 1,
                'genre' => 'Shounen',
            ],
            [
                'genre_id' => 1,
                'genre' => 'Action',
            ],
            
            [
                'genre_id' => 2,
                'genre' => 'Supernatural',
            ],
            
            [
                'genre_id' => 1,
                'genre' => 'Horor',
            ],           
            [
                'genre_id' => 1,
                'genre' => 'Demon',
            ]
            ,            
            [
                'genre_id' => 4,
                'genre' => 'Drama',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Mystey',
            ]
            ,           
            [
                'genre_id' => 4,
                'genre' => 'Romance',
            ]
            ,           
            [
                'genre_id' => 4,
                'genre' => 'Pyschological',
            ]
            ,           
            [
                'genre_id' => 4,
                'genre' => 'Sports',
            ]
            ,           
            [
                'genre_id' => 4,
                'genre' => 'Game',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Slice of life',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Seinen',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Music',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Sci-Fi',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Magic',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Harem',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Martials Arts',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Fantasy',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'School',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Comedy',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Mecha',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Sheinen',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Adventure',
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Super Power',
            ]
            // Tambahkan data episode lainnya di sini
        ];

        // Insert data ke dalam tabel
        $this->db->table('genre')->insertBatch($data);
    }
}
