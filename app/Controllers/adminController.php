<?php namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\UsersModel;
use App\Models\TagModel;
use App\Models\NewsTagModel;
use App\Models\NewsMediaModel;
use App\Models\JjkModel;
use App\Models\Genre;
use App\Models\AnimeGenreEpisode;
use App\Models\EpisodeModel;
use App\Models\EpisodeView;
use App\Models\SeriLainnya;
use App\Models\AnimeTypeModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\File;

ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');
class adminController extends BaseController
{
    
    protected $animeModel;
    public function __construct()
    {
        $this->newsModel = new NewsModel();
        $this->userModel = new UsersModel();
        $this->tagModel = new TagModel();
        $this->newsTagModel = new NewsTagModel();
        $this->newsMediaModel = new NewsMediaModel();
        $this->animeModel = new JjkModel();
        $this->genreModel = new Genre();
        $this->animeGenreModel = new AnimeGenreEpisode();
        $this->episodeModel = new EpisodeModel();
        $this->episodeViews = new EpisodeView();
        $this->seriLainnya = new SeriLainnya();
        $this->animeType = new AnimeTypeModel();
    }

    public function userInfo()
    {
        $infoUser = $this->userModel->getUserDetail();

        $data = [
            'user' => $infoUser
        ];
    }

	public function dashboard()
	{
        // $animes = new JjkModel();

        // $animes = $this->animeModel->findAll();
        $daftarAnime = $this->animeModel->getAnimes();
        $totalAnime = count($daftarAnime);
        $totalEpisode = $this->episodeModel->countAllResults();
        // $anime = $this->animeModel->getAnimeWithGenres($id);
        $data = [
            'titile' => 'Dashboard',
            'animes' => $daftarAnime,
            'totalAnime' => $totalAnime,
            'totalEpisode' => $totalEpisode,
            // 'anime' => $anime
        ];
        // dd($data);
        // $data['animes'] = $animes->where('status', 'Completed')->findAll();
    
        // kirim data ke view
        echo view('admin/admin-partials/admin', $data);
    }

    public function searchAnime()
    {
        $query = $this->request->getGet('query');
        if ($query) {
            $animes = $this->animeModel->like('Judul', $query)->findAll();
            return $this->response->setJSON($animes);
        }

        return $this->response->setJSON([]);
    }

    public function genreList()
    {
        $genre = $this->genreModel->getGenre();
        $totalGenre = count($genre);

        $data = [
            'title' => 'Genre List',
            'genre' => $genre,
            'genres' => $totalGenre
        ];

        echo view('admin/admin-partials/genreList', $data);
    }

    public function genreTambah()
    {
        $data = [
            'title' => ' | Form Tambah Genre',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/admin-partials/tambahGenre', $data);
    }

    public function genreProses()
    {
        if(!$this->validate([
            'genre' =>[
                'rules'=>'required',
                'error'=>[
                    'required' => '{field} Genre Harus diisi'
                ]    
                ]
        ])){
             return redirect()->to('genreTambah')->withInput();
        }

        $genreName = $this->request->getPost('genre');
        $slug = $this->animeModel->createSlug($genreName);

        $this->genreModel->insert([
                'genre' => $genreName,
                'slug_genre' => $slug
            ]);

        session()->setFlashData('pesan','Data Udah ditambah');
        return redirect()->to('genreList')->withInput();
    }

    public function updateGenre($slug)
    {
        $genre = $this->genreModel->where('slug_genre', $slug)->first();
    
        if (!$genre) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Genre with slug ' . $slug . ' not found');
        }
    
        if (!$this->validate([
            'genre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Genre Harus diisi'
                ]
            ]
        ])) {
            return redirect()->to('genreEdit/' . $slug)->withInput();
        }
    
        $genreName = $this->request->getPost('genre');
        $newSlug = $this->animeModel->createSlug($genreName);
    
        $this->genreModel->update($genre['id'], [
            'genre' => $genreName,
            'slug_genre' => $newSlug
        ]);
    
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
        return redirect()->to('genreList')->withInput();
    }

    public function deleteGenre($id)
    {
        $genre = $this->genreModel->find($id);
    
        if (!$genre) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Genre tidak ditemukan'])->setStatusCode(404);
        }
    
        $this->genreModel->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data Genre berhasil dihapus']);
    }

