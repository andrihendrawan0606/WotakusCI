<?php namespace App\Controllers;

use App\Models\NewsModel;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Models\UsersModel;
use App\Models\TagModel;
use App\Models\NewsTagModel;
use App\Models\NewsMediaModel;
use App\Models\JjkModel;
use App\Models\Genre;
use App\Models\AnimeGenreEpisode;
use App\Models\AdminLogsModel;
use App\Models\EpisodeModel;
use App\Models\EpisodeView;
use App\Models\SeriLainnya;
use App\Models\AnimeTypeModel;
use App\Models\JadwalRilisModel;
use App\Models\UserLevelModel;
use App\Models\StudioModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Events\LogEvent;
use CodeIgniter\Files\File;
use App\Models\UserRecentAnimeModel;
use App\Models\UserWatchedModel;
use CodeIgniter\I18n\Time;

ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');
class adminController extends BaseController
{
    
    protected $animeModel;
    public function __construct()
    {
        $this->newsModel = new NewsModel();
        $this->userModel = new UsersModel();
        $this->userLevelModel  = new userLevelModel();
        $this->tagModel = new TagModel();
        $this->newsTagModel = new NewsTagModel();
        $this->newsMediaModel = new NewsMediaModel();
        $this->animeModel = new JjkModel();
        $this->adminLogsModel = new AdminLogsModel();
        $this->genreModel = new Genre();
        $this->animeGenreModel = new AnimeGenreEpisode();
        $this->episodeModel = new EpisodeModel();
        $this->episodeViews = new EpisodeView();
        $this->seriLainnya = new SeriLainnya();
        $this->animeType = new AnimeTypeModel();
        $this->animeJadwalRilis = new JadwalRilisModel();
        $this->studioModel = new StudioModel();
    }

    public function testPythonAPI()
    {
        $userId = session()->get('id');
        $client = \Config\Services::curlrequest();
        
        // Tembak server Python
        $response = $client->request('GET', "http://127.0.0.1:8000/recommend/{$userId}");
        
        echo $response->getBody();
    }



    public function manajemenUsers()
    {
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->getAllUsersWithLevel()
        ];
        
