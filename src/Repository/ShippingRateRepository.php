<?php
// src/Repository/ShippingRateRepository.php

namespace App\Repository;

use App\Entity\ShippingRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ShippingRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingRate::class);
    }

    /**
     * Find shipping rates by criteria and order by price
     *
     * @param string $origin
     * @param string $destination
     * @param float $weight
     * @return ShippingRate[] Returns an array of ShippingRate objects
     */
    public function findMatchingRates(string $origin, string $destination, float $weight): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.origin = :origin')
            ->andWhere('s.destination = :destination')
            ->andWhere('s.weight >= :weight')
            ->setParameter('origin', $origin)
            ->setParameter('destination', $destination)
            ->setParameter('weight', $weight)
            ->orderBy('s.price', 'ASC')  // Order by price ascending
            ->getQuery()
            ->getResult();
    }
}
