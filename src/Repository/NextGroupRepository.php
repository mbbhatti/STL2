<?php

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;
use App\Entity\NextGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NextGroupRepository extends ServiceEntityRepository
{
    /**
     * NextGroupRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NextGroup::class);
    }

    /**
     * @return array|null
     * @throws NonUniqueResultException
     */
    public function checkIfExists(): ?array
    {
        return $this->createQueryBuilder('ng')
            ->select('ng.id', 'ng.groupName AS group_name')
            ->where('ng.used = 0')
            ->andWhere('ng.invalid = 0')
            ->orderBy('ng.id', 'ASC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function updateUsedById(int $id): bool
    {
        return $this->createQueryBuilder('ng')
            ->update()
            ->set('ng.used', 1)
            ->where('ng.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function updateInvalidByName(string $name): bool
    {
        return $this->createQueryBuilder('ng')
            ->update()
            ->set('ng.invalid', 1)
            ->where('ng.groupName = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->execute();
    }
}

