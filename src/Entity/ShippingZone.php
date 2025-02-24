<?php

namespace App\Entity;

use App\Repository\CourierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourierRepository::class)]
class ShippingZone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    private ?int $courierId = null;
    private ?string $shippingZoneName = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourierId(): ?int
    {
        return $this->courierId;
    }

    public function getShippingZoneName(): ?string
    {
        return $this->shippingZoneName;
    }
}
