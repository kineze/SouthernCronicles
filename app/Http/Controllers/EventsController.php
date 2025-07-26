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
        'event_date' => 'required|date',
        'time_in' => 'required',
        'time_out' => 'required',
        'venue' => 'required|string',
        'name' => 'required|string',
        'event_type' => 'required|string',
        'speaker_ids' => 'required|array',
        'moderator_id' => 'nullable|exists:speakers,id',
        'book_signing' => 'required|boolean',
    ]);

    $event = Event::create($validated);
    $event->speakers()->sync($validated['speaker_ids']);

    return Event::with(['speakers', 'moderator'])->find($event->id);
}


public function update(Request $request, Event $event)
{
    $validated = $request->validate([
        'event_date' => 'required|date',
        'time_in' => 'required',
        'time_out' => 'required',
        'venue' => 'required|string',
        'name' => 'required|string',
        'event_type' => 'required|string',
        'speaker_ids' => 'required|array',
        'moderator_id' => 'nullable|exists:speakers,id',
        'book_signing' => 'required|boolean',
    ]);

    $event->update($validated);
    $event->speakers()->sync($validated['speaker_ids']);

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
}
