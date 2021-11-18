<?php

namespace App\Repository;

use App\Entity\ScaleQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ScaleQuestionRepository extends ServiceEntityRepository
{
    /**
     * ScaleQuestionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScaleQuestion::class);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->createQueryBuilder('sq')
            ->select(
                'sq.id',
                'IDENTITY(sq.metaQuestion) AS meta_question',
                'sq.minText AS min_text',
                'sq.minValue AS min_value',
                'sq.maxText AS max_text',
                'sq.maxValue AS max_value',
                'sq.answerId AS answer_id',
            )
            ->where('sq.deletedAt IS NULL')
            ->getQuery()
            ->getResult();
    }
}

