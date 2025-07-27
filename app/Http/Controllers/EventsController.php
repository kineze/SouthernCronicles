<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function manageEvents(){

        return view('dashboards.admin.manageEvents');
    }


    public function index()
    {
        return Event::with(['speakers', 'moderator'])->latest()->get();
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'event_date'    => 'required|date',
        'time_in'       => 'required',
        'time_out'      => 'required',
        'venue'         => 'required|string',
        'name'          => 'required|string',
        'event_type'    => 'nullable|string',
        'description'   => 'nullable|string',
        'speaker_ids'   => 'nullable|array',
        'moderator_id'  => 'nullable|exists:speakers,id',
        'book_signing'  => 'required|boolean',
        'has_color'     => 'nullable|boolean',
        'color'         => 'nullable|string|max:7', // hex color
    ]);

    $eventData = $validated;
    unset($eventData['speaker_ids']);

    $event = Event::create($eventData);

    if (!empty($validated['speaker_ids'])) {
        $event->speakers()->sync($validated['speaker_ids']);
    }

    return Event::with(['speakers', 'moderator'])->find($event->id);
}



public function update(Request $request, Event $event)
{
    $validated = $request->validate([
        'event_date'    => 'required|date',
        'time_in'       => 'required',
        'time_out'      => 'required',
        'venue'         => 'required|string',
        'name'          => 'required|string',
        'event_type'    => 'nullable|string',
        'description'   => 'nullable|string',
        'speaker_ids'   => 'nullable|array',
        'moderator_id'  => 'nullable|exists:speakers,id',
        'book_signing'  => 'required|boolean',
        'has_color'     => 'nullable|boolean',
        'color'         => 'nullable|string|max:7', // hex color
    ]);

    $eventData = $validated;
    unset($eventData['speaker_ids']);

    $event->update($eventData);

    if (!empty($validated['speaker_ids'])) {
        $event->speakers()->sync($validated['speaker_ids']);
    } else {
        $event->speakers()->detach();
    }

    return Event::with(['speakers', 'moderator'])->find($event->id);
}




    public function destroy(Event $event)
    {
        return $event->delete();
    }

    public function getSpeakers()
    {
        return Speaker::all();
    }


    public function getEvents(Request $request)
    {
        $query = Event::with(['moderator', 'speakers'])->orderBy('event_date');

        if ($request->has('date')) {
            $query->whereDate('event_date', $request->input('date'));
        }

        return response()->json($query->get());
    }

    public function uniqueDates()
    {
        $dates = Event::select('event_date')
            ->orderBy('event_date')
            ->get()
            ->pluck('event_date')
            ->unique()
            ->map(function ($date) {
                return [
                    'raw' => $date->format('Y-m-d'),
                    'label' => strtoupper($date->format('M j')),
                ];
            })
            ->values();

        return response()->json($dates);
    }


}
