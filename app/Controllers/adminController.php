<?php namespace App\Controllers;

use App\Models\JjkModel;
use App\Models\Genre;
use App\Models\AnimeGenreEpisode;
use App\Models\EpisodeModel;
use App\Models\EpisodeView;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\File;

ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');
class adminController extends BaseController
{
    
    protected $animeModel;
    public function __construct()
    {
        $this->animeModel = new JjkModel();
        $this->genreModel = new Genre();
        $this->animeGenreModel = new AnimeGenreEpisode();
        $this->episodeModel = new EpisodeModel();
        $this->episodeViews = new EpisodeView();
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

    public function Lihat($id, $slug)
    {
        // $animes = new JjkModel();
        // $animes = $this->animeModel->getAnimes($Judul);
		// $animes['animes'] = $animes->where('id', $id)->first();

        // $data = [
        //     'title' => 'Detail Anime',
        //     // 'anime' => $this->animeModel->getGenre(),
        //     'animes'=> $this->animeModel->getAnimeWithGenres($Judul)
            
        // ];

        $anime = $this->animeModel->getAnimeWithGenres($id);
        if (!$anime) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime dengan ID ' . $id . ' tidak ditemukan.');
        }

        $generatedSlug = url_title($anime['Judul'], '-', true);
        if ($slug !== $generatedSlug) {
            // Jika slug tidak cocok, lempar pengecualian atau redirect ke URL yang benar
            return redirect()->to("/dashboard/detail/$id/$generatedSlug");
        }
        // $anime['genre'] = explode(',', $anime['genre']);
        // $episode['episode_number'] = explode(',', $anime['judul']);
        $episode = $this->animeModel->getEpisode($id);
        $totalEpisode = count($episode);
        // Ambil view count untuk setiap episode
        foreach ($episode as &$ep) {
            $viewRecord = $this->episodeViews->where('episode_id', $ep['id'])->first();
            $ep['view_count'] = $viewRecord ? $viewRecord['view_count'] : 0;
        }

        $data = [
            'title' => '| Detail Anime | ' .$anime['Judul'],
            'animes' => $anime,
            // 'anime' => $this->animeModel->getEpisode($Judul)
            'episode' =>  $episode,
            'totalEpisode' => $totalEpisode,
        ];
        

        // dd($data);

        return view('admin/admin-partials/detail', $data);

        // Kalo Detail anime tidak ada 
        if(empty($data['animes'])){
            throw new \Codeigniter\Exception\PageNotFoundException('Judul Anime'.$Judul.'Tidak ada');
        }
    }

//--------------------------------------------------------------------------

    public function createEpisode($id, $slug)
    {

        $anime = $this->animeModel->getAnimeWithGenres($id);
        if (!$anime) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime dengan ID ' . $id . ' tidak ditemukan.');
        }

