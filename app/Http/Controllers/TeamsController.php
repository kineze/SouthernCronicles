<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamsController extends Controller
{
    public function manageTeams()
    {
        return view('dashboards.admin.manageTeams');
    }

    public function index()
    {
        return Team::latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'show_on_home' => 'nullable|boolean', // ✅ Accept checkbox
        ]);

        $validated['show_on_home'] = $request->boolean('show_on_home'); // ✅ Always set to true/false
        $validated['image'] = $request->file('image')->store('teams', 'public');

        return Team::create($validated);
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        if ($request->has('show_on_home')) {
            $validated['show_on_home'] = $request->boolean('show_on_home');
        }

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($team->image);
            $validated['image'] = $request->file('image')->store('teams', 'public');
        }

        $team->update($validated);
        return $team;
    }


    public function destroy(Team $team)
    {
        Storage::disk('public')->delete($team->image);
        return $team->delete();
    }

    public function toggleStatus(Request $request, Team $team)
    {
        $team->update([
            'show_on_home' => !$team->show_on_home,
        ]);

        return response()->json(['status' => 'success', 'show_on_home' => $team->show_on_home]);
    }


    public function getTeams(){

        return Team::where('show_on_home', 1)->get();

    }
}
