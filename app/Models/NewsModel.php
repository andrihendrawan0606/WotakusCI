<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table            = 'news';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    // protected $protectFields    = true;
    protected $allowedFields    = ['Judul', 'slug' , 'subJudul' , 'user_id', 'waktu_penayangan', 'preview_gambar', 'isiKonten'];

    public function getNews($news = false)
    {
        if($news == false){
            return $this->findAll();
        }

        return $this->where(['Judul' =>  $news])->first();
    }

    public function getNewsWithAuthor()
    {
        return $this->select('news.*, users.nama as author_name')
                    ->join('users', 'users.id = news.user_id')
                    ->findAll();
    }

    public function getNewsDetailBySlug($slug)
    {
        return $this->select('news.*, users.nama as author_name, GROUP_CONCAT(tags.namaTag) as tags')
                    ->join('users', 'users.id = news.user_id')
                    ->join('news_tags', 'news_tags.news_id = news.id', 'left')
                    ->join('tags', 'tags.id = news_tags.tag_id', 'left')
                    ->where('news.slug', $slug)
                    ->groupBy('news.id')
                    ->first();
    }

    public function createSlug($title)
    {
        $slug = url_title($title, '-', true);
        $news = $this->where('slug', $slug)->findAll();

        if ($news) {
            $slug = $slug . '-' . time();
        }

        return $slug;
    }
    // protected bool $allowEmptyInserts = false;
    // protected bool $updateOnlyChanged = true;

    // protected array $casts = [];
    // protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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
