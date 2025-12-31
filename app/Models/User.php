<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'nik', 'role', 'foto_identitas', 'foto_selfie',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function pengaduanDitangani()
    {
        return $this->hasMany(Pengaduan::class, 'petugas_id');
    }

    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    public function isMasyarakat()
    {
        return $this->role === 'masyarakat';
    }
}
