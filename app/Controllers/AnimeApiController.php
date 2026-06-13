<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\JjkModel;

class AnimeApiController extends ResourceController
{
    protected $animeModel;

    public function __construct()
    {
        $this->animeModel = new JjkModel();
    }

    public function index()
    {
        $animes = $this->animeModel->findAll();
        return $this->respond($animes); 
    }

    public function show($id = null)
    {
        if ($id === null) {
            return $this->failNotFound("ID tidak ditemukan.");
        }
    
        $anime = $this->animeModel->find($id);
        if (!$anime) {
            return $this->failNotFound("Anime tidak ditemukan.");
        }
        return $this->respond($anime);
    }

    public function create()
    {
        $data = $this->request->getPost();

        if (!$this->animeModel->insert($data)) {
            return $this->fail($this->animeModel->errors());
        }

        return $this->respondCreated(['message' => 'Anime berhasil ditambahkan', 'data' => $data]);
    }

    public function update($id = null)
    {
        if ($id === null) {
            return $this->failNotFound("ID tidak ditemukan.");
        }

        $data = $this->request->getRawInput();

        if (!$this->animeModel->update($id, $data)) {
            return $this->fail($this->animeModel->errors());
        }

        return $this->respond(['message' => 'Anime berhasil diperbarui', 'data' => $data]);
    }
    
        public function delete($id = null)
    {
        if ($id === null) {
            return $this->failNotFound("ID tidak ditemukan.");
        }

        $anime = $this->animeModel->find($id);
        if (!$anime) {
            return $this->failNotFound("Anime tidak ditemukan.");
        }

        $this->animeModel->delete($id);
        return $this->respondDeleted(['message' => 'Anime berhasil dihapus']);
    }
}
