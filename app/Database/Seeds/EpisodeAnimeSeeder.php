<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EpisodeAnimeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'anime_id' => 1,
                'judul' => 'Episode 1',
                'slug-episode' => url_title('Episode 1', '-', true),
                'episode_number' => 1,
                'deskripsi' => 'Episode 1',
                'GambarPreview' => 'JujutsuPreview.jpg',
                'video_path' => 'Cote-1.mp4'
            ],
            [
                'anime_id' => 1,
                'judul' => 'Episode 2',
                'slug-episode' => url_title('Episode 2', '-', true),
                'episode_number' => 2,
                'deskripsi' => 'Episode 2',
                'GambarPreview' => 'JujutsuPreview2.jpg',
                'video_path' => 'Cote-2.mp4'
            ],
            
            [
                'anime_id' => 1,
                'judul' => 'Episode 3',
                'slug-episode' => url_title('Episode 3', '-', true),
                'episode_number' => 3,
                'deskripsi' => 'Episode 3',
                'GambarPreview' => 'JujutsuPreview3.webp',
                'video_path' => ''
            ],
            
            [
                'anime_id' => 2,
                'judul' => 'Episode 1',
                'slug-episode' => url_title('Episode 1', '-', true),
                'episode_number' => 1,
                'deskripsi' => 'Episode 1',
                'GambarPreview' => 'BnhaPreview.webp',
                'video_path' => ''
            ],
            
            [
                'anime_id' => 3,
                'judul' => 'Episode 1',
                'slug-episode' => url_title('Episode 1', '-', true),
                'episode_number' => 1,
                'deskripsi' => 'Episode 1',
                'GambarPreview' => 'KageNoPreview.jpg',
                'video_path' => ''
            ],
            
            [
                'anime_id' => 3,
                'judul' => 'Episode 2',
                'slug-episode' => url_title('Episode 2', '-', true),
                'episode_number' => 2,
                'deskripsi' => 'Episode 2',
                'GambarPreview' => 'KageNoPreview2.jpg',
                'video_path' => ''
            ],
            
            [
                'anime_id' => 3,
                'judul' => 'Episode 3',
                'slug-episode' => url_title('Episode 3', '-', true),
                'episode_number' => 3,
                'deskripsi' => 'Episode 3',
                'GambarPreview' => 'KageNoPreview3.jpg',
                'video_path' => ''
            ],
            
            [
                'anime_id' => 3,
                'judul' => 'Episode 4',
                'slug-episode' => url_title('Episode 4', '-', true),
                'episode_number' => 4,
                'deskripsi' => 'Episode 4',
                'GambarPreview' => 'KageNoPreview4.webp',
                'video_path' => ''
            ],
            
            [
                'anime_id' => 3,
                'judul' => 'Episode 5',
                'slug-episode' => url_title('Episode 5', '-', true),
                'episode_number' => 5,
                'deskripsi' => 'Episode 5',
                'GambarPreview' => 'KageNoPreview5.jpeg',
                'video_path' => ''
            ],
            
            [
                'anime_id' => 3,
                'judul' => 'Episode 6',
                'slug-episode' => url_title('Episode 6', '-', true),
                'episode_number' => 6,
                'deskripsi' => 'Episode 6',
                'GambarPreview' => 'KageNoPreview6.jpg',
                'video_path' => ''
            ],
            
            [
                'anime_id' => 4,
                'judul' => 'Episode 1',
                'slug-episode' => url_title('Episode 1', '-', true),
                'episode_number' => 1,
                'deskripsi' => 'Episode 1',
                'GambarPreview' => 'KusuriyaNoHitorigotoPreview.png',
                'video_path' => ''
            ],
            
            [
                'anime_id' => 4,
                'judul' => 'Episode 2',
                'slug-episode' => url_title('Episode 2', '-', true),
                'episode_number' => 2,
                'deskripsi' => 'Episode 2',
                'GambarPreview' => 'KusuriyaNoHitorigotoPreview2.jpg',
                'video_path' => ''
            ],
            
            [
                'anime_id' => 5,
                'judul' => 'Episode 1',
                'slug-episode' => url_title('Episode 1', '-', true),
                'episode_number' => 1,
                'deskripsi' => 'Episode 1',
                'GambarPreview' => 'TheTwoSidesOfVoiceActorRadioPreview.webp',
                'video_path' => ''
            ],
            
            [
                'anime_id' => 5,
                'judul' => 'Episode 2',
                'slug-episode' => url_title('Episode 2', '-', true),
                'episode_number' => 2,
                'deskripsi' => 'Episode 2',
                'GambarPreview' => 'TheTwoSidesOfVoiceActorRadioPreview2.webp',
                'video_path' => ''
            ]
        ];

        // Insert data ke dalam tabel
        $this->db->table('episodeanime')->insertBatch($data);
    }
}
