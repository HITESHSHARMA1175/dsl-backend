<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class KlarnaService
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = config('services.klarna.base_url');
        $this->username = config('services.klarna.username');
        $this->password = config('services.klarna.password');
    }

    protected function client()
    {
        return Http::withBasicAuth($this->username, $this->password)
                   ->baseUrl($this->baseUrl)
                   ->acceptJson();
    }

    public function createSession(array $data)
    {
        return $this->client()->post('/payments/v1/sessions', $data)->json();
    }

    public function createOrder(string $token, array $data)
    {
        return $this->client()->post("/payments/v1/authorizations/{$token}/order", $data)->json();
    }

    public function cancelAuthorization(string $token)
    {
        return $this->client()->delete("/payments/v1/authorizations/{$token}")->status();
    }

    public function getSession(string $sessionId)
    {
        return $this->client()->get("/payments/v1/sessions/{$sessionId}")->json();
    }
    
    public function getOrder(string $orderId)
    {
        return $this->client()->get("/ordermanagement/v1/orders/{$orderId}")->json();
    }
}