//--------------------------------------------------------------------------
    
    public function preview($id)
	{
		$animes = new JjkModel();
		$data['animes'] = $animes->where('id', $id)->first();
		
		if(!$data['animes']){
			throw PageNotFoundException::forPageNotFound();
		}
		echo view('welcome_message', $data);
    }

//--------------------------------------------------------------------------

    public function Lihat($slug)
    {
        $anime = $this->animeModel->getAnimeWithGenresAdmin($slug);

        if (!$anime) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Anime tidak ditemukan');
        }

        $episode = $this->animeModel->getEpisode($anime['id']);
        $totalEpisode = count($episode);

        foreach ($episode as &$ep) {
            $viewRecord = $this->episodeViews->where('episode_id', $ep['id'])->first();
            $ep['view_count'] = $viewRecord ? $viewRecord['view_count'] : 0;
        }

        $data = [
            'title' => '| Detail Anime | ' . $anime['Judul'],
            'animes' => $anime,
            'episode' =>  $episode,
            'totalEpisode' => $totalEpisode,
        ];

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data['episode']);
        }

        if (empty($data['animes'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Anime' . $Judul . 'Tidak ada');
        }

        return view('admin/admin-partials/detail', $data);
    }

    public function fetchEpisodes($id)
    {
        $episodes = $this->animeModel->getEpisode($id);

        foreach ($episodes as &$ep) {
            $viewRecord = $this->episodeViews->where('episode_id', $ep['id'])->first();
            $ep['view_count'] = $viewRecord ? $viewRecord['view_count'] : 0;
        }

        return $this->response->setJSON(['data' => $episodes]);
    }

//--------------------------------------------------------------------------

    public function createEpisode($slug)
    {

        $anime = $this->animeModel->getAnimeWithGenresAdmin($slug);
        if (!$anime) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Anime tidak ditemukan');
        }

        $generatedSlug = url_title($anime['Judul'], '-', true);
        if ($slug !== $generatedSlug) {
            // Jika slug tidak cocok, lempar pengecualian atau redirect ke URL yang bener
            return redirect()->to("/dashboard/detail/prosesEpisode/$id/$generatedSlug");
        }
        // $episode['anime_id'] = $id;
        $data = [
            'title' => ' | Tambah Episode | ' .$anime['Judul'],
            'animeId' => $anime,
            'validation' => \Config\Services::validation()
        ];

        // dd($data);

        return view('admin/admin-partials/tambahEpisode', $data);
    }

