<?php

namespace App\Repository;

use App\Entity\Localization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LocalizationRepository extends ServiceEntityRepository
{
    /**
     * LocalizationRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Localization::class);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->createQueryBuilder('l')
            ->select('l.key', 'l.locale', 'l.text')
            ->where('l.deletedAt IS NULL')
            ->getQuery()
            ->getResult();
    }
}

