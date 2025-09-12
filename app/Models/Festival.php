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
        'image',
        'site_url',
        'position',
        'is_default'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'is_default' => 'boolean',
    ];

    public function scopeOrdered($q)
    {
        return $q->orderBy('position')->orderBy('id');
    }
}
