<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Siswa extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * The extracurriculars that the student has joined.
     */
    public function ekskuls()
    {
        return $this->belongsToMany(Ekskul::class, 'ikuts', 'siswa_id', 'ekskul_id');
    }

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class);
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }
}
