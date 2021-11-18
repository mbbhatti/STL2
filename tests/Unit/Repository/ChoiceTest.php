<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Choice;
use App\Repository\ChoiceRepository;
use App\Tests\TestEnv\EntityManagerTestCase;

class ChoiceTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $choice = new ChoiceRepository($this->registry);
        $this->assertNotEmpty($choice);
    }

    public function testGet()
    {
        $choices = $this->entityManager->getRepository(Choice::class)->get(true);
        $this->assertArrayHasKey('order', $choices[0]);

        $choices = $this->entityManager->getRepository(Choice::class)->get(false);
        $this->assertArrayNotHasKey('order', $choices[0]);
    }
}

