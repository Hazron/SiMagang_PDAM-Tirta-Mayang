<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dosenpembimbing extends Model
{
    use HasFactory;

    protected $table = 'pembimbingdosen';

    protected $primaryKey = 'id_pembimbing';

    protected $fillable = [
        'id_pembimbing',
        'nama',
        'asal_kampus',
        'user_id',
        'status',
    ];

    public function dosen()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bimbingan()
    {
        return $this->hasMany(User::class, 'dosen_id', 'id_pembimbing');
    }
}
