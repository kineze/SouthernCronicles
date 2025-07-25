<?php

namespace App\Services;

use Exception;
use Illuminate\Mail\Mailer;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;

class BrevoMailerService
{
    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendContactEmail($data): bool
    {
        try {
            $this->mailer->to('helliumgk@gmail.com')->send(new ContactFormMail($data));
            return true;
        } catch (Exception $e) {
            Log::error('Email send failed: ' . $e->getMessage());
            return false;
        }
    }
}
