<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title', 'small_description', 'published_at', 'content', 'published_by', 'status','image','order'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'boolean',
    ];
}
