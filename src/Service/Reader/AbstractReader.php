<?php

namespace App\Service\Reader;

use App\Service\Localization;

class AbstractReader
{
    const ENTITY_META_QUESTION = 'meta_question';
    const ENTITY_QUESTION = 'question';
    const FIELD_ANSWER_ID = 'answer_id';
    const FIELD_QUESTION_TYPE = 'question_type';
    const ENTITY_STUDY = 'study';
    const FIELD_ORDER = 'order';
    const ENTITY_CHOICE = 'choice';
    const ENTITY_CHOICE_QUESTION = 'choice_question';
    const FIELD_CHOICES = 'choices';
    const ENTITY_QUESTIONNAIRE = 'questionnaire';
    const FIELD_META_QUESTIONS = 'meta_questions';

    /**
     * @var Localization
     */
    private $localization;

    /**
     * AbstractReader constructor.
     * @param Localization $localization
     */
    public function __construct(Localization $localization)
    {
        $this->localization = $localization;
    }

    /**
     * @param array $rows
     * @param bool $ordered
     * @param array $localizationFields
     * @param string|null $locale
     * @return array
     */
    protected function readTable(array $rows, bool $ordered, array $localizationFields, ?string $locale): array
    {
        $result = [];
        foreach ($rows as $row) {
            $cleanRow = $row;
            $cleanRow['id'] = (int)$row['id'];
            foreach ($localizationFields as $localizationField) {
                $key = $cleanRow[$localizationField];
                if ($key !== null) {
                    $local = $this->localization->get($locale, $key);
                    $cleanRow[$localizationField] = $local;
                }
            }

            if ($ordered) {
                $cleanRow[static::FIELD_ORDER] = (int)$cleanRow[static::FIELD_ORDER];
            }

            $cleanRow = array_filter($cleanRow, function($value) {
                return $value !== null;
            });

            $result[$row['id']] = $cleanRow;
        }

        return $result;
    }

    /**
     * @param array $parents
     * @param string $targetField
     * @param $value
     * @return array
     */
    protected function initChildren(array $parents, string $targetField, $value): array
    {
        return array_map(function(array $parent) use ($targetField, $value) {
            $parent[$targetField] = $value;
            return $parent;
        }, $parents);
    }

    /**
     * @param array $parents
     * @param array $children
     * @param string $parentField
     * @param string $targetField
     * @param array $additionalField
     * @param callable $assembler
     * @return array
     */
    protected function assembleChildren(
        array $parents,
        array $children,
        string $parentField,
        string $targetField,
        array $additionalField,
        callable $assembler
    ): array
    {
        $result = $parents;
        foreach ($children as $child) {
            $parentId = $child[$parentField];
            unset($child[$parentField]);
            if (array_key_exists($parentId, $result)) {
                $currentResult = $result[$parentId][$targetField];
                $result[$parentId][$targetField] = $assembler($child + $additionalField, $currentResult);
            }
        }

        return $result;
    }

    /**
     * @param array $rows
     * @param array $objects
     * @param string $field
     * @return array
     */
    protected function convertIdsToObjects(array $rows, array $objects, string $field): array
    {
        $result = array_filter($rows, function($row) use ($field, $objects) {
            $id = $row[$field];
            return array_key_exists($id, $objects);
        });

        return array_map(function($row) use ($field, $objects) {
            $id = $row[$field];
            $row[$field] = $objects[$id];
            return $row;
        }, $result);
    }

    /**
     * @param array $entries
     * @param string $subField
     * @return array
     */
    protected function sortSubFieldsByOrder(array $entries, string $subField): array
    {
        return array_map(function(array $entry) use ($subField) {
            usort($entry[$subField], function (array $a, array $b) {
                return $a[static::FIELD_ORDER] - $b[static::FIELD_ORDER];
            });
            return $entry;
        }, $entries);
    }
}

