<?php namespace App\Controllers;

use Stichoza\GoogleTranslate\GoogleTranslate;
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
use App\Models\UserRecentAnimeModel;
use App\Models\UserLevelModel;
use App\Models\UserWatchedModel;
use App\Models\JadwalRilisModel;
use App\Models\StudioModel;
use CodeIgniter\I18n\Time;
use App\Events\LogEvent;
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
        $this->userRecentAnimeModel = new UserRecentAnimeModel();
        $this->userLevelModel = new UserLevelModel();
        $this->userWatchedModel = new UserWatchedModel();
        $this->animeJadwalRilis = new JadwalRilisModel();
        $this->studioModel = new StudioModel();
        // $this->episodeModel = new Genre();
    }

    public function aiSearch()
    {
        $query = $this->request->getVar('query');

        if(empty($query)) {
            // UBAH DISINI
            return $this->response->setJSON(['error' => 'Ketikan sesuatu dong!']);
        }

        // Hubungi API Python menggunakan CURL
        $pythonApiUrl = "http://127.0.0.1:8000/api/ai-search?query=" . urlencode($query);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pythonApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $pythonData = json_decode($response, true);

        // Pastikan pythonData tidak kosong / python error
        if (!$pythonData || !isset($pythonData['pesan_ai'])) {
            // UBAH DISINI JUGA
            return $this->response->setJSON([
                'status' => 'error',
                'pesan_ai' => 'Aduh, format jawaban AI tidak dikenali nih atau server AI mati.',
                'debug' => $pythonData
            ]);
        }

        $animeModel = new \App\Models\JjkModel();
        $finalData = [];

        if(!empty($pythonData['data'])) {
            foreach($pythonData['data'] as $ai_anime) {
                $detail = $animeModel->find($ai_anime['anime_id']);
                if($detail) {
                    $finalData[] = $detail;
                }
            }
        }

        // UBAH DISINI JUGA UNTUK HASIL AKHIRNYA
        return $this->response->setJSON([
            'status'   => 'success',
            'pesan_ai' => $pythonData['pesan_ai'],
            'animes'   => $finalData 
        ]);
    }
    
    public function animesHome()
    {
        $animes = $this->animeModel->getAnimesWithType();
        $heroRandom = $this->animeModel->getRandomAnimesWithType(5);

        $ongoing   = $this->animeModel->getAnimesByStatus('On-Going', 18);
        $completed = $this->animeModel->getAnimesByStatus('Completed', 18);

            // --- FITUR BARU: AMBIL REKOMENDASI PYTHON ---
        $userId = session()->get('id');
        $personalizedAnimes = [];

        // Hanya ambil rekomendasi jika user sudah login
        if ($userId) {
            $personalizedAnimes = $this->animeModel->getPythonRecommendations($userId);
        }

        $data = [
            'title' => 'Animes | ',
            'animes'=>  $animes,
            'heroList'   => $heroRandom, // Masukkan data random ke variabel baru
            'newEpisodes' => $this->episodModel->getNewEpisodesWithAnimeTitle(15),
            'popularAnimes' => $this->animeModel->getPopularAnimes(10), // Top 10 Populer
            'ongoing'     => $ongoing,    // Data presisi Ongoing
            'completed'   => $completed,  // Data presisi Completed
            'personalizedAnimes' => $personalizedAnimes, // Kirim ke View
            'pager' => $this->animeModel->pager
        ];
        // dd($data);
                // Kalo Detail anime tidak ada 
                if(empty($data['animes'])){
                    throw new \Codeigniter\Exception\PageNotFoundException('Judul Anime'.$Judul.'Tidak ada');
                }
        return view('animesHome' ,$data);
    }

        // 1. Fungsi Toggle (Untuk tombol di detail)
    public function toggleFavorite() {
        $json = $this->request->getJSON();
        $userId = session()->get('id');
        $animeId = $json->anime_id;
        
        $model = new \App\Models\UserFavoriteModel();
        $exists = $model->where(['user_id' => $userId, 'anime_id' => $animeId])->first();
        
        if ($exists) {
            $model->delete($exists['id']);
            return $this->response->setJSON(['status' => 'removed']);
        } else {
            $model->insert(['user_id' => $userId, 'anime_id' => $animeId]);
            return $this->response->setJSON(['status' => 'added']);
        }
    }

    // 2. Fungsi Index (Untuk menampilkan halaman List Favorit)
    public function myFavorites() 
    {
        // 1. CEK LOGIN SECARA PAKSA
        if (!session()->get('isLoggedIn')) {
            // Simpan URL saat ini agar setelah login user balik lagi ke sini
            $redirectUrl = current_url();
            return redirect()->to(url_to('login') . '?redirect=' . urlencode($redirectUrl))
                             ->with('error', 'Silakan login untuk melihat koleksi favorit Anda.');
        }
    
        $model = new \App\Models\UserFavoriteModel();
        $data = [
            'title'     => 'My Favorites | Wotakus',
            'favorites' => $model->getFavorites(session()->get('id')),
            'validation' => \Config\Services::validation() // Tambahkan ini agar tidak error di layout
        ];
        return view('user/favorites', $data);
    }

    public function deleteFavoriteBatch() {
        $ids = $this->request->getPost('anime_ids');
        $userId = session()->get('id');
    
        if ($ids) {
            $model = new \App\Models\UserFavoriteModel();
            $model->where('user_id', $userId)
                  ->whereIn('anime_id', $ids)
                  ->delete();
                  
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => count($ids) . ' anime berhasil dihapus dari favorit.'
            ]);
        }
    }

    public function profileUser()
    {
        $id = session()->get('id');
        $user = $this->userModel->select('users.*, user_level.level, user_level.coins')
                                ->join('user_level', 'user_level.user_id = users.id', 'left')
                                ->find($id);

        $data = [
            'title' => 'Profil Saya | Wotakus',
            'user'  => $user,
            'validation' => \Config\Services::validation()
        ];

        return view('user/profileUser', $data);
    }

    // Memproses update data
    public function updateProfileUser()
    {
        $id = session()->get('id');
        $userLama = $this->userModel->find($id);
    
        // 1. VALIDASI
        $rules = [
            'nama'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,$id]",
            'ProfileImg' => 'max_size[ProfileImg,2048]|is_image[ProfileImg]|mime_in[ProfileImg,image/jpg,image/jpeg,image/png,image/webp]'
        ];
    
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }
    
        // 2. LOGIKA GAMBAR
        $fileGambar = $this->request->getFile('ProfileImg');
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('assets/images', $namaGambar);
            if ($userLama['ProfileImg'] != 'default_profile.jpg' && file_exists('assets/images/' . $userLama['ProfileImg'])) {
                @unlink('assets/images/' . $userLama['ProfileImg']);
            }
        } else {
            $namaGambar = $this->request->getPost('oldProfileImg');
        }
    
        // 3. SIAPKAN DATA UPDATE
        $dataUpdate = [
            'nama'       => $this->request->getPost('nama'),
            'email'      => $this->request->getPost('email'),
            'ProfileImg' => $namaGambar
        ];
    
        if ($this->request->getPost('password')) {
            $dataUpdate['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }
    
        // 4. CEK PERUBAHAN DATA (Penting untuk menghindari DataException)
        // Kita bandingkan data baru dengan data lama
        $isChanged = false;
        foreach ($dataUpdate as $key => $value) {
            if ($value != $userLama[$key]) {
                $isChanged = true;
                break;
            }
        }
    
        // Hanya jalankan update jika ada data yang berubah
        if ($isChanged) {
            $this->userModel->update($id, $dataUpdate);
            
            // Refresh Session
            session()->set([
                'nama'       => $dataUpdate['nama'],
                'ProfileImg' => $dataUpdate['ProfileImg']
            ]);
            
            session()->setFlashdata('pesan', 'Profil berhasil diperbarui!');
        } else {
            session()->setFlashdata('pesan', 'Tidak ada data yang diubah.');
        }
    
        return redirect()->to(url_to('profileUser'));
    }

    public function genres()
    {
        $db = \Config\Database::connect();
        
        // Ambil parameter filter
        $selectedGenres = $this->request->getVar('genres') ?? [];
        $selectedStudio = $this->request->getVar('studio');
        $selectedStatus = $this->request->getVar('status');
        $selectedSeason = $this->request->getVar('season');
        $searchQuery    = $this->request->getVar('q');
    
        $builder = $this->animeModel->select('animes.*, animetipe.tipeAnime, AVG(anime_ratings.rating) as rating_user')
                                    ->join('animetipe', 'animes.typeId = animetipe.id', 'left')
                                    ->join('anime_ratings', 'anime_ratings.anime_id = animes.id', 'left'); // Join ke tabel rating
    
        // Filter: Judul
        if ($searchQuery) $builder->like('animes.Judul', $searchQuery);
    
        // Filter: Status
        if ($selectedStatus) $builder->where('animes.status', $selectedStatus);
    
        // Filter: Genre (Multi-select)
        if (!empty($selectedGenres)) {
            $builder->join('animegenre', 'animes.id = animegenre.anime_id')
                    ->whereIn('animegenre.genre_id', $selectedGenres)
                    ->groupBy('animes.id');
        }
    
        // Filter: Studio
        if ($selectedStudio) {
            $builder->join('anime_studios', 'animes.id = anime_studios.anime_id')
                    ->where('anime_studios.studio_id', $selectedStudio);
        }
    
        // Filter: Season (Berdasarkan Bulan Rilis)
        if ($selectedSeason) {
            $seasonMonths = [
                'winter' => [1, 2, 3],
                'spring' => [4, 5, 6],
                'summer' => [7, 8, 9],
                'fall'   => [10, 11, 12]
            ];
            $builder->whereIn('MONTH(animes.Rilis)', $seasonMonths[$selectedSeason]);
        }
    
        $animes = $builder->where('statusTayang', 'published')
                          ->groupBy('animes.id')
                          ->paginate(20, 'animes');
    
        $data = [
            'title'      => 'Browse Anime | Wotakus',
            'genres'     => $this->genreModel->findAll(),
            'studios'    => $this->studioModel->findAll(),
            'animes'     => $animes,
            'pager'      => $this->animeModel->pager,
            'filter'     => [
                'genres' => $selectedGenres,
                'studio' => $selectedStudio,
                'status' => $selectedStatus,
                'season' => $selectedSeason
            ]
        ];
    
        // JIKA REQUEST ADALAH AJAX, kembalikan hanya bagian grid-nya saja
        if ($this->request->isAJAX()) {
            return view('user/anime_grid', $data);
        }
    
        return view('user/animebyGenre', $data);
    }
    
    public function animesbyGenre($slugGenre)
    {
            $genre = $this->genreModel->getGenreBySlug($slugGenre);
            if (!$genre) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Genre tidak ditemukan.');
            }

            $page = $this->request->getVar('page') ?? 1;
            $perPage = 18;

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
            $animes = $this->animeModel
                ->like('Judul', $query)
                ->where('statusTayang', 'published') 
                ->findAll();
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

        if (!$anime || $anime['statusTayang'] !== 'published') {
            // Tampilkan pesan error jika anime tidak ditemukan atau statusnya draft
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Anime tidak ditemukan atau belum dipublikasikan.');
        }

            // --- LOGIKA RATING (TAMBAHKAN INI) ---
        $ratingModel = new \App\Models\AnimeRatingModel();
        $averageRating = $ratingModel->getAverageRating($anime['anime_id']);

        $totalVoters = $ratingModel->where('anime_id', $anime['anime_id'])->countAllResults();

        $myRating = 0;
        if (session()->has('id')) {
            $userRating = $ratingModel->where([
                'user_id'  => session()->get('id'),
                'anime_id' => $anime['anime_id']
            ])->first();
            
            $myRating = $userRating ? $userRating['rating'] : 0;
        }

        if (!empty($anime['all_genres_data'])) {
            $genres = explode(',', $anime['all_genres_data']);
            $anime['genre_list'] = array_map(function($genre) {
                list($id, $genre, $slug) = explode(':', $genre);
                return [
                    'id' => $id,
                    'genre' => trim($genre),
                    'slug_genre' => trim($slug)
                ];
            }, $genres);
        } else {
            $anime['genre_list'] = [];
        }
        

        $episode = $this->animeModel->getEpisode($anime['anime_id']);
        $totalEpisode = count($episode);

        // Dapatkan view_count untuk setiap episode
        foreach ($episode as &$ep) {
            $viewRecord = $this->episodeViews->where('episode_id', $ep['id'])->first();
            $ep['view_count'] = $viewRecord ? $viewRecord['view_count'] : 0;
        }

        // Get related anime
        $seriLainnya = $this->animeModel->getRelatedAnime($anime['anime_id']);
        $aiRecommendations = $this->animeModel->getPythonSimilarAnimes($anime['id']);

        // $anime['episodeanime'] = explode(',', $anime['judul']);

        
        $data = [
            'title' => $anime['Judul'] . ' | Wotakus ' ,
            // 'animes' => $this->animeModel->getAnimeWithGenres($id),
            'anime' => $anime,
            'episode' =>  $episode,
            'relatedAnime' => $seriLainnya,
            'franchiseAnimes' => $aiRecommendations['franchise'] ?? [], 
            'similarAnimes'   => $aiRecommendations['similar'] ?? [],
            'rating_user'      => $averageRating,
            'total_voters' => $totalVoters, // Kirim ke View
            'my_rating'   => $myRating,
        ];
        // dd($data);
        $animes = $this->animeModel->getAnimeWithGenresSlug($slug);
        if (!$animes) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
        }
        $id = $anime['anime_id'];
        
        // Cek jika user sudah login
        if (session()->has('id')) {
            // Simpan recent anime ke database jika user login
            $userId = session()->get('id');
            
            // Cek jika anime sudah ada di tabel recent_anime tanpa episode
            $existingAnime = $this->userRecentAnimeModel
            ->where('user_id', $userId)
            ->where('anime_id', $id)
            ->first();

            // Jika tidak ada atau episode_id null, tambahkan atau perbarui data recent anime
            if (!$existingAnime) {
            $this->userRecentAnimeModel->insert([
                'user_id' => $userId,
                'anime_id' => $id,
                'episode_id' => null,
            ]);
            }
        } else {
             // Simpan detail anime ke dalam cookie jika user belum login
            $recentAnime = get_cookie('recent_anime');
            $recentAnime = $recentAnime ? json_decode($recentAnime, true) : [];

            // Hapus jika sudah ada duplikat
            foreach ($recentAnime as $key => $item) {
                if ($item['id'] == $id) {
                    unset($recentAnime[$key]);
                }
            }

            // Tambahkan anime ke posisi paling depan
            array_unshift($recentAnime, [
                'id' => $id,
                'Judul' => $anime['Judul'],
                'Poster' => $anime['Poster'],
                'slug' => $anime['slug']
            ]);

            // Batasi array recent anime menjadi maksimal 50 item
            if (count($recentAnime) > 50) {
                array_pop($recentAnime); // Hapus item terakhir jika lebih dari 50
            }

            // Simpan kembali ke cookie dengan durasi 30 hari
            set_cookie('recent_anime', json_encode($recentAnime), 86400 * 30);
        }



        return view('user/animeInfo',  $data);

        // if(empty($data['animes'.'genres'])){
        //     throw new \Codeigniter\Exception\PageNotFoundException('Judul Anime'.$Judul.'Tidak ada');
        // }

    
    }

    public function saveRating()
    {
        $json = $this->request->getJSON();
        $userId = session()->get('id');
        $animeId = $json->anime_id;
        $ratingValue = $json->rating;

        if ($ratingValue < 1 || $ratingValue > 10) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Rating tidak valid']);
        }
    
        $ratingModel = new \App\Models\AnimeRatingModel();
    
        $existing = $ratingModel->where(['user_id' => $userId, 'anime_id' => $animeId])->first();
    
        if ($existing) {
            // Jika sudah ada, Update (Hanya 1 baris per user per anime)
            $ratingModel->update($existing['id'], ['rating' => $ratingValue]);
        } else {
            // Jika belum ada, Insert baru
            $ratingModel->insert([
                'user_id'  => $userId,
                'anime_id' => $animeId,
                'rating'   => $ratingValue
            ]);
        }
    
        // Ambil rata-rata terbaru setelah di-update
        $newAvg = $ratingModel->getAverageRating($animeId);
    
        return $this->response->setJSON([
            'status' => 'success',
            'new_avg' => number_format($newAvg, 1)
        ]);
    }

    public function deleteRating()
    {
        $json = $this->request->getJSON();
        $userId = session()->get('id');
        $animeId = $json->anime_id;

        $ratingModel = new \App\Models\AnimeRatingModel();

        // Hapus baris rating user tersebut pada anime tersebut
        $ratingModel->where(['user_id' => $userId, 'anime_id' => $animeId])->delete();

        // Hitung rata-rata baru (karena pembaginya berkurang 1 orang)
        $newAvg = $ratingModel->getAverageRating($animeId);

        return $this->response->setJSON([
            'status' => 'success',
            'new_avg' => number_format($newAvg, 1)
        ]);
    }

    public function showPreviewVideo($animeSlug, $episodeSlug)
    {
        $episode = $this->episodModel->getEpisodeBySlug($animeSlug, $episodeSlug);
        if (!$episode) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Episode tidak ditemukan.');
        }

            // Increment view count
        $this->incrementView($episode['id']);
    
        $anime = $this->animeModel->getAnimeBySlug($animeSlug);
        if (!$anime) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
        }
    
        // Cek apakah pengguna sudah login
        if (session()->has('isLoggedIn')) {
            $userLevel = session()->get('level');
            $userId = session()->get('id');
            $today = date('Y-m-d');
            $animeId = $anime['id'];
            $episodeId = $episode['id'];
    
            // Hitung jumlah episode yang sudah ditonton hari ini oleh user
            $watchedEpisodesToday = $this->episodeViews
                ->where('id', $userId)
                ->where('DATE(created_at)', $today)
                ->countAllResults();
    
            // Jika level pengguna adalah "Basic" dan sudah menonton 5 episode
            $maxEpisodesPerDay = 5;
            if ($userLevel === 'Basic' && $watchedEpisodesToday >= $maxEpisodesPerDay) {
                return redirect()->to('/animes-home')->with('error', 'Anda telah menonton 5 episode hari ini. Silakan kembali besok untuk menonton lagi.');
            }
        } else {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk menonton episode ini.');
        }
        

          // Ambil view count dari episode
        $viewRecord = $this->episodeViews->where('episode_id', $episode['id'])->first();
        $episode['view_count'] = $viewRecord ? $viewRecord['view_count'] : 0;
        
    
        $previousEpisode = $this->episodModel->getPreviousEpisode($anime['id'], $episode['id']);
        $nextEpisode = $this->episodModel->getNextEpisode($anime['id'], $episode['id']);
           // Ambil semua episode dengan view count
        $allEpisodes = $this->episodModel->getAllEpisodesWithViewsByAnimeId($anime['id']);

        // Cari record existing di recent_anime berdasarkan user_id dan anime_id
        $existingRecord = $this->userRecentAnimeModel
            ->where('user_id', $userId)
            ->where('anime_id', $animeId)
            ->first();

        if ($existingRecord) {
            // Update episode_id jika sudah ada anime_id
            $this->userRecentAnimeModel->update($existingRecord['id'], [
                'episode_id' => $episodeId
            ]);
        }
    
        $data = [
            'title' => $anime['Judul'] . ' | Episode ' . $episode['episode_number'] . ' | ' . 'Wotakus ' ,
            'anime' => $anime,
            'episode' => $episode,
            'EpisodeSebelumnya' => $previousEpisode,
            'EpisodeSelanjutnya' => $nextEpisode,
            'allEpisodes' => $allEpisodes,
            'userLevel' => $userLevel,
            // 'view_count' => formatViews($episode['view_count']) 
        ];
    
        return view('user/videoPre', $data);
    }
    

    // public function incrementView($episodeId)
    // {
    //     if ($this->request->isAJAX()) {
    //         // Ambil data episode berdasarkan ID
    //         $episode = $this->episodModel->find($episodeId);
    //         if ($episode) {
    //             // Ambil atau buat entri episode view
    //             $episodeView = $this->episodeViews->where('episode_id', $episodeId)->first();
    
    //             if ($episodeView) {
    //                 // Jika sudah ada, perbarui view count
    //                 $viewCount = $episodeView['view_count'] + 1;
    //                 $this->episodeViews->update($episodeView['id'], ['view_count' => $viewCount]);
    //             } else {
    //                 // Jika belum ada, buat entri baru
    //                 $this->episodeViews->insert([
    //                     'episode_id' => $episodeId,
    //                     'view_count' => 1
    //                 ]);
    //             }
    
    //             return $this->response->setJSON(['status' => 'success']);
    //         }
    
    //         // Jika episode tidak ditemukan
    //         log_message('error', 'Episode tidak ditemukan dengan ID: ' . $episodeId);
    //         return $this->response->setJSON(['status' => 'error', 'message' => 'Episode not found']);
    //     }
    
    //     // Jika bukan permintaan AJAX
    //     return $this->response->setStatusCode(403, 'Forbidden');
    // }

    public function incrementView($episodeId)
    {
    $userId = session()->get('user_id');
    
    // Pastikan fungsi ini hanya dijalankan untuk user yang sudah login
    if ($userId && $this->request->isAJAX()) {
        // Load models
        $usersLevelModel = new \App\Models\UsersLevelModel();
        $userWatchedEpisodeModel = new \App\Models\UserWatchedEpisodeModel();

        // Get user level
        $userLevel = $usersLevelModel->where('user_id', $userId)->first();

        if ($userLevel['level'] == 'Basic') {
            // Basic user logic
            $today = \CodeIgniter\I18n\Time::today();
            $watchCountToday = $userWatchedEpisodeModel->where('user_id', $userId)
                ->where('DATE(watched_at)', $today->toDateString())
                ->countAllResults();

            // Check if episode already watched today
            $episodeWatchedToday = $userWatchedEpisodeModel->where('user_id', $userId)
                ->where('episode_id', $episodeId)
                ->where('DATE(watched_at)', $today->toDateString())
                ->first();

            if ($watchCountToday >= 5 && !$episodeWatchedToday) {
                // Return early if limit reached
                return $this->response->setJSON(['status' => 'error', 'message' => 'Daily view limit reached']);
            }
        }

        // Increment view count
        $episode = $this->episodModel->find($episodeId);
        if ($episode) {
            $episodeView = $this->episodeViews->where('episode_id', $episodeId)->first();

            if ($episodeView) {
                $viewCount = $episodeView['view_count'] + 1;
                $this->episodeViews->update($episodeView['id'], ['view_count' => $viewCount]);
            } else {
                $this->episodeViews->insert([
                    'episode_id' => $episodeId,
                    'view_count' => 1
                ]);
            }

            return $this->response->setJSON(['status' => 'success']);
        }

        log_message('error', 'Episode tidak ditemukan dengan ID: ' . $episodeId);
        return $this->response->setJSON(['status' => 'error', 'message' => 'Episode not found']);
    }

    return $this->response->setStatusCode(403, 'Forbidden');
    }

    

    private function incrementWatchCount($userId, $episodeId)
    {
        $userWatchedEpisodeModel = new UserWatchedEpisodeModel();

        // Save watch data
        $userWatchedEpisodeModel->insert([
            'user_id'    => $userId,
            'episode_id' => $episodeId,
            'watched_at' => Time::now(),
        ]);
    }

    private function showLimitReachedWarning()
    {
        // Load SweetAlert2
        echo "
            <script>
                Swal.fire({
                    title: 'Limit Reached!',
                    text: 'You have reached your limit of 5 episodes today.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/home';
                    }
                });
            </script>
        ";
    }

    public function trackUserWatch($episodeId)
    {
        try {
            if ($this->request->isAJAX()) {
                log_message('debug', 'trackUserWatch: AJAX request received.');
    
                // Ambil data episode berdasarkan ID
                $episode = $this->episodModel->find($episodeId);
                if ($episode) {
                    log_message('debug', 'trackUserWatch: Episode found.');
    
                    // Ambil ID user dari session
                    $userId = session()->get('id');
                    if (!$userId) {
                        throw new \Exception('User is not logged in.');
                    }
    
                    $today = date('Y-m-d');
    
                    // Cek apakah user telah menonton episode ini hari ini
                    $alreadyWatched = $this->userWatchedEpisode
                        ->where('user_id', $userId)
                        ->where('episode_id', $episodeId)
                        ->where('DATE(watched_at)', $today)
                        ->countAllResults() > 0;
    
                    if (!$alreadyWatched) {
                        log_message('debug', 'trackUserWatch: User has not watched today, inserting record.');
                        // Jika belum menonton, tambahkan entri ke tabel user_watched_episode
                        $this->userWatchedEpisode->insert([
                            'user_id' => $userId,
                            'episode_id' => $episodeId,
                            'watched_at' => date('Y-m-d H:i:s')
                        ]);
    
                        return $this->response->setJSON(['status' => 'success']);
                    } else {
                        log_message('debug', 'trackUserWatch: User has already watched today.');
                        // Jika sudah menonton, berikan pesan error
                        return $this->response->setJSON(['status' => 'error', 'message' => 'Anda sudah menonton episode ini hari ini.']);
                    }
                }
    
                // Jika episode tidak ditemukan
                log_message('error', 'trackUserWatch: Episode not found with ID: ' . $episodeId);
                return $this->response->setJSON(['status' => 'error', 'message' => 'Episode tidak ditemukan']);
            }
    
            // Jika bukan permintaan AJAX
            return $this->response->setStatusCode(403, 'Forbidden');
        } catch (\Exception $e) {
            log_message('error', 'trackUserWatch: Exception occurred: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => 'Internal Server Error']);
        }
    }

    public function storeRecentAnimeToCookie($animeId, $animeData)
    {
        // Ambil data recent anime dari cookie
        $recentAnime = get_cookie('recent_anime');
        $recentAnime = $recentAnime ? json_decode($recentAnime, true) : [];

        // Hapus anime yang sudah ada jika terdapat duplikat
        foreach ($recentAnime as $key => $item) {
            if ($item['id'] == $animeId) {
                unset($recentAnime[$key]);
            }
        }

        // Tambahkan anime terbaru ke posisi paling depan
        array_unshift($recentAnime, [
            'id' => $animeId,
            'title' => $animeData['title'],
            'poster' => $animeData['poster'],
            'slug' => $animeData['slug']
        ]);

        // Batasi array recent anime menjadi maksimal 50 item
        if (count($recentAnime) > 50) {
            array_pop($recentAnime); // Hapus item terakhir
        }

        // Simpan kembali ke cookie dengan durasi 30 hari
        set_cookie('recent_anime', json_encode($recentAnime), 86400 * 30); // 30 hari
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


        $recentAnime = [];

        if (session()->has('id')) {
            // Jika user login, ambil recent anime dari database termasuk episode_id
            $userId = session()->get('id');
            $recentAnime = $this->userRecentAnimeModel->getRecentAnimesByUser($userId);
            
            // Pastikan recent anime tidak memiliki duplikasi dan urutkan berdasarkan waktu terbaru
            $recentAnime = array_map('unserialize', array_unique(array_map('serialize', $recentAnime)));
        } else {
            // Jika user tidak login, ambil recent anime dari cookie
            $recentAnime = get_cookie('recent_anime');
            $recentAnime = $recentAnime ? json_decode($recentAnime, true) : [];
    
            // Batasi hanya 50 item dan urutkan berdasarkan urutan dalam cookie (terbaru di atas)
            if (count($recentAnime) > 50) {
                $recentAnime = array_slice($recentAnime, 0, 50);
            }
        }
    
        $data = [
            'title' => 'Recent Anime Viewed | ',
            'recentAnime' => $recentAnime
        ];
    
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

    public function updateAnimeFromApi($malId)
    {
        // URL API Jikan untuk mengambil data anime berdasarkan mal_id
        $apiUrl = "https://api.jikan.moe/v4/anime/" . $malId;
        
        // Mengambil data dari API Jikan
        $response = file_get_contents($apiUrl);
        $animeData = json_decode($response, true)['data'];
        
        // Memasukkan data ke dalam database lokal menggunakan model
        $this->animeModel->insert([
            'mal_id' => $animeData['mal_id'],
            'Judul' => $animeData['title'],
            'Poster' => $animeData['images']['jpg']['large_image_url'],
            'BackgroundCover' => $animeData['images']['jpg']['large_image_url'],
            'Desc' => $animeData['synopsis'],
            'Eps' => $animeData['episodes'],
            'Durasi' => $animeData['duration'],
            'Rilis' => $animeData['aired']['from'],
            'JudulLainnya' => implode(", ", array_column($animeData['titles'], 'title')),
            'SeriLainnya' => $animeData['related'], 
            'typeId' => $animeData['type'],
            'status' => ($animeData['status'] == 'Finished Airing') ? 'Completed' : 'On-Going',
            'statusTayang' => 'published'
        ]);
        
        // Menyimpan genre jika ada
        $animeId = $this->animeModel->insertID();
        $this->updateAnimeGenres($animeId, $animeData['genres']);
        
        // Menampilkan pesan sukses
        return redirect()->to('animes-home')->with('message', 'Anime berhasil diperbarui dari API.');
    }

    public function updateAnimeGenres($animeId, $genres)
    {
        // Kosongkan genre yang lama dari anime jika ada
        $this->animeGenreModel->where('anime_id', $animeId)->delete();
    
        // Tambahkan genre baru
        foreach ($genres as $genre) {
            // Pastikan genre ada di tabel genres, jika tidak tambahkan
            $existingGenre = $this->genreModel->where('genre', $genre['name'])->first();
            if (!$existingGenre) {
                $this->genreModel->insert(['genre' => $genre['name']]);
                $genreId = $this->genreModel->insertID();
            } else {
                $genreId = $existingGenre['id'];
            }
    
            // Tambahkan genre ke tabel anime_genre
            $this->animeGenreModel->insert([
                'anime_id' => $animeId,
                'genre_id' => $genreId
            ]);
        }
    }

    public function updateMalId($animeId)
    {
        // Ambil data anime berdasarkan ID dari database
        $anime = $this->animeModel->find($animeId);
    
        if ($anime) {
            // Gunakan API Jikan untuk mencari data anime berdasarkan judul
            $client = \Config\Services::curlrequest();
            $response = $client->request('GET', 'https://api.jikan.moe/v4/anime', [
                'query' => ['q' => $anime['Judul']]
            ]);
    
            // Parse response JSON dari API Jikan
            $data = json_decode($response->getBody(), true);
    
            if (!empty($data['data'][0])) {
                // Ambil mal_id dari hasil API
                $malId = $data['data'][0]['mal_id'];
    
                // Update mal_id di database
                $this->animeModel->update($animeId, ['mal_id' => $malId]);
    
                return redirect()->back()->with('message', 'mal_id berhasil diperbarui untuk ' . $anime['Judul']);
            } else {
                return redirect()->back()->with('error', 'Anime tidak ditemukan di MyAnimeList');
            }
        } else {
            return redirect()->back()->with('error', 'Anime tidak ditemukan di database');
        }
    }

    public function updateAnimeDetails($animeId)
    {
        $anime = $this->animeModel->find($animeId);
    
        if ($anime && $anime['mal_id']) {
            $client = \Config\Services::curlrequest();
            $response = $client->request('GET', 'https://api.jikan.moe/v4/anime/' . $anime['mal_id']);
            $data = json_decode($response->getBody(), true);
    
            if (!empty($data['data'])) {
                $animeData = $data['data'];
    
                // Pastikan status dan field lain diambil dengan benar
                $status = isset($animeData['status']) ? $animeData['status'] : 'Unknown';
                $judulLainnya = isset($animeData['title_synonyms'][0]) ? implode(', ', $animeData['title_synonyms']) : $animeData['title_english'];
                $backgroundCover = isset($animeData['images']['jpg']['large_image_url']) ? $animeData['images']['jpg']['large_image_url'] : '';
    
                // Update data anime di database
                $this->animeModel->update($animeId, [
                    'Judul' => $animeData['title'],  // Judul dari API
                    'Desc' => $animeData['synopsis'], // Deskripsi dari API
                    'Eps' => $animeData['episodes'],  // Jumlah episode
                    'Durasi' => $animeData['duration'], // Durasi per episode
                    'Rilis' => $animeData['aired']['from'], // Tanggal rilis
                    'Poster' => $animeData['images']['jpg']['image_url'], // Poster dari API
                    'status' => $status, // Status dari API
                    'JudulLainnya' => $judulLainnya, // Judul lain (synonyms)
                    'BackgroundCover' => $backgroundCover, // Background cover
                    // 'typeId' => $this->getAnimeTypeId($animeData['type']) // Ambil ID tipe anime (TV, Movie, OVA, dll.)
                ]);
    
                return redirect()->back()->with('message', 'Data anime berhasil diperbarui dari API Jikan.');
            } else {
                return redirect()->back()->with('error', 'Data anime tidak ditemukan di API Jikan.');
            }
        } else {
            return redirect()->back()->with('error', 'Anime tidak ditemukan atau mal_id belum diisi.');
        }
    }

    public function updateAnimeEpisodes($animeId)
    {
        // Ambil data anime dari database
        $anime = $this->animeModel->find($animeId);

        if ($anime && $anime['mal_id']) {
            // Panggil API Jikan untuk mendapatkan episode berdasarkan mal_id
            $client = \Config\Services::curlrequest();
            $response = $client->request('GET', 'https://api.jikan.moe/v4/anime/' . $anime['mal_id'] . '/episodes');

            // Parse response JSON dari API Jikan
            $data = json_decode($response->getBody(), true);

            if (!empty($data['data'])) {
                foreach ($data['data'] as $episode) {
                    // Insert or update episode ke database
                    $this->episodeModel->insertOrUpdate([
                        'anime_id' => $animeId,
                        'episode_number' => $episode['mal_id'],
                        'judul_episode' => $episode['title'],
                        'sinopsis' => $episode['synopsis'],
                        'aired' => $episode['aired']
                    ]);
                }

                return redirect()->back()->with('message', 'Episodes berhasil diperbarui dari API Jikan.');
            } else {
                return redirect()->back()->with('error', 'Episodes tidak ditemukan di API Jikan.');
            }
        } else {
            return redirect()->back()->with('error', 'Anime tidak ditemukan atau mal_id belum diisi.');
        }
    }



    public function fetchAnimeData()
    {
        // helper(['anime', 'slug']);  // Pastikan slug helper dimuat
        $client = \Config\Services::curlrequest();
    
        $limit = 50; // Jumlah anime yang ingin diambil
        $fetched = 0;
    
        $totalPages = ceil($limit / 50); // Misal, 25 anime per halaman
        $startTime = microtime(true);
    
        // Inisialisasi progres
        $progressData = [
            'page' => 1,
            'fetched' => $fetched,
            'totalPages' => $totalPages,
            'status' => 'running'
        ];
    
        // Simpan progress awal
        file_put_contents(WRITEPATH . 'progress.json', json_encode($progressData));
    
        // Gunakan perulangan for untuk iterasi
        for ($i = 1; $i <= $limit; $i++) {
            // Ambil data dari API Jikan
            $response = $client->request('GET', 'https://api.jikan.moe/v4' . $i);
            $data = json_decode($response->getBody(), true);
    
            if (!empty($data['data'])) {
                foreach ($data['data'] as $anime) {
                    // Cek apakah judul anime sudah ada di database
                    $existingAnime = $this->animeModel->where('Judul', $anime['title'])->first();

                    if ($existingAnime) {
                        // Jika anime sudah ada, lanjutkan ke anime berikutnya
                        continue;
                    }
                    // Gunakan judul untuk membuat slug
                    $slug = generateSlug($anime['title']);

                    // Cek apakah sinopsis tersedia, jika tidak, berikan string kosong
                    $synopsis = !empty($anime['synopsis']) ? $anime['synopsis'] : 'Sinopsis tidak tersedia.';

                     // Ambil JudulLainnya dari title_japanese
                    $judulLainnya = null;
                    foreach ($anime['titles'] as $title) {
                        if ($title['type'] === 'Japanese') {
                            $judulLainnya = $title['title'];
                            break;
                        }
                    }

                    // Jika title_japanese tidak tersedia, gunakan judul utama dan terjemahkan ke bahasa Jepang
                    if (empty($judulLainnya)) {
                        $judulLainnya = $this->translateTextGoogle($anime['title'], 'ja', 'en');
                    }

                    // Terjemahkan sinopsis ke bahasa Indonesia menggunakan Google Translate
                    $translatedSynopsis = $this->translateTextGoogle($anime['synopsis'], 'id', 'en');
    
                    $animeData = [
                        'Judul'           => $anime['title'],
                        'slug'            => $slug, 
                        'Poster'          => $anime['images']['webp']['large_image_url'],
                        'BackgroundCover' => $anime['images']['webp']['large_image_url'] ?? null,
                        'Desc'            => $translatedSynopsis,
                        'Eps'             => $anime['episodes'] ?? 0,
                        'Durasi'          => $anime['duration'] ?? null,
                        'Rilis'           => $anime['aired']['from'] ?? null,
                        'JudulLainnya'   => $judulLainnya, 
                        // 'JudulLainnya'    => implode(', ', array_column($anime['titles'], 'title')),
                        'SeriLainnya'     => $anime['related']['adaptation'][0]['name'] ?? null,
                        'typeId'          => mapAnimeType($anime['type']),
                        'status'          => mapAnimeStatus($anime['status']),
                        'statusTayang'    => 'published',
                        'created_at'      => date('Y-m-d H:i:s'),
                    ];
    
                    // Simpan anime ke database
                    $this->animeModel->insert($animeData);
                    $animeId = $this->animeModel->insertID();  // Dapatkan ID anime yang baru disimpan
    
                    // Simpan genre dari API Jikan
                    if (!empty($anime['genres'])) {
                        foreach ($anime['genres'] as $genre) {
                        // Generate slug untuk genre
                        $genreSlug = generateSlug($genre['name']);

                            // Cari genre di database, jika tidak ada tambahkan
                            $existingGenre = $this->genreModel->where('genre', $genre['name'])->first();
                            
                            if ($existingGenre) {
                                $genreId = $existingGenre['id'];
                            } else {
                                // Tambahkan genre baru ke tabel genres
                                $this->genreModel->insert([
                                    'genre'      => $genre['name'],
                                    'slug_genre' =>$genreSlug,
                                
                                ]);
                                $genreId = $this->genreModel->insertID();
                            }
    
                            $this->animeGenre->insert([
                                'anime_id' => $animeId,
                                'genre_id' => $genreId,
                            ]);
                        }
                    }
    
                    // Tambah jumlah data yang sudah diambil
                    $fetched++;
                    // Update progressData
                    $progressData = [
                        'page' => $i,
                        'fetched' => $fetched,
                        'totalPages' => $totalPages,
                        'status' => 'running'
                    ];

                    // Simpan progress
                    file_put_contents(WRITEPATH . 'progress.json', json_encode($progressData));
    
                    if ($fetched >= $limit) {
                        break 2; // Keluar dari kedua loop
                    }
                }
            } else {
                break; // Berhenti jika tidak ada lagi data
            }
    
            sleep(1); 
        }
    
        // Selesai
        $endTime = microtime(true);
        $progressData = [
            'page' => $i,
            'fetched' => $fetched,
            'totalPages' => $totalPages, 
            'status' => 'completed',
            'duration' => round($endTime - $startTime, 2)
        ];
    
        // Simpan progress akhir
        file_put_contents(WRITEPATH . 'progress.json', json_encode($progressData));
        
    
        return $this->response->setJSON(['status' => 'success', 'message' => "$fetched anime berhasil diambil."]);
    }

    // Fungsi untuk menerjemahkan teks menggunakan Google Translate
    protected function translateTextGoogle($text, $targetLanguage = 'id', $sourceLanguage = 'en')
    {
        try {
            $tr = new GoogleTranslate();
            $tr->setSource($sourceLanguage); // Bahasa sumber
            $tr->setTarget($targetLanguage); // Bahasa target
            return $tr->translate($text);
        } catch (Exception $e) {
            // Jika terjadi error, kembalikan teks asli
            return $text;
        }
    }

    public function getProgress()
    {
        $progressPath = WRITEPATH . 'progress.json';

        if (!file_exists($progressPath)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Progress file not found.']);
        }

        $progress = json_decode(file_get_contents($progressPath), true);
        return $this->response->setJSON($progress);
    }

    // public function jadwalRilis(){

    //     $data = [
    //         'title' => 'Jadwal Rilis',
    //     ];
        
    //     return view('user/jadwalRilis', $data);
    // }

    public function jadwalRilis()
    {
        $jadwalRilis = $this->animeJadwalRilis
                            ->select('anime_jadwal_rilis.hari_rilis, animes.Judul, animes.Poster, animes.Desc, animes.Eps, animes.slug')
                            ->join('animes', 'animes.id = anime_jadwal_rilis.anime_id')
                            ->where('animes.status', 'On-Going')
                            ->findAll();

        $data = [
            // 'title' => 'Jadwal Rilis',
        ];
        foreach ($jadwalRilis as $jadwal) {
            $data[$jadwal['hari_rilis']][] = $jadwal; // Group by hari_rilis
        }

        return view('user/jadwalRilis', ['jadwal' => $data]);
    }

}