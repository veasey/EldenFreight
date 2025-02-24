<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use App\Repository\ShippingRateRepository;

class ShippingService
{
    private HttpClientInterface $httpClient;
    private CacheInterface $cache;
    private ShippingRateRepository $shippingRateRepository;

    public function __construct(
        HttpClientInterface     $httpClient, 
        CacheInterface          $cache,
        ShippingRateRepository  $shippingRateRepository
    )
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
        $this->shippingRateRepository = $shippingRateRepository;
    }

    public function getShippingRates(array $shipmentDetails): array
    {
        return $this->shippingRateRepository->findMatchingRates(
            $shipmentDetails['origin'],
            $shipmentDetails['destination'],
            $shipmentDetails['weight']
        );
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
