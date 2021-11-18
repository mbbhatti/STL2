<?php

namespace App\Tests\Unit\Service;

use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\TestUtils;

class ReaderTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $class = 'App\Service\Reader';
        $reflectedClass = new \ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testRead()
    {
        $reader = TestUtils::getReader($this->entityManager);

        $content = $reader->read(1,1, 'de-de');
        $this->assertArrayHasKey('questionnaires', $content);

        $content = $reader->read(0,1, 'da-da');
        $this->assertCount(0, $content['questionnaires'], 'Invalid group');

        $content = $reader->read(1,0, null);
        $this->assertCount(0, $content['questionnaires'], 'Invalid study');
    }
}