        return view('admin/admin-partials/usermanajemen', $data);
    }

    public function tampilTambahUserAdmin()
    {
        $data = [
            'title' => 'Tambah User | Wotakus',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/admin-partials/tambahUserAdmin', $data);
    }

    public function prosesTambahUserAdmin()
    {
        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'age'      => 'required|integer|greater_than[0]',
            'role'     => 'required',
            'status'   => 'required',
            'ProfileImg' => [
                'rules'  => 'max_size[ProfileImg,2048]|is_image[ProfileImg]|mime_in[ProfileImg,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 2MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format foto harus JPG, JPEG, PNG, atau WebP.'
                ]
            ]
        ];
    
        if (!$this->validate($rules)) {
            // PENTING: Sertakan objek validasi saat redirect back
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    
        // ... (Logika upload gambar tetap sama) ...
        $fileGambar = $this->request->getFile('ProfileImg');
        if ($fileGambar->getError() == 4) {
            $namaGambar = 'default_profile.jpg';
        } else {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('assets/images', $namaGambar);
        }
    
        $role = $this->request->getPost('role');
    
        // ... (Simpan ke USERS dan USER_LEVEL tetap sama) ...
        $this->userModel->save([
            'nama'       => $this->request->getPost('nama'),
            'email'      => $this->request->getPost('email'),
            'age'        => $this->request->getPost('age'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'       => $role,
            'Status'     => $this->request->getPost('status'),
            'ProfileImg' => $namaGambar
        ]);
    
        $userId = $this->userModel->insertID();
        if ($role === 'user') {
            $this->userLevelModel->insert([
                'user_id' => $userId,
                'level'   => $this->request->getPost('level'),
                'coins'   => 0
            ]);
        }
    
        // Set Flashdata 'success' untuk dibaca SweetAlert
        session()->setFlashdata('success', 'User ' . strtoupper($role) . ' baru berhasil ditambahkan!');
        return redirect()->to(url_to('manageUsers'));
    }

    public function hapusUserAdmin($id)
    {
        $user = $this->userModel->find($id);
        
        // DEFINISIKAN variabel $isSelf di sini
        $isSelf = ($id == session()->get('id'));
    
        // Proteksi: Jika mencoba hapus admin lain (bukan diri sendiri)
        if ($user['role'] == 'admin' && !$isSelf) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Keamanan sistem: Anda tidak diizinkan menghapus akun Administrator lain!'
            ], 403);
        }
    
        if ($user) {
            // Hapus file fisik gambar jika bukan default
            if ($user['ProfileImg'] != 'default_profile.jpg') {
                $filePath = 'assets/images/' . $user['ProfileImg'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
    
            // Hapus data dari database
            $this->userModel->delete($id);
    
            // SEKARANG variabel $isSelf sudah ada dan bisa digunakan
            if ($isSelf) {
                session()->destroy();
                return $this->response->setJSON(['logout' => true]);
            }
    
            return $this->response->setJSON(['logout' => false]);
        }
    
        return $this->response->setJSON(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
    }

    public function tampilEditUserAdmin($id)
    {
        $user = $this->userModel->find($id);
        if ($user['role'] == 'admin' && $id != session()->get('id')) {
            return redirect()->to(url_to('manageUsers'))->with('error', 'Akses ditolak: Anda hanya bisa mengedit profil Anda sendiri.');
        }
        // Ambil data user beserta levelnya (Gunakan method JOIN yang kita buat sebelumnya)
        $user = $this->userModel->select('users.*, user_level.level')
                                ->join('user_level', 'user_level.user_id = users.id', 'left')
                                ->find($id);

        if (!$user) {
            throw new \CodeIgniter\Exception\PageNotFoundException('User tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit User | Wotakus',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/admin-partials/editUserAdmin', $data);
    }

    public function prosesEditUserAdmin($id)
    {
        $rules = [
            'nama'   => 'required|min_length[3]',
            'email'  => "required|valid_email|is_unique[users.email,id,$id]",
            'role'   => 'required',
            'status' => 'required'
        ];
    
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }
    
        if (!$this->validate($rules)) {
            // Jika ingin tahu error apa yang terjadi, aktifkan baris di bawah ini:
            // dd($this->validator->getErrors()); 
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    
        // Ambil file gambar
        $fileGambar = $this->request->getFile('ProfileImg');
        $oldUser = $this->userModel->find($id);
    
        if ($fileGambar->getError() == 4) {
            $namaGambar = $this->request->getPost('oldProfileImg');
        } else {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('assets/images', $namaGambar);
            if ($oldUser['ProfileImg'] != 'default_profile.jpg' && file_exists('assets/images/' . $oldUser['ProfileImg'])) {
                unlink('assets/images/' . $oldUser['ProfileImg']);
            }
        }

        // AMBIL DATA ROLE DARI POST
        $role = $this->request->getPost('role');
        $status = $this->request->getPost('status');
    
        // PROTEKSI SISI SERVER
        if ($id == session()->get('id')) {
            $role = 'admin';    // Paksa admin
            $status = 'active'; // Paksa aktif
        }
    
        // Update data ke database
        $dataUpdate = [
            'nama'       => $this->request->getPost('nama'),
            'email'      => $this->request->getPost('email'),
            'role'       => $role,
            'Status'     => $status,
            'ProfileImg' => $namaGambar
        ];
    
        if ($this->request->getPost('password')) {
            $dataUpdate['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }
    
        // Gunakan update() lebih aman daripada save() jika ID sudah jelas
        $this->userModel->update($id, $dataUpdate);
    
        // Update level jika role = user
        $role = $this->request->getPost('role');
        if ($role === 'user') {
            $level = $this->request->getPost('level');
            $checkLevel = $this->userLevelModel->where('user_id', $id)->first();
            if ($checkLevel) {
                $this->userLevelModel->update($checkLevel['id'], ['level' => $level]);
            } else {
                $this->userLevelModel->insert(['user_id' => $id, 'level' => $level]);
            }
        }
    
        session()->setFlashdata('success', 'Perubahan berhasil disimpan!');
        return redirect()->to(url_to('manageUsers'));
    }

    public function userInfo()
    {
        $infoUser = $this->userModel->getUserDetail();

        $data = [
            'user' => $infoUser
        ];
    }

    public function profileAdmin()
    {
        $id = session()->get('id');
        // Ambil data user lengkap dengan levelnya
        $user = $this->userModel->select('users.*, user_level.level')
                                ->join('user_level', 'user_level.user_id = users.id', 'left')
                                ->find($id);

        $data = [
            'title' => 'Profil Saya | Wotakus',
            'user'  => $user
        ];

        echo view('admin/admin-partials/profileAdmin', $data);
    }

	public function dashboard()
	{
        $db = \Config\Database::connect();

        $threshold = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        
        $perPage = 20; // Jumlah item per halaman
    
        // Ambil data anime dengan paginasi
        $currentPage = $this->request->getVar('page_animes') ? (int)$this->request->getVar('page_animes') : 1;
        
        // Mengambil data anime dengan paginasi
        $daftarAnime = $this->animeModel->paginate($perPage, 'animes', $currentPage);
    
        // Mendapatkan total anime
        $totalAnime = $this->animeModel->pager->getTotal('animes');
        $totalEpisode = $this->episodeModel->countAllResults();

        $chartLabels = [];
        $dataPengunjung = [];
        $dataAnime = [];

                // 2. Looping untuk mengambil data 7 hari terakhir secara berurutan
        for ($i = 6; $i >= 0; $i--) {
            // Ambil tanggal mundur dari hari ini (Format: Y-m-d)
            $dateQuery = date('Y-m-d', strtotime("-$i days"));
            // Ambil format tanggal untuk ditampilkan (Format: 12 Apr)
            $displayDate = date('d M', strtotime("-$i days")); 
            
            $chartLabels[] = $displayDate;

            // 3. Query Jumlah Anime Ditambahkan pada hari tersebut
            $animeCount = $db->table('animes')
                             ->where('DATE(created_at)', $dateQuery)
                             ->countAllResults();
            $dataAnime[] = $animeCount;

            // 4. Query Trafik Pengunjung (Menggunakan histori user menonton sebagai representasi)
            $visitorCount = $db->table('user_recent_anime')
                               ->where('DATE(created_at)', $dateQuery)
                               ->countAllResults();
            $dataPengunjung[] = $visitorCount;

                        // --- QUERY TOP 5 ANIME BERDASARKAN VIEWS ---
            // Join tabel animes -> episodeanime -> episode_views
            $topAnimeQuery = $db->table('animes a')
            ->select('a.Judul, SUM(ev.view_count) as total_views')
            ->join('episodeanime ea', 'ea.anime_id = a.id', 'left')
            ->join('episode_views ev', 'ev.episode_id = ea.id', 'left')
            ->groupBy('a.id')
            ->orderBy('total_views', 'DESC')
            ->limit(5) // Ambil 5 teratas
            ->get()
            ->getResultArray();

            $topAnimeLabels = [];
            $topAnimeViews = [];

            foreach ($topAnimeQuery as $row) {
                // Potong judul jika terlalu panjang agar chart tetap rapi
                $judul = strlen($row['Judul']) > 25 ? substr($row['Judul'], 0, 25) . '...' : $row['Judul'];
                $topAnimeLabels[] = $judul;
                // Jika view_count null, jadikan 0
                $topAnimeViews[] = $row['total_views'] ? $row['total_views'] : 0; 
            }

        }

                // --- QUERY STATISTIK GENRE (TOP 5 GENRE) ---
        // Join tabel genre dan animegenre untuk menghitung jumlah anime per genre
        $genreQuery = $db->table('genre g')
            ->select('g.genre, COUNT(ag.anime_id) as total_anime')
            ->join('animegenre ag', 'ag.genre_id = g.id', 'left')
            ->groupBy('g.id')
            ->orderBy('total_anime', 'DESC')
            ->limit(5) // Ambil 5 genre terbanyak
            ->get()
            ->getResultArray();

        $genreLabels = [];
        $genreCounts = [];

        foreach ($genreQuery as $row) {
            $genreLabels[] = $row['genre'];
            $genreCounts[] = $row['total_anime'] ? $row['total_anime'] : 0;
        }

        $completedCount = $db->table('animes')->where('status', 'Completed')->countAllResults();
        $ongoingCount   = $db->table('animes')->where('status', 'On-Going')->countAllResults();

        // --- 2. STATISTIK LEVEL USER ---
        $basicCount = $db->table('user_level')->where('level', 'Basic')->countAllResults();
        $proCount   = $db->table('user_level')->where('level', 'Pro')->countAllResults();


        $data = [
            'title' => 'Dashboard',
            'animes' => $daftarAnime,
            'pager' => $this->animeModel->pager, // Object pagination
            'totalAnime' => $totalAnime,
            'totalEpisode' => $totalEpisode,
            'totalOnline' =>$this->userModel->where('last_activity >=', $threshold)->countAllResults(),
            'chartLabels'     => json_encode($chartLabels),
            'dataPengunjung'  => json_encode($dataPengunjung),
            'dataAnime'       => json_encode($dataAnime),
            'topAnimeLabels' => json_encode($topAnimeLabels),
            'topAnimeViews'  => json_encode($topAnimeViews),
            'genreLabels'    => json_encode($genreLabels),
            'genreCounts'    => json_encode($genreCounts),
            'animeStatusData' => json_encode($completedCount, $ongoingCount),
            'userLevelData'  => json_encode($basicCount, $proCount)
        ];
        // dd($data);
        // $data['animes'] = $animes->where('status', 'Completed')->findAll();
    

        echo view('admin/admin-partials/admin', $data);
    }

    public function chartDataAjax()
    {
        $db = \Config\Database::connect();
        $filter = $this->request->getGet('filter'); 
    
        // Variabel untuk Chart 1 (Line Chart)
        $chartLabels = [];
        $dataPengunjung = [];
        $dataAnime = [];
    
        // Variabel batas waktu untuk filter Chart 2 (Top Anime)
        $startDate = '';
        $endDate = date('Y-m-d 23:59:59'); // Hari ini

        // ==========================================
        // LOGIKA FILTER
        // ==========================================
        if ($filter == 'this_year') {
            $year = date('Y'); // Ganti '2026' jika sedang testing
            $startDate = "$year-01-01 00:00:00";
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            
            for ($m = 1; $m <= 12; $m++) {
                $chartLabels[] = $months[$m - 1];
                $dataAnime[] = $db->table('animes')->where('MONTH(created_at)', $m)->where('YEAR(created_at)', $year)->countAllResults();
                $dataPengunjung[] = $db->table('user_recent_anime')->where('MONTH(created_at)', $m)->where('YEAR(created_at)', $year)->countAllResults();
            }
        } 
        else if ($filter == 'this_month') {
            $month = date('m'); // Ganti '04' jika sedang testing
            $year = date('Y');  // Ganti '2026' jika sedang testing
            $startDate = "$year-$month-01 00:00:00";
            $daysInMonth = date('t'); 
    
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $chartLabels[] = $d;
                $dateStr = sprintf("%04d-%02d-%02d", $year, $month, $d);
                $dataAnime[] = $db->table('animes')->where('DATE(created_at)', $dateStr)->countAllResults();
                $dataPengunjung[] = $db->table('user_recent_anime')->where('DATE(created_at)', $dateStr)->countAllResults();
            }
        } 
        else {
            // Default: 7 Hari Terakhir
            $startDate = date('Y-m-d 00:00:00', strtotime('-7 days'));
            
            for ($i = 6; $i >= 0; $i--) {
                $dateQuery = date('Y-m-d', strtotime("-$i days"));
                $chartLabels[] = date('d M', strtotime("-$i days")); 
                $dataAnime[] = $db->table('animes')->where('DATE(created_at)', $dateQuery)->countAllResults();
                $dataPengunjung[] = $db->table('user_recent_anime')->where('DATE(created_at)', $dateQuery)->countAllResults();
            }
        }
    
        // ==========================================
        // QUERY UNTUK CHART 2 (TOP 5 ANIME)
        // ==========================================
        // Menghitung views HANYA dalam rentang waktu yang dipilih filter
        $topAnimeQuery = $db->table('animes a')
            ->select('a.Judul, SUM(ev.view_count) as total_views')
            ->join('episodeanime ea', 'ea.anime_id = a.id', 'left')
            ->join('episode_views ev', 'ev.episode_id = ea.id', 'left')
            // Filter berdasarkan waktu kapan views itu dibuat (Tergantung struktur DB Anda)
            // Jika tabel episode_views Anda *tidak* merekam history views harian, 
            // maka kita gunakan data histori penonton dari 'user_recent_anime' sebagai penentu populer.
            ->where('ev.updated_at >=', $startDate) 
            ->where('ev.updated_at <=', $endDate)
            ->groupBy('a.id')
            ->orderBy('total_views', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
    
        $topAnimeLabels = [];
        $topAnimeViews = [];
    
        foreach ($topAnimeQuery as $row) {
            $judul = strlen($row['Judul']) > 25 ? substr($row['Judul'], 0, 25) . '...' : $row['Judul'];
            $topAnimeLabels[] = $judul;
            $topAnimeViews[] = $row['total_views'] ? $row['total_views'] : 0; 
        }
    
        // ==========================================
        // KIRIM SEMUA DATA DALAM FORMAT JSON
        // ==========================================
        return $this->response->setJSON([
            'labels' => $chartLabels,
            'pengunjung' => $dataPengunjung,
            'anime' => $dataAnime,
            // Tambahan untuk Chart 2
            'top_labels' => $topAnimeLabels,
            'top_views'  => $topAnimeViews
        ]);
    }


    public function adminLogsPage()
    {
        $adminId = $this->request->getGet('admin_id');
        $adminName = $this->request->getGet('admin_name');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
    
        // $query = $this->adminLogsModel->orderBy('created_at', 'DESC');
        $query = $this->adminLogsModel
        ->select('admin_logs.*, users.nama as admin_name, animes.Judul as anime_title') // Memilih kolom dari admin_logs, admins, dan animes
        ->join('users', 'users.id = admin_logs.admin_id', 'left') // Join ke tabel users untuk mendapatkan admin_name
        ->join('animes', 'animes.id = admin_logs.item_id', 'left') // Join ke tabel animes untuk mendapatkan anime_title
        ->orderBy('admin_logs.created_at', 'DESC'); // Urutkan berdasarkan created_at
    
        if ($adminId) {
            $query->where('admin_id', $adminId);
        }

        if ($adminName) {
            $query->where('admin_name', $adminId);
        }
    
        if ($startDate && $endDate) {
            $query->where('created_at >=', $startDate)->where('created_at <=', $endDate);
        }
    

        $data['title'] = 'Logs ';
        $data['logs'] = $query->findAll();
        // dd($data);

         // Tampilkan ke view
         echo view('admin/admin-partials/logs', $data);
    }

    public function downloadLogsPdf()
    {
        // 1. Ambil Data Log (Bisa dibatasi misal 500 terbaru agar PDF tidak ngehang)
        $logModel = new \App\Models\AdminLogsModel();
        $data['logs'] = $logModel->orderBy('created_at', 'DESC')->findAll(500); 

        // 2. Load View khusus yang desainnya sederhana (tabel hitam putih) untuk PDF
        $html = view('admin/pdf_template/log_pdf', $data);

        // 3. Konfigurasi DomPDF
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true); // Agar bisa load css/gambar external jika ada
        
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Format kertas
        $dompdf->render();

        // 4. Perintahkan browser untuk men-download file
        $dompdf->stream("Wotakus_AdminLogs_" . date('Y-m-d') . ".pdf", ["Attachment" => true]);
    }

    // Fungsi untuk menghapus log yang lebih tua dari 90 hari
    public function purgeOldLogs()
    {
        $logModel = new \App\Models\AdminLogsModel();
        
        // Ambil tanggal 90 hari yang lalu dari hari ini
        $dateLimit = date('Y-m-d H:i:s', strtotime('-90 days'));

        // Hitung dulu berapa baris yang akan dihapus
        $countToDelete = $logModel->where('created_at <', $dateLimit)->countAllResults();

        if ($countToDelete > 0) {
            // Lakukan eksekusi hapus
            $logModel->where('created_at <', $dateLimit)->delete();
            
            // Catat aktivitas penghapusan ini ke dalam log juga! (Ironis tapi penting)
            $logModel->insert([
                'admin_id'    => session()->get('id'), 
                'admin_name'  => session()->get('nama'),
                'action'      => 'DELETE',
                'item'        => 'System Logs',
                'item_id'     => 0,
                'description' => "Admin melakukan Auto-Purge (Pembersihan). Sebanyak {$countToDelete} baris log yang lebih tua dari 90 hari telah dihapus secara permanen.",
            ]);

            return $this->response->setJSON(['status' => 'success', 'message' => "{$countToDelete} catatan log lama berhasil dihapus!"]);
        } else {
            return $this->response->setJSON(['status' => 'info', 'message' => "Tidak ada log yang lebih tua dari 90 hari. Database sudah bersih."]);
        }
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

    public function search() {
        $query = $this->request->getGet('q');
        log_message('info', 'Search query: ' . ($query ?? 'null'));
    
        if (!$query || trim($query) === '') {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'Query tidak boleh kosong.',
            ]);
        }
    
        $results = $this->animeModel
            ->like('Judul', $query)
            ->orLike('JudulLainnya', $query)
            ->findAll();
    
        return $this->response->setJSON($results);
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

            // --- AMBIL DATA RATING (TAMBAHKAN INI) ---
        $ratingModel = new \App\Models\AnimeRatingModel();
        $avgRating = $ratingModel->getAverageRating($anime['id']);
        $totalVoters = $ratingModel->where('anime_id', $anime['id'])->countAllResults();

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
            'avg_rating'   => $avgRating,    // Kirim rata-rata rating
            'total_voters' => $totalVoters,  // Kirim jumlah pemberi rating
        ];

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data['episode']);
        }

        if (empty($data['animes'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Anime' . $Judul . 'Tidak ada');
        }

        // dd($data);
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
            // Jika slug tidak cocok, redirect ke URL yang bener
            // (Saya merapikan parameter redirectnya agar sesuai struktur URL slug Anda)
            return redirect()->to("/dashboard/detail/createEpisode/$generatedSlug");
        }

        // ==========================================
        // TAMBAHAN UNTUK FITUR SELECTBOX CERDAS
        // ==========================================
        
        // 1. Ambil Total Episode dari Anime Ini
        $totalEpisodeAnime = (int) $anime['Eps'];

        // 2. Ambil Daftar Angka Episode yang SUDAH ADA di tabel episodeanime
        $episodeTerunggah = $this->episodeModel->where('anime_id', $anime['id'])
                                               ->findColumn('episode_number');
                                               
        // Jika belum ada episode satupun, findColumn mengembalikan null. 
        // Kita ubah menjadi array kosong agar in_array() di View tidak error.
        if (!$episodeTerunggah) {
            $episodeTerunggah = []; 
        }
        // ==========================================

        $data = [
            'title'             => 'Tambah Episode | ' . $anime['Judul'],
            'animeId'           => $anime, // Berisi seluruh data anime
            
            // Variabel baru dikirim ke View
            'totalEpisodeAnime' => $totalEpisodeAnime,
            'episodeTerunggah'  => $episodeTerunggah,
            
            'validation'        => \Config\Services::validation()
        ];

        return view('admin/admin-partials/tambahEpisode', $data);
    }

//--------------------------------------------------------------------------

    public function prosesEpisode()
    {
        $videoSourceType = $this->request->getPost('video_source_type');

        // Ganti validasi file dengan validasi string
        if ($videoSourceType === 'upload') {
            $validationRules['uploaded_temp_video'] = [
                'rules' => 'required',
                'errors' => ['required' => 'Video belum selesai diunggah atau belum dipilih.']
            ];
        } else {
            // JIKA ADMIN PILIH TAB EMBED
            $embedLink = $this->request->getPost('video_embed_link');
            
            // Cek manual jika link tersebut berakhiran format gambar
            $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp|svg)(\?.*)?$/i', $embedLink);

            if ($isImage) {
                // Jika terdeteksi gambar, kita paksa validasi gagal dengan cara membuat rule fiktif
                $validationRules['video_embed_link'] = [
                    'rules' => 'in_list[video]', // Aturan fiktif yang pasti gagal
                    'errors' => ['in_list' => 'Link yang dimasukkan adalah gambar. Harap masukkan URL Video atau iFrame!']
                ];
            } else {
                $validationRules['video_embed_link'] = [
                    'rules' => 'required',
                    'errors' => ['required' => 'Link Embed harus diisi!']
                ];
            }
        }

        if (!$this->validate($validationRules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(400)->setJSON(['error' => $this->validator->getErrors()]);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $anime_id = $this->request->getPost('anime_id');
        $anime = $this->animeModel->find($anime_id);
        
        if (!$anime) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
        }

// ==========================================
        // PROSES PEMINDAHAN VIDEO & PEMBERSIHAN TEMP
        // ==========================================
        $newName = null;
        $tempFilename = $this->request->getPost('uploaded_temp_video'); // Ambil nama file temp dari hidden input
        $tempPath = FCPATH . 'assets/videos/temp/' . $tempFilename;

        if ($videoSourceType === 'embed') {
            // 1. JIKA ADMIN MEMILIH EMBED
            // Decode Base64 Embed
            $base64Input = $this->request->getPost('video_embed_link');
            if (!empty($base64Input)) {
                $newName = base64_decode($base64Input);
            }

            // KUNCI PENGAMANAN: Hapus file video lokal jika ada yang nyangkut
            // (Karena admin tadinya upload, lalu berubah pikiran pakai embed)
            if (!empty($tempFilename) && file_exists($tempPath)) {
                unlink($tempPath); // Hapus file dari folder temp selamanya
            }

        } else { 
            // 2. JIKA ADMIN MEMILIH UPLOAD LOCAL
            $finalPath = FCPATH . 'assets/videos/' . $tempFilename;

            if (file_exists($tempPath)) {
                // Pindahkan file dari temp ke folder utama
                rename($tempPath, $finalPath);
                $newName = $tempFilename;
            } else {
                if ($this->request->isAJAX()) {
                    return $this->response->setStatusCode(400)->setJSON(['error' => ['video' => 'File video hilang di server. Silakan upload ulang.']]);
                }
            }
        }

        // ==========================================
        // 4. PROSES UPLOAD GAMBAR PREVIEW (THUMBNAIL)
        // ==========================================
        $namaGambarPreview = 'default.jpg';
        
        // Cek apakah Admin menggunakan fitur jepretan otomatis
        $autoThumbData = $this->request->getPost('auto_generated_thumbnail');
        
        if (!empty($autoThumbData)) {
            // Jika ada jepretan otomatis (Format: data:image/jpeg;base64,.....)
            $image_parts = explode(";base64,", $autoThumbData);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1]; // ext: jpeg/png
            $image_base64 = base64_decode($image_parts[1]); // Decode string jadi file
            
            $namaGambarPreview = time() . '_auto_thumbnail.jpg';
            $file = FCPATH . 'assets/imgPreview/' . $namaGambarPreview;
            
            // Tulis file ke folder
            file_put_contents($file, $image_base64);

        } else {
            // Jika Admin mengupload file manual lewat tombol Browse
            $fileGambarPreview = $this->request->getFile('gambarPreview');
            
            if ($fileGambarPreview && $fileGambarPreview->isValid() && !$fileGambarPreview->hasMoved()) {
                $namaGambarPreview = time() . '_' . $fileGambarPreview->getName();
                $fileGambarPreview->move('assets/imgPreview', $namaGambarPreview);
            } else {
                // Biarkan pakai default.jpg jika tidak ada input apa-apa
            }
        }

        $episodeNumber = $this->request->getPost('episodeNumber');
        
        // AMAN DARI NULL ERROR: Gunakan fallback operator (?? '') sebelum di-trim
        $judulInput = trim($this->request->getPost('judul') ?? '');
        $descInput  = trim($this->request->getPost('Deskripsi') ?? '');
        
        $judul = empty($judulInput) ? "Episode " . $episodeNumber : $judulInput;
        $Deskripsi = empty($descInput) ? "Saksikan kelanjutan cerita yang mendebarkan di Episode " . $episodeNumber . " dari seri anime " . $anime['Judul'] . "." : $descInput;

        $slug = $this->episodeModel->createSlug($episodeNumber);

        $animeData = [
            'anime_id'       => $anime_id,
            'episode_number' => $episodeNumber,
            'judul'          => $judul,
            'slug-episode'   => $slug,
            'deskripsi'      => $Deskripsi,
            'GambarPreview'  => $namaGambarPreview,
            'video_path'     => $newName // Ini bisa berisi nama file.mp4 ATAU link iframe 
        ];

        // Insert ke database dan dapatkan ID Episode yang baru dibuat
        $idEpisodeBaru = $this->episodeModel->insert($animeData, true);

        // ==========================================
        // 7. AUTO-COMPLETE SYSTEM (CEK APAKAH SUDAH TAMAT?)
        // ==========================================
        $isStatusChanged = false;

        // Ambil data Anime Induk (Tabel 'animes')
        $animeInduk = $this->animeModel->find($anime_id);
        
        if ($animeInduk && $animeInduk['Eps'] > 0 && $animeInduk['status'] === 'On-Going') {
            
            // Hitung berapa total episode yang sudah terunggah saat ini
            $totalEpsTerunggah = $this->episodeModel->where('anime_id', $anime_id)->countAllResults();

            // Jika jumlah episode yang diupload sudah mencapai batas target (atau lebih)
            if ($totalEpsTerunggah >= $animeInduk['Eps']) {
                
                // UPDATE STATUS ANIME MENJADI COMPLETED
                $this->animeModel->update($anime_id, [
                    'status' => 'Completed'
                ]);
                
                $isStatusChanged = true;
            }
        }

        // ==========================================
        // 8. LOG AKTIVITAS ADMIN
        // ==========================================
        $sumberInfo = ($videoSourceType === 'embed') ? 'via Embed Link' : 'via Upload File';
        $changeTypeMsg = "Menambahkan <strong>Episode {$episodeNumber}</strong> dengan judul: <strong>{$judul}</strong> ({$sumberInfo})";

        // Jika statusnya ikut berubah jadi Completed, tambahkan pesan sukses ke dalam Log
        if ($isStatusChanged) {
            $changeTypeMsg .= "<br>🎉 <strong>STATUS OTOMATIS:</strong> Anime ini telah mencapai episode maksimal ({$animeInduk['Eps']}) dan statusnya diubah menjadi <strong>Completed</strong>.";
        }

        $this->adminLogsModel->insert([
            'admin_id'    => session()->get('id'),
            'admin_name'  => session()->get('nama'), 
            'action'      => 'CREATE', 
            'item'        => 'Episode', 
            'item_id'     => $idEpisodeBaru, 
            'description' => "Menambahkan episode baru pada seri anime: " . $anime['Judul'],
            'change_type' => $changeTypeMsg
        ]);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Episode berhasil ditambah!']);
        }

        session()->setFlashData('pesan', 'Episode berhasil ditambah!');
        return redirect()->to("/dashboard/detail/{$anime['slug']}")->withInput();
    }



    // 1. FUNGSI UNTUK MENGUNGGAH VIDEO KE FOLDER TEMP
    public function uploadTempVideo()
    {
        if (!$this->validate([
            'video_path' => [
                'rules' => 'uploaded[video_path]|max_size[video_path,102400]|ext_in[video_path,mp4,avi,mkv]',
                'errors' => [
                    'uploaded' => 'Video kosong.',
                    'max_size' => 'Ukuran maksimal 100MB.',
                    'ext_in'   => 'Format harus mp4, avi, atau mkv.'
                ]
            ]
        ])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => $this->validator->getErrors()['video_path']]);
        }

        $videoFile = $this->request->getFile('video_path');
        if ($videoFile->isValid() && !$videoFile->hasMoved()) {
            $newName = $videoFile->getRandomName();
            // Pindahkan ke folder TEMP
            $videoFile->move(FCPATH . 'assets/videos/temp', $newName);
            
            return $this->response->setJSON([
                'status' => 'success', 
                'filename' => $newName
            ]);
        }

        return $this->response->setStatusCode(400)->setJSON(['error' => 'Gagal memindahkan file.']);
    }

    // 2. FUNGSI UNTUK MENGHAPUS VIDEO DARI FOLDER TEMP (Jika Admin klik tombol X)
    public function deleteTempVideo()
    {
        $filename = $this->request->getPost('filename');
        $path = FCPATH . 'assets/videos/temp/' . $filename;

        if (!empty($filename) && file_exists($path)) {
            unlink($path);
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'not_found']);
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

        $oldEpisode = $this->episodeModel->find($id); // Dapatkan data episode lama untuk perbandingan log

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
        // ==========================================
        // TAMBAHAN BARU: LOG AKTIVITAS ADMIN (UPDATE EPISODE)
        // ==========================================
        
        // 1. Ambil Judul Anime dari Episode Lama agar lognya jelas
        $anime = $this->animeModel->find($oldEpisode['anime_id']);
        $animeJudul = $anime ? $anime['Judul'] : 'Unknown Anime';

        // 2. Deteksi Perubahan (Cek apa saja yang diubah admin)
        $perubahan = [];
        if ($oldEpisode['judul'] !== $judul) {
            $perubahan[] = "Judul (<strong>{$oldEpisode['judul']}</strong> ➔ <strong>{$judul}</strong>)";
        }
        if ($oldEpisode['episode_number'] != $episodeNumber) {
            $perubahan[] = "No. Eps (<strong>{$oldEpisode['episode_number']}</strong> ➔ <strong>{$episodeNumber}</strong>)";
        }
        if (isset($namaGambarPreview)) {
            $perubahan[] = "Thumbnail diperbarui";
        }
        if (isset($newName)) {
            $perubahan[] = "File Video diganti";
        }

        // Jika tidak ada perubahan signifikan (misal cuma ubah deskripsi), buat pesan standar
        $detailUbah = !empty($perubahan) ? implode(", ", $perubahan) : "Mengubah deskripsi atau detail lainnya.";

        // 3. Simpan ke Database
        $this->adminLogsModel->insert([
            'admin_id'    => session()->get('id'),
            'admin_name'  => session()->get('nama'),
            'action'      => 'EDIT', // Aksi terstandar (Sesuai Filter)
            'item'        => 'Episode',
            'item_id'     => $id, // ID Episode yang diedit
            'description' => "Memodifikasi Episode {$oldEpisode['episode_number']} pada seri: " . $animeJudul,
            'change_type' => "Perubahan: " . $detailUbah
        ]);
        // ==========================================

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
            'studios' => $this->studioModel->orderBy('nama_studio', 'ASC')->findAll(), 
            'typeAnime' => $this->animeType->findAll(),
            'validation' => \Config\Services::validation()
        ];

        // dd($data);
        return view('admin/admin-partials/tambah', $data);
    }

