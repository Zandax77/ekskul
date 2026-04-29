<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembina;
use App\Models\Pelatih;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        // Pembinas
        Pembina::create([
            'nip' => 'P001',
            'nama' => 'Drs. Supardi',
            'password' => Hash::make('password'),
        ]);

        Pembina::create([
            'nip' => 'P002',
            'nama' => 'Ibu Siti Aminah',
            'password' => Hash::make('password'),
        ]);

        // Pelatihs
        Pelatih::create([
            'nip' => 'L001',
            'nama' => 'Coach Ahmad',
            'password' => Hash::make('password'),
        ]);

        Pelatih::create([
            'nip' => 'L002',
            'nama' => 'Coach Budi',
            'password' => Hash::make('password'),
        ]);
    }
}
