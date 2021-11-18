<?php

namespace App\Repository;

use App\Entity\Group;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class GroupRepository extends BaseRepository
{
    /**
     * GroupRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

    /**
     * @return array
     */
    public function getNames(): array
    {
        return $this->createQueryBuilder('g')
            ->select('g.name')
            ->where('g.deletedAt IS NULL')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $name
     * @return array|null
     * @throws NonUniqueResultException
     */
    public function getIdsByName(string $name): ?array
    {
        return $this->createQueryBuilder('g')
            ->select('g.id')
            ->where('g.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}

