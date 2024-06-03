<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default credentials
        \App\Models\User::insert([
            [ 
                'name' => 'Valentino Lie',
                'email' => 'valenlie2409@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'noWA' => '0895632272075',
                'role' => 'sdm',
                'remember_token' => Str::random(10)
            ]
        ]);

        // Fake users
        User::factory()->times(9)->create();
    }
}
