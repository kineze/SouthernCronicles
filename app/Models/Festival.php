<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Festival extends Model
{
    protected $fillable = [
        'name',
        'start_at',
        'end_at',
        'location', 
        'location_place_id',
        'location_lat',
        'location_lng',
        'image',
        'site_url',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'location_lat' => 'float',
        'location_lng' => 'float',
    ];
}
