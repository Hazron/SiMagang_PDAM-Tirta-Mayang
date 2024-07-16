<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    protected $fillable = [
        'user_id', 'tanggal', 'jam_masuk', 'jam_keluar', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
