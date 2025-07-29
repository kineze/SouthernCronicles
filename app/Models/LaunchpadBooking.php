<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaunchpadBooking extends Model
{
    protected $fillable = [
        'given_name', 'family_name', 'email', 'contact_number', 'country',
        'submission_text',
        'is_copyright', 'copyright_holder', 'copyright_contact',
        'status', 'booking_date', 'time_slot_id'
    ];

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
}
