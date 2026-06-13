<?php

if (!function_exists('mapAnimeStatus')) {
    function mapAnimeStatus($apiStatus)
    {
        // Mapping status dari API Jikan ke enum database
        switch (strtolower($apiStatus)) {
            case 'finished airing':
            case 'completed':
                return 'Completed';
            case 'currently airing':
            case 'on-going':
                return 'On-Going';
            default:
                return 'On-Going'; // Status default
        }
    }
}