<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemorySubmission;

class MemorySubmissionController extends Controller
{
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'given_name' => 'required|string|max:255',
            'family_name' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'submission' => 'required|string',
            'is_copyright' => 'boolean',
            'copyright_holder' => 'nullable|required_if:is_copyright,true|string|max:255',
            'copyright_contact' => 'nullable|required_if:is_copyright,true|string|max:255',
            'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('memory-submissions', 'public');
        }

        $submission = MemorySubmission::create($validated);

        return response()->json([
            'message' => 'Submission saved successfully',
            'data' => $submission,
        ], 201);
    }


}
