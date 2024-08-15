<?php
if (!function_exists('numberToWords')) {
    function numberToWords($number) {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety',
            100 => 'Hundred',
            1000 => 'Thousand',
            1000000 => 'Million',
            1000000000 => 'Billion',
        );

        if (!is_numeric($number)) {
            return false;
        }

        if ($number < 0) {
            return $negative . numberToWords(abs($number));
        }

        $string = $fraction = null;
        $number = (int) $number;

        if ($number >= 1000000000) {
            $string .= numberToWords($number / 1000000000) . ' ' . $dictionary[1000000000];
            $number %= 1000000000;
        }

        if ($number >= 1000000) {
            $string .= (empty($string) ? '' : $separator) . numberToWords($number / 1000000) . ' ' . $dictionary[1000000];
            $number %= 1000000;
        }

        if ($number >= 1000) {
            $string .= (empty($string) ? '' : $separator) . numberToWords($number / 1000) . ' ' . $dictionary[1000];
            $number %= 1000;
        }

        if ($number >= 100) {
            $string .= (empty($string) ? '' : $separator) . numberToWords($number / 100) . ' ' . $dictionary[100];
            $number %= 100;
        }

        if ($number >= 20) {
            $string .= (empty($string) ? '' : $separator) . $dictionary[($number - $number % 10)];
            $number %= 10;
        }

        if ($number > 0) {
            $string .= (empty($string) ? '' : $separator) . $dictionary[$number];
        }

        return $string;
    }
}
