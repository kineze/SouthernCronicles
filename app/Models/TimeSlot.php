<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillable = ['title', 'start_time', 'end_time'];

    public function booking()
{
    return $this->hasOne(LaunchpadBooking::class)->where('status', 'approved');
}
}

