<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    public function manageTimeSlots(){

        return view('dashboards.admin.manageTimeSlots');
    }

public function index(Request $request)
{
    if ($request->has('date')) {
        return TimeSlot::whereDate('date', $request->date)->get();
    }

    return TimeSlot::orderBy('date')->get(); // <-- return all when no date filter
}


public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'interval' => 'required|integer|min:1'
    ]);

    $slots = [];
    $start = \Carbon\Carbon::parse($request->date . ' ' . $request->start_time);
    $end = \Carbon\Carbon::parse($request->date . ' ' . $request->end_time);

    while ($start->lt($end)) {
        $next = $start->copy()->addMinutes($request->interval);
        if ($next->gt($end)) break;

        $slots[] = TimeSlot::create([
            'date' => $request->date,
            'start_time' => $start->format('H:i'),
            'end_time' => $next->format('H:i'),
            'is_active' => true,
        ]);

        $start = $next;
    }

    return response()->json($slots);
}

public function toggleStatus(TimeSlot $timeSlot)
{
    $timeSlot->is_active = !$timeSlot->is_active;
    $timeSlot->save();

    return response()->json(['status' => $timeSlot->is_active]);
}


    public function destroy(TimeSlot $timeSlot)
    {
        $timeSlot->delete();
        return response()->noContent();
    }

    public function destroyByDate(Request $request)
{
    $request->validate([
        'date' => 'required|date',
    ]);

    TimeSlot::whereDate('date', $request->date)->delete();

    return response()->json(['message' => 'All time slots for the date deleted.']);
}
}
