<?php

namespace App\Service\Courier;


class RoyalMailCourier implements CourierInterface
{
    private string $apiKey;

    public function getName(): string
    {
        return 'royal_mail';
    }

    public function getShippingRate(array $shipmentDetails): array
    {
        try {
            
            // get from DB
            return [];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
