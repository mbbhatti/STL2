<?php

namespace App\Test\Functional\Controller\Api;

use App\Tests\TestEnv\WebBaseTestCase;
use App\Tests\TestEnv\TestUtils;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testGetUser()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/v1/user',
            TestUtils::getHeader(),
            [],
            TestUtils::getApiAuthWithUserAuth()
        );

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $apiResult = new WebBaseTestCase();
        $apiResult->assertHasAttributes(['left_at', 'features', 'configuration'], $content);
    }

    public function testRegisterUser()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/user',
            TestUtils::getHeader(),
            [],
            TestUtils::getApiAuth()
        );

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $apiResult = new WebBaseTestCase();
        $apiResult->assertHasAttributes(['auth', 'features', 'configuration'], $content);

        $id = explode('_', $content['auth'], 2)[0];
        TestUtils::deleteLastUser($id);
    }

    public function testRegisterUserUnexpectedValueException()
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        TestUtils::updateGroupName($entityManager);
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/user',
            TestUtils::getHeader(),
            [],
            TestUtils::getApiAuth()
        );
        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertSame('{"ok":false}', $response->getContent());
        TestUtils::rollbackGroups();
        TestUtils::rollbackNextGroupInvalid();
    }

    public function testRegisterUserUnderflowException()
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        TestUtils::updateInvalidByName($entityManager);

        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/user',
            TestUtils::getHeader(),
            [],
            TestUtils::getApiAuth()
        );
        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertSame('{"ok":false}', $response->getContent());
        TestUtils::rollbackNextGroupInvalid();
    }

    public function testRegisterDeleteUser()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/user',
            TestUtils::getHeader(),
            [],
            TestUtils::getApiAuth()
        );

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $apiResult = new WebBaseTestCase();
        $apiResult->assertHasAttributes(['auth', 'features', 'configuration'], $content);

        $client->request(
            'DELETE',
            '/api/v1/user',
            TestUtils::getHeader(),
            [],
            [
                'PHP_AUTH_USER' => 'api',
                'PHP_AUTH_PW' => 'api',
                'HTTP_USER_AUTH' => $content['auth']
            ]
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $id = explode('_', $content['auth'], 2)[0];
        TestUtils::deleteLastUser($id);
    }
}

