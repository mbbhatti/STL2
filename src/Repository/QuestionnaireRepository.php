<?php

namespace App\Repository;

use App\Entity\Questionnaire;
use Doctrine\Persistence\ManagerRegistry;

class QuestionnaireRepository extends BaseRepository
{
    /**
     * QuestionnaireRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Questionnaire::class);
    }

    /**
     * @param bool $order
     * @return array
     */
    public function get(bool $order): array
    {
        $fields = 'q.id, q.label, q.moment, IDENTITY(q.study) AS study';
        if ($order) {
            $fields .= ' ,q.order';
        }

        $query = $this->createQueryBuilder('q')
            ->select($fields)
            ->where('q.deletedAt IS NULL');
        if ($order) {
            $query->orderBy('q.order', 'ASC');
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function getMetaQuestions(): array
    {
        return $this->_em->createQueryBuilder()
            ->select('q.id AS questionnaire', 'mq.id AS meta_question')
            ->from(Questionnaire::class, 'q')
            ->innerJoin('q.metaQuestions', 'mq')
            ->where('q.deletedAt IS NULL')
            ->getQuery()
            ->execute();
    }
}

