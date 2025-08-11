<?php

namespace App\Http\Controllers;

use App\Models\TeamType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamTypeController extends Controller
{
    public function teamTypes()
    {
        return view('dashboards.admin.teamTypes');
    }

    public function index(Request $request)
    {
        $ordered = $request->boolean('ordered');
        $query = TeamType::query();

        if ($ordered) {
            $query->orderBy('position');
        } else {
            $query->orderByDesc('created_at');
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $max = TeamType::max('position') ?? 0;
        $data['position'] = $max + 1;

        $type = TeamType::create($data);

        return response()->json($type, 201);
    }

    public function update(Request $request, TeamType $teamType)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $teamType->update($data);

        return response()->json(['message' => 'Team type updated']);
    }

    public function destroy(TeamType $teamType)
    {
        $teamType->delete();

        return response()->json(['message' => 'Team type deleted']);
    }

    public function reorder(Request $request)
    {
        $payload = $request->validate([
            'order'                 => ['required','array'],
            'order.*.id'            => ['required','integer','exists:team_types,id'],
            'order.*.position'      => ['required','integer','min:0'],
        ]);

        DB::transaction(function () use ($payload) {
            foreach ($payload['order'] as $row) {
                TeamType::where('id', $row['id'])
                    ->update(['position' => $row['position']]);
            }
        });

        return response()->json(['message' => 'Reordered']);
    }
}
