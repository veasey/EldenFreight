<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ShippingService
{
    private HttpClientInterface $httpClient;
    private CacheInterface $cache;
    private array $courierApis;

    public function __construct(HttpClientInterface $httpClient, CacheInterface $cache)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;

        // Load API keys from .env
        $this->courierApis = [
            'royal_mail' => [
                'url' => 'https://api.royalmail.com/shipping-rates',
                'key' => $_ENV['ROYAL_MAIL_API_KEY'] ?? ''
            ],
            'dhl' => [
                'url' => 'https://api.dhl.com/rates',
                'key' => $_ENV['DHL_API_KEY'] ?? ''
            ],
            'dpd' => [
                'url' => 'https://api.dpd.co.uk/shipping-rates',
                'key' => $_ENV['DPD_API_KEY'] ?? ''
            ],
            'evri' => [
                'url' => 'https://api.evri.com/rates',
                'key' => $_ENV['EVRI_API_KEY'] ?? ''
            ],
            'ups' => [
                'url' => 'https://onlinetools.ups.com/rates',
                'key' => $_ENV['UPS_API_KEY'] ?? ''
            ]
        ];
    }

    public function getShippingRates(array $shipmentDetails): array
    {
        return $this->cache->get('shipping_rates', function (ItemInterface $item) use ($shipmentDetails) {
            $item->expiresAfter(86400); // Cache for 24 hours

            $responses = [];
            foreach ($this->courierApis as $courier => $api) {
                $responses[$courier] = $this->fetchShippingRate($courier, $api, $shipmentDetails);
            }

            return $responses;
        });
    }

    private function fetchShippingRate(string $courier, array $api, array $shipmentDetails): array
    {
        try {
            $response = $this->httpClient->request('POST', $api['url'], [
                'json' => $shipmentDetails,
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $api['key']
                ]
            ]);

            return $response->toArray();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
