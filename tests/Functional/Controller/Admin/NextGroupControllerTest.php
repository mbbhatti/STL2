<?php

namespace App\Test\Functional\Controller\Api;

use DomainException;
use App\Tests\TestEnv\TestUtils;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class NextGroupControllerTest extends WebTestCase
{
    public function testImportView()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/nextGroup/import',
            TestUtils::getHeader(),
            [],
            TestUtils::getAdminAuth()
        );
        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testDoNextGroupImportWithoutFile()
    {
        $flash = new FlashBag();
        $message = 'A csv file is required in multipart form data named "file".';
        $flash->add('danger', $message);

        $client = static::createClient();
        $client->request(
            'POST',
            '/nextGroup/import',
            TestUtils::getHeader(),
            [],
            TestUtils::getAdminAuth()
        );

        $response = $client->getResponse();
        $this->assertTrue($response->isOk());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertSame($message, $flash->get('danger')[0]);
    }

    public function testDoNextGroupImportWrongExtension()
    {
        $flash = new FlashBag();
        $message = 'Uploaded file was not a text or csv file.';
        $flash->add('danger', $message);

        $file = new UploadedFile(
            'tests/assets/nextGroupCsvInsert.csv',
            'nextGroupCsvInsert.csv',
            'foo'
        );

        $client = static::createClient();
        $client->request(
            'POST',
            '/nextGroup/import',
            TestUtils::getHeader(),
            ['file' => $file],
            TestUtils::getAdminAuth()
        );

        $response = $client->getResponse();
        $this->assertTrue($response->isOk());
        $this->assertSame($message, $flash->get('danger')[0]);
    }

    public function testDoNextGroupImport()
    {
        $flash = new FlashBag();
        $message = '12 rows inserted.';
        $flash->add('success', $message);

        $file = new UploadedFile(
            'tests/assets/nextGroupCsvInsert.csv',
            'nextGroupCsvInsert.csv',
            'text/csv'
        );

        $client = static::createClient();
        $client->request(
            'POST',
            '/nextGroup/import',
            TestUtils::getHeader(),
            ['file' => $file],
            TestUtils::getAdminAuth()
        );

        $response = $client->getResponse();
        $this->assertTrue($response->isOk());
        $this->assertSame($message, $flash->get('success')[0]);

        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->assertNull(TestUtils::removeLastNextGroupData($entityManager));
    }

    public function testDoNextGroupImportException()
    {
        try {
            $file = new UploadedFile(
                'tests/assets/nextGroupCsvInsertNoGroup.csv',
                'nextGroupCsvInsertNoGroup.csv',
                'text/csv'
            );

            $client = static::createClient();
            $client->request(
                'POST',
                '/nextGroup/import',
                TestUtils::getHeader(),
                ['file' => $file],
                TestUtils::getAdminAuth()
            );
            $this->assertTrue($client->getResponse()->isOk());
        } catch (DomainException $e) {
            $expected = 'Group column not found in csv file.';
            $this->assertSame($expected, $e->getMessage());
        }
    }
}

