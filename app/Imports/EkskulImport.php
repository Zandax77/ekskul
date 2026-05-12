<?php

namespace App\Imports;

use App\Models\Ekskul;
use App\Models\Pembina;
use App\Models\Pelatih;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EkskulImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip if name is empty or ekskul already exists
        if (empty($row['nama']) || Ekskul::where('nama', $row['nama'])->exists()) {
            return null;
        }

        $pembina = Pembina::where('nip', $row['pembina_nip'])->first();
        $pelatih = Pelatih::where('nip', $row['pelatih_nip'])->first();

        return new Ekskul([
            'nama'         => $row['nama'],
            'pembina_id'   => $pembina ? $pembina->id : null,
            'pelatih_id'   => $pelatih ? $pelatih->id : null,
            'deskripsi'    => $row['deskripsi'] ?? null,
            'is_wajib'     => $row['is_wajib'] ?? 0,
            'wajib_kelas'  => $row['wajib_kelas'] ?? null,
        ]);
    }
}
