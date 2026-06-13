<?php

namespace App\Models;

use CodeIgniter\Model;

class UserFavoriteModel extends Model
{
    protected $table            = 'user_favorites';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'anime_id'];

    // Ambil daftar anime favorit user tertentu
    public function getFavorites($userId)
    {
        return $this->select('animes.*, animetipe.tipeAnime') // Gunakan animetipe sesuai nama tabel di join
                    ->join('animes', 'animes.id = user_favorites.anime_id')
                    ->join('animetipe', 'animetipe.id = animes.typeId', 'left') // Pastikan 'animetipe.id' bukan 'tipeAnime.id'
                    ->where('user_favorites.user_id', $userId)
                    ->orderBy('user_favorites.id', 'DESC') 
                    ->findAll();
    }
}