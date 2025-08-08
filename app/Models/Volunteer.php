<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $fillable = [
        'email', 'first_name', 'last_name', 'contact_number', 'description'
    ];
}
