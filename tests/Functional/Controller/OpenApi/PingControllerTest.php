<?php

namespace App\Test\Functional\Controller\OpenApi;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PingControllerTest extends WebTestCase
{
    public function testPingUp()
    {
        $client = static::createClient();

        $client->request('GET', '/openapi/v1/ping');
        $response = $client->getResponse();
        $code = $response->getStatusCode();
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $code);
        $this->assertTrue($response->isOk());
    }
}

