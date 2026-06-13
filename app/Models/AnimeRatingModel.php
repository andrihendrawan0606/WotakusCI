<?php

namespace App\Models;

use CodeIgniter\Model;

class AnimeRatingModel extends Model
{
    protected $table            = 'anime_ratings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'anime_id', 'rating', 'review'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Fungsi untuk menghitung rata-rata rating sebuah anime
     * Sangat berguna untuk fitur "SISTEM CERDAS"
     */
    public function getAverageRating($animeId)
    {
        $result = $this->where('anime_id', $animeId)->selectAvg('rating')->first();
        return $result ? round($result['rating'], 1) : 0;
    }

    /**
     * Fungsi untuk mengambil rating yang diberikan user tertentu pada anime tertentu
     */
    public function getUserRating($animeId, $userId)
    {
        return $this->where(['anime_id' => $animeId, 'user_id' => $userId])->first();
    }
}