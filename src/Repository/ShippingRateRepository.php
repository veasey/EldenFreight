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
     * @param int $originId
     * @param int $destinationId
     * @param float|null $weight
     * @return ShippingRate[] Returns an array of ShippingRate objects
     */
    public function findMatchingRates(int $originId, int $destinationId, ?float $weight): array
    {
        $queryBuilder = $this->createQueryBuilder('s')
            // Join with ShippingZone for origin and destination by ID
            ->innerJoin('s.shippingZone', 'origin')
            ->innerJoin('s.shippingZone', 'destination')
            
            // Filter by origin and destination ShippingZone IDs
            ->andWhere('origin.id = :originId')
            ->andWhere('destination.id = :destinationId')
            
            // Set parameters for origin and destination IDs
            ->setParameter('originId', $originId)
            ->setParameter('destinationId', $destinationId);
        
        // If weight is provided, filter by max weight
        if ($weight) {
            $queryBuilder
                ->setParameter('weight', $weight)
                ->andWhere('s.maxWeight >= :weight');
        }

        // Order by price ascending
        return $queryBuilder
            ->orderBy('s.price', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
