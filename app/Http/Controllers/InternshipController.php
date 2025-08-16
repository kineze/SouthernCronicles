<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class InternshipController extends Controller
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
            'cv'         => ['required', File::types(['pdf','doc','docx'])->max(5 * 1024)], // 5MB
        ]);

        // store CV
        $path = $request->file('cv')->store('cv', 'public'); // storage/app/public/cv/...
        $data['cv_path'] = $path;

        $rec = Internship::create($data);

        return response()->json([
            'message' => 'Internship application submitted',
            'data' => $rec,
        ], 201);
    }
}
