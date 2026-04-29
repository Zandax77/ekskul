<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StaffTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [
                'nama' => 'Budi Santoso',
                'nip' => 'P001',
                'role' => 'pembina',
                'password' => 'password123'
            ],
            [
                'nama' => 'Siti Aminah',
                'nip' => 'L001',
                'role' => 'pelatih',
                'password' => 'password123'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nama',
            'nip',
            'role',
            'password'
        ];
    }
}
