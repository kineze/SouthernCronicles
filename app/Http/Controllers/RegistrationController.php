<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use App\Services\BrevoMailer;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{


    public function index(Request $request)
    {
        $query = Registration::query();

        if ($request->has('search') && $request->search !== '') {
            $query->where('contact_number', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->paginate(10));
    }


    public function registeredList(){

        return view('dashboards.admin.registeredList');
    }


public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:registrations,email',
        'contact_number' => 'required|string|max:20',
        'country' => 'required|string|max:100',
        'postal_code' => 'required|string|max:20',
        'address_line_1' => 'required|string|max:255',
        'address_line_2' => 'nullable|string|max:255',
    ]);

    Registration::create($validated);

    try {
        $mailer = new BrevoMailer();
        $fullName = $validated['first_name'] . ' ' . $validated['last_name'];
        $mailer->sendRegistrationEmail($validated['email'], $fullName);
    } catch (\Exception $e) {
        Log::error('Brevo email failed: ' . $e->getMessage());
    }

    return response()->json(['message' => 'Registration successful!'], 201);
}
}
