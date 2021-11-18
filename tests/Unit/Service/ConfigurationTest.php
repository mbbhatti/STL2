<?php

namespace App\Tests\Unit\Service;

use App\Service\Configuration;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\WebBaseTestCase;
use ReflectionClass;

class ConfigurationTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $class = 'App\Service\Configuration';
        $reflectedClass = new ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testGet()
    {
        $entityManager = $this->entityManager;
        $configurationRepository = $entityManager->getRepository(\App\Entity\Configuration::class);
        $configuration = new Configuration($configurationRepository);
        $content = $configuration->get(1);

        $compare = new WebBaseTestCase();
        $compare->assertHasAttributes(['itemsWithoutDay', 'mandatoryItems'], $content);
        $this->assertCount(0, $configuration->get(10));
    }

    public function tesGetIds()
    {
        $entityManager = $this->entityManager;
        $configurationRepository = $entityManager->getRepository(\App\Entity\Configuration::class);
        $configuration = new Configuration($configurationRepository);

        $reflection = new ReflectionClass(get_class($configuration));
        $method = $reflection->getMethod('getIds');
        $method->setAccessible(true);
        $content = $method->invokeArgs($configuration, [1]);
        $this->assertGreaterThan(0, $content);
    }
}

