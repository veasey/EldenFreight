<?php

namespace App\Service\Courier;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RoyalMailCourier implements CourierInterface
{
    private HttpClientInterface $httpClient;
    private string $apiKey;

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    public function getName(): string
    {
        return 'royal_mail';
    }

    public function getShippingRate(array $shipmentDetails): array
    {
        try {
            $response = $this->httpClient->request('POST', 'https://api.royalmail.com/shipping-rates', [
                'json' => [
                    'origin' => $shipmentDetails['origin'],
                    'destination' => $shipmentDetails['destination'],
                    'weight' => $shipmentDetails['weight'],
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept' => 'application/json'
                ]
            ]);

            return $response->toArray();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
