<?php

namespace App\Service\Reader;

use App\Service\Localization;
use App\Repository\ChoiceQuestionRepository;

class ChoiceQuestionReader extends AbstractReader
{
    /**
     * @var ChoiceQuestionRepository
     */
    private $choiceQuestion;

    /**
     * ChoiceQuestionReader constructor.
     * @param ChoiceQuestionRepository $choiceQuestion
     * @param Localization $localization
     */
    public function __construct(ChoiceQuestionRepository $choiceQuestion, Localization $localization)
    {
        parent::__construct($localization);
        $this->choiceQuestion = $choiceQuestion;
    }

    /**
     * @param bool $ordered
     * @param array $localizationFields
     * @param array $metaQuestions
     * @param array $choiceQuestionCrossChoice
     * @param string|null $locale
     * @return array
     */
    public function get(
        bool $ordered,
        array $localizationFields,
        array $metaQuestions,
        array $choiceQuestionCrossChoice,
        ?string $locale
    ): array
    {
        $rows = $this->choiceQuestion->get();
        $choiceQuestions = $this->readTable($rows, $ordered, $localizationFields, $locale);
        $choiceQuestions = $this->initChildren($choiceQuestions, static::FIELD_CHOICES, []);
        $choiceQuestions = $this->assembleChildren(
            $choiceQuestions,
            $choiceQuestionCrossChoice,
            static::ENTITY_CHOICE_QUESTION,
            static::FIELD_CHOICES,
            [],
            function(array $child, array $parentField) {
                $parentField[] = $child[static::ENTITY_CHOICE];
                return $parentField;
            }
        );
        $choiceQuestions = $this->sortSubFieldsByOrder($choiceQuestions, static::FIELD_CHOICES);

        return $this->assembleChildren(
            $metaQuestions,
            $choiceQuestions,
            static::ENTITY_META_QUESTION,
            static::ENTITY_QUESTION,
            [static::FIELD_QUESTION_TYPE => static::ENTITY_CHOICE],
            function(array $child) {
                return $child;
            }
        );
    }
}

