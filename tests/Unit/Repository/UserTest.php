<?php

namespace App\Tests\Unit\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\TestUtils;
use App\Tests\TestEnv\WebBaseTestCase;

class UserTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $user = new UserRepository($this->registry);
        $this->assertNotEmpty($user);
    }

    public function testGetGroupNamesByStudy()
    {
        $user = $this->entityManager->getRepository(User::class)->getGroupNamesByStudy(1);
        $this->assertSame('acupressure_recommendations', $user[1]);
        $this->assertNotSame('recommendations', $user[1]);

        $user = $this->entityManager->getRepository(User::class)->getGroupNamesByStudy(987);
        $this->assertEmpty($user);
    }

    public function testGetGroupsByStudy()
    {
        $user = $this->entityManager->getRepository(User::class)->getGroupsByStudy(1);
        $this->assertCount(12, $user);

        $user = $this->entityManager->getRepository(User::class)->getGroupsByStudy(321);
        $this->assertEmpty($user);
    }

    public function testGetById()
    {
        $user = $this->entityManager->getRepository(User::class)->getById(1001);
        $content = new WebBaseTestCase();
        $content->assertHasAttributes(['id', 'group', 'study'], $user);

        $user = $this->entityManager->getRepository(User::class)->getGroupsByStudy(9999);
        $this->assertEmpty($user);
    }

    public function testCreateWrongGroupStudy()
    {
        $key = bin2hex(random_bytes(32));
        $hash = password_hash($key, PASSWORD_BCRYPT);

        $user = TestUtils::getUser($this->entityManager);
        $response = $user->insert($hash, 123456, 1);
        $this->assertNull($response);

        $response = $user->insert($hash, 3, 123456);
        $this->assertNull($response);
    }

    public function testUpdateLeftAtById()
    {
        $key = bin2hex(random_bytes(32));
        $hash = password_hash($key, PASSWORD_BCRYPT);

        $user = TestUtils::getUser($this->entityManager);
        $lastId = $user->insert($hash, 3, 1);
        $this->assertGreaterThan(0, $lastId);

        $user = $this->entityManager->getRepository(User::class)->updateLeftAtById($lastId);
        $this->assertTrue($user);

        $user = $this->entityManager->getRepository(User::class)->find($lastId);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}

