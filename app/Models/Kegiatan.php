<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'ekskul_id',
        'tanggal',
        'keterangan',
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
