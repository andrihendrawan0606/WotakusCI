<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminLogsModel extends Model
{
    protected $table = 'admin_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['admin_id', 'action', 'admin_name', 'item', 'item_id', 'description', 'created_at','change_type'];
    protected $useTimestamps = true;

    public function logChange($adminId, $itemId, $changeType, $description)
    {
        $this->insert([
            'admin_id' => $adminId,
            'item_id' => $itemId,
            'change_type' => $changeType,
            'description' => $description,
            // 'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    // protected bool $allowEmptyInserts = false;
    // protected bool $updateOnlyChanged = true;

    // protected array $casts = [];
    // protected array $castHandlers = [];

    // // Dates
    // protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
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
