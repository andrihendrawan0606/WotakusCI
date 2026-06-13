<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'ProfileImg', 'email', 'password', 'role', 'Status','last_login', 'last_activity'];
    protected $useTimestamps = true;

   // Fungsi untuk mengambil pengguna berdasarkan email
   public function getUserByEmail($email)
   {
       return $this->db->table($this->table)
           ->select('users.*, user_level.level')
           ->join('user_level', 'user_level.user_id = users.id', 'left')
           ->where('users.email', $email)
           ->get()
           ->getRowArray();
   }

   // Fungsi untuk mengambil detail pengguna berdasarkan nama dan gambar profil
   public function getUserDetail($id)
   {
       return $this->select('nama, ProfileImg')->where('id', $id)->first();
   }
   public function getAllUsersWithLevel()
   {
       return $this->select('users.*, user_level.level')
                   ->join('user_level', 'user_level.user_id = users.id', 'left')
                   ->orderBy('users.id', 'DESC')
                   ->findAll();
   }

//    public function saveRecentAnime($userId, $animeId)
//     {
//         $this->db->table('user_recent_anime')->where(['user_id' => $userId, 'anime_id' => $animeId])->delete();
//         $this->db->table('user_recent_anime')->insert(['user_id' => $userId, 'anime_id' => $animeId]);
//     }

//     public function getRecentAnimeByUser($userId)
//     {
//         return $this->db->table('user_recent_anime')
//             ->select('anime.*')
//             ->join('anime', 'anime.anime_id = user_recent_anime.anime_id')
//             ->where('user_recent_anime.user_id', $userId)
//             ->orderBy('user_recent_anime.viewed_at', 'DESC')
//             ->get()
//             ->getResultArray();
//     }
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
