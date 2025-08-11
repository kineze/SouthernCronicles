<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerType extends Model
{
    protected $fillable = ['name', 'description', 'position'];

    public function partners()
    {
        return $this->hasMany(Partner::class);
    }
}
