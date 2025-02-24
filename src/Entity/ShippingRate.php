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

    #[ORM\ManyToOne(targetEntity: Courier::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Courier $courier = null;

    #[ORM\ManyToOne(targetEntity: ShippingZone::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?int $shippingZoneId = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $shippingRateName = '';

    #[ORM\Column(type: 'decimal', precision: 6, scale: 2)]
    private ?float $maxWeight = null; // Max weight in kg

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $maxValue = null; // Max package value in GBP

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourier(): ?Courier
    {
        return $this->courier;
    }

    public function getShippingZoneId(): ?int
    {
        return $this->shippingZoneId;
    }

    public function getShippingRateName(): ?string
    {
        return $this->shippingRateName;
    }

    public function getMaxValue(): ?float
    {
        return $this->maxValue;
    }

    public function getMaxWeight(): ?float
    {
        return $this->maxWeight;
    }
}
