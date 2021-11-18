<?php

namespace App\Service\Reader;

use App\Service\Localization;
use App\Repository\QuestionnaireRepository;

class QuestionnaireMetaQuestionReader extends AbstractReader
{
    /**
     * @var QuestionnaireRepository
     */
    private $questionnaireMetaQuestion;

    /**
     * QuestionnaireMetaQuestionReader constructor.
     * @param QuestionnaireRepository $questionnaireMetaQuestion
     * @param Localization $localization
     */
    public function __construct(
        QuestionnaireRepository $questionnaireMetaQuestion,
        Localization $localization
    )
    {
        parent::__construct($localization);
        $this->questionnaireMetaQuestion = $questionnaireMetaQuestion;
    }

    /**
     * @param array $metaQuestionOfGroup
     * @param array $metaQuestionsTree
     * @return array
     */
    public function get(array $metaQuestionOfGroup, array $metaQuestionsTree): array
    {
        $questionnaireCrossMetaQuestion = $this->questionnaireMetaQuestion->getMetaQuestions();
        $questionnaireCrossMetaQuestion = array_filter(
            $questionnaireCrossMetaQuestion,
            function(array $questionnaireCrossMetaQuestion) use ($metaQuestionOfGroup) {
                return in_array(
                    $questionnaireCrossMetaQuestion[static::ENTITY_META_QUESTION],
                    $metaQuestionOfGroup
                );
            }
        );

        return $this->convertIdsToObjects(
            $questionnaireCrossMetaQuestion,
            $metaQuestionsTree,
            static::ENTITY_META_QUESTION
        );
    }
}

