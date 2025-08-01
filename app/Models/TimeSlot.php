<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
   protected $fillable = ['date', 'start_time', 'end_time', 'is_active'];

    public function booking()
    {
        return $this->hasOne(LaunchpadBooking::class)->where('status', 'approved');
    }
}

