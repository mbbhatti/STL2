<?php

namespace App\Repository;

use App\Entity\ChoiceQuestion;
use Doctrine\Persistence\ManagerRegistry;

class ChoiceQuestionRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChoiceQuestion::class);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->createQueryBuilder('cq')
            ->select(
                'cq.id',
                'IDENTITY(cq.metaQuestion) AS meta_question',
                'cq.type',
                'cq.answerId AS answer_id'
            )
            ->where('cq.deletedAt IS NULL')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array
     */
    public function getChoiceQuestionChoice(): array
    {
        return $this->_em->createQueryBuilder()
            ->select('cq.id AS choice_question', 'c.id AS choice')
            ->from(ChoiceQuestion::class, 'cq')
            ->innerJoin('cq.choices', 'c')
            ->getQuery()
            ->execute();
    }
}

