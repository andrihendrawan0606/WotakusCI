<?php namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\UsersModel;
use App\Models\TagModel;
use App\Models\NewsTagModel;
use App\Models\NewsMediaModel;
use App\Models\JjkModel;
use App\Models\EpisodeModel;
use App\Models\Genre;
use App\Models\AnimeGenreEpisode;
use App\Models\EpisodeView;
use App\Models\SeriLainnya;
use CodeIgniter\Exceptions\PageNotFoundException;


class Page extends BaseController
{
    protected $animeModel;
    public function __construct()
    {
        $this->newsModel = new NewsModel();
        $this->userModel = new UsersModel();
        $this->tagModel = new TagModel();
        $this->newsTagModel = new NewsTagModel();
        $this->animeModel = new JjkModel();
        $this->episodModel = new EpisodeModel();
        $this->genreModel = new Genre();
        $this->animeGenre = new AnimeGenreEpisode();
        $this->episodeViews = new EpisodeView();
        $this->seriLainnya = new SeriLainnya();
        // $this->episodeModel = new Genre();
    }
    
    public function animesHome()
    {
        $data = [
            'title' => 'Animes | ',
            'animes'=>  $this->animeModel->where('statusTayang', 'published')->paginate(16, 'animes'),
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
    
    public function animesbyGenre($slugGenre)
    {
            $genre = $this->genreModel->getGenreBySlug($slugGenre);
            if (!$genre) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Genre tidak ditemukan.');
            }

            $page = $this->request->getVar('page') ?? 1;
            $perPage = 5;

            $animes = $this->animeModel->getAnimesByGenre($genre['id'], $perPage, ($page - 1) * $perPage);
            $totalAnimes = $this->animeModel->countAnimesByGenre($genre['id']);

            $data = [
                'title' => $genre['genre'] . ' | ',
                'animes' => $animes,
                'genre' => $genre,
                'pager' => \Config\Services::pager(),
                'page' => $page,
                'totalAnimes' => $totalAnimes,
                'perPage' => $perPage
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

    public function news()
    {
        $newsList = $this->newsModel->getNewsWithAuthor();

        $data = [
            'news' => $newsList,
        ];

        return view('user/news', $data);
    }

    public function newsDetail($slug)
    {
        $newsDetail = $this->newsModel->getNewsDetailBySlug($slug);

        if (!$newsDetail) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('News not found.');
        }

        $data = [
            'title' => $newsDetail['Judul'],
            'news' => $newsDetail
        ];

        // dd($data);
        return view('user/newsDetail', $data);
    }

    public function AnimesDetail($slug)
    {

        $anime = $this->animeModel->getAnimeWithGenresSlug($slug);
        // $desc = strip_tags($anime['Desc']); // Menghapus semua tag HTML
        // $desc_length = strlen($desc);
        // $anime['short_desc'] = strlen($desc) > 200 ? substr($desc, 0, 200) : $desc;
        // $anime['show_view_more'] = $desc_length > 200;

        if (!$anime) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Anime tidak ditemukan');
        }

        if (!empty($anime['genre'])) {
            $genres = explode(',', $anime['genre']);
            $anime['genre'] = array_map(function($genre) {
                list($id, $genre, $slug) = explode(':', $genre);
                return [
                    'id' => $id,
                    'genre' => trim($genre),
                    'slug_genre' => trim($slug)
                ];
            }, $genres);
        } else {
            $anime['genre'] = [];
        }
        

        $episode = $this->animeModel->getEpisode($anime['anime_id']);
        $totalEpisode = count($episode);

        // Get related anime
        $seriLainnya = $this->animeModel->getRelatedAnime($anime['anime_id']);
        $recommendedAnime = $this->animeModel->getRandomAnime($slug, 10);

        // $anime['episodeanime'] = explode(',', $anime['judul']);

        
        $data = [
            'title' => 'Wotakus | ' .$anime['Judul'],
            // 'animes' => $this->animeModel->getAnimeWithGenres($id),
            'anime' => $anime,
            'episode' =>  $episode,
            'relatedAnime' => $seriLainnya,
            'recommendedAnime' => $recommendedAnime
        ];
        // dd($data);
        $animes = $this->animeModel->getAnimeWithGenresSlug($slug);
        if (!$animes) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
        }
        $id = $anime['anime_id'];
        // Simpan detail anime ke dalam cookie
        $recentAnime = get_cookie('recent_anime');
        $recentAnime = $recentAnime ? json_decode($recentAnime, true) : [];

        // Tambahkan anime ke recent list, jika sudah ada maka hapus terlebih dahulu
        foreach ($recentAnime as $key => $item) {
            if ($item['id'] == $id) {
                unset($recentAnime[$key]);
            }
        }

        // Tambahkan anime ke awal array
        array_unshift($recentAnime, [
            'id' => $id, 
            'Judul' => $anime['Judul'], 
            'Poster' => $anime['Poster'],
            'slug' => $anime['slug']
        ]);

        // Simpan kembali ke cookies
        set_cookie('recent_anime', json_encode($recentAnime), 86400 * 30); // Simpan selama 30 hari
        
       // Simpan ID anime ke sesi
    //    $session = session();
    //    $recentAnime = $session->get('recent_anime') ?? [];

    //    // Hapus jika udah ada buat menghindari duplikasi
    //    $recentAnime = array_filter($recentAnime, function($value) use ($slug) {
    //        return $value != $slug;
    //    });

    //    // Tambahkan ID anime ke sesi (di awal array untuk mengatur urutan)
    //    array_unshift($recentAnime, $slug);

    //    // Simpan lagi ke sesi, dibatasin jumlah anime yang disimpan (misalnya 10)
    //    $session->set('recent_anime', array_slice($recentAnime, 0, 15));



        return view('user/animeInfo',  $data);

        // if(empty($data['animes'.'genres'])){
        //     throw new \Codeigniter\Exception\PageNotFoundException('Judul Anime'.$Judul.'Tidak ada');
        // }

    
    }