//--------------------------------------------------------------------------

public function prosesTambah()
    {
        // ==========================================
        // 1. VALIDASI
        // ==========================================
        if (!$this->validate([
            'Judul' => [
                'rules'  => 'required|is_unique[animes.Judul]',
                'errors' => [
                    'required'  => '{field} Anime Harus diisi',
                    'is_unique' => 'Judul anime sudah terdaftar di database'
                ]
            ],
            // Perhatikan namanya diubah menjadi BackgroundCoverFile dan PosterFile
            'BackgroundCoverFile' => [
                'rules'  => 'max_size[BackgroundCoverFile,2048]|is_image[BackgroundCoverFile]|mime_in[BackgroundCoverFile,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran Gambar Brutal Banget njir',
                    'is_image' => 'Yang dipilih bukan gambar bjir',
                    'mime_in'  => 'Yang dipilih bukan gambar bjir'
                ]
            ],
            'PosterFile' => [
                'rules'  => 'max_size[PosterFile,2048]|is_image[PosterFile]|mime_in[PosterFile,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran Gambar Brutal Banget njir',
                    'is_image' => 'Yang dipilih bukan gambar bjir',
                    'mime_in'  => 'Yang dipilih bukan gambar bjir'
                ]
            ]
        ])) {
            return redirect()->to('/dashboard/tampilTambah')->withInput()->with('validation', \Config\Services::validation());
        }

        // ==========================================
        // 2. PROSES BACKGROUND COVER
        // ==========================================
        $bgSourceType = $this->request->getPost('bg_source_type');
        $namafileBackgroundCover = 'default3.jpg'; // Nilai awal (default) untuk anime baru

        if ($bgSourceType === 'url') {
            $urlInput = $this->request->getPost('BackgroundCoverUrl');
            $namafileBackgroundCover = !empty($urlInput) ? $urlInput : 'default3.jpg';
        } else {
            $fileBg = $this->request->getFile('BackgroundCoverFile');
            if ($fileBg && $fileBg->isValid() && !$fileBg->hasMoved()) {
                $namafileBackgroundCover = $fileBg->getRandomName();
                $fileBg->move('assets/images', $namafileBackgroundCover);
            }
        }

        // ==========================================
        // 3. PROSES POSTER UTAMA
        // ==========================================
        $posterSourceType = $this->request->getPost('poster_source_type');
        $namaPoster = 'default1.jpg'; // Nilai awal (default) untuk anime baru

        if ($posterSourceType === 'url') {
            $urlInput = $this->request->getPost('PosterUrl');
            $namaPoster = !empty($urlInput) ? $urlInput : 'default1.jpg';
        } else {
            $filePoster = $this->request->getFile('PosterFile');
            if ($filePoster && $filePoster->isValid() && !$filePoster->hasMoved()) {
                $namaPoster = $filePoster->getRandomName();
                $filePoster->move('assets/images', $namaPoster);
            }
        }

        // ==========================================
        // 4. AMBIL DATA & SET FALLBACK DEFAULT
        // ==========================================
        $judul        = $this->request->getPost('Judul');
        $slug         = $this->animeModel->createSlug($judul);
        
        $Desc         = $this->request->getPost('Desc') ?: 'Belum ada sinopsis untuk anime ini.';
        $Eps          = $this->request->getPost('Eps') ?: 0;
        $Durasi       = $this->request->getPost('Durasi') ?: 0;
        $Rilis        = $this->request->getPost('Rilis') ?: 'TBA'; 
        $JudulLainnya = $this->request->getPost('JudulLainnya') ?: '-';
        $typeid       = $this->request->getPost('typeAnime') ?: 'Unknown';
        
        // Status Tayang untuk Tambah Manual selalu Draft di awal
        $status       = $this->request->getPost('status') ?: 'On-Going';
        
        // Data Relasi
        $id_genre     = $this->request->getPost('genre') ?: []; 
        $id_studios   = $this->request->getPost('studios') ?: []; 
        $seriLainnya  = $this->request->getPost('seriLainnya') ?: [];

        // Metadata Tambahan
        $mal_id       = $this->request->getPost('mal_id') ?: null;
        $mal_score    = $this->request->getPost('mal_score') ?: 0.00;
        $source       = $this->request->getPost('source') ?: 'Unknown';
        $season       = $this->request->getPost('season') ?: 'Unknown';
        $release_year = $this->request->getPost('release_year') ?: null;

        // ==========================================
        // 5. INSERT KE DATABASE
        // ==========================================
        $animeData = [
            'Judul'           => $judul,
            'slug'            => $slug,
            'BackgroundCover' => $namafileBackgroundCover,
            'Poster'          => $namaPoster,
            'Desc'            => $Desc,
            'Eps'             => $Eps,
            'Durasi'          => $Durasi,
            'Rilis'           => $Rilis,
            'JudulLainnya'    => $JudulLainnya,
            'typeId'          => $typeid,
            'status'          => $status,
            'statusTayang'    => 'draft', // DRAFT
            'mal_id'          => $mal_id,
            'mal_score'       => $mal_score,
            'source'          => $source,
            'season'          => $season,
            'release_year'    => $release_year,
        ];

        $idData = $this->animeModel->insert($animeData, true);

        // Insert Genre
        if (!empty($id_genre)) {
            foreach ($id_genre as $genreId) {
                $this->animeGenreModel->insert([
                    'anime_id' => $idData,
                    'genre_id' => $genreId
                ]);
            }
        }

        // Insert Studio
        if (!empty($id_studios)) {
            $db = \Config\Database::connect();
            foreach ($id_studios as $studioId) {
                $db->table('anime_studios')->insert([
                    'anime_id'  => $idData,
                    'studio_id' => $studioId
                ]);
            }
        }

        // Insert Seri Terkait
        if (!empty($seriLainnya)) {
            foreach ($seriLainnya as $relatedAnimeId) {
                $this->seriLainnya->insert([
                    'anime_id' => $idData,
                    'seriLainnya_id' => $relatedAnimeId
                ]);
            }
        }

