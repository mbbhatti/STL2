<?php

namespace App\Tests\Unit\Entity;

use App\Entity\MetaQuestion;
use App\Entity\Study;
use App\Entity\Questionnaire;
use App\Tests\TestEnv\TestUtils;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class QuestionnaireTest extends TestCase
{
    public function testConstructor()
    {
        $class = 'App\Entity\Questionnaire';
        $reflectedClass = new \ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testId()
    {
        $questionnaire = new Questionnaire();
        TestUtils::setProperty($questionnaire, 'id', 1);
        $this->assertEquals(1, $questionnaire->getId());
    }

    public function testVersion()
    {
        $questionnaire = new Questionnaire();
        $questionnaire->setVersion('7');
        $this->assertEquals('7', $questionnaire->getVersion());
    }

    public function testName()
    {
        $questionnaire = new Questionnaire();
        $questionnaire->setName('Baseline');
        $this->assertEquals('Baseline', $questionnaire->getName());
    }

    public function testLabel()
    {
        $questionnaire = new Questionnaire();
        $questionnaire->setLabel('general.questions.about.yourself');
        $this->assertEquals('general.questions.about.yourself', $questionnaire->getLabel());
    }

    public function testOrder()
    {
        $questionnaire = new Questionnaire();
        $questionnaire->setOrder('700');
        $this->assertEquals('700', $questionnaire->getOrder());
    }

    public function testMoment()
    {
        $questionnaire = new Questionnaire();
        $questionnaire->setMoment('baseline');
        $this->assertEquals('baseline', $questionnaire->getMoment());
    }

    public function testStudy()
    {
        $questionnaire = new Questionnaire();
        $study = new Study(1);
        $questionnaire->setStudy($study);
        $this->assertEquals($study, $questionnaire->getStudy());
    }

    public function testMetaQuestions()
    {
        $questionnaire = new Questionnaire();
        $metaQuestions = ['1', '2'];
        $questionnaire->setMetaQuestions(new ArrayCollection($metaQuestions));
        $this->assertEquals($metaQuestions, $questionnaire->getMetaQuestions());

        $metaQuestion = new MetaQuestion(1);
        $questionnaire->addMetaQuestion($metaQuestion);
        $this->assertEquals(true, $questionnaire->removeMetaQuestion($metaQuestion));
    }
}

