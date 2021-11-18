<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Configuration;
use App\Tests\TestEnv\TestUtils;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function testId()
    {
        $configuration = new Configuration();
        TestUtils::setProperty($configuration, 'id', 1);
        $this->assertEquals(1, $configuration->getId());
    }

    public function testVersion()
    {
        $configuration = new Configuration();
        $configuration->setVersion('0');
        $this->assertEquals('0', $configuration->getVersion());
        $this->assertNotEquals('1221', $configuration->getVersion());
    }

    public function testKey()
    {
        $configuration = new Configuration();
        $configuration->setKey('itemsWithoutDay');
        $this->assertEquals('itemsWithoutDay', $configuration->getKey());
        $this->assertNotEquals('graphPeriodActivities', $configuration->getKey());
    }

    public function testValue()
    {
        $configuration = new Configuration();
        $configuration->setValue('7000');
        $this->assertEquals('7000', $configuration->getValue());
        $this->assertNotEquals('6999', $configuration->getValue());
    }
}

