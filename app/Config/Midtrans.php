<?php

namespace App\Config;

class Midtrans
{
    public $serverKey = 'SB-Mid-server-NkMrvYLxclNm6o_b4c723QfL';
    public $isProduction = false; // Ubah menjadi true jika ingin pindah ke production
    public $clientKey = 'SB-Mid-client-v-Sj-hsuxrC8zk1O';

    public function __construct()
    {
        \Midtrans\Config::$serverKey = $this->serverKey;
        \Midtrans\Config::$isProduction = $this->isProduction;
    }
}