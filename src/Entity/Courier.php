<?php

namespace App\Entity;

use App\Repository\CourierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourierRepository::class)]
class Courier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    private ?string $courierName = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourierName(): ?string
    {
        return $this->courierName;
    }
}
