<?php

namespace App\Service\Reader;

use App\Service\Localization;
use App\Repository\ChoiceRepository;
use App\Repository\ChoiceQuestionRepository;

class ChoiceQuestionsChoiceReader extends AbstractReader
{
    /**
     * @var ChoiceQuestionRepository
     */
    private $choiceQuestionChoice;

    /**
     * @var ChoiceRepository
     */
    private $choice;

    /**
     * ChoiceQuestionsChoiceReader constructor.
     * @param ChoiceQuestionRepository $choiceQuestionChoice
     * @param ChoiceRepository $choice
     * @param Localization $localization
     */
    public function __construct(
        ChoiceQuestionRepository $choiceQuestionChoice,
        ChoiceRepository $choice,
        Localization $localization
    )
    {
        parent::__construct($localization);
        $this->choiceQuestionChoice = $choiceQuestionChoice;
        $this->choice = $choice;
    }

    /**
     * @param bool $ordered
     * @param array $localizationFields
     * @param string|null $locale
     * @return array
     */
    public function get(bool $ordered, array $localizationFields, ?string $locale): array
    {
        $choiceQuestionCrossChoice = $this->choiceQuestionChoice->getChoiceQuestionChoice();
        $rows = $this->choice->get($ordered);
        $choices = $this->readTable($rows, $ordered, $localizationFields, $locale);

        return $this->convertIdsToObjects($choiceQuestionCrossChoice, $choices, static::ENTITY_CHOICE);
    }
}

