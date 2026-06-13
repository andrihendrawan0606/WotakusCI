<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRecentAnimeModel extends Model
{
    protected $table = 'user_recent_anime';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'anime_id','episode_id'];
    protected $useTimestamps = true;


    public function getRecentAnimesByUser($userId)
    {
        return $this->db->table('user_recent_anime')
            ->select('user_recent_anime.*, animes.Judul, animes.Poster, animes.slug, episodeanime.episode_number, episodeanime.judul AS episode_title, episodeanime.slug-episode AS episode_slug')
            ->join('animes', 'animes.id = user_recent_anime.anime_id') 
            ->join('episodeanime', 'episodeanime.id = user_recent_anime.episode_id', 'left') 
            ->where('user_recent_anime.user_id', $userId)
            ->where('animes.statusTayang', 'published') 
            ->orderBy('user_recent_anime.updated_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    // Dates
    // protected $useTimestamps = false;
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
