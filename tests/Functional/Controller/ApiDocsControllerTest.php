<?php

namespace App\Test\Functional\Controller;

use App\Tests\TestEnv\WebBaseTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiDocsControllerTest extends WebTestCase
{
    public function testApiDocs()
    {
        $client = static::createClient();

        $client->request('GET', '/api-docs');
        $response = $client->getResponse();
        $code = $response->getStatusCode();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(200, $code);
        $this->assertTrue($client->getResponse()->isOk());

        $apiResult = new WebBaseTestCase();
        $apiResult->assertHasAttributes(['info', 'servers', 'tags', 'paths'], $content);
    }

    public function testOptionsWildcard()
    {
        $client = $this->createClient();

        $client->request('OPTIONS', '/api-docs');
        $this->assertTrue($client->getResponse()->isOk(), 'OPTIONS requests should succeed with valid URLs.');

        $client->request('OPTIONS', '/asd');
        $this->assertFalse($client->getResponse()->isOk(), 'OPTIONS requests should succeed with invalid URLs.');
    }
}

