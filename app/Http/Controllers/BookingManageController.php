<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaunchpadBooking;

class BookingManageController extends Controller
{
    public function manageBookings(){

        return view('dashboards.admin.manageBookings');

    }

    public function allBookings(Request $request)
    {
        $query = LaunchpadBooking::with('timeSlot');

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'canceled'])) {
            $query->where('status', $request->status);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%');
            });
        }

        return $query->orderByDesc('created_at')->paginate(10);
    }


    public function updateStatus(Request $request, LaunchpadBooking $booking)
    {
        $request->validate([
            'status' => 'required|in:approved,canceled',
        ]);

        $booking->status = $request->status;
        $booking->save();

        return response()->json(['message' => 'Status updated.']);
    }
}
