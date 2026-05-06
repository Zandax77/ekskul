<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Authenticatable
{
    use Notifiable, HasFactory;
    
    protected static function booted()
    {
        static::created(function ($siswa) {
            if ($siswa->kelas) {
                // Get all mandatory ekskuls
                $mandatoryEkskuls = Ekskul::where('is_wajib', true)->get();
                
                foreach ($mandatoryEkskuls as $ekskul) {
                    if ($ekskul->wajib_kelas) {
                        $classes = explode(',', $ekskul->wajib_kelas);
                        $isMatch = false;
                        foreach ($classes as $kelas) {
                            if (str_starts_with($siswa->kelas, $kelas)) {
                                $isMatch = true;
                                break;
                            }
                        }
                        if ($isMatch) {
                            $siswa->ekskuls()->attach($ekskul->id);
                        }
                    }
                }
            }
        });
    }

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
