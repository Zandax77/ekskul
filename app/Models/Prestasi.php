<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $fillable = [
        'ekskul_id',
        'siswa_id',
        'judul',
        'deskripsi',
        'tanggal',
        'foto',
        'sertifikat',
    ];

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
