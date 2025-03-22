<?php

namespace App\Formatters;

use DateTimeInterface;
use App\Models\Account;

final class DateFormatter {

    public static function format(DateTimeInterface $date, Account $account): string {
        if ($account === null) {
            return $date;
        }
        $dateFormat = $account->date_format;
        if(!$dateFormat) {
            return $date;
        }
        return date($dateFormat, strtotime($date));
    }
}
