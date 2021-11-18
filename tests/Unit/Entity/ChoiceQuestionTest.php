<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Choice;
use App\Entity\ChoiceQuestion;
use App\Entity\MetaQuestion;
use Doctrine\Common\Collections\ArrayCollection;
use App\Tests\TestEnv\TestUtils;
use PHPUnit\Framework\TestCase;

class ChoiceQuestionTest extends TestCase
{
    public function testConstructor()
    {
        $class = 'App\Entity\ChoiceQuestion';
        $reflectedClass = new \ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testId()
    {
        $choiceQuestion = new ChoiceQuestion();
        TestUtils::setProperty($choiceQuestion, 'id', 1);
        $this->assertEquals(1, $choiceQuestion->getId());
    }

    public function testType()
    {
        $choiceQuestion = new ChoiceQuestion();
        $choiceQuestion->setType('radio');
        $this->assertEquals('radio', $choiceQuestion->getType());
    }

    public function testVersion()
    {
        $choiceQuestion = new ChoiceQuestion();
        $choiceQuestion->setVersion('3');
        $this->assertEquals('3', $choiceQuestion->getVersion());
    }

    public function testAnswerId()
    {
        $choiceQuestion = new ChoiceQuestion();
        $choiceQuestion->setAnswerId('1010');
        $this->assertEquals('1010', $choiceQuestion->getAnswerId());
    }

    public function testMetaQuestion()
    {
        $choiceQuestion = new ChoiceQuestion();
        $metaQuestion = new MetaQuestion(1);
        $choiceQuestion->setMetaQuestion($metaQuestion);
        $this->assertEquals($metaQuestion, $choiceQuestion->getMetaQuestion());
    }

    public function testChoices()
    {
        $choiceQuestion = new ChoiceQuestion();
        $choices = ['1','2'];
        $choiceQuestion->setChoices(new ArrayCollection($choices));
        $this->assertEquals($choices, $choiceQuestion->getChoices());

        $choice = new Choice(1);
        $choiceQuestion->addChoice($choice);
        $this->assertEquals(true, $choiceQuestion->removeChoice($choice));
    }
}

