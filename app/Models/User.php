<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role',
        'name',
        'nomor_induk',
        'asal_kampus',
        'jurusan',
        'alamat',
        'email',
        'no_telpon',
        'password',
        'status',
        'dosen_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_selesai',
        'departemen_id',
        'fotoprofile',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function pembimbingan()
    {
        return $this->hasMany(User::class, 'dosen_id');
    }

    public function dosen()
    {
        return $this->belongsTo(DosenPembimbing::class, 'dosen_id', 'id_pembimbing');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    public function logbook()
    {
        return $this->hasMany(Logbook::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id', 'id_departemen');
    }

    public function departemens()
    {
        return $this->hasOne(Departemen::class, 'user_id', 'id');
    }
}
