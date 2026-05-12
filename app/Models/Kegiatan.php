<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'ekskul_id',
        'tanggal',
        'keterangan',
        'materi',
        'catatan',
        'foto_kegiatan',
    ];

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class);
    }

    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }
}
