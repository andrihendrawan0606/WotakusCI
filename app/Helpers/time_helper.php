<?php

function timeAgo($timestamp)
{
    $time = time() - strtotime($timestamp);

    if ($time < 60) {
        return 'baru saja';
    } elseif ($time < 3600) {
        $minutes = floor($time / 60);
        return $minutes . ' menit yang lalu';
    } elseif ($time < 86400) {
        $hours = floor($time / 3600);
        return $hours . ' jam yang lalu';
    } elseif ($time < 604800) {
        $days = floor($time / 86400);
        return $days . ' hari yang lalu';
    } elseif ($time < 2419200) {
        $weeks = floor($time / 604800);
        return $weeks . ' minggu yang lalu';
    } elseif ($time < 29030400) {
        $months = floor($time / 2419200);
        return $months . ' bulan yang lalu';
    } else {
        $years = floor($time / 29030400);
        return $years . ' tahun yang lalu';
    }
}