// ==========================================
            // 6. LOG AKTIVITAS ADMIN (CERDAS / DINAMIS)
            // ==========================================
            
            // 1. Deteksi Field Opsional yang diisi Admin
            $filledData = [];

            // Cek apakah background bukan default
            if ($namafileBackgroundCover !== 'default3.jpg') $filledData[] = "Background Cover";
            // Cek apakah poster bukan default
            if ($namaPoster !== 'default1.jpg') $filledData[] = "Poster";
            
            // Cek text & number opsional
            if (!empty($this->request->getPost('Desc'))) $filledData[] = "Sinopsis";
            if (!empty($this->request->getPost('Eps'))) $filledData[] = "Jml Episode";
            if (!empty($this->request->getPost('Durasi'))) $filledData[] = "Durasi";
            if (!empty($this->request->getPost('Rilis'))) $filledData[] = "Tgl Rilis";
            if (!empty($this->request->getPost('JudulLainnya'))) $filledData[] = "Judul Alternatif";
            if (!empty($this->request->getPost('release_year'))) $filledData[] = "Tahun Rilis";
            if (!empty($this->request->getPost('mal_id'))) $filledData[] = "MAL ID";
            if (!empty($this->request->getPost('mal_score'))) $filledData[] = "MAL Score";
            
            // Cek dropdown & Selectpicker opsional
            if (!empty($this->request->getPost('typeAnime'))) $filledData[] = "Tipe Anime";
            if (!empty($this->request->getPost('source'))) $filledData[] = "Source Material";
            if (!empty($this->request->getPost('season'))) $filledData[] = "Musim (Season)";
            if (!empty($id_genre)) $filledData[] = count($id_genre) . " Genre";
            if (!empty($id_studios)) $filledData[] = count($id_studios) . " Studio";
            if (!empty($seriLainnya)) $filledData[] = count($seriLainnya) . " Seri Terkait";

            // 2. Tentukan Pesan 'change_type' Berdasarkan Analisa di Atas
            if (empty($filledData)) {
                // JIKA HANYA MENGISI JUDUL SAJA (KOSONGAN)
                $changeTypeMsg = "⚠️ <strong>DRAFT KOSONG:</strong> Hanya judul yang diinput. Menunggu kelengkapan metadata lainnya.";
            } else {
                // JIKA ADA METADATA LAIN YANG DIISI
                $changeTypeMsg = "Data awal dibuat beserta kelengkapan:<br>• " . implode("<br>• ", $filledData);
            }

            // 3. Masukkan ke Database Log
            $this->adminLogsModel->insert([
                'admin_id'    => session()->get('id'),
                'admin_name'  => session()->get('nama'), 
                'action'      => 'CREATE',
                'item'        => 'Anime Master',
                'item_id'     => $idData,
                'description' => 'Menambahkan anime manual secara DRAFT' . ': <strong>' . $judul . '</strong>',
                'change_type' => $changeTypeMsg // Masukkan pesan dinamis yang sudah kita racik
            ]);
        
            session()->setFlashData('pesan', 'Anime dengan Judul <strong>' .$animeData['Judul']. '</strong> Berhasil ditambah');
            return redirect()->to('/dashboard')->withInput();
    }

    public function checkDuplicateTitle()
    {
        $judul = $this->request->getGet('judul');
        
        // Cek ke tabel animes apakah judul tersebut sudah ada
        $isExist = $this->animeModel->where('Judul', $judul)->first();

        if ($isExist) {
            return $this->response->setJSON([
                'status' => 'duplicate', 
                'message' => '⚠️ Perhatian: Anime dengan judul ini sudah ada di database!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'available', 
                'message' => '✅ Judul tersedia (Belum ada di database).'
            ]);
        }
    }

    public function checkDuplicateMalId()
    {
        $mal_id = $this->request->getGet('mal_id');
        
        // Cek ke tabel animes apakah mal_id tersebut sudah dipakai
        // Pastikan mal_id tidak null/kosong sebelum mengecek
        if (empty($mal_id)) {
            return $this->response->setJSON(['status' => 'empty']);
        }

        $isExist = $this->animeModel->where('mal_id', $mal_id)->first();

        if ($isExist) {
            // Kita juga kembalikan nama animenya agar admin tahu nabrak dengan judul apa
            return $this->response->setJSON([
                'status' => 'duplicate', 
                'message' => '⚠️ MAL ID sudah dipakai oleh anime: <strong>' . esc($isExist['Judul']) . '</strong>'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'available', 
                'message' => '✅ MAL ID belum terdaftar.'
            ]);
        }
    }

