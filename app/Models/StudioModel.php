<?php

namespace App\Models;

use CodeIgniter\Model;

class StudioModel extends Model
{
    protected $table            = 'studios';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_studio', 'slug_studio'];
    protected $useTimestamps    = true;

    // Fungsi untuk mengambil studio berdasarkan slug
    public function getStudioBySlug($slug)
    {
        return $this->where('slug_studio', $slug)->first();
    }
}