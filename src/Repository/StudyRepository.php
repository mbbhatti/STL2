<?php

namespace App\Repository;

use App\Entity\Study;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StudyRepository extends ServiceEntityRepository
{
    /**
     * StudyRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Study::class);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->createQueryBuilder('s')
            ->select('s.id', 's.name')
            ->where('s.deletedAt IS NULL')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $study
     * @return bool
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function isStudyValid(int $study): bool
    {
        $row = $this->createQueryBuilder('s')
            ->select('COUNT(s.id) AS amount')
            ->where('s.deletedAt IS NULL')
            ->andWhere('s.id = :id')
            ->setParameter('id', $study)
            ->getQuery()
            ->getSingleResult();

        return (int)$row['amount'] > 0;
    }

    /**
     * @return array|null
     * @throws NonUniqueResultException
     */
    public function getLatestIds(): ?array
    {
        return $this->createQueryBuilder('s')
            ->select('s.id')
            ->where('s.deletedAt IS NULL')
            ->andWhere('s.published IS NOT NULL')
            ->orderBy('s.published', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}

