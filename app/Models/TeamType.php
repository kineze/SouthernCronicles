<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'position'];

        public function teams()
    {
        return $this->hasMany(Team::class, 'team_type_id');
    }
}
