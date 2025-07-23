<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Festival extends Model
{
    protected $fillable = [
        'name', 
        'start_at', 
        'end_at', 
        'location'
    ];
}
