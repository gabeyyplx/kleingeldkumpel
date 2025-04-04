<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {

        $user = User::firstOrCreate([
            'name' => 'user',
            'email' => 'user@email.com',
            'password' => Hash::make('password'),
            'date_format' => 'd.m.Y'
        ]);

        $account = Account::firstOrCreate([
            'name' => 'Account',
            'balance' => 0,
            'user_id' => $user->id,
            'decimal_separator' => ',',
            'thousands_separator' => '.',
            'currency_position' => 'right',
            'currency' => '€'
        ]);

        $categories = [
            '🔁' => 'Waging',
            '🐖' => 'Saving',
            '💸' => 'Cash',
            '🛒' => 'Groceries',
            '🏠' => 'Housing',
            '🚗' => 'Transportation',
            '❤️‍🩹' => 'Health',
            '🛡️' => 'Insurance',
            '😂' => 'Recreation',
            '🤷' => 'Other'
        ];

        foreach ($categories as $icon => $category) {
            Category::firstOrCreate([
                'icon' => $icon,
                'name' => $category
            ]);
        }
    }
}
