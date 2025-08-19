<?php

namespace App\Http\Controllers;

use App\Models\Advisor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdvisorsController extends Controller
{
    public function manageAdvisors(){

        return view('dashboards.admin.manageAdvisors');
    }

    public function index(Request $request)
    {
        $ordered = $request->boolean('ordered');

        $q = Advisor::with('type');

        if ($ordered) {

            return $q->orderBy('position')->orderBy('id')->get();
        }

        return $q->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'advisor_type_id' => ['required','exists:advisor_types,id'],
            'name'            => ['required','string','max:255'],
            'description'     => ['nullable','string'],
            'image'           => ['nullable','image','max:2048'],
            'facebook'        => ['nullable','url'],
            'instagram'       => ['nullable','url'],
            'linkedin'        => ['nullable','url'],
            'show_on_home'    => ['nullable','boolean'],
        ]);

        $validated['show_on_home'] = $request->boolean('show_on_home');

        // NEW: append to end
        $max = Advisor::max('position') ?? 0;
        $validated['position'] = $max + 1;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('advisors', 'public');
        }

        $advisor = Advisor::create($validated);

        return $advisor->load('type');
    }

    public function update(Request $request, Advisor $advisor)
    {
        $validated = $request->validate([
            'advisor_type_id' => ['required','exists:advisor_types,id'],
            'name'            => ['required','string','max:255'],
            'description'     => ['nullable','string'],
            'image'           => ['nullable','image','max:2048'],
            'facebook'        => ['nullable','url'],
            'instagram'       => ['nullable','url'],
            'linkedin'        => ['nullable','url'],
            'show_on_home'    => ['nullable','boolean'],
        ]);

        if ($request->has('show_on_home')) {
            $validated['show_on_home'] = $request->boolean('show_on_home');
        }

        if ($request->hasFile('image')) {
            if ($advisor->image) {
                Storage::disk('public')->delete($advisor->image);
            }
            $validated['image'] = $request->file('image')->store('advisors', 'public');
        }

        $advisor->update($validated);

        return $advisor->load('type');
    }

    public function reorder(Request $request)
    {
        $payload = $request->validate([
            'order'              => ['required','array','min:1'],
            'order.*.id'         => ['required','integer','exists:advisors,id'],
            'order.*.position'   => ['required','integer','min:0'],
        ]);

        DB::transaction(function () use ($payload) {
            // normalize to 0..N-1 in the given order
            $sorted = collect($payload['order'])
                ->sortBy('position')
                ->values()
                ->map(fn($row, $i) => ['id' => $row['id'], 'position' => $i]);

            foreach ($sorted as $row) {
                Advisor::where('id', $row['id'])->update(['position' => $row['position']]);
            }
        });

        return response()->json(['message' => 'Reordered']);
    }

    public function destroy(Advisor $advisor)
    {
        if ($advisor->image) {
            Storage::disk('public')->delete($advisor->image);
        }
        $advisor->delete();

        return response()->json(['success' => true]);
    }

    public function toggleStatus(Advisor $advisor)
    {
        $advisor->update(['show_on_home' => !$advisor->show_on_home]);

        return response()->json([
            'status'        => 'success',
            'show_on_home'  => $advisor->show_on_home,
        ]);
    }

    public function getAdvisors()
    {
        return Advisor::with('type')->where('show_on_home', 1)->get();
    }

}