//--------------------------------------------------------------------------

    public function prosesEpisode()
    {

        if(!$this->validate([
            'judul' =>[
                'rules'=>'required',
                'error'=>[
                    'required' => '{field} Episode Anime Harus diisi'
                ]    
                ],
            'episodeNumber' =>[
                        'rules'=>'required',
                        'error'=>[
                            'required'  => '{field} Anime Harus diisi',
                        ]    
                        ],
            // 'Deskripsi' =>[
            //             'rules'=>'required',
            //             'error'=>[
            //                 'required'  => '{field} Harus diisi',
            //             ]    
            //             ],
            'video_path' => [
                            'rules' => 'max_size[video_path,102400]|ext_in[video_path,mp4,avi,mkv]',
                            'errors' => [
                          
                                'max_size' => 'Ukuran video maksimal 100MB',
                                'ext_in' => 'Format video harus mp4, avi, atau mkv'
                            ]
            ]
                    
        ])){
            $anime_id = $this->request->getPost('anime_id');
            $anime = $this->animeModel->find($anime_id);
            $slug = url_title($anime['Judul'], '-', true);
            return redirect()->to("/dashboard/detail/createEpisode/{$slug}")->withInput();
        }


        $videoFile = $this->request->getFile('video_path');
        if ($videoFile->isValid() && !$videoFile->hasMoved()) {
            $newName = $videoFile->getName();
            $videoFile->move(FCPATH . 'assets/videos', $newName);   
        } else {
            session()->setFlashData('error', 'Upload video failed.');
            $anime_id = $this->request->getPost('anime_id');
            $anime = $this->animeModel->find($anime_id);
            $slug = url_title($anime['Judul'], '-', true);
            return redirect()->to("/dashboard/detail/createEpisode/{$slug}")->withInput();
        }
        

          // Mengelola pengunggahan gambar preview
        $fileGambarPreview = $this->request->getFile('gambarPreview');
        if ($fileGambarPreview->getError() == 4) {
            $namaGambarPreview = 'default.jpg';
        } else {
            if ($fileGambarPreview->isValid() && !$fileGambarPreview->hasMoved()) {
                // Menghasilkan nama file unik dengan nambahin timestamp
                $originalPreviewName = $fileGambarPreview->getName();
                $namaGambarPreview = time() . '_' . $originalPreviewName;
                $fileGambarPreview->move('assets/imgPreview', $namaGambarPreview);
            } else {
                session()->setFlashData('error', 'Upload gambar preview gagal.');
                return redirect()->to("/dashboard/detail/createEpisode/{$slug}")->withInput();
            }
        }

            $anime_id = $this->request->getPost('anime_id');
            $episodeNumber = $this->request->getPost('episodeNumber');
            $judul = $this->request->getPost('judul');
            $anime = $this->animeModel->find($anime_id);
            $slug = $this->episodeModel->createSlug($episodeNumber);
            $Deskripsi = $this->request->getPost('Deskripsi');


            // dd($genres);

            $animeData = [
                'anime_id' => $anime_id,
                'episode_number' => $episodeNumber,
                'judul' => $judul,
                'slug-episode' => $slug,
                'deskripsi' => $Deskripsi,
                'GambarPreview' => $namaGambarPreview,
                'video_path' => $newName
            ];

        // dd($animeData);


            $idData = $this->episodeModel->insert($animeData, true);
            $anime = $this->animeModel->find($anime_id);
            if (!$anime) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
            }
        
            $slug = url_title($anime['Judul'], '-', true);
            session()->setFlashData('pesan','Episode Udah ditambah');
            return redirect()->to("/dashboard/detail/{$anime['slug']}")->withInput();
    }

//--------------------------------------------------------------------------

    public function updateEpisode()
    {
        $id = $this->request->getPost('id');

        if (!$this->validate([
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Episode Anime Harus diisi'
                ]
            ],
            'episodeNumber' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Anime Harus diisi'
                ]
            ],
            'Deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'video_path' => [
                'rules' => 'max_size[video_path,102400]|ext_in[video_path,mp4,avi,mkv]',
                'errors' => [
                    'max_size' => 'Ukuran video maksimal 100MB',
                    'ext_in' => 'Format video harus mp4, avi, atau mkv'
                ]
            ]
        ])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => $this->validator->getErrors()]);
        }

        $oldVideoPath = $this->request->getPost('old_video_path');
        $videoFile = $this->request->getFile('video_path');
        $newName = null;

        if ($videoFile && $videoFile->isValid() && !$videoFile->hasMoved()) {
            $newName = $videoFile->getName();
            $videoFile->move(FCPATH . 'assets/videos', $newName);

            // Hapus video lama
            if ($oldVideoPath && file_exists(FCPATH . 'assets/videos/' . $oldVideoPath)) {
                unlink(FCPATH . 'assets/videos/' . $oldVideoPath);
            }
        }

        $fileGambarPreview = $this->request->getFile('gambarPreview');
        if ($fileGambarPreview && $fileGambarPreview->isValid() && !$fileGambarPreview->hasMoved()) {
            $originalPreviewName = $fileGambarPreview->getName();
            $namaGambarPreview = time() . '_' . $originalPreviewName;
            $fileGambarPreview->move('assets/imgPreview', $namaGambarPreview);
        }

        $anime_id = $this->request->getPost('anime_id');
        $episodeNumber = $this->request->getPost('episodeNumber');
        $judul = $this->request->getPost('judul');
        $Deskripsi = $this->request->getPost('Deskripsi');

        $animeData = [
            'episode_number' => $episodeNumber,
            'judul' => $judul,
            'deskripsi' => $Deskripsi,
        ];

        if (isset($namaGambarPreview)) {
            $animeData['GambarPreview'] = $namaGambarPreview;
        }

        if (isset($newName)) {
            $animeData['video_path'] = $newName;
        }

        $this->episodeModel->update($id, $animeData);
        session()->setFlashdata('pesan', 'Episode berhasil diupdate');
        return $this->response->setJSON(['success' => true]);
    }
            
    // public function create()
    // {
    //     // lakukan validasi
    //     $validation =  \Config\Services::validation();
    //     $validation->setRules(['Judul' => 'required']);
    //     $isDataValid = $validation->withRequest($this->request)->run();

    //     // jika data valid, simpan ke database
    //     if($isDataValid){
    //         $animes = new JjkModel();
    //         $animes->insert_batch([
    //             "Judul" => $this->request->getPost('Judul'),
    //             "Gambar" => $this->request->getPost('Gambar'),
    //             "Desc" => $this->request->getPost('Desc'),
    //             "Eps" => $this->request->getPost('Eps'),
    //             "Durasi" => $this->request->getPost('Durasi'),
    //             "Rilis" => $this->request->getPost('Rilis'),
    //             "JudulLainnya" => $this->request->getPost('JudulLainnya'),
    //             "genre_id" => $this->request->getPost('genre_id'),
    //             "Status" => $this->request->getPost('status'),
    //             // "slug" => url_title($this->request->getPost('slug'), '-', TRUE)
    //         ]);
    //         return redirect()->to('/dashboard');
    //     }
		
    //     // tampilkan form create
    //     return redirect()->to('/dashboard/tampilTambah');
    // }