//--------------------------------------------------------------------------

    public function edit($slug)
    {
    $anime = $this->animeModel->getAnimeWithGenresAdmin($slug);
    // dd($anime);
    if (empty($anime)) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime dengan ID ' . $id . ' tidak ditemukan.');
    }

    // Ambil ID anime setelah memastikan data ada
    $id = $anime['id'];  // Sesuaikan dengan kolom ID dari query

    // $generatedSlug = url_title($anime['Judul'], '-', true);
    //     if ($slug !== $generatedSlug) {
    //         // Jika slug tidak cocok, lempar pengecualian atau redirect ke URL yang benar
    //         return redirect()->to("/dashboard/edit/$id/$generatedSlug");
    //     }

    // Ambil genre yang sudah dipilih
    $selectedGenre = $this->animeModel->selectedGenre($anime['id']);
    $relatedAnime = $this->animeModel->getRelatedAnime($anime['id']);

   
    if (!empty($anime['genre'])) {
        $anime['genre'] = explode(',', $anime['genre']);
    } else {
        $anime['genre'] = [];
    }
    // dd($anime);

        // AMBIL ID STUDIO YANG SUDAH TERPILIH
    $db = \Config\Database::connect();
    $selectedStudios = array_column($db->table('anime_studios')->where('anime_id', $anime['id'])->get()->getResultArray(), 'studio_id');

    // Data untuk dikirim ke view
    $data = [
        'title'             => '| Edit Anime | ' . $anime['Judul'],
        'animes'            => $anime,
        // 'episode' => $episode,
        // 'totalEpisode' => $totalEpisode,
        'genres'            => $this->genreModel->getGenre(),
        'selectedGenre'     => $selectedGenre,
        'relatedAnime'      => $relatedAnime,
        'studios'           => $this->studioModel->orderBy('nama_studio', 'ASC')->findAll(), // SEMUA STUDIO
        'selectedStudios'   => $selectedStudios, // STUDIO YANG DIPILIH
        'typeAnime'         => $this->animeType->findAll(),
        'animess'           => $this->animeModel->findall(),
        'validation'        => \Config\Services::validation()
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
        // 1. Ambil data lama SEBELUM validasi agar bisa dipakai untuk redirect jika gagal
        $animeLama = $this->animeModel->find($id);
        if (!$animeLama) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
        }

        // 2. VALIDASI (Hanya Judul dan Gambar)
        if (!$this->validate([
            'Judul' => [
                'rules' => "required|is_unique[animes.Judul,id,{$id}]",
                'errors' => [
                    'required' => 'Judul Anime Wajib diisi!',
                    'is_unique' => 'Gagal mengedit: Anime dengan judul ini sudah ada di database!'
                ]
            ],
            'BackgroundCoverFile' => [
                'rules' => 'max_size[BackgroundCoverFile,2048]|is_image[BackgroundCoverFile]|mime_in[BackgroundCoverFile,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => ['max_size' => 'Ukuran Gambar Terlalu Besar', 'is_image' => 'File harus berupa gambar', 'mime_in'  => 'Format gambar tidak didukung']
            ],
            'PosterFile' => [
                'rules' => 'max_size[PosterFile,2048]|is_image[PosterFile]|mime_in[PosterFile,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => ['max_size' => 'Ukuran Gambar Terlalu Besar', 'is_image' => 'File harus berupa gambar', 'mime_in'  => 'Format gambar tidak didukung']
            ]
        ])) {
            return redirect()->to('/dashboard/edit/' . $animeLama['slug'])->withInput()->with('validation', $this->validator);
        }

        $changes = [];

        // ==========================================
        // 3. PROSES UPLOAD GAMBAR (MENDUKUNG URL & FILE)
        // ==========================================
        
        // --- BACKGROUND COVER ---
