<?php

namespace App;

enum FixedPositionPeriod: string
{
    case MONTHLY = 'monthly';
    case EVERY_TWO_MONTHS = 'every two months';
    case QUARTERLY = 'quarterly';
    case EVERY_6_MONTHS = 'every 6 months';
    case ANNUALLY = 'annually';

    public static function values() {
        return array_column(self::cases(), 'value');
    }

    public function inMonths() {
        return match($this) {
            self::MONTHLY => 1,
            self::EVERY_TWO_MONTHS => 2,
            self::QUARTERLY => 3,
            self::EVERY_6_MONTHS => 6,
            self::ANNUALLY => 12
        };
    }
}
