<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_post extends Model
{
    use Sluggable, HasFactory;

    protected $table = 'tr_posts';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'category_id'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(tm_category::class);
    }
}
