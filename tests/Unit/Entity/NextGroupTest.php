<?php

namespace App\Tests\Unit\Entity;

use App\Entity\NextGroup;
use App\Tests\TestEnv\TestUtils;
use PHPUnit\Framework\TestCase;

class NextGroupTest extends TestCase
{
    public function testId()
    {
        $nextGroup = new NextGroup();
        TestUtils::setProperty($nextGroup, 'id', 1);
        $this->assertEquals(1, $nextGroup->getId());
    }

    public function testGroupName()
    {
        $nextGroup = new NextGroup();
        $nextGroup->setGroupName('recommendations');
        $this->assertEquals('recommendations', $nextGroup->getGroupName());
        $this->assertNotEquals('acupressure', $nextGroup->getGroupName());
    }

    public function testUsed()
    {
        $nextGroup = new NextGroup();
        $nextGroup->setUsed('1');
        $this->assertEquals('1', $nextGroup->getUsed());
        $this->assertNotEquals('0', $nextGroup->getUsed());
    }

    public function testInvalid()
    {
        $nextGroup = new NextGroup();
        $nextGroup->setInvalid('0');
        $this->assertEquals('0', $nextGroup->getInvalid());
        $this->assertNotEquals('01', $nextGroup->getInvalid());
    }
}

