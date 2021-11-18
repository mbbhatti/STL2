<?php

namespace App\Tests\Unit\Repository;

use App\Entity\FreeInputQuestion;
use App\Repository\FreeInputQuestionRepository;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\WebBaseTestCase;

class FreeInputQuestionTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $freeInputQuestion = new FreeInputQuestionRepository($this->registry);
        $this->assertNotEmpty($freeInputQuestion);
    }

    public function testGet()
    {
        $freeInputQuestion = $this->entityManager->getRepository(FreeInputQuestion::class)->get();
        $this->assertGreaterThan(0, $freeInputQuestion);
        $this->assertArrayHasKey('meta_question', $freeInputQuestion[0]);

        $testAttributes = new WebBaseTestCase();
        $testAttributes->assertHasAttributes(
            ['id', 'type', 'text', 'answer_id', 'min', 'max'],
            $freeInputQuestion[0]
        );
    }
}

