<?php

namespace App\Http\Controllers;

use App\Models\AdvisorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvisorTypesController extends Controller
{
    public function advisorTypes()
    {
        return view('dashboards.admin.advisorTypes');
    }

    // GET /api/advisor-types?ordered=true
    public function index(Request $request)
    {
        $ordered = $request->boolean('ordered');
        $query = AdvisorType::query();

        if ($ordered) {
            $query->orderBy('position');
        } else {
            $query->orderByDesc('created_at');
        }

        return response()->json($query->get());
    }

    // POST /api/advisor-types
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $max = AdvisorType::max('position') ?? 0;
        $data['position'] = $max + 1;

        $type = AdvisorType::create($data);

        return response()->json($type, 201);
    }

    // PUT /api/advisor-types/{advisorType}
    public function update(Request $request, AdvisorType $advisorType)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $advisorType->update($data);

        return response()->json(['message' => 'Advisor type updated']);
    }

    // DELETE /api/advisor-types/{advisorType}
    public function destroy(AdvisorType $advisorType)
    {
        $advisorType->delete();

        return response()->json(['message' => 'Advisor type deleted']);
    }

    // POST /api/advisor-types/reorder
    // body: { order: [{ id, position }, ...] }
    public function reorder(Request $request)
    {
        $payload = $request->validate([
            'order'            => ['required','array'],
            'order.*.id'       => ['required','integer','exists:advisor_types,id'],
            'order.*.position' => ['required','integer','min:0'],
        ]);

        DB::transaction(function () use ($payload) {
            foreach ($payload['order'] as $row) {
                AdvisorType::where('id', $row['id'])
                    ->update(['position' => $row['position']]);
            }
        });

        return response()->json(['message' => 'Reordered']);
    }
}
