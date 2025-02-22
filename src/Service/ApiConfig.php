<?php

namespace App\Service;

class ApiConfig
{
    private array $apiConfigs;

    public function __construct()
    {
        // Load API keys from environment variables
        $this->apiConfigs = [
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

    public function getApiConfig(string $courier): array
    {
        return $this->apiConfigs[$courier] ?? [];
    }
}
