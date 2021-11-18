<?php

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BaseRepository extends ServiceEntityRepository
{
    /**
     * BaseRepository constructor.
     * @param ManagerRegistry $registry
     * @param $entity
     */
    public function __construct(ManagerRegistry $registry, $entity)
    {
        parent::__construct($registry, $entity);
    }

    /**
     * @return string|null
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getEtag(): ?string
    {
        return $this->createQueryBuilder('t')
            ->select('
                max(
                    GREATEST(
                        UNIX_TIMESTAMP(t.createdAt), 
                        UNIX_TIMESTAMP(t.updatedAt), 
                        CASE 
                            WHEN t.deletedAt IS NOT NULL 
                            THEN UNIX_TIMESTAMP(t.deletedAt) 
                            ELSE 0 
                        END
                    )
                ) AS moment'
            )
            ->orderBy('moment', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();
    }
}

