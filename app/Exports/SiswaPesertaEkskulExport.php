<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class SiswaPesertaEkskulExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Siswa::with('ekskuls')
            ->orderBy('kelas')
            ->orderBy('nama')
            ->get()
            ->map(function (Siswa $siswa) {
                $ekskuls = $siswa->ekskuls;

                return [
                    'nama' => $siswa->nama,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas ?? '-',
                    'ekskuls_diaikuti' => $ekskuls->pluck('nama')->filter()->implode(', '),
                    'jumlah_ekskul' => $ekskuls->count(),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIS',
            'Kelas',
            'Ekskul yang diikuti (comma-separated)',
            'Jumlah Ekskul',
        ];
    }
}

