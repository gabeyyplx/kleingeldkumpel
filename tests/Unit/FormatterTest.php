<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Formatting\Formatter;
use App\Models\User;
use App\Models\Account;


class FormatterTest extends TestCase {
    public function test_currency() {
        $user = new User();
        $account = new Account([
            'currency' => '€',
            'decimal_separator' => ',',
            'thousands_separator' => '.',
            'currency_position' => 'right'
        ]);
        $formatter = new Formatter($user, $account);
        $this->assertEquals('1.234,56 €', $formatter->currency(1234.56));
    }

    public function test_date() {
        $user = new User([
            'date_format' => 'd.m.Y'
        ]);
        $account = new Account();
        $formatter = new Formatter($user, $account);
        $this->assertEquals('01.02.2000', $formatter->date(new \DateTime('2000-02-01')));
    }
}
