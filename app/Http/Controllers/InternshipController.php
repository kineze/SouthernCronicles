<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

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

    public function internshipApplications(){

        return view('dashboards.admin.internshipApplications');
    }


    public function index(Request $request)
    {
        $perPage = (int)($request->integer('per_page') ?: 20);
        $status  = $request->query('status');
        $search  = trim((string)$request->query('search'));

        $q = Internship::query()
            ->when(in_array($status, ['pending','approved','rejected']), function ($qq) use ($status) {
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

        // Laravel paginator returns the exact shape you're consuming in Vue
        return response()->json($q->paginate($perPage));
    }


    public function updateStatus($id, Request $request)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending','approved','rejected'])],
        ]);

        $rec = Internship::findOrFail($id);
        $rec->status = $data['status'];
        $rec->save();

        return response()->json(['message' => 'Status updated', 'data' => $rec]);
    }

    public function downloadCv($id)
    {
        $rec = Internship::findOrFail($id);
        if (!$rec->cv_path || !Storage::disk('public')->exists($rec->cv_path)) {
            abort(404, 'CV not found.');
        }

        // Nice filename: CV_First_Last.ext
        $ext  = pathinfo($rec->cv_path, PATHINFO_EXTENSION);
        $name = 'CV_' . preg_replace('/\s+/', '_', trim($rec->first_name . '_' . $rec->last_name));
        $file = "{$name}." . ($ext ?: 'pdf');

        $fullPath = Storage::disk('public')->path($rec->cv_path);
        return response()->download($fullPath, $file);
    }

    public function destroy($id)
    {
        $rec = Internship::findOrFail($id);

        if ($rec->cv_path && Storage::disk('public')->exists($rec->cv_path)) {
            Storage::disk('public')->delete($rec->cv_path);
        }

        $rec->delete();

        return response()->json(['message' => 'Internship application deleted.']);
    }
}
