<?php

namespace App\Imports;

use App\Models\Pembina;
use App\Models\Pelatih;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['nip']) || empty($row['role'])) {
            return null;
        }

        $role = strtolower($row['role']);
        $model = ($role === 'pembina') ? Pembina::class : Pelatih::class;

        // Skip if NIP exists in either table
        if (Pembina::where('nip', $row['nip'])->exists() || Pelatih::where('nip', $row['nip'])->exists()) {
            return null;
        }

        return new $model([
            'nama'     => $row['nama'],
            'nip'      => $row['nip'],
            'password' => Hash::make($row['password'] ?? 'password'),
        ]);
    }
}
