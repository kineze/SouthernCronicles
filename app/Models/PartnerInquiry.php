<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartnerInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'brand_name',
        'email',
        'phone',          // normalized phone (E.164 preferred)
        'country_iso2',   // e.g., "LK"
        'dial_code',      // e.g., "+94"
        'description',
        'status',         // optional: 'pending' | 'contacted' | 'closed'
    ];
}
