<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [
                'nama' => 'Contoh Nama Siswa',
                'nis' => '12345678',
                'kelas' => 'X MIPA 1',
                'password' => 'password123'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nama',
            'nis',
            'kelas',
            'password'
        ];
    }
}
