<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class PeselHelper
{
    public static function getBirthDate(string $pesel): Carbon
    {
        return Carbon::createFromDate(
            year: self::getYear($pesel),
            month: self::getMonth($pesel),
            day: self::getDay($pesel)
        );
    }

    public static function getYear(string $pesel): int
    {
        $year = (int) substr($pesel, 0, 2);
        $month = (int) substr($pesel, 2, 2);

        return $month > 20 ? 2000 + $year : 1900 + $year;
    }

    public static function getMonth(string $pesel): int
    {
        $month = (int) substr($pesel, 2, 2);

        return $month > 20 ? $month - 20 : $month;
    }

    public static function getDay(string $pesel): int
    {
        return (int) substr($pesel, 4, 2);
    }

    public static function getAge(string $pesel): int
    {
        $birthDate = self::getBirthDate($pesel);

        return today()->diff($birthDate)->y;
    }
}
