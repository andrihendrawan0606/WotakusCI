<?php

use Stichoza\GoogleTranslate\GoogleTranslate;

if (!function_exists('translateTextGoogle')) {
    function translateTextGoogle($text, $targetLanguage = 'id', $sourceLanguage = 'en')
    {
        try {
            $tr = new GoogleTranslate();
            $tr->setSource($sourceLanguage); // Bahasa sumber, 'en' Inggris
            $tr->setTarget($targetLanguage); // Bahasa target, 'id' Indonesia
            return $tr->translate($text);
        } catch (Exception $e) {
            // Jika terjadi error, kembalikan teks asli
            return $text;
        }
    }
}
