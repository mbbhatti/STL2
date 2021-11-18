<?php

namespace App\Repository;

use App\Entity\Configuration;
use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ConfigurationRepository extends ServiceEntityRepository
{
    /**
     * ConfigurationRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Configuration::class);
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getByIds(array $ids): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.key', 'c.value')
            ->where('c.id IN (:ids)')
            ->andWhere('c.deletedAt IS NULL')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $group
     * @return array
     */
    public function getIdsByGroup(int $group): array
    {
        return $this->_em->createQueryBuilder()
            ->select('c.id AS configurationId')
            ->from(Group::class, 'g')
            ->leftJoin('g.configurations', 'c')
            ->where('c.deletedAt IS NULL')
            ->andWhere('g.id = :id')
            ->setParameter('id', $group)
            ->getQuery()
            ->execute();
    }
}

