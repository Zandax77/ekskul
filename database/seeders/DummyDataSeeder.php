<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Pembina;
use App\Models\Pelatih;
use App\Models\Ekskul;
use App\Models\WaliKelas;
use App\Models\Kegiatan;
use App\Models\Presensi;
use App\Models\Prestasi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Wali Kelas
        $classes = ['X MIPA 1', 'X MIPA 2', 'XI IPS 1', 'XI IPS 2', 'XII BB 1'];
        foreach ($classes as $index => $class) {
            WaliKelas::firstOrCreate(
                ['kelas' => $class],
                [
                    'nama' => 'Wali Kelas ' . $class,
                    'nip' => 'WK' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'password' => Hash::make('password'),
                ]
            );
        }

        // 2. Pembina & Pelatih (if not enough)
        $pembinaNames = ['Drs. Ahmad', 'Siti Aminah, M.Pd', 'Bambang S.T'];
        foreach ($pembinaNames as $index => $name) {
            Pembina::firstOrCreate(
                ['nip' => 'P10' . $index],
                ['nama' => $name, 'password' => Hash::make('password')]
            );
        }

        $pelatihNames = ['Coach Jaka', 'Rina Sporty', 'Dian Tech'];
        foreach ($pelatihNames as $index => $name) {
            Pelatih::firstOrCreate(
                ['nip' => 'L10' . $index],
                ['nama' => $name, 'password' => Hash::make('password')]
            );
        }

        // 3. Ekskuls
        $ekskuls = [
            ['nama' => 'Futsal', 'desc' => 'Olahraga bola besar paling populer.'],
            ['nama' => 'Voli', 'desc' => 'Mengasah teknik smash dan kerja tim.'],
            ['nama' => 'Sains Club', 'desc' => 'Eksperimen dan olimpiade sains.'],
            ['nama' => 'Seni Tari', 'desc' => 'Melestarikan tarian tradisional dan modern.'],
            ['nama' => 'Paduan Suara', 'desc' => 'Mengolah vokal dan harmonisasi nada.'],
        ];

        foreach ($ekskuls as $index => $e) {
            $ekskul = Ekskul::firstOrCreate(
                ['nama' => $e['nama']],
                [
                    'deskripsi' => $e['desc'],
                    'pembina_id' => Pembina::inRandomOrder()->first()->id,
                    'pelatih_id' => Pelatih::inRandomOrder()->first()->id,
                    'is_wajib' => $index === 0 ? true : false, // Futsal is wajib
                    'wajib_kelas' => $index === 0 ? 'X,XI' : null
                ]
            );

            // 4. Siswas & Enrollment
            // Create 10 students per ekskul if not enough
            $siswas = Siswa::factory()->count(10)->create([
                'kelas' => $classes[array_rand($classes)]
            ]);

            foreach ($siswas as $siswa) {
                if (!$siswa->ekskuls()->where('ekskul_id', $ekskul->id)->exists()) {
                    $ekskul->siswas()->attach($siswa->id);
                }
            }

            // 5. Kegiatans (3 sessions per ekskul)
            for ($i = 1; $i <= 3; $i++) {
                $kegiatan = Kegiatan::create([
                    'ekskul_id' => $ekskul->id,
                    'tanggal' => Carbon::now()->subDays($i * 7)->format('Y-m-d'),
                    'keterangan' => 'Pertemuan rutin ke-' . $i,
                ]);

                // 6. Presensi (Varying attendance rates)
                $studentIds = $ekskul->siswas()->pluck('siswas.id');
                foreach ($studentIds as $sId) {
                    $rate = ($index % 3 == 0) ? 90 : (($index % 3 == 1) ? 60 : 30); // 90%, 60%, 30%
                    Presensi::firstOrCreate(
                        ['kegiatan_id' => $kegiatan->id, 'siswa_id' => $sId],
                        [
                            'status' => (rand(1, 100) <= $rate) ? 'hadir' : 'alfa',
                        ]
                    );
                }
            }

            // 7. Prestasis
            if (rand(0, 1)) {
                Prestasi::create([
                    'ekskul_id' => $ekskul->id,
                    'siswa_id' => $ekskul->siswas()->inRandomOrder()->first()->id,
                    'judul' => 'Juara ' . rand(1, 3) . ' Lomba ' . $e['nama'] . ' Tingkat Provinsi',
                    'deskripsi' => 'Meraih prestasi membanggakan dalam kompetisi tahunan yang diikuti oleh berbagai sekolah se-provinsi.',
                    'tanggal' => Carbon::now()->subMonths(rand(1, 6))->format('Y-m-d'),
                ]);
            }
        }
    }
}
