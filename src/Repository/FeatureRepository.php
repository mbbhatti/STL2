<?php

namespace App\Repository;

use App\Entity\Feature;
use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FeatureRepository extends ServiceEntityRepository
{
    /**
     * FeatureRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feature::class);
    }

    /**
     * @param int $group
     * @return array
     */
    public function getNamesByGroup(int $group): array
    {
        return $this->_em->createQueryBuilder()
            ->select('f.name')
            ->from(Group::class, 'g')
            ->innerJoin('g.features', 'f')
            ->where('g.id = :id')
            ->setParameter('id', $group)
            ->getQuery()
            ->execute();
    }
}

