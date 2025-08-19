<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'order','partner_type_id','site_url'];

    public function partnerType()
    {
        return $this->belongsTo(PartnerType::class);
    }
}
