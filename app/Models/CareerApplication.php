<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CareerApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_id',
        'first_name',
        'last_name',
        'email',
        'country_iso2',
        'dial_code',
        'phone',
        'cv_path',
        'status',
    ];

    public function career() {
        return $this->belongsTo(Career::class);
    }
}

