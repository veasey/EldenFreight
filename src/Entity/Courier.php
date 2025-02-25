<?php

namespace App\Entity;

use App\Repository\CourierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Courier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $courierName = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourierName(): ?string
    {
        return $this->courierName;
    }

    public function setCourierName(string $courierName): self
    {
        $this->courierName = $courierName;
        return $this;
    }
}
