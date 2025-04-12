<?php

namespace App;

enum FixedPositionPeriod: string
{
    case MONTHLY = 'monthly';
    case EVERY_TWO_MONTHS = 'every two months';
    case QUARTERLY = 'quarterly';
    case EVERY_6_MONTHS = 'every 6 months';
    case ANUALLY = 'annually';

    public static function values() {
        return array_column(self::cases(), 'value');
    }
}
