<?php

namespace App\Tests\Unit\Entity;

use DateTime;
use App\Entity\Answer;
use App\Entity\Group;
use App\Entity\Study;
use App\Entity\User;
use App\Tests\TestEnv\TestUtils;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testConstructor()
    {
        $class = 'App\Entity\User';
        $reflectedClass = new \ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testId()
    {
        $user = new User();
        TestUtils::setProperty($user, 'id', 1);
        $this->assertEquals(1, $user->getId());
    }

    public function testVersion()
    {
        $user = new User();
        $user->setVersion('0');
        $this->assertEquals('0', $user->getVersion());
        $this->assertNotEquals('100', $user->getVersion());
    }

    public function testKeyHash()
    {
        $user = new User();
        $keyHash = '$2y$10$k6hiCgRnK3YMoJtZLbZri.7Z6xbq4X6Nd4Ngy6ci8hbOQNyG00/72';
        $user->setKeyHash($keyHash);
        $this->assertEquals($keyHash, $user->getKeyHash());
    }

    public function testLeftAt()
    {
        $user = new User();
        $current = new DateTime();
        $user->setLeftAt($current);
        $this->assertEquals($current, $user->getLeftAt());

        $date = new DateTime('2019-07-16 07:52:00');
        $user->setLeftAt($date);
        $this->assertEquals($date, $user->getLeftAt());
    }

    public function testGroup()
    {
        $user = new User();
        $group = new Group(1);
        $user->setGroup($group);
        $this->assertEquals($group, $user->getGroup());
        $this->assertNotEquals('object', $user->getGroup());
    }

    public function testStudy()
    {
        $user = new User();
        $study = new Study(1);
        $user->setStudy($study);
        $this->assertEquals($study, $user->getStudy());
        $this->assertNotEquals('object', $user->getStudy());
    }

    public function testAnswer()
    {
        $user = new User();
        $answer = new Answer(1);
        $user->addAnswer($answer);
        $this->assertEquals(true, $user->removeAnswer($answer));
        $this->assertNotEquals('object', $user->getAnswers());
    }
}

