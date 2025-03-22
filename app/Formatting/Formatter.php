<?php

namespace App\Formatting;

use DateTimeInterface;
use App\Models\User;
use App\Models\Account;

/**
 * Formats varius data types according to user and account settings.
 */

final class Formatter {

    private $user = null;
    private $account = null;

    public function __construct(User $user, Account $account) {
        $this
        ->setUser($user)
        ->setAccount($account);
    }

    private function getUser(): User {
        return $this->user;
    }

    private function getAccount(): Account {
        return $this->account;
    }

    private function setAccount(Account $account): Formatter {
        if($account === null) {
            return $this;
        }
        $this->account = $account;
        return $this;
    }

    private function setUser(User $user): Formatter {
        if($user === null) {
            return $this;
        }
        $this->user = $user;
        return $this;
    }

    public function date(DateTimeInterface $date): string {
        $user = $this->getUser();
        if($user === null) {
            return $date;
        }
        $dateFormat = $user->date_format;
        if(!$dateFormat) {
            return $date;
        }
        return date_format($date, $dateFormat);
    }

    public function currency(float $number): string {
        $account = $this->getAccount();
        if($account === null) {
            return $number;
        }
        $currency = $account->currency;
        $decimalSeparator = $account->decimal_separator;
        $thousandsSeparator = $account->thousands_separator;
        $currencyPosition = $account->currency_position;
        return 
            ($currencyPosition === 'left' ? "$currency " : '') 
            . number_format($number, 2, $decimalSeparator, $thousandsSeparator) .
            ($currencyPosition === 'right' ? " $currency" : '');
    }
}
