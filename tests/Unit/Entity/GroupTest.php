<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Configuration;
use App\Entity\Feature;
use App\Entity\Group;
use App\Entity\User;
use App\Tests\TestEnv\TestUtils;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
    public function testConstructor()
    {
        $class = 'App\Entity\Group';
        $reflectedClass = new \ReflectionClass($class);
        $constructor = $reflectedClass->getConstructor();
        $this->assertEquals($class, $constructor->class);
    }

    public function testId()
    {
        $group = new Group();
        TestUtils::setProperty($group, 'id', 1);
        $this->assertEquals(1, $group->getId());
    }

    public function testName()
    {
        $group = new Group();
        $group->setName('acupressure_recommendations');
        $this->assertEquals('acupressure_recommendations', $group->getName());
        $this->assertNotEquals('recommendations', $group->getName());
    }

    public function testVersion()
    {
        $group = new Group();
        $group->setVersion('2');
        $this->assertEquals('2', $group->getVersion());
        $this->assertNotEquals('20', $group->getVersion());
    }

    public function testUser()
    {
        $group = new Group();
        $user = new User(1);
        $group->addUser($user);
        $this->assertEquals(true, $group->removeUser($user));
        $this->assertEmpty($group->getUsers());

    }

    public function testConfigurations()
    {
        $group = new Group();
        $configurations = ['1', '2'];
        $group->setConfigurations(new ArrayCollection($configurations));
        $this->assertEquals($configurations, $group->getConfigurations());

        $configuration = new Configuration(1);
        $group->addConfiguration($configuration);
        $this->assertEquals(true, $group->removeConfiguration($configuration));
    }

    public function testFeatures()
    {
        $group = new Group();
        $features = ['1', '2'];
        $group->setFeatures(new ArrayCollection($features));
        $this->assertEquals($features, $group->getFeatures());

        $feature = new Feature(1);
        $group->addFeature($feature);
        $this->assertEquals(true, $group->removeFeature($feature));
    }
}

