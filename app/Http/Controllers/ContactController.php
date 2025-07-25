<?php

namespace App\Http\Controllers;


use App\Services\BrevoMailerService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $brevoMailerService;

    public function __construct(BrevoMailerService $brevoMailerService)
    {
        $this->brevoMailerService = $brevoMailerService;
    }

    public function sendContactEmail(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Send the email using Brevo
        $success = $this->brevoMailerService->sendContactEmail($validated);

        // Return a response based on success or failure
        if ($success) {
            return response()->json(['message' => 'Message sent successfully!'], 200);
        } else {
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
    }
}
