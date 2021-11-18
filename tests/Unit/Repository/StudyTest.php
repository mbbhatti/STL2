<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Study;
use App\Repository\StudyRepository;
use App\Tests\TestEnv\EntityManagerTestCase;
use App\Tests\TestEnv\WebBaseTestCase;

class StudyTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $study = new StudyRepository($this->registry);
        $this->assertNotEmpty($study);
    }

    public function testGet()
    {
        $studies = $this->entityManager->getRepository(Study::class)->get();
        $this->assertSame(1, $studies[0]['id']);
        $this->assertNotSame('test-study', $studies[0]['name']);

        $testAttributes = new WebBaseTestCase();
        $testAttributes->assertHasAttributes(['id', 'name'], $studies[0]);
    }

    public function testIsStudyValid()
    {
        $study = $this->entityManager->getRepository(Study::class)->isStudyValid(1);
        $this->assertTrue($study);

        $study = $this->entityManager->getRepository(Study::class)->isStudyValid(11);
        $this->assertFalse($study);
    }

    public function testGetLatestIds()
    {
        $study = $this->entityManager->getRepository(Study::class)->getLatestIds();
        $this->assertArrayHasKey('id', $study);
        $this->assertSame(1, $study['id']);
        $this->assertNotEquals(10, $study['id']);
    }
}

