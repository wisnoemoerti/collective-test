<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ThirdPartyService
{
    private $baseUrl;
    private $authToken;

    public function __construct()
    {
        $this->baseUrl = 'https://yourdomain.com';
        $this->authToken = base64_encode('fajarwisnumukti');
    }

    public function deposit($orderId, $amount, $timestamp)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->authToken
        ])->post("{$this->baseUrl}/deposit", [
            'order_id' => $orderId,
            'amount' => $amount,
            'timestamp' => $timestamp
        ]);

        // Simulating a success response since the URL is fake
        return [
            'order_id' => $orderId,
            'amount' => $amount,
            'status' => 1 // 1 indicates success, 2 indicates failure
        ];

        // Uncomment this line if using a real API
        // return $response->json();
    }
}
