<?php

namespace App\Http\Controllers;

use App\Models\GalaxyApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class GalaxyApplicationController extends Controller
{

    public function galaxyApplications(){

        return view('dashboards.admin.galaxyApplications');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'          => ['required', 'string', 'max:120'],
            'last_name'           => ['required', 'string', 'max:120'],
            'email'               => ['required', 'email:rfc,dns', 'max:190'],
            'phone'               => ['required', 'string', 'max:64'],  // your UI requires phone; DB allows null
            'phone_country_iso2'  => ['nullable', 'string', 'max:4'],
            'dial_code'           => ['nullable', 'string', 'max:10'],
            'description'         => ['nullable', 'string'],
        ]);

        // status defaults to 'pending' by migration
        $application = GalaxyApplication::create($data);

        return response()->json([
            'message' => 'Application submitted successfully.',
            'id'      => $application->id,
        ], 201);
    }

    // Optional admin listing
    public function index(Request $request)
    {
        $status = $request->query('status'); // 'pending'|'approved'|'rejected'
        $q = trim((string) $request->query('q', ''));

        $query = GalaxyApplication::query();

        if ($status) {
            $query->where('status', $status);
        }
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('first_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%");
            });
        }

        return response()->json($query->orderByDesc('id')->paginate(20));
    }

    // Optional status update
    public function updateStatus(Request $request, GalaxyApplication $galaxyApplication)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending','approved','rejected'])],
        ]);

        $galaxyApplication->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Status updated.']);
    }
}
