<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Answer;
use App\Entity\User;
use App\Entity\Study;
use App\Tests\TestEnv\TestUtils;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    public function testId()
    {
        $answer = new Answer();
        TestUtils::setProperty($answer, 'id', 1);
        $this->assertEquals(1, $answer->getId());
    }

    public function testVersion()
    {
        $answer = new Answer();
        $answer->setVersion('10');
        $this->assertEquals('10', $answer->getVersion());
    }

    public function testAnswer()
    {
        $answer = new Answer();
        $answer->setAnswer('Apr 10, 2018');
        $this->assertEquals('Apr 10, 2018', $answer->getAnswer());
    }

    public function testAnswerId()
    {
        $answer = new Answer();
        $answer->setAnswerId('2040');
        $this->assertEquals('2040', $answer->getAnswerId());
    }

    public function testCycle()
    {
        $answer = new Answer();
        $answer->setCycle('4');
        $this->assertEquals('4', $answer->getCycle());
    }

    public function testDay()
    {
        $answer = new Answer();
        $answer->setDay('5');
        $this->assertEquals('5', $answer->getDay());
    }

    public function testAppVersion()
    {
        $answer = new Answer();
        $answer->setAppVersion('Version 1.0.1 (121)');
        $this->assertEquals('Version 1.0.1 (121)', $answer->getAppVersion());
    }

    public function testUser()
    {
        $answer = new Answer();
        $user = new User(1);
        $answer->setUser($user);
        $this->assertEquals($user, $answer->getUser());
    }

    public function testStudy()
    {
        $answer = new Answer();
        $study = new Study(1);
        $answer->setStudy($study);
        $this->assertEquals($study, $answer->getStudy());
    }
}

