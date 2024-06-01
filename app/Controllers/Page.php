<?php namespace App\Controllers;

use App\Models\JjkModel;
use App\Models\EpisodeModel;
use App\Models\Genre;
use App\Models\AnimeGenreEpisode;
use App\Models\EpisodeView;
use CodeIgniter\Exceptions\PageNotFoundException;


class Page extends BaseController
{
    protected $animeModel;
    public function __construct()
    {
        $this->animeModel = new JjkModel();
        $this->episodModel = new EpisodeModel();
        $this->genreModel = new Genre();
        $this->animeGenre = new AnimeGenreEpisode();
        $this->episodeViews = new EpisodeView();
        // $this->episodeModel = new Genre();
    }
    
    public function animesHome()
    {
        $data = [
            'title' => 'Animes | ',
            'animes'=> $this->animeModel->paginate(10, 'jujutsukaisen'),
            'pager' => $this->animeModel->pager
        ];
        // dd($data);
                // Kalo Detail anime tidak ada 
                if(empty($data['animes'])){
                    throw new \Codeigniter\Exception\PageNotFoundException('Judul Anime'.$Judul.'Tidak ada');
                }

        return view('animesHome' ,$data);
    }

    public function genres()
    {
        $data = [
            'title' => 'Genres | ',
            'genres' => $this->genreModel->getGenre()
        ];

        return view('user/animebyGenre', $data);
    }
    
    public function animesbyGenre($genreId, $namaGenre)
    {
        $data = [
            'title' => 'Anime berdasarkan genre',
            'animes' => $this->animeModel->getAnimesByGenre($genreId),
            'genre' => $this->genreModel->find($genreId)
        ];
        return view('user/viewAnimebyGenre', $data);
    }


    public function searchAnimePage()
    {
        $query = $this->request->getGet('query');
        if ($query) {
            $animes = $this->animeModel->like('Judul', $query)->findAll();
            return $this->response->setJSON($animes);
        }

        return $this->response->setJSON([]);
    }

    public function AnimesDetail($id, $slug)
    {

        $anime = $this->animeModel->getAnimeWithGenres($id);

        if (!empty($anime['genre'])) {
            $genres = explode(',', $anime['genre']);
            $anime['genre'] = array_map(function($genre) {
                list($id, $genre) = explode(':', $genre);
                return [
                    'id' => $id,
                    'genre' => trim($genre)
                ];
            }, $genres);
        } else {
            $anime['genre'] = [];
        }
        $episode = $this->animeModel->getEpisode($id);
        $totalEpisode = count($episode);


        // $anime['episodeanime'] = explode(',', $anime['judul']);

        $generatedSlug = url_title($anime['Judul'], '-', true);
        if ($slug !== $generatedSlug) {
            // Jika slug tidak cocok, lempar pengecualian atau redirect ke URL yang benar
            return redirect()->to("/animesHome/animeinfo/$id/$generatedSlug");
        }
        
        $data = [
            'title' => 'Wotakus | ' .$anime['Judul'],
            // 'animes' => $this->animeModel->getAnimeWithGenres($id),
            'anime' => $anime,
            'episode' =>  $episode
        ];
        // dd($data);
        
        // Simpan detail anime ke dalam cookies
        // $recentAnime = get_cookie('recent_anime');
        // $recentAnime = $recentAnime ? json_decode($recentAnime, true) : [];

        // // Tambahkan anime ke recent list, jika sudah ada maka hapus terlebih dahulu
        // foreach ($recentAnime as $key => $item) {
        //     if ($item['id'] == $id) {
        //         unset($recentAnime[$key]);
        //     }
        // }

        // // Tambahkan anime ke awal array
        // array_unshift($recentAnime, ['id' => $id, 'Judul' => $anime['Judul'], 'Poster' => $anime['Poster']]);

        // // Simpan kembali ke cookies
        // set_cookie('recent_anime', json_encode($recentAnime), 86400 * 30); // Simpan selama 30 hari
        
       // Simpan ID anime ke sesi
       $session = session();
       $recentAnime = $session->get('recent_anime') ?? [];

       // Hapus jika sudah ada untuk menghindari duplikasi
       $recentAnime = array_filter($recentAnime, function($value) use ($id) {
           return $value != $id;
       });

       // Tambahkan ID anime ke sesi (di awal array untuk mengatur urutan)
       array_unshift($recentAnime, $id);

       // Simpan kembali ke sesi, batasi jumlah anime yang disimpan (misalnya 10)
       $session->set('recent_anime', array_slice($recentAnime, 0, 15));



        return view('user/animeInfo',  $data);

        // if(empty($data['animes'.'genres'])){
        //     throw new \Codeigniter\Exception\PageNotFoundException('Judul Anime'.$Judul.'Tidak ada');
        // }

    
    }

