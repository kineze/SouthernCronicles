<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'advisor_type_id',
        'name',
        'description',
        'image',
        'facebook',
        'instagram',
        'linkedin',
        'show_on_home',
        'position', 
    ];

    protected $casts = [
        'show_on_home' => 'boolean',
        'position'     => 'integer',
    ];

    public function type()
    {
        return $this->belongsTo(AdvisorType::class, 'advisor_type_id');
    }
}
