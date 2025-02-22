<?php

namespace App\Service\Courier;

interface CourierInterface
{
    public function getName(): string;

    public function getShippingRate(array $shipmentDetails): array;
}
