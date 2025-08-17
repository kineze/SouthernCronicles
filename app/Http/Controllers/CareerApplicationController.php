<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;
use App\Models\CareerApplication;
use Illuminate\Support\Facades\Storage;

class CareerApplicationController extends Controller
{
    public function store(Request $request, Career $career)
    {
        $validated = $request->validate([
            'first_name'    => ['required', 'string', 'max:120'],
            'last_name'     => ['required', 'string', 'max:120'],
            'email'         => ['required', 'email:rfc,dns', 'max:190'],
            'country_iso2'  => ['nullable', 'string', 'size:2'],
            'dial_code'     => ['nullable', 'string', 'max:8'],
            'phone'         => ['nullable', 'string', 'max:32'],
            'cv'            => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('careers/cv', 'public');
        }

        $app = CareerApplication::create([
            'career_id'   => $career->id,
            'first_name'  => $validated['first_name'],
            'last_name'   => $validated['last_name'],
            'email'       => $validated['email'],
            'country_iso2'=> $validated['country_iso2'] ?? null,
            'dial_code'   => $validated['dial_code'] ?? null,
            'phone'       => $validated['phone'] ?? null,
            'cv_path'     => $cvPath,
            'status'      => 'pending',
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Application received. Thank you!',
            'id' => $app->id,
        ], 201);
    }

    public function careerApplications(){

        return view('dashboards.admin.careerApplications');
    }


    public function index(Request $request)
    {
        $perPage = max(1, min((int)$request->input('per_page', 20), 100));
        $status  = $request->input('status');
        $search  = $request->input('search');

        $q = CareerApplication::with('career:id,title')
            ->when(in_array($status, ['pending','approved','rejected'], true), fn($qq) => $qq->where('status', $status))
            ->when($search, function ($qq) use ($search) {
                $qq->where(function ($w) use ($search) {
                    $w->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at');

        return $q->paginate($perPage);
    }


    public function updateStatus(Request $request, CareerApplication $application)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $application->update(['status' => $data['status']]);

        return response()->json([
            'ok' => true,
            'message' => 'Status updated.',
            'application' => $application->fresh('career:id,title'),
        ]);
    }

    
    public function downloadCv(CareerApplication $application)
    {
        if (!$application->cv_path || !Storage::disk('public')->exists($application->cv_path)) {
            return response()->json(['message' => 'CV not found'], 404);
        }

        $filename = basename($application->cv_path) ?: 'cv.pdf';
        $filePath = Storage::disk('public')->path($application->cv_path);
        return response()->download($filePath, $filename);
    }
}
