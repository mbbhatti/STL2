<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Choice;
use App\Entity\ChoiceQuestion;
use App\Entity\FreeInputQuestion;
use App\Entity\Group;
use App\Entity\MetaQuestion;
use App\Entity\ScaleQuestion;
use App\Tests\TestEnv\TestUtils;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class MetaQuestionTest extends TestCase
{
    public function testConstructor()
    {
        $class = 'App\Entity\MetaQuestion';
        $reflectedClass = new \ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testId()
    {
        $metaQuestion = new MetaQuestion();
        TestUtils::setProperty($metaQuestion, 'id', 1);
        $this->assertEquals(1, $metaQuestion->getId());
    }

    public function testName()
    {
        $metaQuestion = new MetaQuestion();
        $metaQuestion->setName('1000');
        $this->assertEquals('1000', $metaQuestion->getName());
        $this->assertNotEquals('1001', $metaQuestion->getName());
    }

    public function testLabel()
    {
        $metaQuestion = new MetaQuestion();
        $metaQuestion->setLabel('your.age');
        $this->assertEquals('your.age', $metaQuestion->getLabel());
        $this->assertNotEquals('yoga', $metaQuestion->getLabel());
    }

    public function testVersion()
    {
        $metaQuestion = new MetaQuestion();
        $metaQuestion->setVersion('5');
        $this->assertEquals('5', $metaQuestion->getVersion());
        $this->assertNotEquals('2', $metaQuestion->getVersion());
    }

    public function testHeadline()
    {
        $metaQuestion = new MetaQuestion();
        $metaQuestion->setHeadline('during.the.previous');
        $this->assertEquals('during.the.previous', $metaQuestion->getHeadline());
        $this->assertNotEquals('meets.the.following.criteria', $metaQuestion->getHeadline());
    }

    public function testPublished()
    {
        $metaQuestion = new MetaQuestion();
        $metaQuestion->setPublished('1');
        $this->assertEquals('1', $metaQuestion->getPublished());
        $this->assertNotEquals('0', $metaQuestion->getPublished());
    }

    public function testOrder()
    {
        $metaQuestion = new MetaQuestion();
        $metaQuestion->setOrder('1400');
        $this->assertEquals('1400', $metaQuestion->getOrder());
        $this->assertNotEquals('1', $metaQuestion->getOrder());
    }

    public function testChoice()
    {
        $metaQuestion = new MetaQuestion();
        $choice = new Choice(1);
        $metaQuestion->addChoice($choice);
        $this->assertEquals(true, $metaQuestion->removeChoice($choice));
        $this->assertNotEquals('object', $metaQuestion->getChoice());
    }

    public function testChoiceQuestions()
    {
        $metaQuestion = new MetaQuestion();
        $choiceQuestion = new ChoiceQuestion(1);
        $metaQuestion->addChoiceQuestion($choiceQuestion);
        $this->assertEquals(true, $metaQuestion->removeChoiceQuestion($choiceQuestion));
        $this->assertNotEquals('object', $metaQuestion->getChoiceQuestions());
    }

    public function testFreeInputQuestions()
    {
        $metaQuestion = new MetaQuestion();
        $freeInputQuestion = new FreeInputQuestion(1);
        $metaQuestion->addFreeInputQuestion($freeInputQuestion);
        $this->assertEquals(true, $metaQuestion->removeFreeInputQuestion($freeInputQuestion));
        $this->assertNotEquals('object', $metaQuestion->getFreeInputQuestions());
    }

    public function testScaleQuestions()
    {
        $metaQuestion = new MetaQuestion();
        $scaleQuestion = new ScaleQuestion(1);
        $metaQuestion->addScaleQuestion($scaleQuestion);
        $this->assertEquals(true, $metaQuestion->removeScaleQuestion($scaleQuestion));
        $this->assertNotEquals('object', $metaQuestion->getScaleQuestions());
    }

    public function testGroups()
    {
        $metaQuestion = new MetaQuestion();
        $groups = [1, 2];
        $metaQuestion->setGroups(new ArrayCollection($groups));
        $this->assertEquals($groups, $metaQuestion->getGroups());
        $this->assertNotEquals(3, $metaQuestion->getGroups());

        $group = new Group(1);
        $metaQuestion->addGroup($group);
        $this->assertEquals(true, $metaQuestion->removeGroup($group));
    }
}