//--------------------------------------------------------------------------

    public function tampilTambah()
    {
        session();
        $data = [
            'title' => ' | Form Tambah Anime',
            'animes' => $this->animeModel->getAnimes(),
            // 'id' => $this->animeModel->getId(),
            'genres' => $this->genreModel->getGenre(),
            'typeAnime' => $this->animeType->findAll(),
            'validation' => \Config\Services::validation()
        ];

        // dd($data);
        return view('admin/admin-partials/tambah', $data);
    }

//--------------------------------------------------------------------------

    public function prosesTambah()
    {
            if(!$this->validate([
                'Judul' =>[
                    'rules'=>'required|is_unique[animes.Judul]',
                    'error'=>[
                        'required' => '{field} Anime Harus diisi'
                    ]    
                    ],
                'BackgroundCover' => [
                        'rules' => 'max_size[BackgroundCover,2048]|is_image[BackgroundCover]|mime_in[BackgroundCover,image/jpg,image/jpeg,image/png,image/webp]',
                        'errors' =>[
                            'max_size' => 'Ukuran Gambar Brutal Banget njir',
                            'is_image' => 'Yang dipilih bukan gambar bjir',
                            'mime_in'  => 'Yang dipilih bukan gambar bjir'
                        ]
                        ],
                'Poster' => [
                            'rules' => 'max_size[Poster,2048]|is_image[Poster]|mime_in[Poster,image/jpg,image/jpeg,image/png,image/webp]',
                            'errors' =>[
                                'max_size' => 'Ukuran Gambar Brutal Banget njir',
                                'is_image' => 'Yang dipilih bukan gambar bjir',
                                'mime_in'  => 'Yang dipilih bukan gambar bjir'
                            ]
                            ],
                'Desc' =>[
                            'rules'=>'required',
                            'error'=>[
                                'required'  => '{field} Anime Harus diisi',
                            ]    
                            ],
                'Eps' =>[
                            'rules'=>'required',
                            'error'=>[
                            'required'  => '{field} Anime Harus diisi',
                            ]    
                            ],
                'Durasi' =>[
                            'rules'=>'required',
                            'error'=>[
                            'required'  => '{field} Harus diisi',
                            ]    
                            ],
                'Rilis' =>[
                            'rules'=>'required',
                            'error'=>[
                            'required'  => '{field} Harus diisi',
                            ]    
                            ],
                'JudulLainnya' =>[
                            'rules'=>'required',
                            'error'=>[
                            'required'  => '{field} Harus diisi',
                            ]
                            ],
                'genre' => [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Genre Harus diisi',
                                ]
                            ],
                'seriLainnya' => [
                                'rules' => 'permit_empty',
                            ]
                        
            ])){
                // $validation = \Config\Services::validation();
                return redirect()->to('/dashboard/tampilTambah')->withInput()->with('validation', \Config\Services::validation());
            }
                // dd('berhasil');

            // Ambil Gambar
            $fileBackgroundCover = $this->request->getFile('BackgroundCover');
            // Kalo gk upload gambar
            if($fileBackgroundCover->getError() == 4){
                $namaBackgroundCover = 'default.jpg';
            }else{

                $namaBackgroundCover = $fileBackgroundCover->getName();
                // Directori Gambar 
                $fileBackgroundCover->move('assets/images', $namaBackgroundCover);
                // Ambil nama file
            }

            $filePoster = $this->request->getFile('Poster');
            // Kalo gk upload gambar
            if($filePoster->getError() == 4){
                $namaPoster = 'default1.jpg';
            }else{
                // Directori Gambar 
                $namaPoster = $filePoster->getName();

                $filePoster->move('assets/images', $namaPoster);
                // Ambil nama file

            }

            // $id_anime = $this->request->getPost('id');
            $judul = $this->request->getPost('Judul');
            $slug = $this->animeModel->createSlug($judul);
            $Desc = $this->request->getPost('Desc');
            $Eps = $this->request->getPost('Eps');
            $Durasi = $this->request->getPost('Durasi');
            $Rilis = $this->request->getPost('Rilis');
            $JudulLainnya = $this->request->getPost('JudulLainnya');
            $typeid = $this->request->getPost('typeAnime');
            $status = $this->request->getPost('status');
            $id_genre = $this->request->getPost('genre');
            $seriLainnya = $this->request->getPost('seriLainnya');

            // dd($judul,$Desc,$Eps,$Durasi,$Rilis,$JudulLainnya,$status,$namaBackgroundCover,$namaPoster,$id_genre);

            // dd($genres);

            $animeData = [
                'Judul' => $judul,
                'slug' => $slug,
                'BackgroundCover' => $namaBackgroundCover,
                'Poster' => $namaPoster,
                'Desc' => $Desc,
                'Eps' => $Eps,
                'Durasi' => $Durasi,
                'Rilis' => $Rilis,
                'JudulLainnya' => $JudulLainnya,
                'typeId' => $typeid,
                'status' => $status,
                'statusTayang' => 'draft'
            ];

            $idData = $this->animeModel->insert($animeData, true);

            foreach ($id_genre as $genreId) {
                $this->animeGenreModel->insert([
                    'anime_id' => $idData,
                    'genre_id' => $genreId
                ]);
            }

            if ($seriLainnya) {
                foreach ($seriLainnya as $relatedAnimeId) {
                    $this->seriLainnya->insert([
                        'anime_id' => $idData,
                        'seriLainnya_id' => $relatedAnimeId
                    ]);
                }
            }
        
            session()->setFlashData('pesan','Anime dengan Judul ' .$animeData['Judul']. ' Berhasil ditambah');
            return redirect()->to('/dashboard')->withInput();
        
    }

