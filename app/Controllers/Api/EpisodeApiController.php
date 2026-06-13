<?php namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\I18n\Time;

class EpisodeApiController extends ResourceController
{
    public function watchEpisodeAndIncrementView()
    {
        $userId = session()->get('id');
        $role   = session()->get('role');
        $json   = $this->request->getJSON();
        $episodeId = $json->episodeId ?? null;

        if (!$userId || !$episodeId) {
            return $this->failUnauthorized('Sesi habis atau ID tidak valid');
        }

        $userWatchedModel = new \App\Models\UserWatchedModel();
        $userLevelModel   = new \App\Models\UserLevelModel();
        $episodeViewsModel = new \App\Models\EpisodeView();
        
        $today = Time::today()->toDateString();

        // 1. CEK APAKAH USER SUDAH NONTON EPISODE INI HARI INI
        $hasWatchedToday = $userWatchedModel->where([
            'user_id'    => $userId,
            'episode_id' => $episodeId
        ])->where('DATE(watched_at)', $today)->first();

        // Jika sudah ditonton hari ini, jangan tambah view lagi (return success tapi diam saja)
        if ($hasWatchedToday) {
            return $this->respond(['status' => 'success', 'message' => 'Already counted today'], 200);
        }

        // 2. CEK LIMIT UNTUK USER BASIC (ADMIN & PRO BEBAS)
        if ($role !== 'admin') {
            $userLevel = $userLevelModel->where('user_id', $userId)->first();
            
            if ($userLevel && $userLevel['level'] == 'Basic') {
                $watchedCount = $userWatchedModel->where('user_id', $userId)
                    ->where('DATE(watched_at)', $today)
                    ->countAllResults();

                if ($watchedCount >= 5) {
                    return $this->respond(['status' => 'limit_reached'], 200);
                }
            }
        }

        // 3. PROSES INCREMENT VIEW (DATABASE)
        try {
            // Update tabel episode_views
            $exists = $episodeViewsModel->where('episode_id', $episodeId)->first();
            if ($exists) {
                $episodeViewsModel->update($exists['id'], [
                    'view_count' => $exists['view_count'] + 1,
                    'updated_at' => Time::now()
                ]);
            } else {
                $episodeViewsModel->insert([
                    'episode_id' => $episodeId,
                    'view_count' => 1,
                    'created_at' => Time::now()
                ]);
            }

            // Catat ke history harian agar besok bisa nonton lagi & hitung limit
            $userWatchedModel->insert([
                'user_id'    => $userId,
                'episode_id' => $episodeId,
                'watched_at' => Time::now()
            ]);

            return $this->respond(['status' => 'success'], 200);

        } catch (\Exception $e) {
            log_message('error', '[IncrementView Error] ' . $e->getMessage());
            return $this->failServerError('Gagal memproses view: ' . $e->getMessage());
        }
    }
}