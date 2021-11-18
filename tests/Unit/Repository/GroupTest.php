<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Group;
use App\Repository\GroupRepository;
use App\Tests\TestEnv\EntityManagerTestCase;

class GroupTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $group = new GroupRepository($this->registry);
        $this->assertNotEmpty($group);
    }

    public function testGetNames()
    {
        $groups = $this->entityManager->getRepository(Group::class)->getNames();
        $this->assertGreaterThan(0, $groups);
        $this->assertSame('acupressure', $groups[0]['name']);
        $this->assertNotSame('abc', $groups[0]['name']);
    }

    public function testGetIdsByName()
    {
        $id = $this->entityManager->getRepository(Group::class)->getIdsByName('test');
        $this->assertNull($id);

        $id = $this->entityManager->getRepository(Group::class)->getIdsByName('acupressure');
        $this->assertArrayHasKey('id', $id);
    }
}

