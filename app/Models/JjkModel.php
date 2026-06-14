<?php
namespace App\Models;

use CodeIgniter\Model;

class JjkModel extends Model
{
    protected $table      = 'animes';
    protected $primaryKey = 'id';
    protected $userTimestamps = true;
    protected $useAutoIncrement = true;
    // protected $returnType = 'object';
    protected $allowedFields = ['id','Judul','slug','Poster','BackgroundCover','Desc', 'Eps', 'Durasi', 'Rilis',
                                'JudulLainnya','typeId','status','genre_id','genre','statusTayang','mal_id'
                                ,'mal_score','source', 'season', 'release_year'];


public function getPythonRecommendations($userId)
    {
        $client = \Config\Services::curlrequest();
        
        try {
            // Kita panggil API Python Hybrid
            $response = $client->request('GET', "http://127.0.0.1:8000/api/recommend/{$userId}", [
                'timeout' => 5, 
                'http_errors' => false
            ]);

            $result = json_decode($response->getBody(), true);

            // Jika Python berhasil menghitung rekomendasi
            if (isset($result['status']) && $result['status'] === 'success') {
                
                // Ambil array data rekomendasinya
                $recommendationData = $result['data'];
                
                if (empty($recommendationData)) return [];

                // Kumpulkan ID anime hasil rekomendasi
                $animeIds = array_column($recommendationData, 'anime_id');

                // Ambil data lengkap (Poster, Judul, status, tipe) dari database CI4
                $builder = $this->select('animes.*, animetipe.tipeAnime')
                                ->join('animetipe', 'animetipe.id = animes.typeId', 'left')
                                ->whereIn('animes.id', $animeIds);
                
                $animesFromDb = $builder->findAll();

                $finalRecommendations = [];
                // Kita urutkan sesuai urutan ranking dari Python
                foreach ($recommendationData as $rec) {
                    foreach ($animesFromDb as $dbAnime) {
                        if ($rec['anime_id'] == $dbAnime['id']) {
                            
                            // --- LOKASI PERBAIKAN ---
                            // Tangkap key JSON yang baru dari True Hybrid Python
                            $dbAnime['match_percentage'] = $rec['match_percentage'] ?? 85.0; // Ambil %
                            $dbAnime['reason']           = $rec['reason'] ?? 'Disarankan berdasarkan minat Anda'; // Ambil alasan
                            $dbAnime['method']           = $result['method'] ?? 'Hybrid System'; // Ambil info mesin
                            
                            $finalRecommendations[] = $dbAnime;
                            break;
                        }
                    }
                }

                return $finalRecommendations;
            }

        } catch (\Exception $e) {
            log_message('error', 'Gagal memanggil Python AI: ' . $e->getMessage());
        }

        // Fallback: Jika Python mati, return array kosong, biarkan View yang handle
        return [];
    }

    public function getPythonSimilarAnimes($animeId)
    {
        $client = \Config\Services::curlrequest();
        
        try {
            $response = $client->request('GET', "http://127.0.0.1:8000/api/similar/{$animeId}", [
                'timeout' => 5,
                'http_errors' => false
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['status']) && $result['status'] === 'success') {
                $recommendationData = $result['data'];
                
                // --- PERUBAHAN 1: Buat 2 keranjang kosong (Bukan 1 lagi) ---
                $franchiseAnimes = [];
                $similarAnimes   = [];

                if (empty($recommendationData)) {
                    // Jika data kosong, kembalikan format array terstruktur yang kosong
                    return ['franchise' => [], 'similar' => []];
                }

                // Ambil ID
                $animeIds = array_column($recommendationData, 'anime_id');

                $idString = implode(',', $animeIds);
                $builder = $this->select('animes.*, animetipe.tipeAnime')
                                ->join('animetipe', 'animetipe.id = animes.typeId', 'left')
                                ->whereIn('animes.id', $animeIds)
                                ->orderBy("FIELD(animes.id, $idString)");
                
                $animesFromDb = $builder->findAll();

                // Lakukan pemisahan berdasarkan "relation_type" yang dikirim Python
                foreach ($recommendationData as $rec) {
                    foreach ($animesFromDb as $dbAnime) {
                        if ($rec['anime_id'] == $dbAnime['id']) {
                            
                            // Tambahkan data dari Python ke array DB CodeIgniter
                            $dbAnime['ai_badge']  = $rec['badge'];
                            $dbAnime['ai_reason'] = $rec['reason'];
                            
                            // --- PERUBAHAN 2: Pisahkan keranjang berdasarkan relasi ---
                            // Gunakan isset() untuk berjaga-jaga jika Python versi lama masih jalan
                            $relType = isset($rec['relation_type']) ? $rec['relation_type'] : 'similar';
                            
                            if ($relType === 'franchise') {
                                $franchiseAnimes[] = $dbAnime;
                            } else {
                                $similarAnimes[] = $dbAnime;
                            }
                            
                            break; // Stop loop foreach bagian dalam
                        }
                    }
                }
                
                // --- PERUBAHAN 3: Kembalikan 2 Array Sekaligus ---
                return [
                    'franchise' => $franchiseAnimes,
                    'similar'   => $similarAnimes
                ];
            }
        } catch (\Exception $e) {
            log_message('error', 'Python API Down: ' . $e->getMessage());
        }

        // --- PERUBAHAN 4: Penanganan Fallback (Jika Python Mati) ---
        // Jika API error, kita taruh rekomendasi random di keranjang 'similar' saja
        $fallbackData = $this->getRandomAnime($animeId, 12); 
        return [
            'franchise' => [], // Franchise kosong karena Python mati
            'similar'   => $fallbackData
        ];
    }

