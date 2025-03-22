<?php

namespace App\Formatters;

use DateTimeInterface;
use App\Models\User;

final class DateFormatter {

    public static function format(DateTimeInterface $date, User $user): string {
        if ($user === null) {
            return $date;
        }
        $dateFormat = $user->date_format;
        if(!$dateFormat) {
            return $date;
        }
        return date_format($date, $dateFormat);
    }
}