//--------------------------------------------------------------------------

    public function edit($slug)
    {
    $anime = $this->animeModel->getAnimeWithGenresAdmin($slug);
    
    if (empty($anime)) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime dengan ID ' . $id . ' tidak ditemukan.');
    }

    $generatedSlug = url_title($anime['Judul'], '-', true);
        if ($slug !== $generatedSlug) {
            // Jika slug tidak cocok, lempar pengecualian atau redirect ke URL yang benar
            return redirect()->to("/dashboard/edit/$id/$generatedSlug");
        }

    // Ambil genre yang sudah dipilih
    $selectedGenre = $this->animeModel->selectedGenre($anime['id']);
    $relatedAnime = $this->animeModel->getRelatedAnime($anime['id']);

   
    if (!empty($anime['genre'])) {
        $anime['genre'] = explode(',', $anime['genre']);
    } else {
        $anime['genre'] = [];
    }
    // dd($anime);

    // Data untuk dikirim ke view
    $data = [
        'title' => '| Edit Anime | ' . $anime['Judul'],
        'animes' => $anime,
        // 'episode' => $episode,
        // 'totalEpisode' => $totalEpisode,
        'genres' => $this->genreModel->getGenre(),
        'selectedGenre' => $selectedGenre,
        'relatedAnime' => $relatedAnime,
        'typeAnime' => $this->animeType->findAll(),
        'animess' => $this->animeModel->findall(),
        'validation' => \Config\Services::validation()
    ];
    // dd($data);
    // Jika data anime tidak ada, lempar pengecualian
    if (empty($anime)) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime dengan ID ' . $id . ' tidak ditemukan.');
    }

    // Tampilkan view edit
    return view('admin/admin-partials/edit', $data);
    }

