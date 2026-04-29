<?php

namespace App\Imports;

use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip if NIS is already taken or empty
        if (empty($row['nis']) || Siswa::where('nis', $row['nis'])->exists()) {
            return null;
        }

        return new Siswa([
            'nama'     => $row['nama'],
            'nis'      => $row['nis'],
            'kelas'    => $row['kelas'] ?? null,
            'password' => Hash::make($row['password'] ?? 'password'),
        ]);
    }
}
