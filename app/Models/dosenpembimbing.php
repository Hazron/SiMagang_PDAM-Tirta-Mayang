<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbing extends Model
{
    use HasFactory;

    protected $table = 'pembimbingdosen';

    protected $fillable = [
        'nama',
        'asal_kampus',
        'user_id',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
