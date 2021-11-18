<?php

namespace App\Service\Reader;

use App\Repository\MetaQuestionRepository;
use App\Service\Localization;

class MetaQuestionReader extends AbstractReader
{
    /**
     * @var MetaQuestionRepository
     */
    private $metaQuestion;

    /**
     * MetaQuestionReader constructor.
     * @param MetaQuestionRepository $metaQuestion
     * @param Localization $localization
     */
    public function __construct(MetaQuestionRepository $metaQuestion, Localization $localization)
    {
        parent::__construct($localization);
        $this->metaQuestion = $metaQuestion;
    }

    /**
     * @param bool $ordered
     * @param array $localizationFields
     * @param string|null $locale
     * @return array
     */
    public function get(bool $ordered, array $localizationFields, ?string $locale): array
    {
        $rows =  $this->metaQuestion->get();
        $metaQuestions = $this->readTable($rows, $ordered, $localizationFields, $locale);

        return $this->initChildren($metaQuestions, static::ENTITY_QUESTION, null);
    }
}

