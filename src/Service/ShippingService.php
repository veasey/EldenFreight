<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Psr\Log\LoggerInterface;

class ShippingService
{
    private HttpClientInterface $httpClient;
    private CacheInterface $cache;
    private ApiConfig $apiConfig;
    private LoggerInterface $logger;

    public function __construct(
        HttpClientInterface $httpClient, 
        CacheInterface $cache,
        ApiConfig $apiConfig,
        LoggerInterface $logger

    )
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
        $this->logger = $logger;
        $this->apiConfig = $apiConfig;
    }

    public function getShippingRates(array $shipmentDetails): array
    {
        return $this->cache->get('shipping_rates', function (ItemInterface $item) use ($shipmentDetails) {
            $item->expiresAfter(86400); // Cache for 24 hours

            $responses = [];
            foreach ($this->apiConfig as $courier => $api) {

                // skip couriers that have no had a key entered yet
                if (empty($api['key'])) {
                    $this->logger->error($courier, [
                        'Error' => 'No configured. No API key'
                    ]);
                }

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
