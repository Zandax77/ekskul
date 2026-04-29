<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelatih extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nip',
        'nama',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function ekskuls()
    {
        return $this->hasMany(Ekskul::class, 'pelatih_id');
    }
}
