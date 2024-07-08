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
    protected $allowedFields = ['id','Judul','slug','Poster','BackgroundCover','Desc', 'Eps', 'Durasi', 'Rilis','JudulLainnya','typeId','status','genre_id','genre','statusTayang'];

    // use Traits\RelationshipTrait;

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

    public function getAnimeWithGenresSlug($slug)
    {
        $builder = $this->db->table('animes');
        $builder->select('*')->select('GROUP_CONCAT(genre.id, ":", genre.genre, ":", genre.slug_genre) AS genre'); 
        $builder->join('AnimeGenre', 'animes.id = AnimeGenre.anime_id');
        $builder->join('genre', 'AnimeGenre.genre_id = genre.id','genre.slug-genre');
        $builder->join('animetipe', 'animes.typeId = animetipe.id');
        $builder->where('animes.slug', $slug); 
        $builder->groupBy('animes.id');

        $query = $builder->get();
    
        if ($query->getNumRows() === 0) {
            return null; // kembalikan null kalo gk ada anime
        }
    
        return $query->getRowArray();
    }

    public function getAnimeWithGenresAdmin($slug)
    {
        $builder = $this->db->table('animes');
        $builder->select('animes.*, animetipe.tipeAnime as typeAnime, GROUP_CONCAT(genre.genre) AS genre, GROUP_CONCAT(DISTINCT related_anime.Judul) AS relatedAnime'); // Use 'name' instead of 'genre' for clarity
        $builder->join('serilainnya', 'animes.id = serilainnya.anime_id','left');
        $builder->join('animes AS related_anime', 'serilainnya.seriLainnya_id = related_anime.id','left');
        $builder->join('AnimeGenre', 'animes.id = AnimeGenre.anime_id','left');
        $builder->join('animetipe', 'animes.typeId = animetipe.id', 'left');
        // $builder->join('genre', 'AnimeGenre.genre_id = genre.id','left');
        $builder->join('genre', 'AnimeGenre.genre_id = genre.id','genre.slug-genre', 'left');
        $builder->where('animes.slug', $slug); 
        $builder->groupBy('animes.id');

        $query = $builder->get();
    
        if ($query->getNumRows() === 0) {
            return null; // kembalikan null kalo gk ada anime
        }
    
        return $query->getRowArray();
    }

    public function getAnimeWithGenres($id)
    {
        $builder = $this->db->table('animes');
        $builder->select('*')->select('GROUP_CONCAT(genre.id, ":", genre.genre) AS genre'); 
        $builder->join('AnimeGenre', 'animes.id = AnimeGenre.anime_id');
        $builder->join('genre', 'AnimeGenre.genre_id = genre.id');
        $builder->where('animes.id', $id); 
        $builder->groupBy('animes.id');

        $query = $builder->get();
    
        if ($query->getNumRows() === 0) {
            return null; // kembalikan null kalo gk ada anime
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
        return $this->db->table('AnimeGenre')
        ->select('genre_id')
        ->where('anime_id', $id)
        ->get()
        ->getResultArray();
    }

    public function getAnimesByGenre($genreId, $perPage, $offset)
    {
        return $this->db->table('animes')
            ->select('animes.*')
            ->join('AnimeGenre', 'AnimeGenre.anime_id = animes.id')
            ->where('statusTayang', 'published')
            ->where('AnimeGenre.genre_id', $genreId)
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();
    }

    public function countAnimesByGenre($genreId)
    {
        return $this->db->table('animes')
            ->join('AnimeGenre', 'AnimeGenre.anime_id = animes.id')
            ->where('AnimeGenre.genre_id', $genreId)
            ->countAllResults();
    }


    public function getRelatedAnime($animeId)
    {
    return $this->db->table('serilainnya')
                    ->select('animes.*')
                    ->join('animes', 'animes.id = serilainnya.seriLainnya_id')
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

    public function getRandomAnime($currentAnimeSlug, $limit = 10) {
        $builder = $this->builder();
        $builder->where('statusTayang', 'published'); 
        $builder->where('slug !=', $currentAnimeSlug);
        $builder->orderBy('RAND()');
        $builder->limit($limit);
        $query = $builder->get();
        return $query->getResultArray();
    }
    
}