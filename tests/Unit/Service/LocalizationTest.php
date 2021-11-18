<?php

namespace App\Tests\Unit\Service;

use App\Service\Localization;
use App\Tests\TestEnv\EntityManagerTestCase;
use ReflectionClass;

class LocalizationTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $class = 'App\Service\Localization';
        $reflectedClass = new ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testGetSupportedLocales()
    {
        $entityManager = $this->entityManager;
        $localizationRepository = $entityManager->getRepository(\App\Entity\Localization::class);
        $localization = new Localization($localizationRepository);

        $content = $localization->getSupportedLocales();
        $this->assertGreaterThan(0, $content);
    }

    public function testGetBestLocale()
    {
        $entityManager = $this->entityManager;
        $localizationRepository = $entityManager->getRepository(\App\Entity\Localization::class);
        $localization = new Localization($localizationRepository);

        $actual = $localization->getBestLocale('de-de; q=0.5, en-gb; q=0.7, en; q=0.2', ['de', 'en-gb', 'en']);
        $this->assertSame('en-gb', $actual, 'The highest prioritized language should return.');

        $actual = $localization->getBestLocale('en; fr', ['de', 'en-gb', 'en', 'fr']);
        $this->assertSame('en-gb', $actual, 'The highest prioritized language return of same quality.');

        $actual = $localization->getBestLocale('en', ['de', 'en-gb', 'en', 'fr']);
        $this->assertSame('en-gb', $actual, 'Only locale is accepted and returned.');

        $actual = $localization->getBestLocale('en; fr', ['de', 'da']);
        $this->assertSame('de-de', $actual, 'Only unsupported locales accepted and default return.');

        $actual = $localization->getBestLocale('en', ['de', 'da']);
        $this->assertSame('de-de', $actual, 'Unsupported locale is accepted, default return.');

        $actual = $localization->getBestLocale('en', ['da', 'en-gb']);
        $this->assertSame('en-gb', $actual, 'Short form is accepted and only long form is supported.');

        $actual = $localization->getBestLocale(null, ['da', 'en-gb']);
        $this->assertSame('de-de', $actual, 'If nothing is given, the default should be returned.');
    }

    public function testGet()
    {
        $entityManager = $this->entityManager;
        $localizationRepository = $entityManager->getRepository(\App\Entity\Localization::class);
        $localization = new Localization($localizationRepository);

        $expected = 'foo1';
        $content = $localization->get('de-de', $expected);
        $this->assertSame($expected, $content);

        $expected = 'foo666';
        $actual = $localization->get('da-da', 'foo666');
        $this->assertSame($expected, $actual);

        $expected = 'foo666';
        $actual = $localization->get('en-gb', 'foo666');
        $this->assertSame($expected, $actual);

        $expected = 'foo666';
        $actual = $localization->get(null, 'foo666');
        $this->assertSame($expected, $actual);
    }

    public function testLocalizationMap()
    {
        $entityManager = $this->entityManager;
        $localizationRepository = $entityManager->getRepository(\App\Entity\Localization::class);
        $localization = new Localization($localizationRepository);

        $reflection = new ReflectionClass(get_class($localization));
        $method = $reflection->getMethod('getLocalizationsMap');
        $method->setAccessible(true);
        $content = $method->invoke($localization);

        $this->assertArrayHasKey('de-de', $content);
        $this->assertNotNull($content);
    }
}

