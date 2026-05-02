<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_canvas extends Model
{
    use HasFactory;

    protected $table = 'tr_canvas';

    protected $fillable = [
        'title',
        'json'
    ];
}
