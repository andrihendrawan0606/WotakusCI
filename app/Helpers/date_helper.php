<?php
if (!function_exists('format_indo_date')) {
    /**
     * Format a date to Indonesian format (e.g., 19 Mei 2024)
     *
     * @param string $date Date in 'Y-m-d' format
     * @return string Formatted date
     */
    function format_indo_date($date)
    {
        // Check if the date is valid and in the correct format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $months = [
                1 =>    'Januari',
                2 =>    'Februari',
                3 =>    'Maret',
                4 =>    'April',
                5 =>    'Mei',
                6 =>    'Juni',
                7 =>    'Juli',
                8 =>    'Agustus',
                9 =>    'September',
                10 =>   'Oktober',
                11 =>   'November',
                12 =>   'Desember',
            ];

            $dateComponents = explode('-', $date);
            $year = $dateComponents[0];
            $month = (int) $dateComponents[1];
            $day = (int) $dateComponents[2];

            // Check if the month and day are valid
            if ($month >= 1 && $month <= 12 && $day >= 1 && $day <= 31) {
                return $day . ' ' . $months[$month] . ' ' . $year;
            }
        }
        // Return the original date if it is not valid
        return $date;
    }
}