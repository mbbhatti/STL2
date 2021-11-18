<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Answer;
use App\Repository\AnswerRepository;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\TestUtils;
use App\Tests\TestEnv\WebBaseTestCase;

class AnswerTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $response = new AnswerRepository($this->registry);
        $this->assertNotEmpty($response);
    }

    public function testGetByUser()
    {
        $answer = $this->entityManager->getRepository(Answer::class)->getByUser(951);
        $compare = new WebBaseTestCase();
        $compare->assertHasAttributes(['answer', 'answer_id'], $answer[0]);

        $answer = $this->entityManager->getRepository(Answer::class)->getByUser(1122);
        $this->assertCount(0, $answer);
    }

    public function testGetByStudy()
    {
        $answer = $this->entityManager->getRepository(Answer::class)->getByStudy(1);
        $compare = new WebBaseTestCase();
        $compare->assertHasAttributes(['answer', 'answer_id'], $answer[0]);

        $answer = $this->entityManager->getRepository(Answer::class)->getByStudy(1122);
        $this->assertCount(0, $answer);
    }

    public function testGetIdsByStudy()
    {
        $answer = $this->entityManager->getRepository(Answer::class)->getIdsByStudy(1);
        $compare = new WebBaseTestCase();
        $compare->assertHasAttributes(['complete_answer_id', 'answer_id'], $answer[0]);

        $answer = $this->entityManager->getRepository(Answer::class)->getIdsByStudy(1122);
        $this->assertCount(0, $answer);
    }

    public function testAddWrongUser()
    {
        $answer = TestUtils::getAnswer($this->entityManager);
        $response = $answer->add(
            'test',
            1234,
            123456,
            1,
            null,
            null,
            null
        );
        $this->assertNull($response);
    }

    public function testAddWrongStudy()
    {
        $answer = TestUtils::getAnswer($this->entityManager);
        $response = $answer->add(
            'test',
            1234,
            1105,
            123456,
            null,
            null,
            null
        );
        $this->assertNull($response);
    }

    public function testAddUpdate()
    {
        $answer = TestUtils::getAnswer($this->entityManager);
        $lastId = $answer->add(
            'test',
            1,
            1105,
            1,
            null,
            null,
            null
        );

        $this->assertGreaterThan(0, $lastId);
        $updated = $this->entityManager->getRepository(Answer::class)->updateAnswer('test', 1, $lastId, null);
        $this->assertTrue($updated);

        $answer = $this->entityManager->getRepository(Answer::class)->find($lastId);
        $this->entityManager->remove($answer);
        $this->entityManager->flush();
    }
}

