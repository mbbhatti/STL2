<?php

namespace App\Repository;

use App\Entity\User;
use DateTime;
use Exception;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int $study
     * @return array of userId => groupName
     */
    public function getGroupNamesByStudy(int $study): array
    {
        $rows = $this->createQueryBuilder('u')
            ->addSelect('g')
            ->select('u.id', 'g.name')
            ->leftJoin('u.group', 'g')
            ->where('u.study = :study')
            ->setParameter('study', $study)
            ->getQuery()
            ->getResult();

        $response = [];
        foreach ($rows as $row) {
            $response[$row['id']] = $row['name'];
        }

        return $response;
    }

    /**
     * @param int $study
     * @return array of userId => groupId
     */
    public function getGroupsByStudy(int $study): array
    {
        $rows = $this->createQueryBuilder('u')
            ->select('u.id', 'IDENTITY(u.group) as group')
            ->where('u.deletedAt IS NULL')
            ->andWhere('u.study = :study')
            ->setParameter('study', $study)
            ->getQuery()
            ->getResult();

        $response = [];
        foreach ($rows as $row) {
            $response[$row['id']] = $row['group'];
        }

        return $response;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getById(int $userId): array
    {
        $response = $this->createQueryBuilder('u')
            ->select(
                'u.id',
                'IDENTITY(u.group) AS group',
                'IDENTITY(u.study) AS study',
                'u.leftAt AS left_at',
                'u.keyHash AS key_hash'
            )
            ->where('u.deletedAt IS NULL')
            ->andWhere('u.id = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->getResult();

        return $response[0] ?? [];
    }

    /**
     * @param int $userId
     * @return bool
     * @throws Exception
     */
    public function updateLeftAtById(int $userId): bool
    {
        return $this->createQueryBuilder('u')
            ->update()
            ->set('u.leftAt', ':left_at')
            ->where('u.leftAt IS NULL')
            ->andWhere('u.id = :userId')
            ->setParameter('left_at', new DateTime())
            ->setParameter('userId', $userId)
            ->getQuery()
            ->execute();
    }
}

