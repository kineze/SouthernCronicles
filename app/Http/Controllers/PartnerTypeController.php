<?php

namespace App\Http\Controllers;

use App\Models\PartnerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerTypeController extends Controller
{
    public function partnerTypes(){


        return view('dashboards.admin.partnerTypes');
    }

    public function index(Request $request)
    {
        $ordered = $request->boolean('ordered');
        $query = PartnerType::query();

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

        $max = PartnerType::max('position') ?? 0;
        $data['position'] = $max + 1;

        $pt = PartnerType::create($data);

        return response()->json($pt, 201);
    }


    public function update(Request $request, PartnerType $partnerType)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $partnerType->update($data);

        return response()->json(['message' => 'Partner type updated']);
    }


    public function destroy(PartnerType $partnerType)
    {
        $partnerType->delete();

        return response()->json(['message' => 'Partner type deleted']);
    }


    public function reorder(Request $request)
    {
        $payload = $request->validate([
            'order'                 => ['required','array'],
            'order.*.id'            => ['required','integer','exists:partner_types,id'],
            'order.*.position'      => ['required','integer','min:0'],
        ]);

        DB::transaction(function () use ($payload) {
            foreach ($payload['order'] as $row) {
                PartnerType::where('id', $row['id'])->update(['position' => $row['position']]);
            }
        });

        return response()->json(['message' => 'Reordered']);
    }
}
