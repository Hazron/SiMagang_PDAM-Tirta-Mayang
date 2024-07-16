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
        'role', 'name', 'nomor_induk', 'asal_kampus', 'jurusan', 'alamat',
        'email', 'no_telpon', 'password', 'status', 'departemen', 'logbook_id',
        'presensi_id', 'dosen_id', 'pembimbing', 'fotoprofile', 'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $hidden = [
        'password', 'remember_token',
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
}
