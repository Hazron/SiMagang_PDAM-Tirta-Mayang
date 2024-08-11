<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $table = 'logbooks';
    protected $primaryKey = 'id_logbook';

    protected $fillable = [
        'tanggal',
        'deskripsi_kegiatan',
        'dokumentasi',
        'status',
        'user_id',
    ];
}
