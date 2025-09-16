<?php

namespace App\Http\Controllers;

use App\Models\KidsStory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KidsStoryController extends Controller
{
    public function kidsStories(){

        return view('dashboards.admin.kidsStories');
    }
    
    public function store(Request $request)
    {
        if (is_string($request->input('genres'))) {
            $decoded = json_decode($request->input('genres'), true);
            $request->merge(['genres' => is_array($decoded) ? $decoded : []]);
        }

        $validated = $request->validate([
            // child/guardian
            'first_name'        => ['required','string','max:120'],
            'age'               => ['required','integer','between:4,18'],
            'location'          => ['required','string','max:190'],
            'guardian_name'     => ['required','string','max:190'],
            'guardian_email'    => ['nullable','email','max:190'],

            // story meta
            'title'             => ['required','string','max:190'],
            'genres'            => ['nullable','array'],
            'genres.*'          => ['string','max:50'],
            'genre_other'       => ['nullable','string','max:120'],
            'main_characters'   => ['required','string','max:3000'],

            // story body
            'story_html'        => ['nullable','string'],
            'story'             => ['required','string','max:10000'],

            // file
            'drawing_file'      => ['nullable','file','mimes:jpeg,jpg,png','max:5120'],

            // ✅ no consent validation
            'guardian_signature'=> ['required','string','max:190'],
            'consent_date'      => ['required','date'],
        ]);

        $path = null;
        if ($request->hasFile('drawing_file')) {
            $path = $request->file('drawing_file')->store('kids-stories', 'public');
        }

        $story = KidsStory::create([
            'first_name'         => $validated['first_name'],
            'age'                => $validated['age'],
            'location'           => $validated['location'],
            'guardian_name'      => $validated['guardian_name'],
            'guardian_email'     => $validated['guardian_email'] ?? null,
            'title'              => $validated['title'],
            'genres'             => $validated['genres'] ?? [],
            'genre_other'        => $validated['genre_other'] ?? null,
            'main_characters'    => $validated['main_characters'],
            'story_html'         => $validated['story_html'] ?? null,
            'story'              => $validated['story'],
            'drawing_path'       => $path,
            // 'consent'         => ... // ❌ do not store
            'guardian_signature' => $validated['guardian_signature'],
            'consent_date'       => $validated['consent_date'],
            'status'             => 'pending',
        ]);

        return response()->json([
            'message' => 'Story submitted successfully.',
            'story'   => $story,
        ], 201);
    }

    public function index(Request $request)
    {
        // Example: restrict to Admin (adjust to your auth/roles)
        if ($request->user() && method_exists($request->user(), 'hasRole')) {
            if (!$request->user()->hasRole('Admin')) {
                abort(403, 'Forbidden');
            }
        }

        $q = KidsStory::query()->latest();

        if ($status = $request->query('status')) {
            $q->where('status', $status);
        }

        // Pagination params
        $perPage = (int) $request->query('per_page', 20);
        $perPage = max(1, min(100, $perPage)); // clamp 1..100

        return $q->paginate($perPage); // returns Laravel paginator JSON with meta
    }


    public function counts()
    {
        $base = ['pending' => 0, 'approved' => 0, 'rejected' => 0];

        $rows = KidsStory::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $res = array_merge($base, array_map('intval', $rows));
        $res['all'] = array_sum($res); // optional "all" count

        return response()->json($res);
    }



    public function updateStatus(Request $request, KidsStory $kidsStory)
    {
        if ($request->user() && method_exists($request->user(), 'hasRole')) {
            if (!$request->user()->hasRole('Admin')) {
                abort(403, 'Forbidden');
            }
        }

        $data = $request->validate([
            'status' => ['required', Rule::in(['pending','approved','rejected'])],
        ]);

        $kidsStory->update(['status' => $data['status']]);

        return response()->json([
            'message' => 'Status updated.',
            'story'   => $kidsStory->fresh(),
        ]);
    }


    public function destroy(Request $request, KidsStory $kidsStory)
    {
        if ($request->user() && method_exists($request->user(), 'hasRole')) {
            if (!$request->user()->hasRole('Admin')) {
                abort(403, 'Forbidden');
            }
        }

        if ($kidsStory->drawing_path) {
            Storage::disk('public')->delete($kidsStory->drawing_path);
        }

        $kidsStory->delete();

        return response()->json(['message' => 'Story deleted.']);
    }
}
