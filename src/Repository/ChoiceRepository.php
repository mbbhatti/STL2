<?php

namespace App\Repository;

use App\Entity\Choice;
use Doctrine\Persistence\ManagerRegistry;

class ChoiceRepository extends BaseRepository
{
    /**
     * ChoiceRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Choice::class);
    }

    /**
     * @param bool $order
     * @return array
     */
    public function get(bool $order): array
    {
        // Entity fields
        $fields = '
            c.id, 
            c.type, 
            c.text, 
            c.answerId AS answer_id, 
            c.answerValue AS answer_value, 
            c.min, 
            c.max, 
            c.default,
            IDENTITY(c.metaQuestion) AS meta_question';

        // Check order to add order field
        if ($order) {
            $fields .= ' ,c.order';
        }

        // Prepare query
        $query = $this->createQueryBuilder('c')->select($fields);

        // Condition
        $query->where('c.deletedAt IS NULL');

        // Check and set order
        if ($order) {
            $query->orderBy('c.order', 'ASC');
        }

        // Return result
        return $query->getQuery()->getResult();
    }
}

