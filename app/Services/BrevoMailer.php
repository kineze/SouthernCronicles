<?php

namespace App\Services;

use Brevo\Client\Configuration;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

class BrevoMailer
{
    protected $apiInstance;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', config('services.brevo.api_key'));
        $this->apiInstance = new TransactionalEmailsApi(new Client(), $config);
    }

    public function sendRegistrationEmail($toEmail, $toName)
    {
        $sendSmtpEmail = new SendSmtpEmail([
            'subject' => '🎉 The Asian Literary Festival Registration Successful!',
            'sender' => [
                'name' => 'Asian Literary Festival',
                'email' => 'helliumgk@gmail.com',
            ],
            'to' => [[
                'email' => $toEmail,
                'name' => $toName,
            ]],
            'htmlContent' => "
                <div style='font-family:sans-serif; padding: 20px; color:#333'>
                    <h2 style='color:#512B81;'>Hello {$toName},</h2>
                    <p>Thank you for registering for <strong>The Asian Literary Festival 2025</strong>!</p>
                    <p>We’re excited to have you join us for a magical celebration of literature and culture.</p>
                    <p>📍 <strong>Location:</strong> Gampaha, Sri Lanka<br>
                       📅 <strong>Date:</strong> 23rd December 2025</p>
                    <p>More updates will follow soon. Stay tuned!</p>
                    <br>
                    <p style='font-size:14px;color:#555;'>Warm regards,<br><strong>Asian Literary Festival Team</strong></p>
                </div>
            "
        ]);

        return $this->apiInstance->sendTransacEmail($sendSmtpEmail);
    }
}
