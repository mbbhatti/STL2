<?php

namespace App\Service\Reader;

use App\Service\Localization;
use App\Repository\QuestionnaireRepository;

class QuestionnaireReader extends AbstractReader
{
    /**
     * @var QuestionnaireRepository
     */
    private $questionnaire;

    /**
     * QuestionnaireReader constructor.
     * @param QuestionnaireRepository $questionnaire
     * @param Localization $localization
     */
    public function __construct(QuestionnaireRepository $questionnaire, Localization $localization)
    {
        parent::__construct($localization);
        $this->questionnaire = $questionnaire;
    }

    /**
     * @param bool $ordered
     * @param array $localizationFields
     * @param int $study
     * @param array $questionnaireCrossMetaQuestion
     * @param string|null $locale
     * @return array
     */
    public function get(
        bool $ordered,
        array $localizationFields,
        int $study,
        array $questionnaireCrossMetaQuestion,
        ?string $locale
    ): array
    {
        $rows = $this->questionnaire->get($ordered);
        $questionnaires = $this->readTable($rows, $ordered, $localizationFields, $locale);
        $questionnaires = $this->filterQuestionnairesByStudy($questionnaires, $study);
        $questionnaires = $this->initChildren($questionnaires, static::FIELD_META_QUESTIONS, []);
        $questionnaires = $this->assembleChildren(
            $questionnaires,
            $questionnaireCrossMetaQuestion,
            static::ENTITY_QUESTIONNAIRE,
            static::FIELD_META_QUESTIONS,
            [],
            function(array $child, array $parentField) {
                $parentField[] = $child[static::ENTITY_META_QUESTION];
                return $parentField;
            }
        );
        $questionnaires = $this->sortSubFieldsByOrder($questionnaires, static::FIELD_META_QUESTIONS);

        // filter out questionnaires without questions
        $questionnaires = array_filter($questionnaires, function(array $questionnaire) {
            return count($questionnaire['meta_questions']) > 0;
        });

        // filter out the order afterwards as we use it to sort some many-to-many relations
        // where the order coming from the DB was lost
        $questionnaires = $this->removeOrders($questionnaires);

        return $questionnaires;
    }

    /**
     * @param array $questionnaires
     * @param int $study
     * @return array
     */
    protected function filterQuestionnairesByStudy(array $questionnaires, int $study): array
    {
        $result = array_filter($questionnaires, function(array $questionnaire) use ($study) {
            return $questionnaire[static::ENTITY_STUDY] == $study;
        });

        return array_map(function(array $questionnaire) {
            unset($questionnaire[static::ENTITY_STUDY]);

            return $questionnaire;
        }, $result);
    }

    /**
     * @param array $entries
     * @return array
     */
    protected function removeOrders(array $entries): array
    {
        unset($entries['order']);
        foreach ($entries as $key => $entry) {
            if (is_array($entry)) {
                $entries[$key] = $this->removeOrders($entry);
            }
        }

        return $entries;
    }
}

