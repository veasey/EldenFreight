<?php

namespace App\Entity;

use App\Repository\CourierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ShippingZone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Courier::class)]
    #[ORM\JoinColumn(name: 'courier_id', referencedColumnName: 'id', nullable: false, onDelete: "CASCADE")]
    private ?Courier $courier = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $shippingZoneName = null;

    #[ORM\ManyToMany(targetEntity: ShippingRate::class, inversedBy: 'shippingZones')]
    #[ORM\JoinTable(name: 'shipping_rate_shipping_zone')]
    private iterable $shippingRates;

    public function __construct()
    {
        $this->shippingRates = new \Doctrine\Common\Collections\ArrayCollection(); // Initialize collection
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourier(): ?Courier
    {
        return $this->courier;
    }

    public function getShippingZoneName(): ?string
    {
        return $this->shippingZoneName;
    }

    public function getShippingRates(): iterable
    {
        return $this->shippingRates;
    }
}
