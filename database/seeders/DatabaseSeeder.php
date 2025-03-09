<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Account;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'user',
            'email' => 'user@email.com',
            'password' => Hash::make('reallysecurepassword')
        ]);

        $categories = [
            '🔁' => 'Waging', 
            '🐖' => 'Saving', 
            '🛒' => 'Groceries', 
            '🏠' => 'Housing', 
            '🚗' => 'Transportation', 
            '❤️‍🩹' => 'Health', 
            '🛡️' => 'Insurance', 
            '😂' => 'Recreation', 
            '🤷' => 'Other'
        ];
        foreach($categories as $icon => $category) {
           Category::firstOrCreate([
                'icon' => $icon,
                'name' => $category
            ]);
        }

        Account::firstOrCreate([
            'name' => 'Account',
            'balance' => 0,
            'user_id' => 1,
            'currency' => '€'
        ]);
    }
}
