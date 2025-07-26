<?php

namespace App\Services;

use Brevo\Client\Configuration;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

class BrevoMailerService
{
    protected $apiInstance;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', config('services.brevo.api_key'));

        $this->apiInstance = new TransactionalEmailsApi(new Client(), $config);
    }

    /**
     * Send contact form submission to admin inbox
     */
    public function sendContactEmail(array $data): bool
    {
        $email = new SendSmtpEmail([
            'subject' => '📩 New Contact Message - ' . $data['subject'],
            'sender' => [
                'name'  => $data['full_name'],
                'email' => 'helliumgk@gmail.com',
            ],
            'to' => [[
                'email' => $data['email'],
                'name'  => 'Asian Literary Festival',
            ]],
            'replyTo' => [
                'name'  => $data['full_name'],
                'email' => $data['email'],
            ],
            'htmlContent' => $this->buildContactHtml($data),
        ]);

        $this->apiInstance->sendTransacEmail($email);
        return true;
    }

    /**
     * Build the HTML content for the contact email
     */
    protected function buildContactHtml(array $data): string
    {
        return "
            <div style='font-family: sans-serif; padding: 20px; color: #333;'>
                <h2 style='color:#512B81;'>New Contact Message</h2>
                <p><strong>Name:</strong> {$data['full_name']}</p>
                <p><strong>Email:</strong> {$data['email']}</p>
                <p><strong>Mobile:</strong> {$data['mobile']}</p>
                <p><strong>Subject:</strong> {$data['subject']}</p>
                <p><strong>Message:</strong></p>
                <p style='white-space: pre-line; border-left: 3px solid #ccc; padding-left: 10px;'>{$data['message']}</p>
                <br>
                <p style='font-size: 12px; color: #888;'>This message was sent via the Asian Literary Festival contact form.</p>
            </div>
        ";
    }
}
