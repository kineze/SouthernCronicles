<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerApplication extends Model
{
    protected $fillable = [
        'first_name','last_name','email',
        'phone','phone_country_iso2','dial_code','why','status'
    ];
}
