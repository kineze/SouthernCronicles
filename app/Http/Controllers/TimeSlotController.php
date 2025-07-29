<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    public function manageTimeSlots(){

        return view('dashboards.admin.manageTimeSlots');
    }

    public function index()
    {
        return TimeSlot::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        return TimeSlot::create($validated);
    }

    public function update(Request $request, TimeSlot $timeSlot)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $timeSlot->update($validated);

        return $timeSlot;
    }

    public function destroy(TimeSlot $timeSlot)
    {
        $timeSlot->delete();
        return response()->noContent();
    }
}
