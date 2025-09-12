<?php

namespace App\Http\Controllers;

use App\Models\Festival;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FestivalController extends Controller
{
    public function allFestivals()
    {
        return view('dashboards.admin.allFestivals');
    }

    public function index(Request $request)
    {
        if ($request->boolean('ordered')) {
            return Festival::ordered()->get();
        }
        return Festival::latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required','string','max:255'],
            'start_at'  => ['required','date'],
            'end_at'    => ['required','date','after_or_equal:start_at'],
            'location'  => ['required','string','max:255'],
            'site_url'  => ['nullable','url','max:255'],
            'image'     => ['nullable','image','mimes:jpg,jpeg,png,webp,avif','max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('festivals', 'public');
        }

        // Put new item at the end
        $validated['position'] = (int) (Festival::max('position') ?? 0) + 1;

        return Festival::create($validated);
    }

    public function update(Request $request, Festival $festival)
    {
        $validated = $request->validate([
            'name'      => ['required','string','max:255'],
            'start_at'  => ['required','date'],
            'end_at'    => ['required','date','after_or_equal:start_at'],
            'location'  => ['required','string','max:255'],
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

    public function destroy(Festival $festival)
    {
        if ($festival->image) {
            Storage::disk('public')->delete($festival->image);
        }
        $festival->delete();
        return response()->json(['success' => true]);
    }

    public function show(Festival $festival)
    {
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
            ->select(['id','name','start_at','end_at','location','image','site_url']);

        if ($limit > 0) $q->limit($limit);
        return $q->get();
    }

    /** Reorder by position */
    public function reorder(Request $request)
    {
        $payload = $request->validate([
            'order' => ['required','array','min:1'],
            'order.*.id' => ['required','integer','exists:festivals,id'],
            'order.*.position' => ['required','integer','min:1'],
        ]);

        DB::transaction(function () use ($payload) {
            foreach ($payload['order'] as $row) {
                Festival::where('id', $row['id'])->update(['position' => $row['position']]);
            }
        });

        return response()->json(['message' => 'Order updated']);
    }

    public function toggleDefault(Request $request, Festival $festival)
    {
        $data = $request->validate([
            'value' => ['required','boolean'],
        ]);

        DB::transaction(function () use ($festival, $data) {
            if ($data['value']) {
                // Turn off everyone else, then set this one
                Festival::where('is_default', true)
                    ->where('id', '<>', $festival->id)
                    ->update(['is_default' => false]);

                $festival->is_default = true;
                $festival->save();
            } else {
                // Allow having no default
                $festival->is_default = false;
                $festival->save();
            }
        });

        return response()->json([
            'id' => $festival->id,
            'is_default' => $festival->is_default,
            'message' => $festival->is_default
                ? 'Festival set as default.'
                : 'Festival unset as default.',
        ]);
    }
}
