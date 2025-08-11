<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'position'];
}
