<?php

namespace App\Tests\Unit\Repository;

use App\Entity\ScaleQuestion;
use App\Repository\ScaleQuestionRepository;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\WebBaseTestCase;

class ScaleQuestionTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $scaleQuestion = new ScaleQuestionRepository($this->registry);
        $this->assertNotEmpty($scaleQuestion);
    }

    public function testGet()
    {
        $scaleQuestions = $this->entityManager->getRepository(ScaleQuestion::class)->get();
        $this->assertSame('16', $scaleQuestions[0]['meta_question']);
        $this->assertNotSame(0, $scaleQuestions[0]['answer_id']);

        $testAttributes = new WebBaseTestCase();
        $testAttributes->assertHasAttributes(
            ['id', 'min_text', 'min_value', 'max_text', 'max_value'],
            $scaleQuestions[0]
        );
    }
}

