<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tm_category extends Model
{
    use HasFactory;

    protected $table = 'tm_categories';

    protected $fillable = [
        'name',
        'description',
        'slug'
    ];

    public function posts()
    {
        return $this->hasMany(tr_post::class);
    }
}
