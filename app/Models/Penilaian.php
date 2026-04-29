<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'ekskul_id',
        'siswa_id',
        'pelatih_id',
        'nilai',
        'keterangan',
    ];

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function pelatih()
    {
        return $this->belongsTo(Pelatih::class);
    }
}
