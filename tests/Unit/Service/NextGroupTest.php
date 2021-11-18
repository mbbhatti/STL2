<?php

namespace App\Tests\Unit\Service;

use DomainException;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\TestUtils;
use ReflectionClass;
use UnderflowException;

class NextGroupTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $class = 'App\Service\NextGroup';
        $reflectedClass = new ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testConsume()
    {
        $nextGroup = TestUtils::getNextGroup($this->entityManager);
        $this->entityManager->beginTransaction();
        $this->assertIsString($nextGroup->consume());
        $this->entityManager->rollBack();
    }

    public function testConsumeException()
    {
        $nextGroup = TestUtils::getNextGroup($this->entityManager);
        $this->entityManager->beginTransaction();
        TestUtils::updateInvalidByName($this->entityManager);
        $this->expectException(UnderflowException::class);
        $this->expectExceptionMessage('No next group available.');
        $nextGroup->consume();
        $this->entityManager->rollBack();
    }

    public function testInvalidate()
    {
        $nextGroup = TestUtils::getNextGroup($this->entityManager);
        $this->assertNull($nextGroup->invalidate('acupressure'));
    }

    public function testImportCSVInvalidGroups()
    {
        $nextGroup = TestUtils::getNextGroup($this->entityManager);
        $csvContent = file_get_contents('tests/assets/nextGroupCsvInsertInvalidGroups.csv');
        try {
            $nextGroup->importCSV($csvContent);
        } catch (DomainException $e) {
            $expected = 'The following groups to import don\'t exist yet: bar, foo';
            $this->assertSame($expected, $e->getMessage());
        }
    }

    public function testImportCSVNoGroupException()
    {
        $nextGroup = TestUtils::getNextGroup($this->entityManager);
        $csvContent = file_get_contents('tests/assets/nextGroupCsvInsertNoGroup.csv');
        try {
            $nextGroup->importCSV($csvContent);
        } catch (DomainException $e) {
            $expected = 'Group column not found in csv file.';
            $this->assertSame($expected, $e->getMessage());
        }
    }

    public function testImportCSV()
    {
        $nextGroup = TestUtils::getNextGroup($this->entityManager);
        $csvContent = file_get_contents('tests/assets/nextGroupCsvInsert.csv');
        $this->entityManager->beginTransaction();
        $response = $nextGroup->importCSV($csvContent);
        $this->entityManager->rollBack();
        $this->assertSame(12, $response, 'Rows inserted');
    }

    public function testValidateGroupNames()
    {
        $nextGroup = TestUtils::getNextGroup($this->entityManager);
        $reflection = new ReflectionClass(get_class($nextGroup));
        $method = $reflection->getMethod('validateGroupNames');
        $method->setAccessible(true);
        $groupNames = [
            "acupressure",
            "acupressure",
            "recommendations",
            "recommendations",
            "acupressure_recommendations",
            "acupressure_recommendations",
            "bar",
            "recommendations",
            "acupressure_recommendations",
            "acupressure",
            "acupressure",
            "acupressure",
            "foo"
        ];
        $message = 'The following groups to import don\'t exist yet: bar, foo';
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($message);
        $method->invokeArgs($nextGroup, [$groupNames]);
    }
}

