<?php

namespace App\Models;

use CodeIgniter\Model;

class AnimeGenreEpisode extends Model
{
    protected $table            = 'animegenreepisode';
    protected $primaryKey       = 'anime_id';
    // protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    // protected $protectFields    = true;
    protected $userTimestamps = true;
    protected $allowedFields    = ['anime_id','genre_id'];

    public function getGenre($anime_id)
    {
        if($anime_id == false){
            return $this->findAll();
        }

        return $this->where(['anime_id' =>  $anime_id])->first();
    }


    public function getAnimeWithGenres($Judul)
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT jujutsukaisen.id, jujutsukaisen.Judul, GROUP_CONCAT(genre.genre) as genres
            FROM jujutsukaisen
            JOIN animegenreepisode ON jujutsukaisen.id = animegenreepisode.anime_id
            WHERE jujutsukaisen.id = ?
            GROUP BY jujutsukaisen.id, jujutsukaisen.Judul", [$Judul]);

        return $query->getRow();
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