// ==========================================
        // 3. PROSES UPLOAD GAMBAR (MENDUKUNG URL & FILE)
        // ==========================================
        
        // --- BACKGROUND COVER ---
        $bgSourceType = $this->request->getPost('bg_source_type');
        $namafileBackgroundCover = $animeLama['BackgroundCover']; // Default: Pertahankan gambar lama
        $bgReset = $this->request->getPost('BackgroundCoverReset'); // Tangkap perintah reset dari JS

        // JIKA ADMIN MENEKAN TOMBOL "X" (RESET GAMBAR KE DEFAULT)
        if ($bgReset == '1') {
            $namafileBackgroundCover = 'default3.jpg'; // Paksa jadi default
            
            if ($animeLama['BackgroundCover'] !== 'default3.jpg') {
                $changes[] = "Background Cover dihapus/direset ke default";
                // Hapus file fisik lama di server (jika itu bukan URL)
                if (!filter_var($animeLama['BackgroundCover'], FILTER_VALIDATE_URL) && file_exists('assets/images/' . $animeLama['BackgroundCover'])) {
                    unlink('assets/images/' . $animeLama['BackgroundCover']);
                }
            }
        } 
        // JIKA TIDAK DIRESET, CEK APAKAH ADA PERUBAHAN VIA URL ATAU UPLOAD
        else {
            if ($bgSourceType === 'url') {
                $urlInput = $this->request->getPost('BackgroundCoverUrl');
                if (!empty($urlInput) && $urlInput !== $animeLama['BackgroundCover']) {
                    $namafileBackgroundCover = $urlInput;
                    $changes[] = "Background Cover diubah via URL";
                    
                    if ($animeLama['BackgroundCover'] !== 'default3.jpg' && !filter_var($animeLama['BackgroundCover'], FILTER_VALIDATE_URL) && file_exists('assets/images/' . $animeLama['BackgroundCover'])) {
                        unlink('assets/images/' . $animeLama['BackgroundCover']);
                    }
                }
            } else {
                $fileBg = $this->request->getFile('BackgroundCoverFile');
                if ($fileBg && $fileBg->isValid() && !$fileBg->hasMoved()) {
                    $namafileBackgroundCover = $fileBg->getRandomName();
                    $fileBg->move('assets/images', $namafileBackgroundCover);
                    
                    if ($animeLama['BackgroundCover'] !== 'default3.jpg' && !filter_var($animeLama['BackgroundCover'], FILTER_VALIDATE_URL) && file_exists('assets/images/' . $animeLama['BackgroundCover'])) {
                        unlink('assets/images/' . $animeLama['BackgroundCover']);
                    }
                    $changes[] = "Background Cover diupload ulang";
                }
            }
        }


        // --- POSTER UTAMA ---
        $posterSourceType = $this->request->getPost('poster_source_type');
        $namaPoster = $animeLama['Poster']; // Default: Pertahankan gambar lama
        $posterReset = $this->request->getPost('PosterReset'); // Tangkap perintah reset

        // JIKA ADMIN MENEKAN TOMBOL "X" (RESET GAMBAR KE DEFAULT)
        if ($posterReset == '1') {
            $namaPoster = 'default1.jpg'; // Paksa jadi default
            
            if ($animeLama['Poster'] !== 'default1.jpg') {
                $changes[] = "Poster Utama dihapus/direset ke default";
                // Hapus file fisik lama
                if (!filter_var($animeLama['Poster'], FILTER_VALIDATE_URL) && file_exists('assets/images/' . $animeLama['Poster'])) {
                    unlink('assets/images/' . $animeLama['Poster']);
                }
            }
        } 
        // JIKA TIDAK DIRESET, CEK APAKAH ADA PERUBAHAN VIA URL ATAU UPLOAD
        else {
            if ($posterSourceType === 'url') {
                $urlInput = $this->request->getPost('PosterUrl');
                if (!empty($urlInput) && $urlInput !== $animeLama['Poster']) {
                    $namaPoster = $urlInput;
                    $changes[] = "Poster diubah via URL";
                    
                    if ($animeLama['Poster'] !== 'default1.jpg' && !filter_var($animeLama['Poster'], FILTER_VALIDATE_URL) && file_exists('assets/images/' . $animeLama['Poster'])) {
                        unlink('assets/images/' . $animeLama['Poster']);
                    }
                }
            } else {
                $filePoster = $this->request->getFile('PosterFile');
                if ($filePoster && $filePoster->isValid() && !$filePoster->hasMoved()) {
                    $namaPoster = $filePoster->getRandomName();
                    $filePoster->move('assets/images', $namaPoster);
                    
                    if ($animeLama['Poster'] !== 'default1.jpg' && !filter_var($animeLama['Poster'], FILTER_VALIDATE_URL) && file_exists('assets/images/' . $animeLama['Poster'])) {
                        unlink('assets/images/' . $animeLama['Poster']);
                    }
                    $changes[] = "Poster diupload ulang";
                }
            }
        }

        // ==========================================
        // 4. TANGKAP SEMUA DATA POST DARI FORM
        // ==========================================
        $judul        = $this->request->getPost('Judul');
        $slug         = $this->animeModel->createSlug($judul);
        $Desc         = $this->request->getPost('Desc') ?: 'Belum ada sinopsis untuk anime ini.';
        $Eps          = $this->request->getPost('Eps') ?: 0;
        $Durasi       = $this->request->getPost('Durasi') ?: 0;
        $Rilis        = $this->request->getPost('Rilis') ?: 'TBA';
        $JudulLainnya = $this->request->getPost('JudulLainnya') ?: '-';
        $typeid       = $this->request->getPost('typeAnime') ?: 'Unknown';
        $statustayang = $this->request->getPost('status_tayang') ?? 'draft';
        $status       = $this->request->getPost('status') ?: 'On-Going';
        
        // Metadata Baru
        $mal_id       = $this->request->getPost('mal_id') ?: null;
        $mal_score    = $this->request->getPost('mal_score') ?: 0.00;
        $source       = $this->request->getPost('source') ?: 'Unknown';
        $season       = $this->request->getPost('season') ?: 'Unknown';
        $release_year = $this->request->getPost('release_year') ?: null;

        // Data Relasi
        $genreBaru    = $this->request->getPost('genre') ?: [];
        $studiosBaru  = $this->request->getPost('studios') ?: [];
        $serilainnya  = $this->request->getPost('seriLainnya') ?: [];

        // ==========================================
        // 5. DETEKSI PERUBAHAN (CHANGE LOGGING)
        // ==========================================
        if ($animeLama['Judul'] != $judul) $changes[] = "Judul (<strong>{$animeLama['Judul']}</strong> ➔ <strong>{$judul}</strong>)";
        if ($animeLama['Desc'] != $Desc) $changes[] = "Deskripsi / Sinopsis diperbarui";
        if ($animeLama['Eps'] != $Eps) $changes[] = "Episode (<strong>{$animeLama['Eps']}</strong> ➔ <strong>{$Eps}</strong>)";
        if ($animeLama['Durasi'] != $Durasi) $changes[] = "Durasi (<strong>{$animeLama['Durasi']}</strong> ➔ <strong>{$Durasi}</strong>)";
        if ($animeLama['Rilis'] != $Rilis) $changes[] = "Tanggal Rilis (<strong>{$animeLama['Rilis']}</strong> ➔ <strong>{$Rilis}</strong>)";
        if ($animeLama['status'] != $status) $changes[] = "Status (<strong>{$animeLama['status']}</strong> ➔ <strong>{$status}</strong>)";
        if ($animeLama['statusTayang'] != $statustayang) $changes[] = "Status Publikasi (<strong>{$animeLama['statusTayang']}</strong> ➔ <strong>{$statustayang}</strong>)";
        
        if ($animeLama['mal_id'] != $mal_id) $changes[] = "MAL ID diubah menjadi <strong>{$mal_id}</strong>";
        if ($animeLama['mal_score'] != $mal_score) $changes[] = "MAL Score diubah menjadi <strong>{$mal_score}</strong>";
        if ($animeLama['source'] != $source) $changes[] = "Source Material (<strong>{$animeLama['source']}</strong> ➔ <strong>{$source}</strong>)";
        if ($animeLama['season'] != $season) $changes[] = "Season (<strong>{$animeLama['season']}</strong> ➔ <strong>{$season}</strong>)";
        if ($animeLama['release_year'] != $release_year) $changes[] = "Tahun Rilis diubah menjadi <strong>{$release_year}</strong>";

        // Deteksi Perbedaan Genre 
        $genreLama = $this->animeGenreModel->where('anime_id', $id)->findColumn('genre_id') ?: [];
        $genreDitambahkan = array_diff($genreBaru, $genreLama); 
        $genreDihapus = array_diff($genreLama, $genreBaru); 

        if (!empty($genreDitambahkan) || !empty($genreDihapus)) {
            $detailPerubahanGenre = [];
            if (!empty($genreDitambahkan)) {
                $namaG = array_map(fn($g) => "<strong>$g</strong>", $this->getGenreNames($genreDitambahkan));
                $detailPerubahanGenre[] = "Genre ditambahkan: " . implode(", ", $namaG);
            }
            if (!empty($genreDihapus)) {
                $namaG = array_map(fn($g) => "<strong>$g</strong>", $this->getGenreNames($genreDihapus));
                $detailPerubahanGenre[] = "Genre dihapus: " . implode(", ", $namaG);
            }
            $changes[] = implode("; ", $detailPerubahanGenre);
        }

        // ==========================================
        // 6. SIMPAN KE DATABASE
        // ==========================================
        $animeData = [
            'id'              => $id,
            'Judul'           => $judul,
            'slug'            => $slug,
            'BackgroundCover' => $namafileBackgroundCover,
            'Poster'          => $namaPoster,
            'Desc'            => $Desc,
            'Eps'             => $Eps,
            'Durasi'          => $Durasi,
            'Rilis'           => $Rilis,
            'JudulLainnya'    => $JudulLainnya,
            'typeId'          => $typeid,
            'status'          => $status,
            'statusTayang'    => $statustayang,
            'mal_id'          => $mal_id,
            'mal_score'       => $mal_score,
            'source'          => $source,
            'season'          => $season,
            'release_year'    => $release_year
        ];

        $this->animeModel->save($animeData);
    
        // Update Relasi Genre
        $this->animeGenreModel->where('anime_id', $id)->delete();
        if(!empty($genreBaru)) {
            foreach ($genreBaru as $genreId) {
                $this->animeGenreModel->insert(['anime_id' => $id, 'genre_id' => $genreId]);
            }
        }

        // Update Relasi Studio
        $db = \Config\Database::connect();
        $db->table('anime_studios')->where('anime_id', $id)->delete(); 
        if(!empty($studiosBaru)) {
            foreach ($studiosBaru as $studioId) {
                $db->table('anime_studios')->insert(['anime_id' => $id, 'studio_id' => $studioId]);
            }
        }

        // Update Relasi Seri Lainnya
        $this->seriLainnya->where('anime_id', $id)->delete();
        if (!empty($serilainnya)) {
            foreach ($serilainnya as $relatedAnimeId) {
                $this->seriLainnya->insert(['anime_id' => $id, 'seriLainnya_id' => $relatedAnimeId]);
            }
        }

// ==========================================
        // 7. LOG ACTIVITY ADMIN
        // ==========================================
        
        // HANYA CATAT LOG JIKA ADA PERUBAHAN YANG BENAR-BENAR TERJADI
        if (!empty($changes)) {
            
            $jumlahPerubahan = count($changes);
            
            // Format perubahan agar turun ke bawah (bullet points)
            $detailPerubahan = "• " . implode("<br>• ", $changes);
            
            // Buat header kecil di dalam change_type agar jelas berapa item yang diedit
            $changeTypeMsg = "Melakukan <strong>{$jumlahPerubahan} perubahan</strong> data:<br>" . $detailPerubahan;

            // Jika status tayang diubah dari DRAFT ke PUBLISHED, berikan pesan khusus yang mencolok!
            if ($animeLama['statusTayang'] == 'draft' && $statustayang == 'published') {
                 $changeTypeMsg = "🚀 <strong>DIPUBLIKASIKAN:</strong> Anime ini sekarang sudah tampil untuk User.<br>" . $changeTypeMsg;
            } 
            // Sebaliknya, jika di-draft (disembunyikan)
            else if ($animeLama['statusTayang'] == 'published' && $statustayang == 'draft') {
                 $changeTypeMsg = "🔒 <strong>DISEMBUNYIKAN (DRAFT):</strong> Anime ditarik dari halaman User.<br>" . $changeTypeMsg;
            }

            $this->adminLogsModel->insert([
                'admin_id'    => session()->get('id'), 
                'admin_name'  => session()->get('nama'),
                'action'      => 'UPDATE', // WAJIB 'UPDATE' agar sesuai dropdown filter HTML Anda
                'item'        => 'Anime Master', 
                'item_id'     => $id,
                'description' => 'Memodifikasi data anime: <strong>' . esc($animeLama['Judul']) . '</strong>', 
                'change_type' => $changeTypeMsg 
            ]);
        }

        session()->setFlashData('pesan', 'Anime dengan Judul <strong>' . $judul . '</strong> Berhasil diubah');
        return redirect()->to('/dashboard');
    }

    protected function getGenreNames($genreIds)
    {
        return $this->genreModel->whereIn('id', $genreIds)->findColumn('genre');
    }

//--------------------------------------------------------------------------

