<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaunchpadBooking extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'contact_number',
        'status',
        'booking_date',
        'time_slot_id'
    ];

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
}
