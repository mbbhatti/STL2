<?php

namespace App\Service\Reader;

use App\Service\Localization;
use App\Repository\FreeInputQuestionRepository;

class FreeInputQuestionReader extends AbstractReader
{
    /**
     * @var FreeInputQuestionRepository
     */
    private $freeInputQuestion;

    /**
     * FreeInputQuestionReader constructor.
     * @param FreeInputQuestionRepository $freeInputQuestion
     * @param Localization $localization
     */
    public function __construct(FreeInputQuestionRepository $freeInputQuestion, Localization $localization)
    {
        parent::__construct($localization);
        $this->freeInputQuestion = $freeInputQuestion;
    }

    /**
     * @param bool $ordered
     * @param array $localizationFields
     * @param array $metaQuestions
     * @param string|null $locale
     * @return array
     */
    public function get(bool $ordered, array $localizationFields, array $metaQuestions, ?string $locale): array
    {
        $rows = $this->freeInputQuestion->get();
        $freeInputQuestions = $this->readTable($rows, $ordered, $localizationFields, $locale);

        return $this->assembleChildren(
            $metaQuestions,
            $freeInputQuestions,
            static::ENTITY_META_QUESTION,
            static::ENTITY_QUESTION,
            [static::FIELD_QUESTION_TYPE => 'free_input'],
            function(array $child) {
                return $child;
            }
        );
    }
}

