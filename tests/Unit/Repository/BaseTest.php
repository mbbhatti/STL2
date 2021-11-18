<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Group;
use App\Entity\Questionnaire;
use App\Repository\BaseRepository;
use App\Tests\TestEnv\EntityManagerTestCase;
use DateTime;

class BaseTest extends EntityManagerTestCase
{
    public function testConstructor()
    {
        $questionnaire = new BaseRepository($this->registry, Questionnaire::class);
        $this->assertNotEmpty($questionnaire);
    }

    public function testGetEtag()
    {
        $date = new DateTime();
        $this->entityManager->beginTransaction();
        $group = $this->entityManager->getRepository(Group::class)->find(2);
        $group->setUpdatedAt($date);
        $this->entityManager->persist($group);
        $this->entityManager->flush();

        $object = new BaseRepository($this->registry, Group::class);
        $this->assertEquals(date('Y-m-d', $date->getTimestamp()), date('Y-m-d',$object->getEtag()));
        $this->entityManager->rollBack();
    }
}

