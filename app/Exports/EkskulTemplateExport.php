<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EkskulTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [
                'nama' => 'Pramuka',
                'pembina_nip' => '197001012000031001',
                'pelatih_nip' => '198001012010011001',
                'deskripsi' => 'Ekstrakurikuler Wajib Pramuka',
                'is_wajib' => '1',
                'wajib_kelas' => 'X,XI,XII'
            ],
            [
                'nama' => 'Basket',
                'pembina_nip' => '197001012000031002',
                'pelatih_nip' => '198001012010011002',
                'deskripsi' => 'Ekstrakurikuler Basket',
                'is_wajib' => '0',
                'wajib_kelas' => ''
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nama',
            'pembina_nip',
            'pelatih_nip',
            'deskripsi',
            'is_wajib',
            'wajib_kelas'
        ];
    }
}
