<?php

namespace App\Tests\Unit\Service;

use DateTime;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\TestUtils;
use UnderflowException;
use UnexpectedValueException;
use InvalidArgumentException;
use BadFunctionCallException;

class UserTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $class = 'App\Service\User';
        $reflectedClass = new ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testCheckWrongAuth()
    {
        $user = TestUtils::getUser($this->entityManager);
        $request = new Request();
        $request->headers->set('User-Auth', '');
        $response = $user->checkAuth($request);
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertSame('{"ok":false}', $response->getContent());
    }

    public function testCheckAuth()
    {
        $user = TestUtils::getUser($this->entityManager);
        $request = new Request();
        $request->headers->set('User-Auth', TestUtils::getAuthUser());
        $response = $user->checkAuth($request);
        $this->assertNull($response);
    }

    public function testCreate()
    {
        $user = TestUtils::getUser($this->entityManager);
        $this->entityManager->beginTransaction();
        $content = $user->create();
        $this->assertNotNull($content);
        $this->entityManager->rollBack();
    }

    public function testCreateException()
    {
        $user = TestUtils::getUser($this->entityManager);
        $this->entityManager->beginTransaction();
        TestUtils::updateInvalidByName($this->entityManager);
        $this->expectException(UnderflowException::class);
        $this->expectExceptionMessage('No next group available.');
        $user->create();
        $this->entityManager->rollBack();
    }

    public function testCreateInvalidInsertOptions()
    {
        $key = bin2hex(random_bytes(32));
        $hash = password_hash($key, PASSWORD_BCRYPT);

        $user = TestUtils::getUser($this->entityManager);
        $response = $user->insert($hash, 123456, 1);
        $this->assertNull($response);

        $response = $user->insert($hash, 3, 123456);
        $this->assertNull($response);
    }

    public function testConsumeGroup()
    {
        $user = TestUtils::getUser($this->entityManager);
        $reflection = new ReflectionClass(get_class($user));
        $method = $reflection->getMethod('consumeGroup');
        $method->setAccessible(true);
        $content = $method->invoke($user);
        $this->assertGreaterThanOrEqual(0, $content);
        TestUtils::rollbackNextGroupInvalidUsed();
    }

    public function testConsumeGroupException()
    {
        $user = TestUtils::getUser($this->entityManager);
        $reflection = new ReflectionClass(get_class($user));
        $method = $reflection->getMethod('consumeGroup');
        $method->setAccessible(true);

        $this->entityManager->beginTransaction();
        TestUtils::updateGroupName($this->entityManager);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Next group resulted in invalid group name.');

        $method->invoke($user);
        $this->entityManager->rollBack();
    }

    public function testGeneratePassword()
    {
        $user = TestUtils::getUser($this->entityManager);
        $reflection = new ReflectionClass(get_class($user));
        $method = $reflection->getMethod('generatePassword');
        $method->setAccessible(true);
        $content = $method->invoke($user);
        $this->assertIsString($content);
    }

    public function testGetCurrentStudy()
    {
        $user = TestUtils::getUser($this->entityManager);
        $reflection = new ReflectionClass(get_class($user));
        $method = $reflection->getMethod('getCurrentStudy');
        $method->setAccessible(true);
        $content = $method->invoke($user);
        $this->assertGreaterThan(0, $content);
    }

    public function testGetCurrentStudyException()
    {
        $user = TestUtils::getUser($this->entityManager);
        $reflection = new ReflectionClass(get_class($user));
        $method = $reflection->getMethod('getCurrentStudy');
        $method->setAccessible(true);

        $this->entityManager->beginTransaction();
        TestUtils::updateStudy($this->entityManager);
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('No current study available.');
        $method->invoke($user);
        $this->entityManager->rollBack();
    }

    public function testGet()
    {
        $user = TestUtils::getUser($this->entityManager);
        $invalidAuths = [null, '', '1_abc', '1'];
        foreach ($invalidAuths as $invalidId) {
            try {
                $user->get($invalidId);
            } catch (InvalidArgumentException $e) {
                $this->assertSame('No user found with given auth.', $e->getMessage());
            }
        }

        TestUtils::setLeftAt();
        $content = $user->get(TestUtils::getAuthUser());
        TestUtils::rollbackLeftAt();
        $this->assertArrayHasKey('id', $content);
        $this->assertSame(1105, $content['id']);
    }

    public function testGetLast()
    {
        $user = TestUtils::getUser($this->entityManager);
        try {
            $user->getLast();
        } catch (BadFunctionCallException $e) {
            $expected = 'The method "get" must be called before a last user can be fetched.';
            $this->assertSame($expected, $e->getMessage());
        }
        $this->entityManager->beginTransaction();
        $auth = $user->create();
        $content = $user->get($auth);
        $expected = $user->getLast();
        $this->entityManager->rollBack();
        $this->assertSame($expected, $content, 'The last user should be the one from the previous get call.');
    }

    public function testToISO8601UTCDateTime()
    {
        $user = TestUtils::getUser($this->entityManager);
        $reflection = new ReflectionClass(get_class($user));
        $method = $reflection->getMethod('toISO8601UTCDateTime');
        $method->setAccessible(true);
        $date = new DateTime();
        $stringDate = $date->format('Y-m-d H:i:s');
        $content = $method->invokeArgs($user,[$stringDate]);
        $this->assertIsString($content);
    }

    public function testLeaveStudy()
    {
        $user = TestUtils::getUser($this->entityManager);
        $this->entityManager->beginTransaction();
        $auth = $user->create();
        $content = $user->get($auth);
        $this->assertSame(null, $content['left_at'], 'A newly created user should be in the study.');

        $left = $user->leaveStudy($content['id']);
        $this->assertTrue($left, 'A not left user should be able to leave the study.');

        $left = $user->leaveStudy($content['id']);
        $this->assertFalse($left, 'An already left user should not be able to leave the study again.');
        $this->entityManager->rollBack();
    }
}

