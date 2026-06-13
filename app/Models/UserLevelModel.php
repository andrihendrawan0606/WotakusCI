<?php

namespace App\Models;

use CodeIgniter\Model;

class UserLevelModel extends Model
{
    protected $table = 'user_level';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'level', 'coins', 'subscription_expiry', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    // Method untuk mendapatkan level pengguna berdasarkan user_id
    public function getUserLevel($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    // Method untuk mengecek apakah subscription Pro masih aktif
    public function isProActive($userId)
    {
        $userLevel = $this->getUserLevel($userId);

        if ($userLevel && $userLevel['level'] === 'Pro' && $userLevel['subscription_expiry'] > date('Y-m-d H:i:s')) {
            return true;
        }

        return false;
    }

    // Method untuk mengupdate level pengguna
    public function updateUserLevel($userId, $data)
    {
        return $this->where('user_id', $userId)->set($data)->update();
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
