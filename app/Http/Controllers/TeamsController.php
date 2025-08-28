<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeamsController extends Controller
{
    public function manageTeams()
    {
        return view('dashboards.admin.manageTeams');
    }

    public function index(Request $request)
    {
        // Always include relation for grouping on frontend
        $query = Team::with('type');

        if ($request->boolean('ordered')) {
            // Order by TeamType (if you have team_types.position), then team.position (ASC), then name
            $query->leftJoin('team_types', 'team_types.id', '=', 'teams.team_type_id')
                ->select('teams.*')
                ->orderByRaw('team_types.position IS NULL, team_types.position ASC')
                ->orderBy('teams.team_type_id')
                ->orderBy('teams.position')
                ->orderBy('teams.name');

            return $query->get();
        }

        return $query
            ->orderBy('team_type_id')
            ->orderBy('position')
            ->orderBy('name')
            ->get();
    }

    public function getTeams()
    {
        return Team::with('type')
            ->where('show_on_home', true)
            ->leftJoin('team_types', 'team_types.id', '=', 'teams.team_type_id')
            ->select('teams.*')
            ->orderByRaw('team_types.position IS NULL, team_types.position ASC')
            ->orderBy('teams.team_type_id')
            ->orderBy('teams.position')
            ->orderBy('teams.name')
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => ['required','string','max:255'],
            'description'  => ['nullable','string'],
            'image'        => ['nullable','image','max:2048'],
            'facebook'     => ['nullable','url'],
            'instagram'    => ['nullable','url'],
            'linkedin'     => ['nullable','url'],
            'show_on_home' => ['nullable','boolean'],
            'team_type_id' => ['required','exists:team_types,id'],
        ]);

        $validated['show_on_home'] = $request->boolean('show_on_home');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('teams', 'public');
        }

        // Put new item at the end of its group
        $max = (int) Team::where('team_type_id', $validated['team_type_id'])->max('position');
        $validated['position'] = $max + 1;   // ✅ requires fillable

        $team = Team::create($validated);
        return $team->load('type');
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name'         => ['required','string','max:255'],
            'description'  => ['nullable','string'],
            'image'        => ['nullable','image','max:2048'],
            'facebook'     => ['nullable','url'],
            'instagram'    => ['nullable','url'],
            'linkedin'     => ['nullable','url'],
            'show_on_home' => ['nullable','boolean'],
            'team_type_id' => ['required','exists:team_types,id'],
        ]);

        if ($request->has('show_on_home')) {
            $validated['show_on_home'] = $request->boolean('show_on_home');
        }

        if ($request->hasFile('image')) {
            if ($team->image) Storage::disk('public')->delete($team->image);
            $validated['image'] = $request->file('image')->store('teams', 'public');
        }

        DB::transaction(function () use (&$team, $validated) {
            $oldType = $team->team_type_id;
            $newType = $validated['team_type_id'];

            $team->update($validated);

            // If moved to another group, place at end of the new group
            if ($oldType !== $newType) {
                $max = (int) Team::where('team_type_id', $newType)->max('position');
                $team->update(['position' => $max + 1]);

                $this->resequenceGroup($oldType);
            }
        });

        return $team->load('type');
    }

    public function destroy(Team $team)
    {
        DB::transaction(function () use ($team) {
            if ($team->image) Storage::disk('public')->delete($team->image);
            $type = $team->team_type_id;
            $team->delete();
            $this->resequenceGroup($type);
        });

        return response()->json(['success' => true]);
    }

    public function toggleStatus(Team $team)
    {
        $team->update(['show_on_home' => !$team->show_on_home]);
        return response()->json(['status' => 'success', 'show_on_home' => $team->show_on_home]);
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            'team_type_id'  => ['required','integer','exists:team_types,id'],
            'ordered_ids'   => ['required','array','min:1'],
            'ordered_ids.*' => ['integer','exists:teams,id'],
        ]);

        $typeId = (int) $data['team_type_id'];
        $ids    = $data['ordered_ids'];

        // Ensure all provided IDs belong to this team_type_id
        $count = Team::whereIn('id', $ids)->where('team_type_id', $typeId)->count();
        if ($count !== count($ids)) {
            return response()->json(['message' => 'Some teams do not belong to the provided team type.'], 422);
        }

        DB::transaction(function () use ($ids) {
            foreach ($ids as $i => $id) {
                Team::whereKey($id)->update(['position' => $i + 1]);
            }
        });

        return response()->json(['message' => 'Positions updated.']);
    }

    /** Compact group positions to 1..N (keeps order by current position, then name, id). */
    protected function resequenceGroup($teamTypeId): void
    {
        if (is_null($teamTypeId)) return;

        $rows = Team::where('team_type_id', $teamTypeId)
            ->orderBy('position')
            ->orderBy('name')
            ->orderBy('id')
            ->get(['id']);

        $pos = 1;
        foreach ($rows as $row) {
            Team::whereKey($row->id)->update(['position' => $pos++]);
        }
    }
}
