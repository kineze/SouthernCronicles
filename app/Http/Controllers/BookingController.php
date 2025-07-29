<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\Request;
use App\Models\LaunchpadBooking;

class BookingController extends Controller
{
    public function getTimeSlots(Request $request)
    {
        $selectedDate = $request->query('booking_date');

        // Fetch all slots
        $slots = TimeSlot::all();

        // Fetch all approved bookings for that date
        $bookedSlots = LaunchpadBooking::where('booking_date', $selectedDate)
            ->where('status', 'approved')
            ->pluck('time_slot_id')
            ->toArray();

        // Append `status` to each slot
        $slots->each(function ($slot) use ($bookedSlots) {
            $slot->status = in_array($slot->id, $bookedSlots) ? 'approved' : 'available';
        });

        return $slots;
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'booking_date' => 'required|date',
            'time_slot_id' => 'required|exists:time_slots,id'
        ]);

        $validated['status'] = 'pending';
        LaunchpadBooking::create($validated);

        return response()->json(['message' => 'Booking submitted successfully.']);
    }
}
