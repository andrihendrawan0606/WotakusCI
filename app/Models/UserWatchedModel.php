<?php

namespace App\Models;

use CodeIgniter\Model;

class UserWatchedModel extends Model
{
    protected $table      = 'user_watched_episodes';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['user_id', 'episode_id', 'watched_at'];

    protected $useTimestamps = false;

    public function getWatchedEpisodesByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->join('episodeanime', 'episodeanime.id = user_watched_episodes.episode_id')
                    ->findAll();
    }

    public function hasUserWatchedEpisode($userId, $episodeId)
    {
        return $this->where('user_id', $userId)
                    ->where('episode_id', $episodeId)
                    ->first() !== null;
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
