<?php

if (!function_exists('mapAnimeType')) {
    function mapAnimeType($type)
    {
        $mapping = [
            'OVA' => 1,
            'ONA' => 2,
            'TV' => 3,
            'Movie' => 4
        ];

        return $mapping[$type] ?? 0;  // Jika tidak ditemukan, kembalikan 0 atau ID default
    }
}
