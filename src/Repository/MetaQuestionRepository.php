<?php

namespace App\Repository;

use App\Entity\MetaQuestion;
use Doctrine\Persistence\ManagerRegistry;

class MetaQuestionRepository extends BaseRepository
{
    /**
     * MetaQuestionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MetaQuestion::class);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->createQueryBuilder('mq')
            ->select('mq.id', 'mq.order', 'mq.label', 'mq.headline')
            ->where('mq.deletedAt IS NULL')
            ->where('mq.published = 1')
            ->orderBy('mq.order', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $group
     * @return array
     */
    public function getByGroup(int $group): array
    {
        return $this->_em->createQueryBuilder()
            ->select('mq.id AS meta_question')
            ->from(MetaQuestion::class, 'mq')
            ->innerJoin('mq.groups', 'g')
            ->where('mq.deletedAt IS NULL')
            ->andWhere('g.id = :id')
            ->setParameter('id', $group)
            ->getQuery()
            ->execute();
    }
}

