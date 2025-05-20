<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_company extends Model
{
    use HasFactory;

    protected $table = 'tr_companies';

    protected $fillable = [
        'name',
        'address',
        'description',
        'phone',
        'logoo',
        'email',
        'latitude',
        'longitude',
    ];
}