public function deleteEpisode($id)
    {
        // 1. Ambil data episode SEBELUM dihapus agar kita tahu dia milik anime yang mana
        $episode = $this->episodeModel->find($id);
        
        if (!$episode) {
            if ($this->request->isAJAX()) return $this->response->setStatusCode(404)->setJSON(['error' => 'Episode tidak ditemukan.']);
            return redirect()->back()->with('error', 'Episode tidak ditemukan.');
        }

        $anime_id = $episode['anime_id'];
        $episode_number = $episode['episode_number'];

        // 2. Ambil data Anime Induknya
        $animeInduk = $this->animeModel->find($anime_id);
        $animeJudul = $animeInduk ? $animeInduk['Judul'] : 'Unknown Anime';

        // ==========================================
        // 3. PROSES HAPUS FILE VIDEO & THUMBNAIL (OPSIONAL TAPI PENTING)
        // ==========================================
        // Hapus Video Lokal (Jika ada dan bukan link embed)
        if (!empty($episode['video_path']) && !filter_var($episode['video_path'], FILTER_VALIDATE_URL) && strpos($episode['video_path'], '<iframe') === false) {
            $videoPath = FCPATH . 'assets/videos/' . $episode['video_path'];
            if (file_exists($videoPath) && is_file($videoPath)) unlink($videoPath);
        }

        // Hapus Thumbnail Lokal (Jika bukan default)
        if (!empty($episode['GambarPreview']) && $episode['GambarPreview'] !== 'default.jpg') {
            $thumbPath = FCPATH . 'assets/imgPreview/' . $episode['GambarPreview'];
            if (file_exists($thumbPath) && is_file($thumbPath)) unlink($thumbPath);
        }

        // ==========================================
        // 4. EKSEKUSI HAPUS EPISODE DARI DATABASE
        // ==========================================
        $this->episodeModel->delete($id);

        // ==========================================
        // 5. REVERSE AUTO-STATUS SYSTEM (CEK APAKAH HARUS KEMBALI ON-GOING?)
        // ==========================================
        $isStatusReverted = false;

        // Jika anime ini targetnya jelas (>0) dan statusnya saat ini 'Completed'
        if ($animeInduk && $animeInduk['Eps'] > 0 && $animeInduk['status'] === 'Completed') {
            
            // Hitung ULANG jumlah episode setelah penghapusan
            $sisaEpisode = $this->episodeModel->where('anime_id', $anime_id)->countAllResults();

            // Jika sisa episode SEKARANG KURANG DARI target total episode
            if ($sisaEpisode < $animeInduk['Eps']) {
                
                // KEMBALIKAN STATUSNYA JADI ON-GOING
                $this->animeModel->update($anime_id, [
                    'status' => 'On-Going'
                ]);
                
                $isStatusReverted = true;
            }
        }

        // ==========================================
        // 6. LOG AKTIVITAS ADMIN
        // ==========================================
        $changeTypeMsg = "Menghapus <strong>Episode {$episode_number}</strong> secara permanen.";

        if ($isStatusReverted) {
            $changeTypeMsg .= "<br>⚠️ <strong>STATUS REVERT:</strong> Jumlah episode berkurang dari batas target ({$animeInduk['Eps']}). Status anime dikembalikan menjadi <strong>On-Going</strong>.";
        }

        $this->adminLogsModel->insert([
            'admin_id'    => session()->get('id'),
            'admin_name'  => session()->get('nama'), 
            'action'      => 'DELETE', // Sesuai dengan filter Anda
            'item'        => 'Episode', 
            'item_id'     => $id, // ID episode yang sudah jadi abu (dihapus)
            'description' => "Menghapus episode pada seri anime: " . $animeJudul,
            'change_type' => $changeTypeMsg
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Episode berhasil dihapus.']);
        }

        return redirect()->back()->with('pesan', 'Episode berhasil dihapus.');
    }

    public function deleteAllEpisodes($animeId)
    {
        // Cari semua episode terkait anime
        $episodes = $this->episodeModel->where('anime_id', $animeId)->findAll();
    
        if (empty($episodes)) {
            // Jika tidak ada episode ditemukan, kirimkan respons error
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak ada episode yang dapat dihapus pada judul anime ini.'
            ]);
        }
    
        // Cari data anime terkait
        $anime = $this->animeModel->find($animeId);
        
        if (!$anime) {
            // Jika anime tidak ditemukan
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
        }
    
        // Loop melalui setiap episode untuk menghapus file video dan gambar preview
        foreach ($episodes as $episode) {
            // Hapus gambar preview jika bukan default
            if ($episode['GambarPreview'] != 'default.jpg') {
                $GambarPreviewPath = 'assets/imgPreview/' . $episode['GambarPreview'];
                if (file_exists($GambarPreviewPath)) {
                    unlink($GambarPreviewPath);
                }
            }
    
            // Hapus file video
            $videoPath = FCPATH . 'assets/videos/' . $episode['video_path'];
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
    
            // Hapus data episode dari database
            $this->episodeModel->delete($episode['id']);
        }
    
        // Logging untuk admin
        $adminId = session()->get('id');
        $this->adminLogsModel->logChange(
            $adminId, 
            $animeId, 
            'hapus', 
            'Semua episode dari anime <strong>' . $anime['Judul'] . '</strong> telah dihapus.'
        );

         // Kirimkan respons sukses dalam format JSON
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Semua episode telah dihapus.'
        ]);
    
        // Set pesan flash untuk notifikasi
        session()->setFlashdata('pesan', 'Semua episode dari anime ' . $anime['Judul'] . ' telah dihapus.');
    
        // Redirect ke halaman detail anime
        return redirect()->to("/dashboard/detail/{$anime['slug']}");
    }

//--------------------------------------------------------------------------

