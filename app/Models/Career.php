<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'small_description',
        'closing_date',
        'content',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'closing_date' => 'date',
    ];
}
