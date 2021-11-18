<?php

namespace App\Test\Functional\Controller\Api;

use App\Tests\TestEnv\TestUtils;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CsvControllerTest extends WebTestCase
{
    public function testCsvExport()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/csvExport',
            TestUtils::getHeader(),
            [],
            TestUtils::getAdminAuth()
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDoCsvExportInvalid()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/csvExport',
            ['headers' => ['Content-Type' => 'application/json'], 'study' => 999],
            [],
            TestUtils::getAdminAuth()
        );

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());

        $content = $response->getContent();
        $this->assertSame('Study not found.', $content, 'Indicate wrong study id');
    }

    public function testDoCsvExportValid()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/csvExport',
            ['headers' => ['Content-Type' => 'application/json'], 'study' => 1],
            [],
            TestUtils::getAdminAuth()
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
}

