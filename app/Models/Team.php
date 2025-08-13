<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'image',
        'facebook', 'instagram', 'linkedin',
        'show_on_home',
        'team_type_id', // ← add this
    ];

    public function type()
    {
        return $this->belongsTo(TeamType::class, 'team_type_id');
    }
}
