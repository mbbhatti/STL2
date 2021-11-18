<?php

namespace App\Service;

use App\Service\Reader\MetaQuestionReader;
use App\Service\Reader\FreeInputQuestionReader;
use App\Service\Reader\ScaleQuestionReader;
use App\Service\Reader\ChoiceQuestionsChoiceReader;
use App\Service\Reader\ChoiceQuestionReader;
use App\Service\Reader\MetaQuestionGroupReader;
use App\Service\Reader\QuestionnaireMetaQuestionReader;
use App\Service\Reader\QuestionnaireReader;

class Reader
{
    /**
     * @var MetaQuestionReader
     */
    private $metaQuestion;

    /**
     * @var FreeInputQuestionReader
     */
    private $freeInputQuestion;

    /**
     * @var ScaleQuestionReader
     */
    private $scaleQuestion;

    /**
     * @var ChoiceQuestionsChoiceReader
     */
    private $choicesQuestions;

    /**
     * @var ChoiceQuestionReader
     */
    private $choiceQuestion;

    /**
     * @var MetaQuestionGroupReader
     */
    private $metaQuestionGroup;

    /**
     * @var QuestionnaireMetaQuestionReader
     */
    private $metaQuestionnaire;

    /**
     * @var QuestionnaireReader
     */
    private $questionnaire;

    /**
     * Reader constructor.
     * @param MetaQuestionReader $metaQuestion
     * @param FreeInputQuestionReader $freeInputQuestion
     * @param ScaleQuestionReader $scaleQuestion
     * @param ChoiceQuestionsChoiceReader $choicesQuestions
     * @param ChoiceQuestionReader $choiceQuestion
     * @param MetaQuestionGroupReader $metaQuestionGroup
     * @param QuestionnaireMetaQuestionReader $metaQuestionnaire
     * @param QuestionnaireReader $questionnaire
     */
    public function __construct(
        MetaQuestionReader $metaQuestion,
        FreeInputQuestionReader $freeInputQuestion,
        ScaleQuestionReader $scaleQuestion,
        ChoiceQuestionsChoiceReader $choicesQuestions,
        ChoiceQuestionReader $choiceQuestion,
        MetaQuestionGroupReader $metaQuestionGroup,
        QuestionnaireMetaQuestionReader $metaQuestionnaire,
        QuestionnaireReader $questionnaire
    )
    {
        $this->metaQuestion = $metaQuestion;
        $this->freeInputQuestion = $freeInputQuestion;
        $this->scaleQuestion = $scaleQuestion;
        $this->choicesQuestions = $choicesQuestions;
        $this->choiceQuestion = $choiceQuestion;
        $this->metaQuestionGroup = $metaQuestionGroup;
        $this->metaQuestionnaire = $metaQuestionnaire;
        $this->questionnaire = $questionnaire;
    }

    /**
     * @param int $group
     * @param int $study
     * @param string|null $locale
     * @return array
     */
    public function read(int $group, int $study, ?string $locale): array
    {
        $metaQuestions = $this->metaQuestion->get(true, ['headline', 'label'], $locale);
        $metaQuestions = $this->freeInputQuestion->get(false, ['text'], $metaQuestions, $locale);
        $metaQuestions = $this->scaleQuestion->get(false, ['min_text', 'max_text'], $metaQuestions, $locale);
        $choicesQuestions = $this->choicesQuestions->get(true, ['text'], $locale);
        $metaQuestions = $this->choiceQuestion->get(false, [], $metaQuestions, $choicesQuestions, $locale);
        $metaQuestionGroup = $this->metaQuestionGroup->getGroups($group);
        $metaQuestionsTree = $this->metaQuestionGroup->get($metaQuestions, $metaQuestionGroup);
        $metaQuestionnaires = $this->metaQuestionnaire->get($metaQuestionGroup, $metaQuestionsTree);
        $questionnaires = $this->questionnaire->get(true, ['label'], $study, $metaQuestionnaires, $locale);

        return ['questionnaires' => array_values($questionnaires)];
    }
}

