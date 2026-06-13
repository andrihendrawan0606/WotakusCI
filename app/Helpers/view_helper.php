<?php

if (!function_exists('formatViews')) {
    function formatViews($viewCount)
    {
        // PENTING: Paksa variabel menjadi integer agar perbandingan === 0 berfungsi
        $viewCount = (int)$viewCount;

        if ($viewCount === 0) {
            return 'Belum ditonton';
        } elseif ($viewCount < 1000) {
            return $viewCount . ' x ditonton';
        } elseif ($viewCount >= 1000 && $viewCount < 1000000) {
            return round($viewCount / 1000, 1) . ' rb x ditonton';
        } elseif ($viewCount >= 1000000) {
            return round($viewCount / 1000000, 1) . ' jt x ditonton';
        }
    }
}

if (!function_exists('isNew')) {
    function isNew($createdAt)
    {
        $created = strtotime($createdAt);
        $now = time();
        $threeDays = 3 * 24 * 60 * 60; // 3 hari dalam hitungan detik

        // Jika selisih waktu kurang dari 3 hari, kembalikan true
        return ($now - $created) < $threeDays;
    }
}