<?php

namespace App\Models;

use CodeIgniter\Model;

class EpisodeModel extends Model
{
    protected $table            = 'episodeanime';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['anime_id', 'judul','slug-episode', 'episode_number','deskripsi','GambarPreview','video_path', 'created_at'];

    public function getEpisode($id = false)
    {
        if($id == false){
            return $this->findAll();
        }

        return $this->where(['anime_id' =>  $id])->first();
    }

    public function getEpisodeBySlug($animeSlug, $episodeSlug)
    {
        return $this->db->table('episodeanime')
                    ->select('episodeanime.*, animes.slug as anime_slug, episodeanime.slug-episode as episode_slug')
                    ->join('animes', 'episodeanime.anime_id = animes.id')
                    ->where('animes.slug', $animeSlug)
                    ->where('episodeanime.slug-episode', $episodeSlug)
                    ->get()
                    ->getRowArray();
    }

    public function getNewEpisodesWithAnimeTitle($limit = 8)
    {
        return $this->select('episodeanime.*, animes.Judul as Judul, animes.slug as slug')
                    ->join('animes', 'animes.id = episodeanime.anime_id', 'left')
                    ->orderBy('episodeanime.created_at', 'DESC')
                    ->findAll($limit);
    }
    
    public function getPreviousEpisode($animeId, $currentEpisodeId)
    {
        return $this->where('anime_id', $animeId)
                    ->where('id <', $currentEpisodeId)
                    ->orderBy('episode_number', 'desc')
                    ->first();
    }
    
    public function getNextEpisode($animeId, $currentEpisodeId)
    {
        return $this->where('anime_id', $animeId)
                    ->where('id >', $currentEpisodeId)
                    ->orderBy('episode_number', 'asc')
                    ->first();
    }

    public function getAllEpisodesByAnimeId($animeId)
    {
        return $this->where('anime_id', $animeId)
                    ->orderBy('id', 'asc')
                    ->findAll();
    }

    public function getAllEpisodesWithViewsByAnimeId($animeId)
    {
        return $this->select('episodeanime.*, COALESCE(SUM(episode_views.view_count), 0) as view_count')
                    ->join('episode_views', 'episode_views.episode_id = episodeanime.id', 'left')
                    ->where('episodeanime.anime_id', $animeId)
                    ->groupBy('episodeanime.id')
                    ->orderBy('episode_number', 'ASC')
                    ->findAll();
    }

    public function createSlug($episodeNumber)
    {
        // Membuat slug dari judul anime dan episode number
        $slug ='episode-' . $episodeNumber;
        $uniqueSlug = $slug;
    

        // $i = 1;
        // while ($this->where('slug-episode', $uniqueSlug)->first()) {
        //     $uniqueSlug = $slug . '-' . $i;
        //     $i++;
        // }
    
        return $uniqueSlug;
    }

    // protected bool $allowEmptyInserts = false;
    // protected bool $updateOnlyChanged = true;

    // protected array $casts = [];
    // protected array $castHandlers = [];

    // // Dates
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];
}
