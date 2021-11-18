<?php

namespace App\Test\Functional\Controller\Api;

use App\Tests\TestEnv\TestUtils;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/',
            TestUtils::getHeader(),
            [],
            TestUtils::getAdminAuth()
        );

        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue($response->isRedirect());
    }
}