//--------------------------------------------------------------------------

    public function ProsesEdit($id)
    {
        if (!$this->validate([
            'Judul' => 'required',
            'Desc' => 'required',
            'Eps' => 'required|numeric',
            'Durasi' => 'required|numeric',
            'Rilis' => 'required|valid_date',
            'JudulLainnya' => 'required',
            'status' => 'required',
            'genre' => 'required',
            'BackgroundCover' => 'is_image[BackgroundCover]|mime_in[BackgroundCover,image/jpg,image/jpeg,image/png,image/webp]|max_size[BackgroundCover,2048]',
            'Poster' => 'is_image[Poster]|mime_in[Poster,image/jpg,image/jpeg,image/png,image/webp]|max_size[Poster,2048]',
        ])) {
            return redirect()->to('/dashboard/edit/' . $id)->withInput()->with('validation', $this->validator);
        }
        
        $fileBackgroundCover = $this->request->getFile('BackgroundCover');
        $backgroundCoverReset = $this->request->getPost('BackgroundCoverReset');
        $posterReset = $this->request->getPost('PosterReset');
        
        // Background Cover
        if ($backgroundCoverReset == '1') {
            $namafileBackgroundCover = 'default.jpg';
            // Hapus gambar lama jika bukan gambar default
            if ($this->request->getVar('BackgroundCoverOld') !== 'default.jpg') {
                unlink('assets/images/' . $this->request->getVar('BackgroundCoverOld'));
            }
        } else if ($fileBackgroundCover->getError() == 4) {
            $namafileBackgroundCover = $this->request->getVar('BackgroundCoverOld');
        } else {
            $namafileBackgroundCover = $fileBackgroundCover->getRandomName();
            $fileBackgroundCover->move('assets/images', $namafileBackgroundCover);
            // Hapus gambar lama jika bukan gambar default
            if ($this->request->getVar('BackgroundCoverOld') !== 'default.jpg') {
                unlink('assets/images/' . $this->request->getVar('BackgroundCoverOld'));
            }
        }
        
        // Poster
        $filePoster = $this->request->getFile('Poster');
        if ($posterReset == '1') {
            $namaPoster = 'default1.jpg';
            // Hapus gambar lama jika bukan gambar default
            if ($this->request->getVar('PosterOld') !== 'default1.jpg') {
                unlink('assets/images/' . $this->request->getVar('PosterOld'));
            }
        } else if ($filePoster->getError() == 4) {
            $namaPoster = $this->request->getVar('PosterOld');
        } else {
            $namaPoster = $filePoster->getRandomName();
            $filePoster->move('assets/images', $namaPoster);
            // Hapus gambar lama jika bukan gambar default
            if ($this->request->getVar('PosterOld') !== 'default1.jpg') {
                unlink('assets/images/' . $this->request->getVar('PosterOld'));
            }
        }

        $genre = $this->request->getPost('genre');
        $serilainnya = $this->request->getPost('seriLainnya');
        $judul = $this->request->getPost('Judul');
        $slug = $this->animeModel->createSlug($judul);
        $typeid = $this->request->getPost('typeAnime');
        $statustayang = $this->request->getPost('status_tayang') ?? 'draft';
        // Debugging: Lihat nilai status_tayang
        // var_dump($statustayang);
        // exit;
    
        $animeData = [
            'id' => $id,
            'Judul' => $judul,
            'slug' => $slug,
            'BackgroundCover' => $namafileBackgroundCover,
            'Poster' => $namaPoster,
            'Desc' => $this->request->getPost('Desc'),
            'Eps' => $this->request->getPost('Eps'),
            'Durasi' => $this->request->getPost('Durasi'),
            'Rilis' => $this->request->getPost('Rilis'),
            'JudulLainnya' => $this->request->getPost('JudulLainnya'),
            'typeId' => $typeid,
            'status' => $this->request->getPost('status'),
            'statusTayang' => $statustayang
        ];

        // dd($genre,$animeData);
    
        $this->animeModel->save($animeData);
    
        // Update genre
        $this->animeGenreModel->where('anime_id', $id)->delete();
        foreach ($this->request->getPost('genre') as $genreId) {
            $this->animeGenreModel->insert([
                'anime_id' => $id,
                'genre_id' => $genreId
            ]);
        }

         
        $this->seriLainnya->where('anime_id', $id)->delete();

        // Masukkan data seri lainnya
        if ($serilainnya) {
            foreach ($serilainnya as $relatedAnimeId) {
                $this->seriLainnya->insert([
                    'anime_id' => $id,
                    'seriLainnya_id' => $relatedAnimeId
                ]);
            }
        }
    
        session()->setFlashData('pesan', 'Anime dengan Judul ' . $judul . ' Berhasil diubah');
    
        return redirect()->to('/dashboard');

    }
    
