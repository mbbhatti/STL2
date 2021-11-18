<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Choice;
use App\Entity\MetaQuestion;
use App\Tests\TestEnv\TestUtils;
use PHPUnit\Framework\TestCase;

class ChoiceTest extends TestCase
{
    public function testId()
    {
        $choice = new Choice();
        TestUtils::setProperty($choice, 'id', 1);
        $this->assertEquals(1, $choice->getId());
    }

    public function testVersion()
    {
        $choice = new Choice();
        $choice->setVersion('7');
        $this->assertEquals('7', $choice->getVersion());
    }

    public function testName()
    {
        $choice = new Choice();
        $choice->setName('1010_1');
        $this->assertEquals('1010_1', $choice->getName());
    }

    public function testText()
    {
        $choice = new Choice();
        $choice->setText('your.size');
        $this->assertEquals('your.size', $choice->getText());
    }

    public function testOrder()
    {
        $choice = new Choice();
        $choice->setOrder('200');
        $this->assertEquals('200', $choice->getOrder());
    }

    public function testType()
    {
        $choice = new Choice();
        $choice->setType('choice');
        $this->assertEquals('choice', $choice->getType());
    }

    public function testAnswerId()
    {
        $choice = new Choice();
        $choice->setAnswerId('2022');
        $this->assertEquals('2022', $choice->getAnswerId());
    }

    public function testAnswerValue()
    {
        $choice = new Choice();
        $choice->setAnswerValue('6');
        $this->assertEquals('6', $choice->getAnswerValue());
    }

    public function testMin()
    {
        $choice = new Choice();
        $choice->setMin('140');
        $this->assertEquals('140', $choice->getMin());
    }

    public function testMax()
    {
        $choice = new Choice();
        $choice->setMax('110');
        $this->assertEquals('110', $choice->getMax());
    }

    public function testDefault()
    {
        $choice = new Choice();
        $choice->setDefault('0');
        $this->assertEquals('0', $choice->getDefault());
    }

    public function testMetaQuestion()
    {
        $choice = new Choice();
        $metaQuestion = new MetaQuestion(1);
        $choice->setMetaQuestion($metaQuestion);
        $this->assertEquals($metaQuestion, $choice->getMetaQuestion());
    }
}