    public function getAnimes($Judul = false)
    {
        if($Judul == false){
            return $this->findAll();
        }

         $this->where(['Judul' =>  $Judul])->first();
    
    }


    public function getAnimesid($id = false)
    {
        if($id == false){
            return $this->findAll();
        }

         $this->where(['id' =>  $id])->first();
    }

    public function getId(){

        $lastRecord = $this->where(['id' =>  'DESC'])->first();
        if ($lastRecord) {
            return $lastRecord['id'] ;
        }
    }

    public function getStatus()
    {
        return $this->findAll();
    }

    public function getGenre($id)
    {
        $builder = $this->db->table('animes');
        $builder->select('*');
        $builder->join('genre', 'genre.id = animes.genre_id');
        $builder->where('animes.id', $id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getAnimesWithType()
    {
        return $this->select('animes.*, animetipe.tipeAnime, GROUP_CONCAT(DISTINCT studios.nama_studio SEPARATOR ", ") as all_studios')
                    ->join('animetipe', 'animes.typeId = animetipe.id', 'left')
                    ->join('anime_studios', 'animes.id = anime_studios.anime_id', 'left')
                    ->join('studios', 'anime_studios.studio_id = studios.id', 'left')
                    ->where('animes.statusTayang', 'published')
                    ->groupBy('animes.id')
                    ->paginate(18, 'animes');
    }
    
    public function getRandomAnimesWithType($limit = 5)
    {
        // Ganti 'avg_rating' menjadi 'rating_user'
        return $this->select('animes.*, animetipe.tipeAnime, AVG(anime_ratings.rating) as rating_user')
                    ->join('animetipe', 'animes.typeId = animetipe.id')
                    ->join('anime_ratings', 'anime_ratings.anime_id = animes.id', 'left')
                    ->groupBy('animes.id')
                    ->orderBy('animes.id', 'RANDOM')
                    ->limit($limit)
                    ->findAll();
    }

    public function getAnimeWithGenresSlug($slug)
    {
        $builder = $this->db->table('animes');
        
        // ALIASING: Paksa kolom 'id' menjadi 'anime_id'
        $builder->select('animes.*, animes.id as anime_id, animetipe.tipeAnime as tipeAnime');
        
        // PENTING: Gunakan SEPARATOR ',' agar explode di controller bekerja dengan baik
        $builder->select('GROUP_CONCAT(DISTINCT CONCAT(genre.id, ":", genre.genre, ":", genre.slug_genre) SEPARATOR ",") AS all_genres_data');
        $builder->select('GROUP_CONCAT(DISTINCT studios.nama_studio SEPARATOR ", ") AS all_studios');
        
        // SEMUA JOIN HARUS 'LEFT' AGAR DATA YANG KOSONG (NULL) TETAP DITARIK
        $builder->join('animegenre', 'animes.id = animegenre.anime_id', 'left');
        $builder->join('genre', 'animegenre.genre_id = genre.id', 'left'); // <- Tadi salah di sini
        
        $builder->join('anime_studios', 'animes.id = anime_studios.anime_id', 'left');
        $builder->join('studios', 'anime_studios.studio_id = studios.id', 'left');
        
        $builder->join('animetipe', 'animes.typeId = animetipe.id', 'left');
        
        $builder->where('animes.slug', $slug); 
        $builder->groupBy('animes.id');
    
        return $builder->get()->getRowArray();
    }

    public function getAnimeWithGenresAdmin($slug)
    {
        $builder = $this->db->table('animes');
        $builder->select('
            animes.*, 
            animetipe.tipeAnime AS typeAnime, 
            GROUP_CONCAT(DISTINCT genre.genre) AS genre, 
            GROUP_CONCAT(DISTINCT related_anime.Judul) AS relatedAnime,
            GROUP_CONCAT(DISTINCT studios.nama_studio SEPARATOR ", ") AS all_studios
        '); // <--- Tambahkan all_studios di sini
    
        $builder->join('serilainnya', 'animes.id = serilainnya.anime_id', 'left');
        $builder->join('animes AS related_anime', 'serilainnya.serilainnya_id = related_anime.id', 'left');
        $builder->join('animegenre', 'animes.id = animegenre.anime_id', 'left');
        $builder->join('animetipe', 'animes.typeId = animetipe.id', 'left');
        $builder->join('genre', 'animegenre.genre_id = genre.id', 'left');
        
        // --- TAMBAHKAN JOIN STUDIO DI BAWAH INI ---
        $builder->join('anime_studios', 'animes.id = anime_studios.anime_id', 'left');
        $builder->join('studios', 'anime_studios.studio_id = studios.id', 'left');
        // ------------------------------------------
    
        $builder->where('animes.slug', $slug); 
        $builder->groupBy('animes.id');
    
        $query = $builder->get();
    
        if ($query->getNumRows() === 0) {
            return null; 
        }
    
        return $query->getRowArray();
    }
    

    public function getAnimeWithGenres($id)
    {
        $builder = $this->db->table('animes');
        $builder->select('*')->select('GROUP_CONCAT(genre.id, ":", genre.genre) AS genre'); 
        $builder->join('animegenre', 'animes.id = animegenre.anime_id');
        $builder->join('genre', 'animegenre.genre_id = genre.id');
        $builder->where('animes.id', $id); 
        $builder->groupBy('animes.id');

        $query = $builder->get();
    
        if ($query->getNumRows() === 0) {
            return null; 
        }
    
        return $query->getRowArray();
    }



    public function getEpisode($id)
    {
        return $this->db->table('animes')
                        ->join('episodeanime', 'episodeanime.anime_id = animes.id')
                        ->select('*')
                        ->where('animes.id', $id)
                        ->orderBy('episode_number', 'ASC')
                        ->get()
                        ->getResultArray();
    }


    public function selectedGenre($id)
    {
        return $this->db->table('animegenre')
        ->select('genre_id')
        ->where('anime_id', $id)
        ->get()
        ->getResultArray();
    }

    public function getAnimesByGenre($genreId, $perPage, $offset)
    {
        return $this->db->table('animes')
            ->select('animes.*')
            ->join('animegenre', 'animegenre.anime_id = animes.id')
            ->where('statusTayang', 'published')
            ->where('animegenre.genre_id', $genreId)
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();
    }

    public function countAnimesByGenre($genreId)
    {
        return $this->db->table('animes')
            ->join('animegenre', 'animegenre.anime_id = animes.id')
            ->where('animegenre.genre_id', $genreId)
            ->countAllResults();
    }


    public function getRelatedAnime($animeId)
    {
    return $this->db->table('serilainnya')
                    ->select('animes.*')
                    ->join('animes', 'animes.id = serilainnya.serilainnya_id')
                    ->where('serilainnya.anime_id', $animeId)
                    ->get()
                    ->getResultArray();
    }

    public function getAnimeBySlug($slug)
    {
        return $this->db->table('animes')
            ->select("*")
            ->where('slug', $slug)
            ->get()
            ->getRowArray();
    }

    public function getEpisodeBySlug($animeSlug, $episodeSlug)
    {
        return $this->db->table('episodeanime')
            ->select('episodeanime.*, animes.id, animes.slug')
            ->join('animes', 'episodeanime.anime_id = animes.id')
            ->where('animes.slug', $animeSlug)
            ->where('episodeanime.slug-episode', $episodeSlug)
            ->get()
            ->getRowArray();
    }

    public function createSlug($title)
    {
        $slug = url_title($title, '-', true);
        $anime = $this->where('slug', $slug)->findAll();

        return $slug;
    }

    public function getRandomAnime($currentAnimeSlug, $limit = 15) {
        $builder = $this->builder();
        $builder->where('statusTayang', 'published'); 
        $builder->where('slug !=', $currentAnimeSlug);
        $builder->orderBy('RAND()');
        $builder->limit($limit);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTodayEpisodeCount($userId)
    {
        return $this->db->table('user_anime_views')
                        ->where('user_id', $userId)
                        ->where('DATE(created_at)', date('Y-m-d'))
                        ->countAllResults();
    }

    public function getOnGoingAnimeNotInSchedule()
    {
        return $this->where('status', 'On-Going')
                    ->whereNotIn('id', function($builder) {
                    $builder->select('anime_id')->from('anime_jadwal_rilis');
                    })
                    ->findAll();
    }

    public function getAnimesByStatus($status, $limit = 12)
    {
        return $this->select('animes.*, animetipe.tipeAnime')
                    ->join('animetipe', 'animetipe.id = animes.typeId')
                    ->where('animes.status', $status)
                    ->orderBy('animes.created_at', 'DESC') 
                    ->limit($limit)
                    ->findAll();
    }

    public function getPopularAnimes($limit = 10)
    {
        // 1. Buat subquery untuk menghitung total views per anime secara akurat
        $viewSubquery = $this->db->table('episode_views')
            ->select('episodeanime.anime_id, SUM(episode_views.view_count) as total_sum')
            ->join('episodeanime', 'episodeanime.id = episode_views.episode_id')
            ->groupBy('episodeanime.anime_id')
            ->getCompiledSelect();
            
        // 2. Gabungkan data anime dengan hasil perhitungan views tadi
        return $this->select('animes.*, animetipe.tipeAnime, IFNULL(view_data.total_sum, 0) as total_views')
                    ->join('animetipe', 'animetipe.id = animes.typeId', 'left')
                    ->join("($viewSubquery) as view_data", 'view_data.anime_id = animes.id', 'left')
                    ->orderBy('total_views', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    
}