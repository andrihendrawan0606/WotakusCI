<?php
if (!function_exists('format_indo_date')) {
    /**
     * Format a date to Indonesian format (e.g., 29 September 2023)
     *
     * @param string $date Date in any valid format, including timestamps
     * @return string Formatted date in Indonesian format
     */
    function format_indo_date($date)
    {
        try {
            $dateTime = new DateTime($date);
        } catch (Exception $e) {
            return $date;
        }

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $day = $dateTime->format('d');
        $month = (int) $dateTime->format('m');
        $year = $dateTime->format('Y');

        return $day . ' ' . $months[$month] . ' ' . $year;
    }
}


function formatTanggalDalamDeskripsi($deskripsi)
{
    // Define month
    $bulanIndo = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    // Cari pola tanggal dalam format YYYY-MM-DD
    if (preg_match_all('/\d{4}-\d{2}-\d{2}/', $deskripsi, $matches)) {
        // Loop untuk memformat semua tanggal yang ditemukan
        foreach ($matches[0] as $tanggal) {
            try {
                $tanggalObj = new DateTime($tanggal);
                $bulan = (int)$tanggalObj->format('m');
                $formatted = $tanggalObj->format('d') . ' ' . $bulanIndo[$bulan] . ' ' . $tanggalObj->format('Y');

                // Ganti tanggal lama dengan format baru di deskripsi
                $deskripsi = str_replace($tanggal, $formatted, $deskripsi);
            } catch (Exception $e) {
                // Handle jika format tanggal tidak valid
                continue;
            }
        }
    }

    return $deskripsi;
}