        $generatedSlug = url_title($anime['Judul'], '-', true);
        if ($slug !== $generatedSlug) {
            // Jika slug tidak cocok, lempar pengecualian atau redirect ke URL yang benar
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
                    'required' => '{field} Anime Harus diisi'
                ]    
                ],
            'episodeNumber' =>[
                        'rules'=>'required',
                        'error'=>[
                            'required'  => '{field} Anime Harus diisi',
                        ]    
                        ],
            'Deskripsi' =>[
                        'rules'=>'required',
                        'error'=>[
                            'required'  => '{field} Harus diisi',
                        ]    
                        ],
            'video_path' => [
                            'rules' => 'uploaded[video_path]|max_size[video_path,102400]|ext_in[video_path,mp4,avi,mkv]',
                            'errors' => [
                                'uploaded' => 'Video harus diunggah',
                                'max_size' => 'Ukuran video maksimal 100MB',
                                'ext_in' => 'Format video harus mp4, avi, atau mkv'
                            ]
            ]
                    
        ])){
             return redirect()->to('/dashboard/detail/createEpisode')->withInput();
        }


        $videoFile = $this->request->getFile('video_path');
        if ($videoFile->isValid() && !$videoFile->hasMoved()) {
            $newName = $videoFile->getName();
            $videoFile->move(FCPATH . 'assets/videos', $newName);
        } else {
            // Handle error if the video file is not valid or has moved
            session()->setFlashData('error', 'Upload video failed.');
            return redirect()->to('/dashboard/detail/createEpisode')->withInput();
        }
        

        $fileGambarPreview = $this->request->getFile('gambarPreview');
        // Kalo gk upload gambar
        if($fileGambarPreview->getError() == 4){
            $namaGambarPreview = 'default.jpg';
        }else{

            $namaGambarPreview = $fileGambarPreview->getName();
            // Directori Gambar 
            $fileGambarPreview->move('assets/imgPreview', $namaGambarPreview);
            // Ambil nama file
            // $fileBackgroundCover = $namaBackgroundCover->getName();
        }

            $anime_id = $this->request->getPost('anime_id');
            $episodeNumber = $this->request->getPost('episodeNumber');
            $judul = $this->request->getPost('judul');
            $Deskripsi = $this->request->getPost('Deskripsi');

            // dd($judul,$Desc,$Eps,$Durasi,$Rilis,$JudulLainnya,$status,$namaBackgroundCover,$namaPoster,$id_genre);

            // dd($genres);

            $animeData = [
                'anime_id' => $anime_id,
                'episode_number' => $episodeNumber,
                'judul' => $judul,
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
            session()->setFlashData('pesan','Data Udah ditambah');
            return redirect()->to("/dashboard/detail/{$anime_id}/{$slug}")->withInput();
    }

