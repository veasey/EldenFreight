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
    public function findMatchingRates(string $origin, string $destination, ?float $weight): array
    {

       $queryBuilder = $this->createQueryBuilder('s');
     
       $queryBuilder->setParameter('origin', $origin)
                    ->setParameter('destination', $destination);

        /*    
            ->innerJoin('s.origin', 'o')  // Join with the ShippingZone entity for origin
            ->innerJoin('s.destination', 'd')  // Join with the ShippingZone entity for destination
            ->andWhere('o.name = :origin')  // Assuming 'name' is the field in ShippingZone entity
                 ->andWhere('d.name = :destination')  // Assuming 'name' is the field in ShippingZone entity
     */

        if ($weight) {
            $queryBuilder->setParameter('weight', $weight)
                         ->andWhere('s.maxWeight >= :weight');
        }     
            
    
        return $queryBuilder->orderBy('s.price', 'ASC')  // Order by price ascending
                            ->getQuery()
                            ->getResult();
    }
}
