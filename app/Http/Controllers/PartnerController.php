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

    public function index()
    {
        return Partner::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'image' => 'required|image|max:2048'
        ]);

        $data['image'] = $request->file('image')->store('partners', 'public');
        return Partner::create($data);
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
        $limit = $request->get('limit', 27);
        return Partner::select('id', 'image')->take($limit)->get();
    }
}
