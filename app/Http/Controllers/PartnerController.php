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
        $q = Partner::query();
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
            'title' => ['required','string','max:255'],
            'image' => ['required','image','max:4096'],
        ]);

        $data['image'] = $request->file('image')->store('partners', 'public');
        $data['order'] = Partner::max('order') + 1; // append to end

        $partner = Partner::create($data);
        return response()->json($partner, 201);
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($partner->image);
            $data['image'] = $request->file('image')->store('partners', 'public');
        }

        $partner->update($data);
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
        $limit = $request->get('limit', 50);
        return Partner::select('id', 'image')->take($limit)->get();
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
