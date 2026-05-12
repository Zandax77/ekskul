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
        // Admin User (Handled by migration, but ensured here)
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@ekskul.com'],
            [
                'name' => 'Super Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            ]
        );

        $this->call([
            SiswaSeeder::class,
            StaffSeeder::class,
            EkskulSeeder::class,
        ]);
    }
}
