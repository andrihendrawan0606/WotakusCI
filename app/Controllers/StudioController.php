<?php

namespace App\Controllers;

class StudioController extends BaseController
{
    public function index()
    {
        $studioModel = new \App\Models\StudioModel();
        $data = [
            'title' => 'Manajemen Studio',
            'studios' => $studioModel->findAll()
        ];
        return view('admin/admin-partials/studios', $data);
    }

    // Fungsi Tambah Manual
    public function store()
    {
        helper(['url']); // Tambahkan ini
        $nama = $this->request->getPost('nama_studio');
        $model = new \App\Models\StudioModel();
        
        $model->insert([
            'nama_studio' => $nama,
            'slug_studio' => url_title($nama, '-', true)
        ]);
        return $this->response->setJSON(['status' => 'success']);
    }
    
    public function update($id)
    {
        helper(['url']);
        $nama = $this->request->getPost('nama_studio');
        $model = new \App\Models\StudioModel();
        
        // 1. Ambil data lama dari database
        $oldData = $model->find($id);
        if (!$oldData) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Studio tidak ditemukan'], 404);
        }
    
        // 2. Generate slug baru
        $newSlug = url_title($nama, '-', true);
    
        // 3. CEK PERUBAHAN: Jika nama dan slug sama, jangan panggil update()
        if ($oldData['nama_studio'] === $nama && $oldData['slug_studio'] === $newSlug) {
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Tidak ada perubahan data.'
            ]);
        }
    
        try {
            $model->update($id, [
                'nama_studio' => $nama,
                'slug_studio' => $newSlug
            ]);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            // Log error ke folder writable/logs/ agar Anda bisa cek detailnya nanti
            log_message('error', '[Update Studio Error] ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Gagal menyimpan ke database.'
            ], 500);
        }
    }
    
    // Fungsi Hapus
    public function delete($id)
    {
        $model = new \App\Models\StudioModel();
        $model->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function fetchGlobalStudios($page = 1)
    {
        // WAJIB: Load helper url agar url_title tidak error
        helper(['url']); 
        
        $client = \Config\Services::curlrequest();
        $db = \Config\Database::connect();
        $fetched = 0;
    
        $apiUrl = "https://api.jikan.moe/v4/producers?page={$page}";
    
        try {
            // Tambahkan timeout agar tidak menggantung jika API Jikan lambat
            $response = $client->request('GET', $apiUrl, [
                'http_errors' => false,
                'timeout'     => 10 
            ]);
            
            $statusCode = $response->getStatusCode();
            $data = json_decode($response->getBody(), true);
    
            if ($statusCode !== 200) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'API Jikan sedang sibuk (Error '.$statusCode.'). Coba lagi nanti.']);
            }
    
            $hasNextPage = $data['pagination']['has_next_page'] ?? false;
    
            if (empty($data['data'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
            }
    
            foreach ($data['data'] as $studio) {
                $studioName = $studio['titles'][0]['title'] ?? $studio['name'];
                
                $existing = $db->table('studios')->where('nama_studio', $studioName)->get()->getRowArray();
    
                if (!$existing) {
                    $db->table('studios')->insert([
                        'nama_studio' => $studioName,
                        'slug_studio' => url_title($studioName, '-', true),
                        'created_at'  => date('Y-m-d H:i:s')
                    ]);
                    $fetched++;
                }
            }
    
            return $this->response->setJSON([
                'status' => 'success',
                'fetched' => $fetched,
                'has_next' => $hasNextPage,
                'message' => "Halaman $page diproses. $fetched studio baru ditambahkan."
            ]);
    
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}