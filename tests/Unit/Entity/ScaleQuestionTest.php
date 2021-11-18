<?php

namespace App\Tests\Unit\Entity;

use App\Entity\ScaleQuestion;
use App\Entity\MetaQuestion;
use App\Tests\TestEnv\TestUtils;
use PHPUnit\Framework\TestCase;

class ScaleQuestionTest extends TestCase
{
    public function testId()
    {
        $scaleQuestion = new ScaleQuestion();
        TestUtils::setProperty($scaleQuestion, 'id', 1);
        $this->assertEquals(1, $scaleQuestion->getId());
    }

    public function testVersion()
    {
        $scaleQuestion = new ScaleQuestion();
        $scaleQuestion->setVersion('2');
        $this->assertEquals('2', $scaleQuestion->getVersion());
    }

    public function testMinText()
    {
        $scaleQuestion = new ScaleQuestion();
        $scaleQuestion->setMinText('not.at.all');
        $this->assertEquals('not.at.all', $scaleQuestion->getMinText());
    }

    public function testMinValue()
    {
        $scaleQuestion = new ScaleQuestion();
        $scaleQuestion->setMinValue('0');
        $this->assertEquals('0', $scaleQuestion->getMinValue());
    }

    public function testMaxText()
    {
        $scaleQuestion = new ScaleQuestion();
        $scaleQuestion->setMaxText('very.satisfied');
        $this->assertEquals('very.satisfied', $scaleQuestion->getMaxText());
    }

    public function testMaxValue()
    {
        $scaleQuestion = new ScaleQuestion();
        $scaleQuestion->setMaxValue('10');
        $this->assertEquals('10', $scaleQuestion->getMaxValue());
    }

    public function testAnswerId()
    {
        $scaleQuestion = new ScaleQuestion();
        $scaleQuestion->setAnswerId('4012');
        $this->assertEquals('4012', $scaleQuestion->getAnswerId());
    }

    public function testMetaQuestion()
    {
        $scaleQuestion = new ScaleQuestion();
        $metaQuestion = new MetaQuestion(1);
        $scaleQuestion->setMetaQuestion($metaQuestion);
        $this->assertEquals($metaQuestion, $scaleQuestion->getMetaQuestion());
    }
}

