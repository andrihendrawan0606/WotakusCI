<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'Judul'  => 'Jujur Kasian',
                'Poster' => 'jjk1.jpg',
                'BackgroundCover' => 'jjk-cover.jpg',
                'Desc'  =>  'Yūji Itadori adalah seorang siswa SMA dengan atletisitas yang tidak wajar yang tinggal di Sendai bersama kakeknya. Ia sering menghindari Klub Lari karena keengganannya pada bidang atletik, meskipun dia memiliki bakat bawaan untuk olahraga tersebut. Sebali',
                'Eps'   => '24',
                'Durasi' => '24',
                'Rilis'  => '2020-10-20',
                'JudulLainnya' => '呪術廻戦',
                'SeriLainnya' => 'Jujutsu Kaisen Season 2',
                // 'genre_id' => 1,
                'status' => 'Completed'
            ],
            [
                'Judul'  => 'Boku no Hero Academia ',
                'Poster' => 'myheroacademia1.jpg',
                'BackgroundCover' => 'bokunoheroacademia-cover.png',
                'Desc'  =>  'Ceritanya mengisahkan tentang Izuku Midoriya (nama pahlawan: Deku), seorang anak lelaki tanpa kekuatan super (yang disebut quirk) di dunia tempat hal seperti itu sudah menjadi sesuatu yang umum, tetapi masih bercita-cita untuk menjadi seorang pahlawan.men',
                'Eps'   => '13',
                'Durasi' => '24',
                'Rilis'  => '2016-04-03',
                'JudulLainnya' => '僕のヒーローアカデミア',
                'SeriLainnya' => 'Boku No Hero Academia Season 2',
                // 'genre_id' => 3,
                'status' => 'Completed'
            ],
            [
                'Judul'  => 'Kage no Jitsuryokusha ni Naritakute',
                'Poster' => 'kageno1.jpg',
                'BackgroundCover' => 'KageNoJitsuryokushaNiNaritakute-cover.jpg',
                'Desc'  =>  'Bagi Cid Kagenou, menjadi seorang pahlawan dan penjahat merupakan keinginan banyak orang. Namun, Cid menilai bahwa orang yang berada di balik bayangan adalah suatu hal keren dan ia memimpikan hal tersebut',
                'Eps'   => '20',
                'Durasi' => '24',
                'Rilis'  => '2022-10-05',
                'JudulLainnya' => '陰の実力者になりたくて',
                'SeriLainnya' => 'Kage no Jitsuryokusha ni Naritakute 2',
                // 'genre_id' => 4,
                'status' => 'On-Going'
            ],
            [
                'Judul'  => 'kusuriya no hitorigoto',
                'Poster' => 'KusuriyaNoHitorigoto.jpg',
                'BackgroundCover' => 'KusuriyaNoHitorigoto-cover.jpg',
                'Desc'  =>  'Berlatar cerita di sebuah negara besar yang terletak di tengah benua. Ada seorang putri yang tinggal di bagian dalam istana tempat istri raja tinggal. Namanya adalah Maomao. Dulu dia bekerja sebagai apoteker di Hanamachi',
                'Eps'   => '21',
                'Durasi' => '24',
                'Rilis'  => '2024-03-20',
                'JudulLainnya' => '薬屋のひとりごと',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 2,
                'status' => 'Completed'
            ],
            [
                'Judul'  => 'The Two Sides of Voice Actor Radio',
                'Poster' => 'TheTwoSidesofVoiceActorRadio.jpg',
                'BackgroundCover' => 'TheTwoSidesofVoiceActorRadio-cover.jpg',
                'Desc'  =>  'Acara radio seiyu (pengisi suara) yang hangat telah dimulai. Dibawakan oleh Yuuhi dan Yasumi, dua seiyu yang akrab dan kebetulan juga teman kelas…itu',
                'Eps'   => '12',
                'Durasi' => '23',
                'Rilis'  => '2024-04-10',
                'JudulLainnya' => '声優ラジオのウラオモテ',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'Completed'
            ]
        ];
        $this->db->table('jujutsukaisen')->insertBatch($data);
    }
}
