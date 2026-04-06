<?php

namespace App\Helpers;

use Carbon\Carbon;

class GlobalHelper
{
    public static function getZodiacFromDate($tanggal_lahir)
    {
        if (!$tanggal_lahir) {
            return null;
        }

        $date = Carbon::parse($tanggal_lahir);

        $day = $date->day;
        $month = $date->month;

        return match (true) {
            ($month == 3 && $day >= 21) || ($month == 4 && $day <= 19) => 'Aries',
            ($month == 4 && $day >= 20) || ($month == 5 && $day <= 20) => 'Taurus',
            ($month == 5 && $day >= 21) || ($month == 6 && $day <= 20) => 'Gemini',
            ($month == 6 && $day >= 21) || ($month == 7 && $day <= 22) => 'Cancer',
            ($month == 7 && $day >= 23) || ($month == 8 && $day <= 22) => 'Leo',
            ($month == 8 && $day >= 23) || ($month == 9 && $day <= 22) => 'Virgo',
            ($month == 9 && $day >= 23) || ($month == 10 && $day <= 22) => 'Libra',
            ($month == 10 && $day >= 23) || ($month == 11 && $day <= 21) => 'Scorpio',
            ($month == 11 && $day >= 22) || ($month == 12 && $day <= 21) => 'Sagittarius',
            ($month == 12 && $day >= 22) || ($month == 1 && $day <= 19) => 'Capricorn',
            ($month == 1 && $day >= 20) || ($month == 2 && $day <= 18) => 'Aquarius',
            ($month == 2 && $day >= 19) || ($month == 3 && $day <= 20) => 'Pisces',
            default => null,
        };
    }
}
