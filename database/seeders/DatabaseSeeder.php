<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@ekskul.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $this->call([
            SiswaSeeder::class,
            StaffSeeder::class,
            EkskulSeeder::class,
        ]);
    }
}
