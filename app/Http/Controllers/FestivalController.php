<?php

namespace App\Http\Controllers;

use App\Models\Festival;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FestivalController extends Controller
{
    public function allFestivals() {

        
        return view('dashboards.admin.allFestivals');
    }

    public function index() {
        return Festival::latest()->get();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name'      => ['required','string','max:255'],
            'start_at'  => ['required','date'],
            'end_at'    => ['required','date','after_or_equal:start_at'],
            'location'  => ['required','string','max:255'],   // formatted address from Places
            'location_place_id' => ['nullable','string','max:255'],
            'location_lat' => ['nullable','numeric','between:-90,90'],
            'location_lng' => ['nullable','numeric','between:-180,180'],
            'site_url'  => ['nullable','url','max:255'],
            'image'     => ['nullable','image','mimes:jpg,jpeg,png,webp,avif','max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('festivals', 'public');
        }

        return Festival::create($validated);
    }

    public function update(Request $request, Festival $festival) {
        $validated = $request->validate([
            'name'      => ['required','string','max:255'],
            'start_at'  => ['required','date'],
            'end_at'    => ['required','date','after_or_equal:start_at'],
            'location'  => ['required','string','max:255'],
            'location_place_id' => ['nullable','string','max:255'],
            'location_lat' => ['nullable','numeric','between:-90,90'],
            'location_lng' => ['nullable','numeric','between:-180,180'],
            'site_url'  => ['nullable','url','max:255'],
            'image'     => ['nullable','image','mimes:jpg,jpeg,png,webp,avif','max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($festival->image) {
                Storage::disk('public')->delete($festival->image);
            }
            $validated['image'] = $request->file('image')->store('festivals', 'public');
        }

        $festival->update($validated);
        return $festival;
    }

    public function destroy(Festival $festival) {
        if ($festival->image) {
            Storage::disk('public')->delete($festival->image);
        }
        $festival->delete();
        return response()->json(['success' => true]);
    }

    public function show(Festival $festival) {
        return $festival;
    }


    public function upcoming(Request $request)
    {
        $limit = (int) $request->get('limit', 50);

        $from = $request->get('from');
        $fromDate = $from ? date('Y-m-d H:i:s', strtotime($from)) : now()->startOfDay();

        $q = Festival::query()
            ->where(function ($q) use ($fromDate) {
                $q->where('start_at', '>=', $fromDate)
                  ->orWhere(function ($q2) use ($fromDate) {
                      $q2->whereNotNull('end_at')->where('end_at', '>=', $fromDate);
                  });
            })
            ->orderBy('start_at')
            ->select([
                'id',
                'name',
                'start_at',
                'end_at',
                'location',
                'location_place_id',
                'location_lat',
                'location_lng',
                'image',
                'site_url',
            ]);

        if ($limit > 0) {
            $q->limit($limit);
        }

        return $q->get();
    }
}
