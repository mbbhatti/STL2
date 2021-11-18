<?php

namespace App\Repository;

use App\Entity\FreeInputQuestion;
use Doctrine\Persistence\ManagerRegistry;

class FreeInputQuestionRepository extends BaseRepository
{
    /**
     * FreeInputQuestionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FreeInputQuestion::class);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->createQueryBuilder('f')
            ->select(
                'f.id',
                'IDENTITY(f.metaQuestion) AS meta_question',
                'f.type',
                'f.text',
                'f.answerId AS answer_id',
                'f.min',
                'f.max'
            )
            ->where('f.deletedAt IS NULL')
            ->getQuery()
            ->getResult();
    }
}

