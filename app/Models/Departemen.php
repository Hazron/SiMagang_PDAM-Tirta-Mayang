<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_departemen';
    protected $table = 'departemen';
    protected $fillable = [
        'nama_departemen',
        'nama_pembimbing',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'departemen_id', 'id_departemen');
    }
}
