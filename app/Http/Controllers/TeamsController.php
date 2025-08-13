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

    public function index(Request $request)
    {
        $query = Team::with('type');

        if ($request->boolean('ordered')) {
            $query->leftJoin('team_types', 'team_types.id', '=', 'teams.team_type_id')
                ->select('teams.*')
                ->orderByRaw('team_types.position IS NULL, team_types.position ASC')
                ->orderBy('teams.name');
            return $query->get();
        }

        return $query->latest()->get();
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image'       => ['nullable','image','max:2048'],
            'facebook'    => ['nullable','url'],
            'instagram'   => ['nullable','url'],
            'linkedin'    => ['nullable','url'],
            'show_on_home'=> ['nullable','boolean'],
            'team_type_id'=> ['required','exists:team_types,id'], // ← required select
        ]);

        $validated['show_on_home'] = $request->boolean('show_on_home');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('teams', 'public');
        }

        $team = Team::create($validated);
        return $team->load('type');
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image'       => ['nullable','image','max:2048'],
            'facebook'    => ['nullable','url'],
            'instagram'   => ['nullable','url'],
            'linkedin'    => ['nullable','url'],
            'show_on_home'=> ['nullable','boolean'],
            'team_type_id'=> ['required','exists:team_types,id'], // ← required select
        ]);

        if ($request->has('show_on_home')) {
            $validated['show_on_home'] = $request->boolean('show_on_home');
        }

        if ($request->hasFile('image')) {
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }
            $validated['image'] = $request->file('image')->store('teams', 'public');
        }

        $team->update($validated);
        return $team->load('type');
    }

    public function destroy(Team $team)
    {
        if ($team->image) {
            Storage::disk('public')->delete($team->image);
        }
        $team->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus(Team $team)
    {
        $team->update(['show_on_home' => !$team->show_on_home]);
        return response()->json(['status' => 'success', 'show_on_home' => $team->show_on_home]);
    }

    public function getTeams()
    {
        return Team::with('type')->where('show_on_home', 1)->get();
    }
}
