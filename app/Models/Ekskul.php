<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    protected $fillable = [
        'nama',
        'pembina_id',
        'pelatih_id',
        'deskripsi',
        'is_wajib',
        'wajib_kelas',
    ];

    public function pembina()
    {
        return $this->belongsTo(Pembina::class, 'pembina_id');
    }

    public function pelatih()
    {
        return $this->belongsTo(Pelatih::class, 'pelatih_id');
    }

    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'ikuts', 'ekskul_id', 'siswa_id');
    }

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class);
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function presensis()
    {
        return $this->hasManyThrough(Presensi::class, Kegiatan::class);
    }
}