    public function showPreviewVideo($id, $slug)
    {
        $episode = $this->episodModel->find($id);
        if (!$episode) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Episode tidak ditemukan.');
        }
    
        $anime = $this->animeModel->find($episode['anime_id']);
        if (!$anime) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
        }
    
        $generatedSlug = url_title($anime['Judul'], '-', true);
        if ($slug !== $generatedSlug) {
            return redirect()->to("/animesHome/animeinfo/PreviewVideo/$id/$generatedSlug");
        }
    
        $previousEpisode = $this->episodModel->getPreviousEpisode($anime['id'], $id);
        $nextEpisode = $this->episodModel->getNextEpisode($anime['id'], $id);
    
        $data = [
            'title' => 'Wotakus | ' . $anime['Judul'] . ' | ' . $episode['judul'],
            'anime' => $anime,
            'episode' => $episode,
            'EpisodeSebelumnya' => $previousEpisode,
            'EpisodeSelanjutnya' => $nextEpisode,
        ];
    
        return view('user/videoPre', $data);
    }

    public function incrementView($episodeId)
    {
        if ($this->request->isAJAX()) {
            // Ambil data episode berdasarkan ID
            $episode = $this->episodModel->find($episodeId);
            if ($episode) {
                // Ambil atau buat entri episode view
                $episodeView = $this->episodeViews->where('episode_id', $episodeId)->first();
    
                if ($episodeView) {
                    // Jika sudah ada, perbarui view count
                    $viewCount = $episodeView['view_count'] + 1;
                    $this->episodeViews->update($episodeView['id'], ['view_count' => $viewCount]);
                } else {
                    // Jika belum ada, buat entri baru
                    $this->episodeViews->insert([
                        'episode_id' => $episodeId,
                        'view_count' => 1
                    ]);
                }
    
                return $this->response->setJSON(['status' => 'success']);
            }
    
            // Jika episode tidak ditemukan
            log_message('error', 'Episode not found for ID: ' . $episodeId);
            return $this->response->setJSON(['status' => 'error', 'message' => 'Episode not found']);
        }
    
        // Jika bukan permintaan AJAX
        return $this->response->setStatusCode(403, 'Forbidden');
    }

    public function recent()
    {
        $session = session();
        $recentAnimeIds = $session->get('recent_anime') ?? [];

        $recentAnime = [];
        if (!empty($recentAnimeIds)) {
            // Ambil anime berdasarkan ID dari database
            $recentAnime = $this->animeModel->whereIn('id', $recentAnimeIds)->findAll();

            // Urutkan anime berdasarkan urutan ID di sesi
            usort($recentAnime, function($a, $b) use ($recentAnimeIds) {
                return array_search($a['id'], $recentAnimeIds) - array_search($b['id'], $recentAnimeIds);
            });
        }


        // Dapatkan recent anime dari cookies
        // $recentAnime = get_cookie('recent_anime');
        // $recentAnime = $recentAnime ? json_decode($recentAnime, true) : [];

        $data = [
            'title' => 'Recent Anime Viewed | ',
            'recentAnime' => $recentAnime
        ];

        // dd($data);

        return view('user/recentAnime', $data);
    }

    public function showEpisodes($title)
    {
        // $episodeModel = new EpisodeModel();
        // $data['episodes'] = $episodeModel->where('anime_id', $animeId)->findAll();

        $data = [
            'title' => 'Eps Anime',
            'anime' => $this->episodModel->getEpisode($title),
            'animes'=> $this->episodModel->getEpisode()
        ];

        return view('user/animeInfo', $data);
    }



    // public function showGenre($title)
    // {
    //     $data = [
    //         'title' => 'Genre',
    //         'anime' => $this->GenreModel->getGenre($title),
    //         'animes'=> $this->GenreModel->getGenre()
    //     ];

    //     return view('user/animeInfo', $data);
    // }

}