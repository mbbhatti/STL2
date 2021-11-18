<?php

namespace App\Service\Reader;

use App\Service\Localization;
use App\Repository\MetaQuestionRepository;

class MetaQuestionGroupReader extends AbstractReader
{
    /**
     * @var MetaQuestionRepository
     */
    private $metaQuestionGroup;

    /**
     * MetaQuestionGroupReader constructor.
     * @param MetaQuestionRepository $metaQuestionGroup
     * @param Localization $localization
     */
    public function __construct(MetaQuestionRepository $metaQuestionGroup, Localization $localization)
    {
        parent::__construct($localization);
        $this->metaQuestionGroup = $metaQuestionGroup;
    }

    /**
     * @param array $metaQuestions
     * @param array $metaQuestionGroup
     * @return array
     */
    public function get(array $metaQuestions, array $metaQuestionGroup): array
    {
        $metaQuestionsRoot = array_filter($metaQuestions, function(array $metaQuestion) use ($metaQuestionGroup) {
            return in_array($metaQuestion['id'], $metaQuestionGroup);
        });

        return array_map(function(array $metaQuestion) use ($metaQuestions) {
            return $this->createTree($metaQuestion, $metaQuestions);
        }, $metaQuestionsRoot);
    }

    /**
     * @param int $group
     * @return array
     */
    public function getGroups(int $group): array
    {
        $rows = $this->metaQuestionGroup->getByGroup($group);

        return array_column($rows, static::ENTITY_META_QUESTION);
    }

    /**
     * @param array $metaQuestion
     * @param array $metaQuestions
     * @return array
     */
    protected function createTree(array $metaQuestion, array $metaQuestions): array
    {
        if (isset($metaQuestion[static::ENTITY_QUESTION][static::FIELD_QUESTION_TYPE]) &&
            $metaQuestion[static::ENTITY_QUESTION][static::FIELD_QUESTION_TYPE] === static::ENTITY_CHOICE &&
            !empty($metaQuestion[static::ENTITY_QUESTION][static::FIELD_CHOICES])
        ) {
            foreach($metaQuestion[static::ENTITY_QUESTION][static::FIELD_CHOICES] as &$choice) {
                if (array_key_exists(static::ENTITY_META_QUESTION, $choice) &&
                    array_key_exists($choice[static::ENTITY_META_QUESTION], $metaQuestions)) {
                    $metaQuestionTree = $this->createTree(
                        $metaQuestions[$choice[static::ENTITY_META_QUESTION]],
                        $metaQuestions
                    );
                    $choice[static::ENTITY_META_QUESTION] = $metaQuestionTree;
                }
            }
        }

        return $metaQuestion;
    }
}