public function delete($slug)
{
    if (!$this->request->isAJAX()) {
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid request method.'])->setStatusCode(405);
    }

    $anime = $this->animeModel->where('slug', $slug)->first();

    if (!$anime) {
        // Anime tidak ditemukan
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Anime tidak ditemukan.');
    }

    // Hapus BackgroundCover jika bukan default
    if ($anime['BackgroundCover'] != 'default3.jpg') {
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

    // log aktivitas admin
    $this->adminLogsModel->insert([
        'admin_id' => session()->get('id'),
        'action' => 'DELETE',
        'item' => 'Anime',
        'item_id' => $anime['Judul'],
        'description' => 'Menghapus anime berjudul ' . $anime['Judul']
    ]);
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
            'title' => 'List News | WOTAKUS',
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
            'title' => 'Form Tambah News | WOTAKUS',
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

    public function jadwalRilis()
    {
        $animeOnGoing = $this->animeModel->getOnGoingAnimeNotInSchedule();
        $animeTayang = $this->animeJadwalRilis->getAnimeJadwal();

        $data = [
            'title'          => 'Jadwal Rilis',
            'On_Going_Anime' => $animeOnGoing,
            'AnimeTayang' => $animeTayang,
        ];

        return view('admin/admin-partials/jadwalRilis', $data);
    }

    public function deleteAnimeJadwal($id)
    {
        // Hapus jadwal rilis berdasarkan ID
        $this->animeJadwalRilis->delete($id);

        return redirect()->back()->with('success', 'Jadwal rilis berhasil dihapus.');
    }

    public function saveJadwalRilis()
    {
         // Ambil data dari request
        $animeIds = $this->request->getPost('animeOnGoing'); // Array of anime IDs
        $hariRilis = $this->request->getPost('hari_rilis');

        // Pastikan array animeIds tidak kosong
        if (!empty($animeIds)) {
            foreach ($animeIds as $animeId) {
                // Simpan setiap anime ke dalam tabel anime_jadwal_rilis
                $this->animeJadwalRilis->save([
                    'anime_id' => $animeId,
                    'hari_rilis' => $hariRilis,
                ]);
            }

            return redirect()->back()->with('success', 'Jadwal rilis berhasil disimpan.');
        } else {
            return redirect()->back()->with('error', 'Pilih setidaknya satu anime untuk menyimpan jadwal rilis.');
        }
    }

    public function updateAnimeData()
    {
        // helper(['anime', 'slug']); 
    
        $client = \Config\Services::curlrequest([
            'timeout' => 400,  // Atur timeout yang sesuai
        ]);
        $limit = 270;  // Jumlah anime yang ingin diperbarui
        $page = 1;     // Mulai dari halaman pertama
        $updated = 0;
    
        while ($updated < $limit) {
            // Ambil data dari API Jikan
            $response = $client->request('GET', 'https://api.jikan.moe/v4/top/anime?page=' . $page);
            $data = json_decode($response->getBody(), true);
    
            if (!empty($data['data'])) {
                foreach ($data['data'] as $anime) {
                    // Cek apakah judul anime sudah ada di database
                    $existingAnime = $this->animeModel->where('Judul', $anime['title'])->first();
    
                    if (!$existingAnime) {
                        // Jika anime tidak ada, lewati dan lanjutkan ke anime berikutnya
                        continue;
                    }
    
                    // Gunakan judul untuk membuat slug
                    $slug = generateSlug($anime['title']);
    
                    // Cek apakah sinopsis tersedia, jika tidak, berikan string kosong
                    $synopsis = !empty($anime['synopsis']) ? $anime['synopsis'] : 'Sinopsis tidak tersedia.';
    
                    // Ambil judul lainnya dalam bahasa Jepang jika tersedia
                    $judulLainnya = null;
                    foreach ($anime['titles'] as $title) {
                        if ($title['type'] === 'Japanese') {
                            $judulLainnya = $title['title'];
                            break;
                        }
                    }
    
                    // Terjemahkan sinopsis ke bahasa Indonesia menggunakan Google Translate
                    $translatedSynopsis = $this->translateTextGoogle($anime['synopsis'], 'id', 'en');
    
                    // Buat data anime yang akan diupdate
                    $animeData = [
                        'Judul'           => $anime['title'],
                        'slug'            => $slug,
                        'Poster'          => $anime['images']['webp']['large_image_url'],
                        'BackgroundCover' => $anime['images']['webp']['large_image_url'] ?? null,
                        'Desc'            => $translatedSynopsis,
                        'Eps'             => $anime['episodes'] ?? $existingAnime['Eps'],
                        'Durasi'          => $anime['duration'] ?? $existingAnime['Durasi'],
                        'Rilis'           => $anime['aired']['from'] ?? $existingAnime['Rilis'],
                        'JudulLainnya'    => $judulLainnya,
                        'SeriLainnya'     => $anime['related']['adaptation'][0]['name'] ?? $existingAnime['SeriLainnya'],
                        'typeId'          => mapAnimeType($anime['type']),
                        'status'          => mapAnimeStatus($anime['status']),
                        'statusTayang'    => 'published',
                        'created_at'      => date('Y-m-d H:i:s'),
                    ];
    
                    // Periksa jika ada perubahan data
                    if (
                        $animeData['status'] !== $existingAnime['status'] ||
                        $animeData['Eps'] != $existingAnime['Eps'] ||
                        $animeData['Judul'] != $existingAnime['Judul']
                    ) {
                        // Update data anime di database
                        $this->animeModel->update($existingAnime['id'], $animeData);
                        $updated++;
                    }
    
                    // Update genre kalau ada perbedaan
                    if (!empty($anime['genres'])) {
                        foreach ($anime['genres'] as $genre) {
                            // Generate slug untuk genre
                            $genreSlug = generateSlug($genre['name']);
    
                            // Cari genre di database, jika tidak ada tambahkan
                            $existingGenre = $this->genreModel->where('genre', $genre['name'])->first();
    
                            if ($existingGenre) {
                                $genreId = $existingGenre['id'];
                            } else {
                                // Tambahkan genre baru ke tabel genre
                                $this->genreModel->insert([
                                    'genre'      => $genre['name'],
                                    'slug_genre' => $genreSlug,
                                ]);
                                $genreId = $this->genreModel->insertID();
                            }
    
                            // Simpan hubungan antara anime dan genre di tabel pivot anime_genre
                            if (!$this->animeGenreModel->where(['anime_id' => $existingAnime['id'], 'genre_id' => $genreId])->first()) {
                                $this->animeGenreModel->insert([
                                    'anime_id' => $existingAnime['id'],
                                    'genre_id' => $genreId,
                                ]);
                            }
                        }
                    }
    
                    // Berhenti kalau sudah mencapai limit
                    if ($updated >= $limit) {
                        break;
                    }
                }
            } else {
                break;  // Berhenti jika tidak ada lagi data
            }
    
            // Tambahkan jeda 2 detik sebelum memulai halaman berikutnya
            sleep(2);
    
            // Pindah ke halaman berikutnya
            $page++;
        }
    
        // Redirect dengan pesan berdasarkan hasil update
        return $this->response->setJSON([
            'success' => $updated > 0,
            'message' => $updated > 0 ? "$updated anime berhasil diperbarui." : 'Tidak ada update terbaru.'
        ]);
    }

    public function fetchAnimeData($source = 'seasons/now', $page = 1)
    {
        helper(['anime', 'mapAnimeStatus', 'translation', 'url']); 
        $client = \Config\Services::curlrequest();
        $db = \Config\Database::connect();
        $fetched = 0;
    
        $apiPath = str_replace('-', '/', $source); 
        $apiUrl = "https://api.jikan.moe/v4/{$apiPath}?page={$page}&sfw=true";
    
        try {
            $response = $client->request('GET', $apiUrl, ['http_errors' => false]);
            $data = json_decode($response->getBody(), true);
            $hasNextPage = $data['pagination']['has_next_page'] ?? false;
    
            if (empty($data['data'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
            }
    
            // Batasi jumlah anime per klik agar tidak timeout saat translasi & fetch studio/episode
            $limitData = 5; 
            $animesToProcess = array_slice($data['data'], 0, $limitData); 
    
            foreach ($animesToProcess as $anime) {
                // 1. Cek duplikasi anime
                $existingAnime = $this->animeModel->where('Judul', $anime['title'])->first();
                if ($existingAnime) continue;
    
                // 2. Siapkan Data Anime Utama (Termasuk MAL Score)
                $animeData = [
                    'Judul'           => $anime['title'],
                    'slug'            => url_title($anime['title'], '-', true),
                    'Poster'          => $anime['images']['webp']['large_image_url'],
                    'BackgroundCover' => $anime['images']['webp']['large_image_url'],
                    'Desc'            => translateTextGoogle($anime['synopsis'], 'id', 'en'),
                    'Eps'             => $anime['episodes'] ?? 0,
                    'Durasi'          => $this->parseDurationToMinutes($anime['duration'] ?? ''),
                    'Rilis'           => $anime['aired']['from'] ?? null,
                    'JudulLainnya'    => $anime['title_japanese'] ?? null,
                    'typeId'          => mapAnimeType($anime['type']),
                    'status'          => mapAnimeStatus($anime['status']),
                    'statusTayang'    => 'published',
                    'mal_id'          => $anime['mal_id'],
                    'mal_score'       => $anime['score'] ?? 0.00, // AMBIL SCORE MAL
                    'source'          => $anime['source'] ?? 'Unknown',
                    'season'          => $anime['season'] ?? 'Unknown',
                    'release_year'    => $anime['year'] ?? null,
                    'created_at'      => date('Y-m-d H:i:s'),
                ];
    
                $this->animeModel->insert($animeData);
                $animeInternalId = $this->animeModel->getInsertID();
    

                $listStudio = []; // Menyimpan nama studio untuk keperluan log
                // 3. LOGIKA OTOMATIS AMBIL STUDIO
                if (!empty($anime['studios'])) {
                    foreach ($anime['studios'] as $s) {
                        $studioName = $s['name'];
                        $listStudio[] = $studioName; // Masukkan ke array log
                        // Cek di tabel master studio
                        $existingStudio = $db->table('studios')->where('nama_studio', $studioName)->get()->getRowArray();
                        
                        if (!$existingStudio) {
                            $db->table('studios')->insert([
                                'nama_studio' => $studioName,
                                'slug_studio' => url_title($studioName, '-', true)
                            ]);
                            $studioId = $db->insertID();
                        } else {
                            $studioId = $existingStudio['id'];
                        }
    
                        // Hubungkan ke tabel pivot anime_studios
                        $db->table('anime_studios')->insert([
                            'anime_id'  => $animeInternalId,
                            'studio_id' => $studioId
                        ]);
                    }
                }
    
                // 4. LOGIKA AMBIL GENRE, THEMES, & DEMOGRAPHICS (Digabung jadi satu)
                $allTags = array_merge($anime['genres'], $anime['themes'], $anime['demographics']);
                $listGenre = []; // Menyimpan nama genre untuk keperluan log
                if (!empty($allTags)) {
                    foreach ($allTags as $g) {
                        $listGenre[] = $g['name']; // Masukkan ke array log
                        $existingGenre = $this->genreModel->where('genre', $g['name'])->first();
                        if (!$existingGenre) {
                            $this->genreModel->insert([
                                'genre'      => $g['name'], 
                                'slug_genre' => url_title($g['name'], '-', true)
                            ]);
                            $genreId = $this->genreModel->getInsertID();
                        } else {
                            $genreId = $existingGenre['id'];
                        }
                        
                        $db->table('animeGenre')->insert([
                            'anime_id' => $animeInternalId,
                            'genre_id' => $genreId
                        ]);
                    }
                }
    
                // 5. LOGIKA AMBIL EPISODE (Me-return jumlah episode untuk Log)
                $jumlahEps = $this->autoFetchEpisodes($anime['mal_id'], $animeInternalId);
    
                // --- TAMBAHAN UNTUK LOG ADMIN ---
                $strStudio = !empty($listStudio) ? implode(", ", $listStudio) : 'Unknown';
                $strGenre = !empty($listGenre) ? implode(", ", $listGenre) : 'Unknown';
                
                $this->adminLogsModel->insert([
                    'admin_id'    => session()->get('id'),
                    'admin_name'  => session()->get('nama'),
                    'action'      => 'SYNC API',
                    'item'        => 'Anime Master Jikan API',
                    'item_id'     => $animeInternalId,
                    'description' => 'Melakukan Sync data Jikan API untuk anime berjudul: <strong>' . $anime['title'] .'</strong>',
                    'change_type' => "Ditarik beserta <strong>$jumlahEps Eps</strong>, Studio: <strong>$strStudio</strong>, Genre: <strong>$strGenre</strong>"
                ]);
                // ---------------------------------

                $fetched++;

                // Jeda agar tidak kena Rate Limit Jikan
                sleep(2); 
            }
    
            return $this->response->setJSON([
                'status'   => 'success', 
                'fetched'  => $fetched,
                'has_next' => $hasNextPage,
                'message'  => "Sync selesai. $fetched anime, studio, dan episode berhasil ditarik."
            ]);
    
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    
    /**
     * Fungsi pembantu untuk ambil episode secara otomatis
     */
    private function autoFetchEpisodes($malId, $animeInternalId)
    {
        sleep(1); // Jeda rate limit
    
        $client = \Config\Services::curlrequest();
        $epUrl = "https://api.jikan.moe/v4/anime/{$malId}/episodes";
        $jumlahDitarik = 0; // Tambahkan variabel counter
        
        try {
            $response = $client->request('GET', $epUrl, ['http_errors' => false]);
            $epData = json_decode($response->getBody(), true);
    
            if (!empty($epData['data'])) {
                $db = \Config\Database::connect();
    
                foreach ($epData['data'] as $ep) {
                    // 1. Simpan Episode
                    $db->table('EpisodeAnime')->insert([
                        'anime_id'       => $animeInternalId,
                        'judul'          => $ep['title'] ?? 'Episode ' . $ep['mal_id'],
                        'slug-episode'   => 'episode-' . $ep['mal_id'] . '-' . bin2hex(random_bytes(2)),
                        'episode_number' => $ep['mal_id'],
                        'deskripsi'      => 'Episode terbaru dari seri ini.',
                        'GambarPreview'  => 'default.png',
                        'video_path'     => 'default.mp4',
                        'created_at'     => date('Y-m-d H:i:s')
                    ]);
                    
                    $lastEpId = $db->insertID();
    
                    // 2. Simpan Views Awal (0)
                    $db->table('episode_views')->insert([
                        'episode_id' => $lastEpId,
                        'view_count' => 0, // Database tetap menyimpan angka murni
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    $jumlahDitarik++; // Increment jika berhasil
                }
            }
            return $jumlahDitarik; // Return ke fungsi utama

        } catch (\Exception $e) {
            log_message('error', "Gagal fetch episode MAL ID $malId: " . $e->getMessage());
            return 0; // Return 0 jika gagal
        }
    }

    private function parseDurationToMinutes($durationStr)
    {
        if (empty($durationStr) || $durationStr == 'Unknown') {
            return 0;
        }

        $totalMinutes = 0;

        // Cari angka jam (contoh: 1 hr)
        if (preg_match('/(\d+)\s*hr/', $durationStr, $matches)) {
            $totalMinutes += intval($matches[1]) * 60;
        }

        // Cari angka menit (contoh: 32 min)
        if (preg_match('/(\d+)\s*min/', $durationStr, $matches)) {
            $totalMinutes += intval($matches[1]);
        }

        // Jika tidak ada jam/menit (format tidak standar), ambil angka pertama saja
        if ($totalMinutes === 0) {
            $totalMinutes = intval(filter_var($durationStr, FILTER_SANITIZE_NUMBER_INT));
        }

        return $totalMinutes;
    }

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

}