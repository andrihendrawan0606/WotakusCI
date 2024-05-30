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
	public function about()
	{
		// echo "about page";
        return view('about');
	}
    
    public function contact()
	{
		// echo "contact page";
        $data['name'] = "Petani Kode";
	echo view("contact", $data);
	}
    
    public function faqs()
	{
		// echo "Faqs page";
	}
    public function animesHome()
    {
        // $animes = new JjkModel();

        // /*
        //  siapkan data untuk dikirim ke view dengan nama $newses
        //  dan isi datanya dengan news yang sudah terbit
        // */
        // $data['animes'] = $animes->where('status', 'Completed' 'On-Going')->findAll();
    
        // // kirim data ke view
        // echo view('animesHome', $data);
        // $episode = $this->animeModel->getEpisode($id);

        $data = [
            'title' => 'Anime User',
            // 'anime' => $this->animeModel->getAnimes($Judul),
            // 'animes'=> $this->animeModel->getAnimes(),
            'animes'=> $this->animeModel->paginate(10, 'jujutsukaisen'),
            'pager' => $this->animeModel->pager
            // 'episode' => $episode
        ];
        // dd($data);
                // Kalo Detail anime tidak ada 
                if(empty($data['animes'])){
                    throw new \Codeigniter\Exception\PageNotFoundException('Judul Anime'.$Judul.'Tidak ada');
                }

        return view('animesHome',$data);
        // dd($data);
		
		// if(!$data['animes']){
		// 	throw PageNotFoundException::forPageNotFound();
		// }
		// echo view('admin/admin-partials/detail', $data);



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

    public function viewAnimes($slug)
    {
        $animes = new NewsModel();
		$data['animes'] = $animes->where([
			'slug' => $slug,
			'status' => 'Completed'])->first();

        // tampilkan 404 error jika data tidak ditemukan
		if (!$data['animes']) {
			throw PageNotFoundException::forPageNotFound();
		}

		echo view('welcome_message', $data);
    }

    public function AnimesDetail($id, $slug)
    {

        $anime = $this->animeModel->getAnimeWithGenres($id);
        if (isset($anime['genre'])) {
            $anime['genre'] = explode(',', $anime['genre']);
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
        $anime = $this->animeModel->find($id);
        $episode = $this->episodModel->find($id);
        // $anime = $this->animeModel->find($episode['anime_id']);
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
            // Jika slug tidak cocok, lempar pengecualian atau redirect ke URL yang benar
            return redirect()->to("/animesHome/animeinfo/PreviewVideo/$id/$generatedSlug");
        }
        $data = [
            'title' => 'Wotakus | ' .$anime['Judul'] .' | '. $episode['judul'],
            'anime' => $anime,
            'episode' =>  $episode,
        ];

        //  dd($data);

         return view('user/videoPre',  $data);
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
            'title' => 'Recent Anime Viewed',
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



    public function showGenre($title)
    {
        // $episodeModel = new EpisodeModel();
        // $data['episodes'] = $episodeModel->where('anime_id', $animeId)->findAll();
        // dd($data);

        $data = [
            'title' => 'Genre',
            'anime' => $this->GenreModel->getGenre($title),
            'animes'=> $this->GenreModel->getGenre()
        ];

        return view('user/animeInfo', $data);
    }

}