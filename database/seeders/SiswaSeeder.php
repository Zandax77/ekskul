<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Siswa::create([
            'nis' => '12345',
            'nama' => 'Budi Santoso',
            'kelas' => 'X MIPA 1',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
    }
}
