<?php

namespace App\Entity;

use App\Repository\CourierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourierRepository::class)]
class ShippingRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    private ?int $courierId = null;
    private ?int $shippingZoneId = null;
    private ?string $shippingRateName = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourierId(): ?int
    {
        return $this->courierId;
    }

    public function getShippingZoneId(): ?int
    {
        return $this->shippingZoneId;
    }

    public function getShippingRateName(): ?string
    {
        return $this->shippingRateName;
    }
}
