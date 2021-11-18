<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Configuration;
use App\Repository\ConfigurationRepository;
use App\Tests\TestEnv\EntityManagerTestCase;

class ConfigurationTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $configuration = new ConfigurationRepository($this->registry);
        $this->assertNotEmpty($configuration);
    }

    public function testGetByIds()
    {
        $ids = [1122,2211];
        $configuration = $this->entityManager->getRepository(Configuration::class)->getByIds($ids);
        $this->assertCount(0, $configuration, 'No configuration found');

        $ids = [1,2211];
        $configuration = $this->entityManager->getRepository(Configuration::class)->getByIds($ids);
        $this->assertCount(1, $configuration, 'One configuration found');

        $ids = [1,2];
        $configuration = $this->entityManager->getRepository(Configuration::class)->getByIds($ids);
        $this->assertCount(2, $configuration, 'All configuration found');
    }

    public function testGetIdsByGroup()
    {
        $data = $this->entityManager->getRepository(Configuration::class)->getIdsByGroup(1);
        $this->assertGreaterThan(0, $data, 'Get group id 1 detail');
        $this->assertArrayHasKey('configurationId', $data[0]);

        $data = $this->entityManager->getRepository(Configuration::class)->getIdsByGroup(10);
        $this->assertCount(0, $data, 'No value found');
    }
}

