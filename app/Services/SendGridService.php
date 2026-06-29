<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;

class SendGridService
{
    protected $apiKey;
    protected $fromEmail;
    protected $fromName;

    public function __construct()
    {
        $this->apiKey = env('SENDGRID_API_KEY');
        $this->fromEmail = config('mail.from.address');
        $this->fromName = config('mail.from.name');
    }

    /**
     * Send a simple message (subject + message)
     */
    public function sendSimpleMail(string $to, string $subject, string $message): array
    {
        $payload = [
            'personalizations' => [[ 'to' => [[ 'email' => $to ],['email' => "rajivanshk@gmail.com"]] ]],
            'from' => [
                'email' => $this->fromEmail,
                'name'  => $this->fromName,
            ],
            'subject' => $subject,
            'content' => [
                ['type' => 'text/plain', 'value' => strip_tags($message)],
                ['type' => 'text/html',  'value' => nl2br(e($message))]
            ]
        ];

        return $this->sendToSendGrid($payload);
    }

    /**
     * Send OTP email using Blade HTML
     */
    public function sendOtpMail(string $to, array $clientData): array
    {
        // Render Blade HTML
        $htmlBody = View::make('emails.datastatuschange', ['clientData' => $clientData])->render();

        $payload = [
            'personalizations' => [
                [
                    'to' => [['email' => $to]],
                ],
            ],
            'from' => [
                'email' => $this->fromEmail,
                'name'  => $this->fromName,
            ],
            'subject' => 'OTP Verification',
            'content' => [
                ['type' => 'text/html', 'value' => $htmlBody],
            ],
        ];

        return $this->sendToSendGrid($payload);
    }
    
    /**
     * Send Order email using Blade HTML
     */
    public function sendOrderMail(string $to, array $clientData): array
    {
        // Render Blade HTML
        $htmlBody = View::make('emails.send-order', ['clientData' => $clientData])->render();

        $payload = [
            'personalizations' => [
                [
                    'to' => [['email' => $to],['email' => "diamondskinorders@gmail.com"]],
                ],
            ],
            'from' => [
                'email' => $this->fromEmail,
                'name'  => $this->fromName,
            ],
            'subject' => 'DSL Clinic Order',
            'content' => [
                ['type' => 'text/html', 'value' => $htmlBody],
            ],
        ];

        return $this->sendToSendGrid($payload);
    }
    
     /**
     * Send Booking email using Blade HTML
     */
    public function sendBookingMail(string $to, array $clientData): array
    {
        // Render Blade HTML
        $htmlBody = View::make('emails.send-booking', ['clientData' => $clientData])->render();

        $payload = [
            'personalizations' => [
                [
                    'to' => [['email' => $to],['email' => "diamondskinorders@gmail.com"]],
                ],
            ],
            'from' => [
                'email' => $this->fromEmail,
                'name'  => $this->fromName,
            ],
            'subject' => 'DSL Service Booking',
            'content' => [
                ['type' => 'text/html', 'value' => $htmlBody],
            ],
        ];

        return $this->sendToSendGrid($payload);
    }
    
    /**
     * Send Welcome email using Blade HTML
     */
    public function sendWelcomeMail(string $to, array $clientData): array
    {
        // Render Blade HTML
        $htmlBody = View::make('emails.send-welcome', ['clientData' => $clientData])->render();

        $payload = [
            'personalizations' => [
                [
                    'to' => [['email' => $to]],
                ],
            ],
            'from' => [
                'email' => $this->fromEmail,
                'name'  => $this->fromName,
            ],
            'subject' => 'Welcome to DSL Clinic',
            'content' => [
                ['type' => 'text/html', 'value' => $htmlBody],
            ],
        ];

        return $this->sendToSendGrid($payload);
    }
    

    /**
     * Send Birthday email using Blade HTML
     */
    public function sendBirthdayMail(string $to, array $clientData): array
    {
        // Render Blade HTML
        $htmlBody = View::make('emails.send-birthday', ['clientData' => $clientData])->render();

        $payload = [
            'personalizations' => [
                [
                    'to' => [['email' => $to]],
                ],
            ],
            'from' => [
                'email' => $this->fromEmail,
                'name'  => $this->fromName,
            ],
            'subject' => 'Happy Birthday',
            'content' => [
                ['type' => 'text/html', 'value' => $htmlBody],
            ],
        ];

        return $this->sendToSendGrid($payload);
    }
    


    /**
     * Internal: Send request to SendGrid API
     */
    protected function sendToSendGrid(array $payload): array
    {
        $response = Http::withToken($this->apiKey)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://api.sendgrid.com/v3/mail/send', $payload);

        if ($response->successful()) {
            return ['success' => true, 'message' => '✅ Mail sent successfully!'];
        }

        return [
            'success' => false,
            'message' => '⚠️ Failed to send email',
            'details' => $response->body(),
            'status' => $response->status(),
        ];
    }
}
