<?php

namespace App\Tests\Unit\Entity;

use App\Entity\MetaQuestion;
use App\Entity\FreeInputQuestion;
use App\Tests\TestEnv\TestUtils;
use PHPUnit\Framework\TestCase;

class FreeInputQuestionTest extends TestCase
{
    public function testId()
    {
        $freeInputQuestion = new FreeInputQuestion();
        TestUtils::setProperty($freeInputQuestion, 'id', 1);
        $this->assertEquals(1, $freeInputQuestion->getId());
    }

    public function testVersion()
    {
        $freeInputQuestion = new FreeInputQuestion();
        $freeInputQuestion->setVersion('2');
        $this->assertEquals('2', $freeInputQuestion->getVersion());
    }

    public function testText()
    {
        $freeInputQuestion = new FreeInputQuestion();
        $freeInputQuestion->setText('your.age.years');
        $this->assertEquals('your.age.years', $freeInputQuestion->getText());
    }

    public function testType()
    {
        $freeInputQuestion = new FreeInputQuestion();
        $freeInputQuestion->setType('integer');
        $this->assertEquals('integer', $freeInputQuestion->getType());
    }

    public function testAnswerId()
    {
        $freeInputQuestion = new FreeInputQuestion();
        $freeInputQuestion->setAnswerId('2110');
        $this->assertEquals('2110', $freeInputQuestion->getAnswerId());
    }

    public function testMin()
    {
        $freeInputQuestion = new FreeInputQuestion();
        $freeInputQuestion->setMin('18');
        $this->assertEquals('18', $freeInputQuestion->getMin());
    }

    public function testMax()
    {
        $freeInputQuestion = new FreeInputQuestion();
        $freeInputQuestion->setMax('34');
        $this->assertEquals('34', $freeInputQuestion->getMax());
    }

    public function testMetaQuestion()
    {
        $freeInputQuestion = new FreeInputQuestion();
        $metaQuestion = new MetaQuestion(1);
        $freeInputQuestion->setMetaQuestion($metaQuestion);
        $this->assertEquals($metaQuestion, $freeInputQuestion->getMetaQuestion());
    }
}

