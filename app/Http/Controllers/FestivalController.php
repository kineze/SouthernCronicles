<?php

namespace App\Http\Controllers;

use App\Models\Festival;
use Illuminate\Http\Request;

class FestivalController extends Controller
{
    public function allFestivals () {

        return view('dashboards.admin.allFestivals');
    
    }

     public function index() {
        return Festival::latest()->get();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'location' => 'required|string',
        ]);

        return Festival::create($validated);
    }

    public function update(Request $request, Festival $festival) {
        $validated = $request->validate([
            'name' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'location' => 'required|string',
        ]);

        $festival->update($validated);
        return $festival;
    }

    public function destroy(Festival $festival) {
        $festival->delete();
        return response()->json(['success' => true]);
    }

    public function show(Festival $festival) {
        return $festival;
    }
}
