<?php

namespace App\Models;

use CodeIgniter\Model;

class EpisodeModel extends Model
{
    protected $table            = 'episodeanime';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['anime_id', 'judul', 'episode_number','deskripsi','GambarPreview','video_path'];

    public function getEpisode($id = false)
    {
        if($id == false){
            return $this->findAll();
        }

        return $this->where(['anime_id' =>  $id])->first();
    }

    public function getPreviousEpisode($animeId, $currentEpisodeId)
    {
        return $this->where('anime_id', $animeId)
                    ->where('id <', $currentEpisodeId)
                    ->orderBy('id', 'desc')
                    ->first();
    }

    public function getNextEpisode($animeId, $currentEpisodeId)
    {
        return $this->where('anime_id', $animeId)
                    ->where('id >', $currentEpisodeId)
                    ->orderBy('id', 'asc')
                    ->first();
    }

    // protected bool $allowEmptyInserts = false;
    // protected bool $updateOnlyChanged = true;

    // protected array $casts = [];
    // protected array $castHandlers = [];

    // // Dates
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
