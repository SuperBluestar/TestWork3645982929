<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create(
          [
            'name' => 'Naoyuki T',
            'email' => 'alexander116gm@gmail.com',
            'email_verified_at' => date("Y-m-d H:i:s"),
            'password' => Hash::make('111111'),
            'role' => 0b1111111111 // 10 of seperated roles
          ]
        );
        \App\Models\User::factory(5)->create();
    }
}
