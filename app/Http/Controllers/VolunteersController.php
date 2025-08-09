<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\BrevoMailerService;

class VolunteersController extends Controller
{
    
    public function volunteers()
    {
        return view('dashboards.admin.volunteers');
    }
    

    public function index(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 15);
        $search  = (string) $request->get('search', '');

        $q = \App\Models\Volunteer::query();

        if ($search !== '') {
            $q->where(function ($qq) use ($search) {
                $qq->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        return $q->latest()->paginate($perPage);
    }


    // Public create (used by frontend form)
    public function store(Request $request)
    {
        $data = $request->validate([
            'email'          => ['required','email','max:255','unique:volunteers,email'],
            'first_name'     => ['required','string','max:120'],
            'last_name'      => ['required','string','max:120'],
            'contact_number' => ['required','string','max:40'],
            'description'    => ['nullable','string'],
        ]);

        $data['status'] = 'pending'; // default

        $vol = Volunteer::create($data);
        return response()->json($vol, 201);
    }

public function setStatus(Request $request, Volunteer $volunteer, BrevoMailerService $mailer)
{
    $validated = $request->validate([
        'status' => ['required', Rule::in(['pending','accepted','rejected'])],
    ]);

    $volunteer->update(['status' => $validated['status']]);

    // Try email, but don't fail the whole request if Brevo errors
    try {
        $mailer->sendVolunteerStatusEmail([
            'email'      => $volunteer->email,
            'first_name' => $volunteer->first_name,
            'last_name'  => $volunteer->last_name,
            'status'     => $validated['status'],
        ]);
    } catch (Throwable $e) {
        Log::warning('Volunteer status email failed', [
            'volunteer_id' => $volunteer->id,
            'status'       => $validated['status'],
            'error'        => $e->getMessage(),
        ]);
        // continue; we still return 200
    }

    return response()->json([
        'message'   => 'Status updated' . ($validated['status'] !== 'pending' ? ' and email attempted.' : '.'),
        'volunteer' => $volunteer->fresh(),
    ]);
}

    public function destroy(Volunteer $volunteer)
    {
        $volunteer->delete();
        return response()->json(['message' => 'Deleted']);
    }
}

