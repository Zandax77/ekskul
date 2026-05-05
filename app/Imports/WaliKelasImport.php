<?php

namespace App\Imports;

use App\Models\WaliKelas;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WaliKelasImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip if NIP is already taken or empty
        if (empty($row['nip']) || WaliKelas::where('nip', $row['nip'])->exists()) {
            return null;
        }

        return new WaliKelas([
            'nama'     => $row['nama'],
            'nip'      => $row['nip'],
            'kelas'    => $row['kelas'],
            'password' => Hash::make($row['password'] ?? '12345678'),
        ]);
    }
}
