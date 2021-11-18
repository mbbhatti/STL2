<?php

namespace App\Tests\Unit\Service;

use App\Service\Answer AS AnswerService;
use App\Entity\Answer;
use App\Entity\User;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\TestUtils;
use ReflectionClass;

class AnswerTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $class = 'App\Service\Answer';
        $reflectedClass = new ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testGet()
    {
        $entityManager = $this->entityManager;
        $answerRepository = $entityManager->getRepository(Answer::class);
        $userRepository = $entityManager->getRepository(User::class);

        $reader = TestUtils::getReader($entityManager);
        $answer = new AnswerService($answerRepository, $userRepository, $reader, $entityManager);
        $content = $answer->get(342);
        $this->assertArrayHasKey('id', $content[0]);
        $this->assertCount(0, $answer->get(1122));
    }

    public function testWriteCSV()
    {
        $entityManager = $this->entityManager;
        $answerRepository = $entityManager->getRepository(Answer::class);
        $userRepository = $entityManager->getRepository(User::class);
        $reader = TestUtils::getReader($entityManager);
        $answer = new AnswerService($answerRepository, $userRepository, $reader, $entityManager);

        $handle = fopen('php://memory', 'w');
        $answer->writeCSV($handle, 1);
        fseek($handle, 0);
        $content = stream_get_contents($handle);
        fclose($handle);

        $this->assertNotNull($content);

        $handle = fopen('php://memory', 'w');
        $answer->writeCSV($handle, 11);
        fseek($handle, 0);
        $content = stream_get_contents($handle);
        fclose($handle);

        $csvReportRows = explode("\n", $content);
        $data = explode(";", $csvReportRows[0]);
        $this->assertSame("User", $data[0]);
    }

    public function testInsertUserAnswers()
    {
        $entityManager = $this->entityManager;
        $answerRepository = $entityManager->getRepository(Answer::class);
        $userRepository = $entityManager->getRepository(User::class);

        $reader = TestUtils::getReader($entityManager);
        $answer = new AnswerService($answerRepository, $userRepository, $reader, $entityManager);

        $entityManager->beginTransaction();
        $answerJson = json_decode(file_get_contents('tests/assets/AnswerInsert_1.json'), true)['answers'];
        $contentInsert = $answer->insertUserAnswers($answerJson, 723, 1);
        $this->assertNull($contentInsert);

        $answerJson = json_decode(file_get_contents('tests/assets/AnswerInsert_2.json'), true)['answers'];
        $contentUpdate = $answer->insertUserAnswers($answerJson, 723, 1);
        $this->assertNull($contentUpdate);
        $entityManager->rollBack();
    }

    public function testInsertWrongUserStudy()
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
}

