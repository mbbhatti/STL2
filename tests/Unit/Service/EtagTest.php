<?php

namespace App\Tests\Unit\Service;

use App\Repository\MetaQuestionRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\GroupRepository;
use App\Repository\FreeInputQuestionRepository;
use App\Repository\ChoiceQuestionRepository;
use App\Repository\ChoiceRepository;
use App\Service\Etag;
use App\Tests\TestEnv\EntityManagerTestCase;

class EtagTest extends EntityManagerTestCase
{
    public function testGetEtag()
    {
        $metaQuestion = new MetaQuestionRepository($this->registry);
        $questionnaire = new QuestionnaireRepository($this->registry);
        $group = new GroupRepository($this->registry);
        $freeInputQuestion = new FreeInputQuestionRepository($this->registry);
        $choiceQuestion = new ChoiceQuestionRepository($this->registry);
        $choice = new ChoiceRepository($this->registry);

        $etag = new Etag(
            $metaQuestion,
            $questionnaire,
            $group,
            $freeInputQuestion,
            $choiceQuestion,
            $choice
        );
        $response = $etag->getEtag();
        $this->assertTrue(is_string($response));
    }
}

