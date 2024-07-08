<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnimeTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['tipeAnime' => 'OVA'],
            ['tipeAnime' => 'ONA'],
            ['tipeAnime' => 'TV'],
            ['tipeAnime' => 'Movie'],
        ];

        $this->db->table('animeTipe')->insertBatch($data);
    }
}
