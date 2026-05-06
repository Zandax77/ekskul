<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nis' => $this->faker->unique()->numberBetween(100000, 999999),
            'nama' => $this->faker->name(),
            'kelas' => $this->faker->randomElement(['X MIPA 1', 'X MIPA 2', 'XI IPS 1', 'XII BB 1']),
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ];
    }
}
