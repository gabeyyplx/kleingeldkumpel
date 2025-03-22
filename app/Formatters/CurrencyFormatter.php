<?php

namespace App\Formatters;
use App\Models\Account;

final class CurrencyFormatter {

    public static function format(float $number, Account $account): string {
        if($account === null) {
            return $number;
        }
        $currency = $account->currency;
        $decimalSeparator = $account->decimal_separator;
        $thousandsSeparator = $account->thousands_separator;
        $currencyPosition = $account->currency_position;
        if($currencyPosition === 'left') {
            return $currency . ' ' . number_format($number, 2, $decimalSeparator, $thousandsSeparator);
        }
        return number_format($number, 2, $decimalSeparator, $thousandsSeparator) . ' ' . $currency;
    }
}