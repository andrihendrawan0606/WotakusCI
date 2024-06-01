<?php
namespace App\Models;

use CodeIgniter\Model;

class JjkModel extends Model
{
    protected $table      = 'jujutsukaisen';
    protected $primaryKey = 'id';
    protected $userTimestamps = true;
    protected $useAutoIncrement = true;
    // protected $returnType = 'object';
    protected $allowedFields = ['id','Judul','Poster','BackgroundCover','Desc', 'Eps', 'Durasi', 'Rilis','JudulLainnya','status','genre_id','genre'];

    // use Traits\RelationshipTrait;

    public function getAnimes($Judul = false)
    {
        if($Judul == false){
            return $this->findAll();
        }

         $this->where(['Judul' =>  $Judul])->first();
    
        }

    public function getAnimesid($id = falase)
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
        // $this->db->select('jujutsukaisen.*, genre.genre_id');
        // $this->db->from('jujutsukaisen');
        // $this->db->join('genre', 'jujutsukaisen.id_genre = genre.id');
        // $query = $this->db->get();
        // $builder = $this->db->table('jujutsukaisen');
        // $builder->select('*');
        // $builder->join('genre', 'genre.id = jujutsukaisen.genre_id');
        // $builder->where('jujutsukaisen.Judul', $Judul);
        // $query = $builder->get();
        // return $query->getResultArray();
       


        // return $this->db->table('jujutsukaisen')
        // ->join('genre','genre.id = jujutsukaisen.genre_id','left')
        // ->Get()->getResultArray();
  

    public function getStatus()
    {
        return $this->findAll();
    }

    public function getGenre($id)
    {
        $builder = $this->db->table('jujutsukaisen');
        $builder->select('*');
        $builder->join('genre', 'genre.id = jujutsukaisen.genre_id');
        $builder->where('jujutsukaisen.id', $id);
        $query = $builder->get();
        return $query->getRowArray();


        // return $this->select('*')
        // ->join('genre', 'genre.id = jujutsukaisen.genre_id')
        // ->where('jujutsukaisen.Judul', $Judul)
        // ->get()
        // ->getRowArray(); // Mengambil satu baris data
    }

    public function getAnimeWithGenres($id)
    {
        $builder = $this->db->table('jujutsukaisen');
        $builder->select('*')->select('GROUP_CONCAT(genre.id, ":", genre.genre) AS genre'); // Use 'name' instead of 'genre' for clarity
        $builder->join('animegenreepisode', 'jujutsukaisen.id = animegenreepisode.anime_id');
        $builder->join('genre', 'animegenreepisode.genre_id = genre.id');
        $builder->where('jujutsukaisen.id', $id); // Use where clause with actual title
        $builder->groupBy('jujutsukaisen.id');

        $query = $builder->get();
    
        if ($query->getNumRows() === 0) {
            return null; // Return null if no anime found
        }
    
        return $query->getRowArray();
    }

    public function getAnimeWithGenresAdmin($id)
    {
        $builder = $this->db->table('jujutsukaisen');
        $builder->select('*')->select('GROUP_CONCAT(genre.genre) AS genre'); // Use 'name' instead of 'genre' for clarity
        $builder->join('animegenreepisode', 'jujutsukaisen.id = animegenreepisode.anime_id');
        $builder->join('genre', 'animegenreepisode.genre_id = genre.id');
        $builder->where('jujutsukaisen.id', $id); // Use where clause with actual title
        $builder->groupBy('jujutsukaisen.id');

        $query = $builder->get();
    
        if ($query->getNumRows() === 0) {
            return null; // Return null if no anime found
        }
    
        return $query->getRowArray();
    }

    public function getEpisode($id)
    {
        return $this->db->table('jujutsukaisen')
                        ->join('episodeanime', 'episodeanime.anime_id = jujutsukaisen.id')
                        ->select('*')
                        ->where('jujutsukaisen.id', $id)
                        ->orderBy('episode_number', 'ASC')
                        ->get()
                        ->getResultArray();
    }


    public function selectedGenre($id)
    {
        return $this->db->table('animegenreepisode')
        ->select('genre_id')
        ->where('anime_id', $id)
        ->get()
        ->getResultArray();
    }

    public function getAnimesByGenre($genreId)
    {
        return $this->db->table('jujutsukaisen')
            ->select('jujutsukaisen.*')
            ->join('animegenreepisode', 'animegenreepisode.anime_id = jujutsukaisen.id')
            ->where('animegenreepisode.genre_id', $genreId)
            ->get()
            ->getResultArray();
    }
}