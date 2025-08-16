<?php

namespace App\Http\Controllers;

use App\Models\VolunteerApplication;
use Illuminate\Http\Request;

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
}
