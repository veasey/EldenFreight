<?php

namespace App\DTO;

use App\Entity\ShippingRate;

class ShippingRateDTO
{
    public static function fromEntity(ShippingRate $shippingRate): array
    {
        return [
            'shipping_rate_id' => $shippingRate->getId(),
            'shipping_rate_name' => $shippingRate->getShippingRateName(),
            'max_weight' => $shippingRate->getMaxWeight(),
            'max_value' => $shippingRate->getMaxValue(),
            'price' => $shippingRate->getPrice(),
            'courier_name' => $shippingRate->getCourier()?->getCourierName(), // Safe null handling
            'shipping_zones' => $shippingRate->getShippingZoneNames()
        ];
    }
}
