<?php

if (!function_exists('generateSlug')) {
    function generateSlug($string)
    {
        // Ubah string menjadi lowercase
        $string = strtolower($string);
        
        // Hapus karakter yang tidak diinginkan seperti ':', ';', dan '/'
        $string = str_replace([':', ';', '/', '?'], '', $string);
        
        // Ganti semua karakter non-alphabetic dengan tanda minus
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $string);
        
        // Hilangkan tanda minus berlebih di awal dan akhir
        $slug = trim($slug, '-');
        
        return $slug;
    }
}