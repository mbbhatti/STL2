<?php

namespace App\Tests\Unit\Entity;

use DateTime;
use App\Entity\Answer;
use App\Entity\Questionnaire;
use App\Entity\User;
use App\Entity\Study;
use App\Tests\TestEnv\TestUtils;
use PHPUnit\Framework\TestCase;

class StudyTest extends TestCase
{
    public function testConstructor()
    {
        $class = 'App\Entity\Study';
        $reflectedClass = new \ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testId()
    {
        $study = new Study();
        TestUtils::setProperty($study, 'id', 1);
        $this->assertEquals(1, $study->getId());
    }

    public function testName()
    {
        $study = new Study();
        $study->setName('ACUD-2');
        $this->assertEquals('ACUD-2', $study->getName());
        $this->assertNotEquals('test', $study->getName());
    }

    public function testVersion()
    {
        $study = new Study();
        $study->setVersion('0');
        $this->assertEquals('0', $study->getVersion());
        $this->assertNotEquals('1', $study->getVersion());
    }

    public function testPublished()
    {
        $study = new Study();
        $current = new DateTime();
        $study->setPublished($current);
        $this->assertEquals($current, $study->getPublished());

        $date = new DateTime('2019-07-16 07:52:00');
        $study->setPublished($date);
        $this->assertEquals($date, $study->getPublished());
    }

    public function testUser()
    {
        $study = new Study();
        $user = new User(1);
        $study->addUser($user);
        $this->assertEquals(true, $study->removeUser($user));
        $this->assertNotEquals('object', $study->getUsers());
    }

    public function testAnswer()
    {
        $study = new Study();
        $answer = new Answer(1);
        $study->addAnswer($answer);
        $this->assertEquals(true, $study->removeAnswer($answer));
        $this->assertNotEquals('object', $study->getAnswers());
    }

    public function testQuestionnaires()
    {
        $study = new Study();
        $questionnaire = new Questionnaire(1);
        $study->addQuestionnaire($questionnaire);
        $this->assertEquals(true, $study->removeQuestionnaire($questionnaire));
        $this->assertNotEquals('object', $study->getQuestionnaires());
    }
}

