<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    /** Admin page */
    public function partners()
    {
        return view('dashboards.admin.partners');
    }

    /** List partners for admin/table views */
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
        'title'           => ['required', 'string', 'max:255'],
        'image'           => ['required', 'image', 'max:4096'],
        'partner_type_id' => ['nullable', 'integer', 'exists:partner_types,id'],
        'site_url'        => ['nullable', 'url', 'max:2048'], // ✅ new
    ]);

    $data['image'] = $request->file('image')->store('partners', 'public');

    $maxOrder = Partner::max('order');
    $data['order'] = is_null($maxOrder) ? 0 : ($maxOrder + 1);

    $partner = Partner::create($data)->load('partnerType:id,name');

    return response()->json($partner, 201);
}

public function update(Request $request, Partner $partner)
{
    if ($request->has('partner_type_id') && $request->input('partner_type_id') === '') {
        $request->merge(['partner_type_id' => null]);
    }

    $data = $request->validate([
        'title'           => ['required', 'string', 'max:255'],
        'partner_type_id' => ['nullable', 'integer', 'exists:partner_types,id'],
        'site_url'        => ['nullable', 'url', 'max:2048'], // ✅ new
        'image'           => ['sometimes', 'image', 'max:4096'],
    ]);

    if ($request->hasFile('image')) {
        if ($partner->image && Storage::disk('public')->exists($partner->image)) {
            Storage::disk('public')->delete($partner->image);
        }
        $data['image'] = $request->file('image')->store('partners', 'public');
    }

    $partner->fill($data)->save();

    return $partner->load('partnerType:id,name');
}


    /** Delete partner */
    public function destroy(Partner $partner)
    {
        if ($partner->image) {
            Storage::disk('public')->delete($partner->image);
        }
        $partner->delete();

        return response()->noContent();
    }


    public function partnersList(Request $request)
    {
        $limit = (int) $request->get('limit', 50);

        $q = Partner::query();

        if ($request->filled('type_id')) {
            $q->where('partner_type_id', $request->integer('type_id'));
        }

        if ($request->boolean('ordered')) {
            $q->orderBy('order')->orderByDesc('id');
        } else {
            $q->latest();
        }

        // ✅ Include site_url and title so the frontend can link & alt text
        return $q->select('id', 'title', 'image', 'partner_type_id', 'site_url')
                ->take($limit)
                ->get();
    }


    /** Drag & drop reorder */
    public function reorder(Request $request)
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*.id' => ['required', 'integer', 'exists:partners,id'],
            'order.*.order' => ['required', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($data) {
            foreach ($data['order'] as $row) {
                Partner::where('id', $row['id'])->update(['order' => $row['order']]);
            }
        });

        return response()->json(['message' => 'Order updated']);
    }
}
