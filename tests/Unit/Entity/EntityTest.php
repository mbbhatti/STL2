<?php

namespace App\Tests\Unit\Entity;

use DateTime;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testCreatedAt()
    {
        $user = new User();
        $current = new DateTime();
        $user->setCreatedAt($current);
        $this->assertEquals($current, $user->getCreatedAt());

        $date = new DateTime('2016-09-14 13:41:06');
        $user->setCreatedAt($date);
        $this->assertEquals($date, $user->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $user = new User();
        $current = new DateTime();
        $user->setUpdatedAt($current);
        $this->assertEquals($current, $user->getUpdatedAt());

        $date = new DateTime('2017-02-06 15:21:40');
        $user->setUpdatedAt($date);
        $this->assertEquals($date, $user->getUpdatedAt());
    }

    public function testDeletedAt()
    {
        $user = new User();
        $current = new DateTime();
        $user->setDeletedAt($current);
        $this->assertEquals($current, $user->getDeletedAt());
    }
}

