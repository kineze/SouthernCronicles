<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;
use App\Models\CareerApplication;

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
}
