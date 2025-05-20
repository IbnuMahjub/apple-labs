<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_absen extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'latitude',
        'longitude'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
