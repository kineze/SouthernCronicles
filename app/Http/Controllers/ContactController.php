<?php

namespace App\Http\Controllers;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\BrevoMailerService;

class ContactController extends Controller
{


public function sendContactEmail(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'mobile' => 'required|string|max:20',
        'subject' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    try {
        $fullName = $validated['first_name'] . ' ' . $validated['last_name'];

        $mailer = new BrevoMailerService(); 
        $mailer->sendContactEmail([
            'full_name' => $fullName,
            'email'     => $validated['email'],
            'mobile'    => $validated['mobile'],
            'subject'   => $validated['subject'],
            'message'   => $validated['description'],
        ]);
    } catch (Exception $e) {
        Log::error('Brevo contact email failed: ' . $e->getMessage());
        return response()->json(['message' => 'Failed to send your message. Please try again later.'], 500);
    }

    return response()->json(['message' => 'Message sent successfully!'], 201);
}

}
