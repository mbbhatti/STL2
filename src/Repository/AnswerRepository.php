<?php

namespace App\Repository;

use DateTime;
use Exception;
use App\Entity\Answer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AnswerRepository extends ServiceEntityRepository
{
    /**
     * AnswerRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    /**
     * @param int $user
     * @return array
     */
    public function getByUser(int $user): array
    {
        return $this->createQueryBuilder('a')
            ->select(
                'a.id',
                'a.answerId AS answer_id',
                'a.cycle',
                'a.day',
                'a.answer',
                'a.appVersion'
            )
            ->where('a.deletedAt IS NULL')
            ->andWhere('a.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $study
     * @return array
     */
    public function getByStudy(int $study): array
    {
        return $this->createQueryBuilder('a')
            ->select(
                'IDENTITY(a.user) AS user',
                'a.answerId AS answer_id',
                'a.cycle',
                'a.day',
                'a.answer',
                'a.appVersion AS app_version'
            )
            ->where('a.deletedAt IS NULL')
            ->andWhere('a.study = :study')
            ->setParameter('study', $study)
            ->orderBy('a.user', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $study
     * @return array
     */
    public function getIdsByStudy(int $study): array
    {
        return $this->createQueryBuilder('a')
            ->select(
                'CONCAT(
                        a.answerId, \'_\', IFNULL(a.cycle, \'NULL\'), \'_\', IFNULL(a.day, \'NULL\')
                    ) AS complete_answer_id',
                'a.answerId AS answer_id', 'a.cycle', 'a.day'
            )
            ->where('a.deletedAt IS NULL')
            ->andWhere('a.study = :study')
            ->setParameter('study', $study)
            ->groupBy('complete_answer_id, a.answerId, a.cycle, a.day')
            ->orderBy('a.answerId, a.cycle, a.day', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $answer
     * @param int $study
     * @param int $id
     * @param string|null $appVersion
     * @return bool
     * @throws Exception
     */
    public function updateAnswer(string $answer, int $study, int $id, string $appVersion = null): bool
    {
        return $this->createQueryBuilder('a')
            ->update()
            ->set('a.updatedAt', ':updated_at')
            ->set('a.version', 'a.version + 1')
            ->set('a.answer', ':answer')
            ->set('a.study', ':study')
            ->set('a.appVersion', ':app_version')
            ->where('a.id = :id')
            ->setParameter('updated_at', new DateTime())
            ->setParameter('answer', $answer)
            ->setParameter('study', $study)
            ->setParameter('app_version', $appVersion ?? null)
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }
}

