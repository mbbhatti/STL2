<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Feature;
use App\Tests\TestEnv\TestUtils;
use PHPUnit\Framework\TestCase;

class FeatureTest extends TestCase
{
    public function testId()
    {
        $feature = new Feature();
        TestUtils::setProperty($feature, 'id', 1);
        $this->assertEquals(1, $feature->getId());
    }

    public function testName()
    {
        $feature = new Feature();
        $feature->setName('acupressure');
        $this->assertEquals('acupressure', $feature->getName());
        $this->assertNotEquals('recommendations', $feature->getName());
    }

    public function testVersion()
    {
        $feature = new Feature();
        $feature->setVersion('0');
        $this->assertEquals('0', $feature->getVersion());
        $this->assertNotEquals('190', $feature->getVersion());
    }
}

