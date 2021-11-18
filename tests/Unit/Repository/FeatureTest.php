<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Feature;
use App\Repository\FeatureRepository;
use App\Tests\TestEnv\EntityManagerTestCase;

class FeatureTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $feature = new FeatureRepository($this->registry);
        $this->assertNotEmpty($feature);
    }

    public function testGetNamesByGroup()
    {
        $feature = $this->entityManager->getRepository(Feature::class)->getNamesByGroup(1);
        $this->assertSame('acupressure', $feature[0]['name']);

        $feature = $this->entityManager->getRepository(Feature::class)->getNamesByGroup(2);
        $this->assertSame('recommendations', $feature[0]['name']);

        $feature = $this->entityManager->getRepository(Feature::class)->getNamesByGroup(3);
        $this->assertGreaterThan(0, $feature);
    }
}

