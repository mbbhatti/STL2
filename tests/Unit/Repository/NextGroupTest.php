<?php

namespace App\Tests\Unit\Repository;

use App\Entity\NextGroup;
use App\Repository\NextGroupRepository;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\TestUtils;
use App\Tests\TestEnv\WebBaseTestCase;

class NextGroupTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $nextGroup = new NextGroupRepository($this->registry);
        $this->assertNotEmpty($nextGroup);
    }

    public function testCheckIfExists()
    {
        $nextGroup = $this->entityManager->getRepository(NextGroup::class)->checkIfExists();
        $testAttributes = new WebBaseTestCase();
        $testAttributes->assertHasAttributes(['id', 'group_name'], $nextGroup);
    }

    public function testAddUpdate()
    {
        $nextGroupService = TestUtils::getNextGroup($this->entityManager);
        $name = 'test';

        $lastId = $nextGroupService->add($name);
        $this->assertGreaterThan(0, $lastId);

        $updateUsedId = $this->entityManager->getRepository(NextGroup::class)->updateUsedById($lastId);
        $this->assertEquals($lastId, $updateUsedId);

        $updateInvalid = $this->entityManager->getRepository(NextGroup::class)->updateInvalidByName($name);
        $this->assertTrue($updateInvalid);

        $updateInvalid = $this->entityManager->getRepository(NextGroup::class)->updateInvalidByName('one');
        $this->assertFalse($updateInvalid);

        $nextGroup = $this->entityManager->getRepository(NextGroup::class)->find($lastId);
        $this->entityManager->remove($nextGroup);
        $this->entityManager->flush();
    }
}