//--------------------------------------------------------------------------

	public function deleteEpisode($id){
        
        $episode = $this->episodeModel->find($id);

        if (!$episode) {
            // Episode tidak ditemukan
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Episode tidak ditemukan.');
        }
    
        // Dapatkan informasi anime terkait dari episode yang dihapus
        $anime = $this->animeModel->find($episode['anime_id']);
    
        if (!$anime) {
            // Anime tidak ditemukan
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
        }
    
        // Hapus Gambar Preview jika bukan default
        if ($episode['GambarPreview'] != 'default.jpg') {
            $GambarPreviewPath = 'assets/imgPreview/' . $episode['GambarPreview'];
            if (file_exists($GambarPreviewPath)) {
                unlink($GambarPreviewPath);
            }
        }
    
        $videoPath = FCPATH . 'assets/videos/' . $episode['video_path'];
        if (file_exists($videoPath)) {
            unlink($videoPath);
        }
    
        // Hapus data episode dari database
        $this->episodeModel->delete($id);
        session()->setFlashdata('pesan',  $episode['slug-episode'] . ' sudah dihapus.');
    
        // Redirect ke halaman detail anime
        return redirect()->to("/dashboard/detail/{$anime['slug']}");
    }

//--------------------------------------------------------------------------

public function delete($slug)
{
    $anime = $this->animeModel->where('slug', $slug)->first();

    if (!$anime) {
        // Anime tidak ditemukan
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
    }

    // Hapus BackgroundCover jika bukan default
    if ($anime['BackgroundCover'] != 'default.jpg') {
        $backgroundCoverPath = 'assets/images/' . $anime['BackgroundCover'];
        if (file_exists($backgroundCoverPath)) {
            unlink($backgroundCoverPath);
        }
    }

    // Hapus Poster jika bukan default
    if ($anime['Poster'] != 'default1.jpg') {
        $posterPath = 'assets/images/' . $anime['Poster'];
        if (file_exists($posterPath)) {
            unlink($posterPath);
        }
    }

    // Hapus data dari database
    $this->animeModel->delete($anime['id']);
    session()->setFlashdata('pesan', 'Anime dengan Judul ' . $anime['Judul'] . ' sudah dihapus');
    return $this->response->setJSON(['success' => true]);
}

    // public function testTambah()
    // {
    //     return view('admin/admin-partials/testTambah');
    // }
    public function NewsList()
    {
        $data = [
            'title' => ' | List News',
            // 'animes' => $this->animeModel->getAnimes(),
            // 'id' => $this->animeModel->getId(),
            'news' => $this->newsModel->getNewsWithAuthor(),
            'tags' => $this->tagModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        // dd($data);
        return view('admin/admin-partials/newsList', $data);
    }

    public function TambahNews()
    {
        $data = [
            'title' => ' | Form Tambah News',
            'tags' => $this->tagModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        // dd($data);
        return view('admin/admin-partials/tambahNews', $data);
    }


    public function SaveNews()
    {
        if (!$this->validate([
            'JudulNews' => [
                'rules' => 'required|is_unique[news.Judul]',
                'errors' => [
                    'required' => '{field} Anime Harus diisi',
                    'is_unique' => '{field} sudah ada'
                ]
            ],
            'tags' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'isi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
        ])) {
            return redirect()->to('/dashboard/tambahNews')->withInput()->with('validation', \Config\Services::validation());
        }
    
        $JudulNews = $this->request->getPost('JudulNews');
        $subJudulNews = $this->request->getPost('subJudulNews');
        $isiNews = $this->request->getPost('isi');
        $id_tags = $this->request->getPost('tags');
        $gambarPreviewNews = $this->request->getFile('previewGambarNews');
    
        // Debugging: Print the data

        // echo "<pre>";
        // print_r([
        //     'JudulNews' => $JudulNews,
        //     'isi' => $isiNews,
        //     'tags' => $id_tags,
        //     'waktu_penayangan' => $waktu_penayangan
        // ]);
        // echo "</pre>";
        // exit;
    

        // Lanjutkan kode jika data udah benar
        $session = session();
        $user_id = $session->get('id');


        if ($gambarPreviewNews && $gambarPreviewNews->isValid() && !$gambarPreviewNews->hasMoved()) {
            $gambarPreviewName = $gambarPreviewNews->getRandomName();
            $gambarPreviewNews->move('assets/imgPreview', $gambarPreviewName);
        } else {
            $gambarPreviewName = null; // or a default image name
        }
        // // Set locale to Indonesian
        // setlocale(LC_TIME, 'id_ID.UTF-8');
        // $waktu_penayangan = strftime('%A, %d %B %Y');
    
        // Get current date in YYYY-MM-DD format
        $waktu_penayangan = date('Y-m-d');
        $slug = $this->newsModel->createSlug($JudulNews);

        $newsData = [
            'Judul' => $JudulNews,
            'slug' => $slug,
            'subJudul' => $subJudulNews,
            'isiKonten' => $isiNews,
            'user_id' => $user_id,
            'waktu_penayangan' => $waktu_penayangan,
            'preview_gambar' => $gambarPreviewName
        ];
    
        $idData = $this->newsModel->insert($newsData, true);
    
        foreach ($id_tags as $tagsId) {
            $this->newsTagModel->insert([
                'news_id' => $idData,
                'tag_id' => $tagsId
            ]);
        }
    
        session()->setFlashData('pesan', 'Data Udah ditambah');
        return redirect()->to('/newsList')->withInput();
    }
    
    public function uploadGambarNews()
    {
        if ($this->request->getFile('file')){
            $dataFile = $this->request->getFile('file');
            $fileName = $dataFile->getName();
            $dataFile->move("uploads/berkas/", $fileName);
            echo base_url("uploads/berkas/$fileName");
        }
    }

    public function deleteGambarNews()
    {
        $src = $this->request->getVar('src');

        if ($src) {
            // DIR'/uploads/berkas/download.jpg'
            $filePath = FCPATH . ltrim($src, '/');

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    return $this->response->setStatusCode(200)->setBody("Delete berhasil");
                } else {
                    return $this->response->setStatusCode(500)->setBody("Gagal menghapus file");
                }
            } else {
                return $this->response->setStatusCode(404)->setBody("File tidak ditemukan");
            }
        } else {
            return $this->response->setStatusCode(400)->setBody("Tidak ada src yang diberikan");
        }
    }

    public function listGambar()
    {
        $files = array_filter(glob('uploads/berkas/*'), 'is_file');
        $response = [];
        foreach ($files as $file) {
            if (strpos($file, "index.html")) {
                continue;
            }
            $response[] = basename($file);
        }
        header("Content-Type:application/json");
        echo json_encode($response);
        die();
    }
}