<?php

namespace App\Entity;

use App\Repository\ShippingRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShippingRateRepository::class)]
class ShippingRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Courier::class)]
    #[ORM\JoinColumn(name: 'courier_id', referencedColumnName: 'id', nullable: false, onDelete: "CASCADE")]
    private ?Courier $courier = null;

    #[ORM\ManyToMany(targetEntity: ShippingZone::class, inversedBy: 'shippingRates')]
    #[ORM\JoinTable(name: 'shipping_rate_shipping_zone')]
    private iterable $shippingZones; // Many Shipping Zones

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $shippingRateName = '';

    #[ORM\Column(type: 'decimal', precision: 6, scale: 2)]
    private ?float $maxWeight = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $maxValue = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourier(): ?Courier
    {
        return $this->courier;
    }

    // Getters and setters for shippingZones
    public function getShippingZones(): iterable
    {
        return $this->shippingZones;
    }

    public function addShippingZone(ShippingZone $shippingZone): self
    {
        if (!$this->shippingZones->contains($shippingZone)) {
            $this->shippingZones[] = $shippingZone;
        }
        return $this;
    }

    public function removeShippingZone(ShippingZone $shippingZone): self
    {
        $this->shippingZones->removeElement($shippingZone);
        return $this;
    }

    public function getShippingRateName(): ?string
    {
        return $this->shippingRateName;  // This method needs to be here
    }

    public function getMaxWeight(): ?float
    {
        return $this->maxWeight;  // This method needs to be here
    }

    public function getMaxValue(): ?float
    {
        return $this->maxValue;  // This method needs to be here
    }

    public function getPrice(): ?float
    {
        return $this->price;  // This method needs to be here
    }

    public function getShippingZoneNames(): array
    {
        $zoneNames = [];
        foreach ($this->shippingZones as $zone) {
            $zoneNames[] = $zone->getName(); // Assuming ShippingZone has a getName() method
        }
        return $zoneNames;
    }
}
