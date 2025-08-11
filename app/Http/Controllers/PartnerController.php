<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function partners(){

        return view('dashboards.admin.partners');
    }

    public function index(Request $request)
    {
        $q = Partner::query()->with('partnerType:id,name');

        if ($request->filled('type_id')) {
            $q->where('partner_type_id', $request->integer('type_id'));
        }

        if ($request->boolean('ordered')) {
            $q->orderBy('order')->orderByDesc('id');
        } else {
            $q->latest();
        }

        return $q->get();
    }

public function store(Request $request)
{
    $data = $request->validate([
        'title'            => ['required','string','max:255'],
        'image'            => ['required','image','max:4096'],
        'partner_type_id'  => ['nullable','exists:partner_types,id'],
    ]);

    $data['image'] = $request->file('image')->store('partners', 'public');

    // Avoid null + 1 when table empty
    $maxOrder = Partner::max('order');
    $data['order'] = is_null($maxOrder) ? 0 : $maxOrder + 1;

    $partner = Partner::create($data);

    // include type in response for UI
    $partner->load('partnerType:id,name');

    return response()->json($partner, 201);
}


public function update(Request $request, Partner $partner)
{
    $data = $request->validate([
        'title'            => ['required','string','max:255'],
        'image'            => ['nullable','image','max:4096'],
        'partner_type_id'  => ['nullable','exists:partner_types,id'],
    ]);

    if ($request->hasFile('image')) {
        if ($partner->image) {
            Storage::disk('public')->delete($partner->image);
        }
        $data['image'] = $request->file('image')->store('partners', 'public');
    }

    $partner->update($data);

    $partner->load('partnerType:id,name');

    return $partner;
}


    public function destroy(Partner $partner)
    {
        Storage::disk('public')->delete($partner->image);
        $partner->delete();
        return response()->noContent();
    }


    public function partnersList(Request $request)
    {
        $limit = (int) $request->get('limit', 50);

        $q = Partner::query();

        if ($request->boolean('ordered')) {
            // order saved by drag & drop, then tie-break by id
            $q->orderBy('order')->orderByDesc('id');
        } else {
            $q->latest();
        }

        // only expose fields needed by the public grid
        return $q->select('id', 'image')->take($limit)->get();
    }


    public function reorder(Request $request)
    {
        $data = $request->validate([
            'order' => ['required','array'],
            'order.*.id' => ['required','integer','exists:partners,id'],
            'order.*.order' => ['required','integer','min:0'],
        ]);

        foreach ($data['order'] as $row) {
            Partner::where('id', $row['id'])->update(['order' => $row['order']]);
        }

        return response()->json(['message' => 'Order updated']);
    }
}