//--------------------------------------------------------------------------
    
    public function create()
    {
        // lakukan validasi
        $validation =  \Config\Services::validation();
        $validation->setRules(['Judul' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();

        // jika data valid, simpan ke database
        if($isDataValid){
            $animes = new JjkModel();
            $animes->insert_batch([
                "Judul" => $this->request->getPost('Judul'),
                "Gambar" => $this->request->getPost('Gambar'),
                "Desc" => $this->request->getPost('Desc'),
                "Eps" => $this->request->getPost('Eps'),
                "Durasi" => $this->request->getPost('Durasi'),
                "Rilis" => $this->request->getPost('Rilis'),
                "JudulLainnya" => $this->request->getPost('JudulLainnya'),
                "genre_id" => $this->request->getPost('genre_id'),
                "Status" => $this->request->getPost('status'),
                // "slug" => url_title($this->request->getPost('slug'), '-', TRUE)
            ]);
            return redirect()->to('/dashboard');
        }
		
        // tampilkan form create
        return redirect()->to('/dashboard/tampilTambah');
    }

//--------------------------------------------------------------------------

    public function tampilTambah()
    {
        // session();
        $data = [
            'title' => ' | Form Tambah Anime',
            'animes' => $this->animeModel->getAnimes(),
            // 'id' => $this->animeModel->getId(),
            'genres' => $this->genreModel->getGenre(),
            // 'anime' => $this->animeModel->getAnimeWithGenres(),
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
                    'rules'=>'required|is_unique[jujutsukaisen.Judul]',
                    'error'=>[
                        'required' => '{field} Anime Harus diisi'
                    ]    
                    ],
                'BackgroundCover' => [
                        'rules' => 'max_size[BackgroundCover,2048]|is_image[BackgroundCover]|mime_in[BackgroundCover,image/jpg,image/jpeg,image/png,image/webp]',
                        'errors' =>[
                            'max_size' => 'Ukuran Gambar Brutal Banget njir',
                            'is_image' => 'Yang dipilih bukan gambar WOILAH',
                            'mime_in'  => 'Yang dipilih bukan gambar WOILAH'
                        ]
                        ],
                'Poster' => [
                            'rules' => 'max_size[Poster,2048]|is_image[Poster]|mime_in[Poster,image/jpg,image/jpeg,image/png]',
                            'errors' =>[
                                'max_size' => 'Ukuran Gambar Brutal Banget njir',
                                'is_image' => 'Yang dipilih bukan gambar WOILAH',
                                'mime_in'  => 'Yang dipilih bukan gambar WOILAH'
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
                'genre' =>[
                            'rules'=>'required',
                            'error'=>[
                            'required'  => '{field} Harus diisi',
                            ]
                            ],
                // 'genre_id' =>[
                //             'rules'=>'required',
                //             'error'=>[
                //             'required'  => '{field} Harus diisi',
                //             ]
                //             ],
                        
            ])){
                // $validation = \Config\Services::validation();
                 return redirect()->to('/dashboard/tampilTambah')->withInput();
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
                // $fileBackgroundCover = $namaBackgroundCover->getName();
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

            // $fmt = $this->request->getVar('Rilis');
            // $fmt = new \IntlDateFormatter('id_ID', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);
            // $fmt->setPattern('EEEE, MMMM yyyy'); // Pola untuk "Rabu, Mei 2024"

            // $id_anime = $this->request->getPost('id');
            $judul = $this->request->getPost('Judul');
            $Desc = $this->request->getPost('Desc');
            $Eps = $this->request->getPost('Eps');
            $Durasi = $this->request->getPost('Durasi');
            $Rilis = $this->request->getPost('Rilis');
            $JudulLainnya = $this->request->getPost('JudulLainnya');
            $status = $this->request->getPost('status');
            $id_genre = $this->request->getPost('genre');

            // dd($judul,$Desc,$Eps,$Durasi,$Rilis,$JudulLainnya,$status,$namaBackgroundCover,$namaPoster,$id_genre);

            // dd($genres);

            $animeData = [
                'Judul' => $judul,
                'BackgroundCover' => $namaBackgroundCover,
                'Poster' => $namaPoster,
                'Desc' => $Desc,
                'Eps' => $Eps,
                'Durasi' => $Durasi,
                'Rilis' => $Rilis,
                'JudulLainnya' => $JudulLainnya,
                'status' => $status,
            ];

            $idData = $this->animeModel->insert($animeData, true);
            


            // $animeId = $this->animeModel->insertID();

            // $animeGenreData = [
            //     'anime_id' => $animeId, // Menggunakan ID anime yang baru diinsert
            //     'genre_id' => $id_genre
            // ];

            // $this->animeGenreModel->insert($animeGenreData);

            foreach ($id_genre as $genreId) {
                $this->animeGenreModel->insert([
                    'anime_id' => $idData,
                    'genre_id' => $genreId
                ]);
            }

            // $this->animeModel->save([
            //     'Judul' => $judul,
            //     'BackgroundCover' => $namaBackgroundCover,
            //     'Poster' => $namaPoster,
            //     'Desc' => $Desc,
            //     'Eps' => $Eps,
            //     'Durasi' =>$Durasi,
            //     'Rilis' => $Rilis,
            //     'JudulLainnya' => $JudulLainnya,
            //     'status' => $status,
            //     // 'genre_id' => $genres
            // ]);

            // $this->animeGenreModel->save([
            //     // 'anime_id' => $id_anime,
            //     'genre_id' => $id_genre
            // ]);

        
            session()->setFlashData('pesan','Data Udah ditambah');
            return redirect()->to('/dashboard')->withInput();





            // $validationRule = [
            //     'BackgroundCover' => [
            //         'label' => 'Image File',
            //         'rules' => [
            //             'uploaded[BackgroundCover]',
            //             'is_image[BackgroundCover]',
            //             'mime_in[BackgroundCover,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
            //             'max_size[BackgroundCover,100]',
            //             'max_dims[BackgroundCover,1024,768]',
            //         ],
            //     ],
            //     'Gambar' => [
            //         'label' => 'Image File',
            //         'rules' => [
            //             'uploaded[Gambar]',
            //             'is_image[Gambar]',
            //             'mime_in[Gambar,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
            //             'max_size[Gambar,100]',
            //             'max_dims[Gambar,1024,768]',
            //         ],
            //     ],
            // ];
            // if (! $this->validateData([], $validationRule)) {
            //     $data = ['errors' => $this->validator->getErrors()];
    
            //     return view('admin/admin-partials/tambah', $data);
            // }
    
            // $img = $this->request->getFile('BackgroundCover');
            // $img = $this->request->getFile('Gambar');
    
            // if (! $img->hasMoved()) {
            //     $filepath = WRITEPATH . 'uploads/' . $img->store();
    
            //     $data = ['uploaded_fileinfo' => new File($filepath)];
    
            //     return view('/Dashboard', $data);
            // }
    
            // $data = ['errors' => 'The file has already been moved.'];
    
            // return view('admin/admin-partials/tambah', $data);
        
    }

//--------------------------------------------------------------------------

    public function edit($id, $slug)
    {
    $anime = $this->animeModel->getAnimeWithGenres($id);
    
    if (empty($anime)) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime dengan ID ' . $id . ' tidak ditemukan.');
    }

    $generatedSlug = url_title($anime['Judul'], '-', true);
        if ($slug !== $generatedSlug) {
            // Jika slug tidak cocok, lempar pengecualian atau redirect ke URL yang benar
            return redirect()->to("/dashboard/edit/$id/$generatedSlug");
        }

    // Ambil genre yang sudah dipilih
    $selectedGenre = $this->animeModel->selectedGenre($id);
    
    // Pastikan genre ada sebelum menggunakan explode
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
    
        if ($fileBackgroundCover->getError() == 4) {
            $namafileBackgroundCover = $this->request->getVar('BackgroundCoverOld');
        } else {
            $namafileBackgroundCover = $fileBackgroundCover->getRandomName();
            $fileBackgroundCover->move('assets/images', $namafileBackgroundCover);
            unlink('assets/images/' . $this->request->getVar('BackgroundCoverOld'));
        }
    
        $filePoster = $this->request->getFile('Poster');
    
        if ($filePoster->getError() == 4) {
            $namaPoster = $this->request->getVar('PosterOld');
        } else {
            $namaPoster = $filePoster->getRandomName();
            $filePoster->move('assets/images', $namaPoster);
            unlink('assets/images/' . $this->request->getVar('PosterOld'));
        }

        $genre = $this->request->getPost('genre');


    
        $animeData = [
            'id' => $id,
            'Judul' => $this->request->getPost('Judul'),
            'BackgroundCover' => $namafileBackgroundCover,
            'Poster' => $namaPoster,
            'Desc' => $this->request->getPost('Desc'),
            'Eps' => $this->request->getPost('Eps'),
            'Durasi' => $this->request->getPost('Durasi'),
            'Rilis' => $this->request->getPost('Rilis'),
            'JudulLainnya' => $this->request->getPost('JudulLainnya'),
            'status' => $this->request->getPost('status'),
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
    
        session()->setFlashData('pesan', 'Data Udah diubah');
    
        return redirect()->to('/dashboard');

    }
    
//--------------------------------------------------------------------------

	public function deleteEpisode($id, $slug){
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
    
        $generatedSlug = url_title($anime['Judul'], '-', true);
        if ($slug !== $generatedSlug) {
            // Jika slug tidak cocok, lempar pengecualian atau redirect ke URL yang benar
            return redirect()->to("/dashboard/delete/$id/$generatedSlug");
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
        session()->setFlashdata('pesan', 'Episode sudah dihapus.');
    
        // Redirect ke halaman detail anime
        return redirect()->to("/dashboard/detail/{$anime['id']}/{$generatedSlug}");
    }

//--------------------------------------------------------------------------

    public function delete($id)
    {
    $anime = $this->animeModel->find($id);

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
    $this->animeModel->delete($id);
    session()->setFlashdata('pesan', 'Data udah keapus');
    return redirect()->to('/dashboard');
    }

    public function testTambah()
    {
        return view('admin/admin-partials/testTambah');
    }
}