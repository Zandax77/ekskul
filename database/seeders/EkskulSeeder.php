<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ekskul;
use App\Models\Pembina;
use App\Models\Pelatih;

class EkskulSeeder extends Seeder
{
    public function run(): void
    {
        $p001 = Pembina::where('nip', 'P001')->first()->id;
        $p002 = Pembina::where('nip', 'P002')->first()->id;
        $l001 = Pelatih::where('nip', 'L001')->first()->id;
        $l002 = Pelatih::where('nip', 'L002')->first()->id;

        Ekskul::create([
            'nama' => 'Pramuka',
            'pembina_id' => $p001,
            'pelatih_id' => $l001,
            'deskripsi' => 'Ekstrakurikuler wajib untuk melatih kedisiplinan dan kepemimpinan.',
        ]);

        Ekskul::create([
            'nama' => 'PMR',
            'pembina_id' => $p002,
            'pelatih_id' => $l001,
            'deskripsi' => 'Palang Merah Remaja melatih kesigapan dalam pertolongan pertama.',
        ]);

        Ekskul::create([
            'nama' => 'Basket',
            'pembina_id' => $p001,
            'pelatih_id' => $l002,
            'deskripsi' => 'Mengembangkan bakat olahraga basket dan kerja sama tim.',
        ]);

        Ekskul::create([
            'nama' => 'IT Club',
            'pembina_id' => $p002,
            'pelatih_id' => $l002,
            'deskripsi' => 'Mempelajari pemrograman, desain grafis, dan teknologi terbaru.',
        ]);
    }
}
