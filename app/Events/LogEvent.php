<?php

namespace App\Events;

use App\Models\AdminLogsModel;

class LogEvent
{
    /**
     * Log Action
     *
     * @param int $adminId ID admin yang melakukan aksi
     * @param string $action Aksi yang dilakukan
     * @param int|null $animeId ID judul anime (opsional)
     * @param int|null $episodeId ID episode (opsional)
     */
    public static function logAction($adminId, $action, $animeId = null, $episodeId = null)
    {
        $logModel = new AdminLogsModel();
        $logModel->save([
            'admin_id'  => $adminId,
            'action'    => $action,
            'anime_id'  => $animeId,
            'episode_id' => $episodeId,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}