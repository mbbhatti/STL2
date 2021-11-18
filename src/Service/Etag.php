<?php

namespace App\Service;

use App\Repository\MetaQuestionRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\GroupRepository;
use App\Repository\FreeInputQuestionRepository;
use App\Repository\ChoiceQuestionRepository;
use App\Repository\ChoiceRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;

class Etag
{
    /**
     * @var MetaQuestionRepository
     */
    private $metaQuestion;

    /**
     * @var QuestionnaireRepository
     */
    private $questionnaire;

    /**
     * @var GroupRepository
     */
    private $group;

    /**
     * @var FreeInputQuestionRepository
     */
    private $freeInputQuestion;

    /**
     * @var ChoiceQuestionRepository
     */
    private $choiceQuestion;

    /**
     * @var ChoiceRepository
     */
    private $choice;

    /**
     * Etag constructor.
     * @param MetaQuestionRepository $metaQuestion
     * @param QuestionnaireRepository $questionnaire
     * @param GroupRepository $group
     * @param FreeInputQuestionRepository $freeInputQuestion
     * @param ChoiceQuestionRepository $choiceQuestion
     * @param ChoiceRepository $choice
     */
    public function __construct(
        MetaQuestionRepository $metaQuestion,
        QuestionnaireRepository $questionnaire,
        GroupRepository $group,
        FreeInputQuestionRepository $freeInputQuestion,
        ChoiceQuestionRepository $choiceQuestion,
        ChoiceRepository $choice
    )
    {
        $this->metaQuestion = $metaQuestion;
        $this->questionnaire = $questionnaire;
        $this->group = $group;
        $this->freeInputQuestion = $freeInputQuestion;
        $this->choiceQuestion = $choiceQuestion;
        $this->choice = $choice;
    }

    /**
     * @return string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getEtag(): string
    {
        $metaQuestionETag = $this->metaQuestion->getEtag();
        $questionnaire = $this->questionnaire->getEtag();
        $groupETag = $this->group->getEtag();
        $freeInputQuestion = $this->freeInputQuestion->getEtag();
        $choiceQuestion = $this->choiceQuestion->getEtag();
        $choice = $this->choice->getEtag();

        return max(
            $metaQuestionETag ?? 0,
            $questionnaire ?? 0,
            $groupETag ?? 0,
            $freeInputQuestion ?? 0,
            $choiceQuestion ?? 0,
            $choice ?? 0
        );
    }
}

