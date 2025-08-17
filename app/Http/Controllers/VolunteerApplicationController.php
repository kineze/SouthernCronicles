<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\VolunteerApplication;

class VolunteerApplicationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'email'      => ['required','email','max:150'],
            'phone'      => ['nullable','string','max:50'],
            'phone_country_iso2' => ['nullable','string','max:4'],
            'dial_code'  => ['nullable','string','max:10'],
            'why'        => ['nullable','string','max:5000'],
        ]);

        $rec = VolunteerApplication::create($data);

        return response()->json([
            'message' => 'Volunteer application submitted',
            'data' => $rec,
        ], 201);
    }

    public function volunteerApplications(){

        return view('dashboards.admin.volunteerApplications');
    }

    public function index(Request $request)
    {
        $perPage = (int) ($request->integer('per_page') ?: 20);
        $status  = $request->query('status');
        $search  = trim((string)$request->query('search'));

        $q = VolunteerApplication::query()
            ->when(in_array($status, ['pending','approved','rejected'], true), function ($qq) use ($status) {
                $qq->where('status', $status);
            })
            ->when($search !== '', function ($qq) use ($search) {
                $qq->where(function ($sub) use ($search) {
                    $sub->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name',  'like', "%{$search}%")
                        ->orWhere('email',      'like', "%{$search}%")
                        ->orWhere('phone',      'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at');

        return response()->json($q->paginate($perPage));
    }

    public function show($id)
    {
        $rec = VolunteerApplication::findOrFail($id);
        return response()->json(['data' => $rec]);
    }

        public function updateStatus($id, Request $request)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending','approved','rejected'])],
        ]);

        $rec = VolunteerApplication::findOrFail($id);
        $rec->status = $data['status'];
        $rec->save();

        return response()->json(['message' => 'Status updated', 'data' => $rec]);
    }

    public function destroy($id)
    {
        $rec = VolunteerApplication::findOrFail($id);
        $rec->delete();

        return response()->json(['message' => 'Volunteer application deleted.']);
    }
}
