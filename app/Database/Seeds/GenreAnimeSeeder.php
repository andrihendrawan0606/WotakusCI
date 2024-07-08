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
                'slug_genre' => url_title('Shounen', '-', true),
            ],
            [
                'genre_id' => 1,
                'genre' => 'Action',
                'slug_genre' => url_title('Action', '-', true),
            ],
            
            [
                'genre_id' => 2,
                'genre' => 'Supernatural',
                'slug_genre' => url_title('Supernatural', '-', true),
            ],
            
            [
                'genre_id' => 1,
                'genre' => 'Horor',
                'slug_genre' => url_title('Horor', '-', true),
            ],           
            [
                'genre_id' => 1,
                'genre' => 'Demon',
                'slug_genre' => url_title('Demon', '-', true),
            ]
            ,            
            [
                'genre_id' => 4,
                'genre' => 'Drama',
                'slug_genre' => url_title('Drama', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Mystey',
                'slug_genre' => url_title('Mystey', '-', true),
            ]
            ,           
            [
                'genre_id' => 4,
                'genre' => 'Romance',
                'slug_genre' => url_title('Romance', '-', true),
            ]
            ,           
            [
                'genre_id' => 4,
                'genre' => 'Pyschological',
                'slug_genre' => url_title('Pyschological', '-', true),
            ]
            ,           
            [
                'genre_id' => 4,
                'genre' => 'Sports',
                'slug_genre' => url_title('Sports', '-', true),
            ]
            ,           
            [
                'genre_id' => 4,
                'genre' => 'Game',
                'slug_genre' => url_title('Game', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Slice of life',
                'slug_genre' => url_title('Slice of life', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Seinen',
                'slug_genre' => url_title('Seinen', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Music',
                'slug_genre' => url_title('Music', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Sci-Fi',
                'slug_genre' => url_title('Sci-Fi', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Magic',
                'slug_genre' => url_title('Magic', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Harem',
                'slug_genre' => url_title('Harem', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Martials Arts',
                'slug_genre' => url_title('Martials Arts', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Fantasy',
                'slug_genre' => url_title('Fantasy', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'School',
                'slug_genre' => url_title('School', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Comedy',
                'slug_genre' => url_title('Comedy', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Mecha',
                'slug_genre' => url_title('Mecha', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Sheinen',
                'slug_genre' => url_title('Sheinen', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Adventure',
                'slug_genre' => url_title('Adventure', '-', true),
            ],           
            [
                'genre_id' => 4,
                'genre' => 'Super Power',
                'slug_genre' => url_title('Super Power', '-', true),
            ]
        ];

        // Insert data ke dalam tabel
        $this->db->table('genre')->insertBatch($data);
    }
}
