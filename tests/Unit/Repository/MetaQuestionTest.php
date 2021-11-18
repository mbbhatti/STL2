<?php

namespace App\Tests\Unit\Repository;

use App\Entity\MetaQuestion;
use App\Repository\MetaQuestionRepository;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\WebBaseTestCase;

class MetaQuestionTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $metaQuestion = new MetaQuestionRepository($this->registry);
        $this->assertNotEmpty($metaQuestion);
    }

    public function testGet()
    {
        $metaQuestions = $this->entityManager->getRepository(MetaQuestion::class)->get();
        $this->assertSame(0, $metaQuestions[0]['order']);
        $this->assertNotSame('xyz', $metaQuestions[0]['label']);

        $testAttributes = new WebBaseTestCase();
        $testAttributes->assertHasAttributes(['id', 'headline', 'label'], $metaQuestions[0]);
    }

    public function testGetByGroup()
    {
        $questionGroupsOne = $this->entityManager->getRepository(MetaQuestion::class)->getByGroup(1);
        $this->assertArrayHasKey('meta_question', $questionGroupsOne[0]);
        $this->assertGreaterThan(0, $questionGroupsOne);

        $questionGroupsTwo = $this->entityManager->getRepository(MetaQuestion::class)->getByGroup(2);
        $this->assertCount(count($questionGroupsOne), $questionGroupsTwo);
    }
}

