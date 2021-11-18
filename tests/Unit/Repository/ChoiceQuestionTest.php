<?php

namespace App\Tests\Unit\Repository;

use App\Entity\ChoiceQuestion;
use App\Repository\ChoiceQuestionRepository;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\WebBaseTestCase;

class ChoiceQuestionTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $choiceQuestion = new ChoiceQuestionRepository($this->registry);
        $this->assertNotEmpty($choiceQuestion);
    }

    public function testGet()
    {
        $choiceQuestion = $this->entityManager->getRepository(ChoiceQuestion::class)->get();
        $compare = new WebBaseTestCase();
        $compare->assertHasAttributes(['id', 'type', 'meta_question', 'answer_id'], $choiceQuestion[0]);
    }

    public function testGetChoiceQuestionChoice()
    {
        $choiceQuestions = $this->entityManager->getRepository(ChoiceQuestion::class)->getChoiceQuestionChoice();
        $this->assertGreaterThan(0, $choiceQuestions);

        $testAttributes = new WebBaseTestCase();
        $testAttributes->assertHasAttributes(['choice_question', 'choice'], $choiceQuestions[0]);
    }
}