    public function showPreviewVideo($animeSlug, $episodeSlug)
    {
        $episode = $this->episodModel->getEpisodeBySlug($animeSlug, $episodeSlug);
        if (!$episode) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Episode tidak ditemukan.');
        }
    
        $anime = $this->animeModel->getAnimeBySlug($animeSlug);
        if (!$anime) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
        }
    
        $previousEpisode = $this->episodModel->getPreviousEpisode($anime['id'], $episode['id']);
        $nextEpisode = $this->episodModel->getNextEpisode($anime['id'], $episode['id']);
        $allEpisodes = $this->episodModel->getAllEpisodesByAnimeId($anime['id']);
    
        $data = [
            'title' => 'Wotakus | ' . $anime['Judul'] . ' | ' . $episode['judul'],
            'anime' => $anime,
            'episode' => $episode,
            'EpisodeSebelumnya' => $previousEpisode,
            'EpisodeSelanjutnya' => $nextEpisode,
            'allEpisodes' => $allEpisodes
        ];
        // dd($data);
    
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
            log_message('error', 'Episode tidak ditemukan dengan ID: ' . $episodeId);
            return $this->response->setJSON(['status' => 'error', 'message' => 'Episode not found']);
        }
    
        // Jika bukan permintaan AJAX
        return $this->response->setStatusCode(403, 'Forbidden');
    }

    public function recent()
    {
        // $session = session();
        // $recentAnimeIds = $session->get('recent_anime') ?? [];

        // $recentAnime = [];
        // if (!empty($recentAnimeIds)) {
        //     // Ambil anime berdasarkan ID dari database
        //     $recentAnime = $this->animeModel->whereIn('slug', $recentAnimeIds)->where('statusTayang','published')->findAll();

        //     // Urutkan anime berdasarkan urutan ID di sesi
        //     usort($recentAnime, function($a, $b) use ($recentAnimeIds) {
        //         return array_search($a['slug'], $recentAnimeIds) - array_search($b['slug'], $recentAnimeIds);
        //     });
        // }


        // Dapatkan recent anime dari cookies
        $recentAnime = get_cookie('recent_anime');
        $recentAnime = $recentAnime ? json_decode($recentAnime, true) : [];


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