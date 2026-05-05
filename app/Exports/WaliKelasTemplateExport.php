<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WaliKelasTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [
                'nama' => 'Budi Santoso, S.Pd',
                'nip' => '198701012010011001',
                'kelas' => 'X MIPA 1',
                'password' => 'password123'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nama',
            'nip',
            'kelas',
            'password'
        ];
    }
}
