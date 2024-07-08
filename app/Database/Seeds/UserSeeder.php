<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\AnimeTypeModel;

class UserSeeder extends Seeder
{
    public function run()
    {
         // Instansiasi model AnimeTypeModel
         $animeTypeModel = new AnimeTypeModel();

         // Fungsi buat dapetin type_id berdasarkan nama tipe
         function getTypeIdByName($animeTypeModel, $typeName)
         {
             $type = $animeTypeModel->where('tipeAnime', $typeName)->first();
             return $type ? $type['id'] : null;
         }

        $data = [
            [
                'Judul'  => 'Jujur Kasian',
                'slug' => url_title('Jujur Kasian', '-', true),
                'Poster' => 'jjk1.jpg',
                'BackgroundCover' => 'jjk-cover.jpg',
                'Desc'  =>  'Yūji Itadori adalah seorang siswa SMA dengan atletisitas yang tidak wajar yang tinggal di Sendai bersama kakeknya. Ia sering menghindari Klub Lari karena keengganannya pada bidang atletik, meskipun dia memiliki bakat bawaan untuk olahraga tersebut. Sebali',
                'Eps'   => '24',
                'Durasi' => '24',
                'Rilis'  => '2020-10-20',
                'JudulLainnya' => '呪術廻戦',
                'SeriLainnya' => 'Jujutsu Kaisen Season 2',
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'Boku no Hero Academia ',
                'slug' => url_title('Boku no Hero Academia', '-', true),
                'Poster' => 'myheroacademia1.jpg',
                'BackgroundCover' => 'bokunoheroacademia-cover.png',
                'Desc'  =>  'Ceritanya mengisahkan tentang Izuku Midoriya (nama pahlawan: Deku), seorang anak lelaki tanpa kekuatan super (yang disebut quirk) di dunia tempat hal seperti itu sudah menjadi sesuatu yang umum, tetapi masih bercita-cita untuk menjadi seorang pahlawan.men',
                'Eps'   => '13',
                'Durasi' => '24',
                'Rilis'  => '2016-04-03',
                'JudulLainnya' => '僕のヒーローアカデミア',
                'SeriLainnya' => 'Boku No Hero Academia Season 2',
                // 'genre_id' => 3,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'Kage no Jitsuryokusha ni Naritakute',
                'slug' => url_title('Kage no Jitsuryokusha ni Naritakute', '-', true),
                'Poster' => 'kageno1.jpg',
                'BackgroundCover' => 'KageNoJitsuryokushaNiNaritakute-cover.jpg',
                'Desc'  =>  'Bagi Cid Kagenou, menjadi seorang pahlawan dan penjahat merupakan keinginan banyak orang. Namun, Cid menilai bahwa orang yang berada di balik bayangan adalah suatu hal keren dan ia memimpikan hal tersebut',
                'Eps'   => '20',
                'Durasi' => '24',
                'Rilis'  => '2022-10-05',
                'JudulLainnya' => '陰の実力者になりたくて',
                'SeriLainnya' => 'Kage no Jitsuryokusha ni Naritakute 2',
                // 'genre_id' => 4,
                'status' => 'On-Going',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'Kusuriya no hitorigoto',
                'slug' => url_title('Kusuriya no hitorigoto', '-', true),
                'Poster' => 'KusuriyaNoHitorigoto.jpg',
                'BackgroundCover' => 'KusuriyaNoHitorigoto-cover.jpg',
                'Desc'  =>  'Berlatar cerita di sebuah negara besar yang terletak di tengah benua. Ada seorang putri yang tinggal di bagian dalam istana tempat istri raja tinggal. Namanya adalah Maomao. Dulu dia bekerja sebagai apoteker di Hanamachi',
                'Eps'   => '21',
                'Durasi' => '24',
                'Rilis'  => '2024-03-20',
                'JudulLainnya' => '薬屋のひとりごと',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 2,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'The Two Sides of Voice Actor Radio',
                'slug' => url_title('The Two Sides of Voice Actor Radio', '-', true),
                'Poster' => 'seiyuradioPosterNew.webp',
                'BackgroundCover' => 'TheTwoSidesofVoiceActorRadio-cover.jpg',
                'Desc'  =>  'Acara radio seiyu (pengisi suara) yang hangat telah dimulai. Dibawakan oleh Yuuhi dan Yasumi, dua seiyu yang akrab dan kebetulan juga teman kelas…itu',
                'Eps'   => '12',
                'Durasi' => '23',
                'Rilis'  => '2024-04-10',
                'JudulLainnya' => '声優ラジオのウラオモテ',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'Jujutsu Kaisen 2',
                'slug' => url_title('Jujutsu Kaisen 2', '-', true),
                'Poster' => 'jujutsuS2Poster.jpg',
                'BackgroundCover' => 'jujutsuS2Banner.webp',
                'Desc'  =>  'Musim ini diawali dengan kilas balik ke tahun 2006, di mana kita mengikuti Satoru Gojo muda dan teman sekelasnya, Suguru Geto, saat mereka bersekolah di SMA Jujutsu. Kita akan melihat awal persahabatan mereka yang erat, yang kemudian berkembang menjadi perselisihan dan pertentangan ideologi. Di sini, kita akan memahami bagaimana Gojo menjadi penyihir Jujutsu yang sangat kuat dan Geto menjadi penjahat yang ingin memusnahkan semua non-penyihir.',
                'Eps'   => '23',
                'Durasi' => '24',
                'Rilis'  => '2023-06-06',
                'JudulLainnya' => ' 呪術廻戦',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'Spy x Family',
                'slug' => url_title('Spy x Family', '-', true),
                'Poster' => 'spyxfamilyPoster.jpg',
                'BackgroundCover' => 'spyxfamilyBanner.jpg',
                'Desc'  =>  'Di Spy x Family season 1, kita diajak mengikuti kisah mata-mata ulung bernama Twilight, yang memiliki misi rahasia untuk menyelidiki politisi ternama Donovan Desmond.  Untuk menjalankan misinya, Twilight harus membangun sebuah keluarga palsu.',
                'Eps'   => '12',
                'Durasi' => '24',
                'Rilis'  => '2023-04-09',
                'JudulLainnya' => 'スパイ×ファミリー',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'Classroom Of Elite',
                'slug' => url_title('Classroom Of Elite', '-', true),
                'Poster' => 'classroomofelitePoster.jpg',
                'BackgroundCover' => 'classroomofeliteBanner.jpg',
                'Desc'  =>  'Welcome to the Classroom of the Elite (Classroom of the Elite) | Berlatar di SMA Koudo Ikusei, sekolah paling bergengsi dengan fasilitas terbaik dan super mewah serta hampir 100% lulusan dari sekolah tersebut dapat dengan mudah diterima disemua Universitas & Perusahaan. Disana sistem pengajarannya sedikit berbeda dengan kebanyakan sekolah lainnya, para murid diberikan hak kebebasan yang tinggi seperti berpenampilan dan membawa alat-alat lain kesekolah, mereka juga menggunakan sistem Point untuk menggantikan Uang yang bertujuan untuk bertransaksi, misalnya seperti berbelanja dan lain sebagainya.',
                'Eps'   => '12',
                'Durasi' => '24',
                'Rilis'  => '2023-07-12',
                'JudulLainnya' => 'ようこそ実力至上主義の教室へ',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'Kingmetsu No Yaiba',
                'slug' => url_title('Kingmetsu No Yaiba', '-', true),
                'Poster' => 'DemonslayerPoster.jpg',
                'BackgroundCover' => 'DemonslayerBanner.jpg',
                'Desc'  =>  'Sejak dahulu, beredar rumor bahwa iblis pemakan manusia yang bersembunyi di dalam hutan akan muncul pada malam hari, karena itu, para penduduk tak ada yang berani keluar malam-malam. Dan pada saat yang sama akan muncul para pembunuh iblis (demon slayer) yang berkeliaran pada malam hari untuk memburu iblis.',
                'Eps'   => '26',
                'Durasi' => '24',
                'Rilis'  => '2019-04-06',
                'JudulLainnya' => '鬼滅の刃',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'Kimetsu no Yaiba: Hashira Geiko-hen',
                'slug' => url_title('Kimetsu no Yaiba: Hashira Geiko-hen', '-', true),
                'Poster' => 'DemonslayerS4Poster.jpg',
                'BackgroundCover' => 'demon_slayer_movie_singapore.jpg',
                'Desc'  =>  ' Arc ini berfokus pada pelatihan dan persiapan intensif para Pembasmi Iblis, khususnya Tanjiro Kamado dan sekutunya, saat mereka bersiap untuk pertempuran terakhir melawan raja iblis, Muzan Kibutsuji.',
                'Eps'   => '12',
                'Durasi' => '24',
                'Rilis'  => '2024-05-12',
                'JudulLainnya' => '柱稽古編',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'On-Going',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'One Punch Man',
                'slug' => url_title('One Punch Man', '-', true),
                'Poster' => 'OnepunchmanPoster.jpg',
                'BackgroundCover' => 'OnepunchmanBanner.jpg',
                'Desc'  =>  'Bercerita tentang seorang Hero bernama Saitama, memiliki kepala botak dengan ekspresi yang datar merupakan ciri khasnya, namun jangan salah, ia memiliki kekuatan yang luar biasa, ia dapat membunuh monster-monster kuat hanya dengan sekali pukulan.',
                'Eps'   => '12',
                'Durasi' => '24',
                'Rilis'  => '2015-10-05',
                'JudulLainnya' => 'ワンパンマン',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'One Punch Man Season 2',
                'slug' => url_title('One Punch Man Season 2', '-', true),
                'Poster' => 'OnepunchmanPosterS2.jpg',
                'BackgroundCover' => 'OnepunchmanBannerS2.webp',
                'Desc'  =>  'Saitama, sang protagonis yang overpowered, melanjutkan aksi pahlawannya sembari menghadapi tantangan baru dan menjelajahi dunia pahlawan yang lebih dalam.',
                'Eps'   => '12',
                'Durasi' => '23',
                'Rilis'  => '2019-04-10',
                'JudulLainnya' => 'ワンパンマン',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'Zom 100: Zombie ni Naru made ni Shitai 100 no Koto',
                'slug' => url_title('Zom 100: Zombie ni Naru made ni Shitai 100 no Koto', '-', true),
                'Poster' => 'zoom100Poster.jpg',
                'BackgroundCover' => 'zoom100Banner.webp',
                'Desc'  =>  'Akira Tendou merupakan karyawan muda yang secara tidak sengaja bekerja di sebuah perusahaan gelap selama 3 tahun lebih. Setiap hari, Akira selalu lembur dengan durasi kerja yang tidak wajar. Walau begitu, Akira masih tetap bertahan di perusahaan tersebut karena ia menyimpan perasaan terhadap karyawan lain bernama Ootori.',
                'Eps'   => '12',
                'Durasi' => '24',
                'Rilis'  => '2023-07-01',
                'JudulLainnya' => 'ゾン100ゾンビになるまでにしたい100のこと',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'Jigokuraku',
                'slug' => url_title('Jigokuraku', '-', true),
                'Poster' => 'jigokurakuPoster.jpg',
                'BackgroundCover' => 'jigokurakuBanner.webp',
                'Desc'  =>  'Kisah berpusat kepada Gabimaru, seorang pembunuh berdarah dingin yang berasal dari desa Iwagakure. Suatu hari, ia berkhianat dan membuatnya mendapatkan hukuman mati. Namun, berbagai cara telah dilakukan guna membunuh Gabimaru, sayang semuanya menjadi sia-sia saja.',
                'Eps'   => '13',
                'Durasi' => '23',
                'Rilis'  => '2023-04-01',
                'JudulLainnya' => '地獄楽',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ],
            [
                'Judul'  => 'Otonari no Tenshi-sama ni Itsunomanika Dame Ningen ni Sareteita Ken',
                'slug' => url_title('Otonari no Tenshi-sama ni Itsunomanika Dame Ningen ni Sareteita Ken', '-', true),
                'Poster' => 'OtonariNoTenshisamaPoster.jpg',
                'BackgroundCover' => 'OtonariNoTenshisamaBanner.jpg',
                'Desc'  =>  'Amane Fujimiya yang tengah berjalan di bawah hujan yang deras bertemu dengan Mahiru Shiina, seorang gadis cantik yang dijuluki sebagai Bidadari. Fujimiya yang melihat Shiina tengah duduk sembari terkena hujan menawarkan satu-satunya payung yang ia punya.',
                'Eps'   => '12',
                'Durasi' => '23',
                'Rilis'  => '2023-01-07',
                'JudulLainnya' => 'お隣の天使様にいつの間にか駄目人間にされていた件',
                'SeriLainnya' => 'Coming Soon',
                // 'genre_id' => 6,
                'status' => 'Completed',
                'statusTayang' => 'published',
                'typeId' => getTypeIdByName($animeTypeModel, 'TV')
            ]
        ];
        $this->db->table('animes')->insertBatch($data);
    }
}
