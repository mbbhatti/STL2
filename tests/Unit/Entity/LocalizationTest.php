<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Localization;
use App\Tests\TestEnv\TestUtils;
use PHPUnit\Framework\TestCase;

class LocalizationTest extends TestCase
{
    public function testId()
    {
        $localization = new Localization();
        TestUtils::setProperty($localization, 'id', 1);
        $this->assertEquals(1, $localization->getId());
    }

    public function testVersion()
    {
        $localization = new Localization();
        $localization->setVersion('0');
        $this->assertEquals('0', $localization->getVersion());
        $this->assertNotEquals('121', $localization->getVersion());
    }

    public function testLocal()
    {
        $localization = new Localization();
        $localization->setLocale('de-de');
        $this->assertEquals('de-de', $localization->getLocale());
        $this->assertNotEquals('pt-br', $localization->getLocale());
    }

    public function testKey()
    {
        $localization = new Localization();
        $localization->setKey('moderate');
        $this->assertEquals('moderate', $localization->getKey());
        $this->assertNotEquals('severe', $localization->getKey());
    }

    public function testText()
    {
        $localization = new Localization();
        $localization->setText('Diversos');
        $this->assertEquals('Diversos', $localization->getText());
        $this->assertNotEquals('Alemanha', $localization->getText());
    }
}

