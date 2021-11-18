<?php

namespace App\Service\Reader;

use App\Service\Localization;
use App\Repository\ScaleQuestionRepository;

class ScaleQuestionReader extends AbstractReader
{
    /**
     * @var ScaleQuestionRepository
     */
    private $scaleQuestion;

    /**
     * ScaleQuestionReader constructor.
     * @param ScaleQuestionRepository $scaleQuestion
     * @param Localization $localization
     */
    public function __construct(ScaleQuestionRepository $scaleQuestion, Localization $localization)
    {
        parent::__construct($localization);
        $this->scaleQuestion = $scaleQuestion;
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
        $rows = $this->scaleQuestion->get();
        $scaleQuestions = $this->readTable($rows, $ordered, $localizationFields, $locale);

        return $this->assembleChildren(
            $metaQuestions,
            $scaleQuestions,
            static::ENTITY_META_QUESTION,
            static::ENTITY_QUESTION,
            [static::FIELD_QUESTION_TYPE => 'scale'],
            function(array $child) {
                return $child;
            }
        );
    }
}

