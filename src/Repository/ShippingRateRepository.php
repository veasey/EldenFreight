<?php
// src/Repository/ShippingRateRepository.php

namespace App\Repository;

use App\Entity\ShippingRate;
use App\DTO\ShippingRateDTO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ShippingRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingRate::class);
    }

    public function findAll(): array
    {
        $qb = $this->createQueryBuilder('sr')
            ->leftJoin('sr.courier', 'c')
            ->leftJoin('sr.shippingZones', 'sz')
            ->addSelect('c', 'sz')
            ->getQuery();

        $shippingRates = $qb->getResult();

        // Use DTO for transformation
        return array_map(fn($rate) => ShippingRateDTO::fromEntity($rate), $shippingRates);
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
        $queryBuilder = $this->createQueryBuilder('sr')
            ->leftJoin('sr.courier', 'c')
            ->leftJoin('sr.shippingZones', 'sz')
            ->addSelect('c', 'sz')
            ->orderBy('sr.price', 'ASC');

        // Filter couriers that either:
        // - Cover BOTH the origin and destination zones
        // - OR have no zones at all
        $queryBuilder->andWhere(
            $queryBuilder->expr()->orX(
                'sz.id IS NULL',
                '(sz.id = :originId OR sz.id = :destinationId)'
            )
        )
        ->setParameter('originId', $originId)
        ->setParameter('destinationId', $destinationId);

        // Filter by max weight if provided
        if ($weight !== null) {
            $queryBuilder->andWhere('sr.maxWeight >= :weight')
                ->setParameter('weight', $weight);
        }

        // Use DISTINCT to ensure unique results for ShippingRates
        $queryBuilder->distinct();

        $shippingRates = $queryBuilder->getQuery()->getResult();

        // Use DTO for transformation
        return array_map(fn($rate) => ShippingRateDTO::fromEntity($rate), $shippingRates);
    }

}
