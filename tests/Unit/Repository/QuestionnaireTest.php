<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Questionnaire;
use App\Repository\QuestionnaireRepository;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\WebBaseTestCase;

class QuestionnaireTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $questionnaire = new QuestionnaireRepository($this->registry);
        $this->assertNotEmpty($questionnaire);
    }

    public function testGet()
    {
        $questionnaires = $this->entityManager->getRepository(Questionnaire::class)->get(true);
        $this->assertSame('baseline', $questionnaires[0]['moment']);
        $this->assertNotSame('abc.test', $questionnaires[0]['label']);

        $testAttributes = new WebBaseTestCase();
        $testAttributes->assertHasAttributes(['id', 'study', 'order'], $questionnaires[0]);

        $questionnaires = $this->entityManager->getRepository(Questionnaire::class)->get(false);
        $this->assertGreaterThan(0, $questionnaires);
    }

    public function testGetMetaQuestions()
    {
        $questionnaires = $this->entityManager->getRepository(Questionnaire::class)->getMetaQuestions();
        $this->assertSame(1, $questionnaires[0]['questionnaire']);
        $this->assertArrayHasKey('meta_question', $questionnaires[0]);
    }
}

