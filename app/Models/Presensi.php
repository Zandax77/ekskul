<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $fillable = [
        'kegiatan_id',
        'siswa_id',
        'status',
        'keterangan',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
