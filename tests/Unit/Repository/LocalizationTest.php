<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Localization;
use App\Repository\LocalizationRepository;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\WebBaseTestCase;

class LocalizationTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $localization = new LocalizationRepository($this->registry);
        $this->assertNotEmpty($localization);
    }

    public function testGet()
    {
        $localization = $this->entityManager->getRepository(Localization::class)->get();

        $this->assertGreaterThan(0, $localization);
        $this->assertSame('de-de', $localization[0]['locale']);
        $this->assertNotSame('xyz', $localization[0]['locale']);

        $testAttributes = new WebBaseTestCase();
        $testAttributes->assertHasAttributes(['key', 'locale', 'text'], $localization[0]);
    }
}

