<?php

namespace App\Test\Functional\Controller\Api;

use App\Tests\TestEnv\TestUtils;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnswerControllerTest extends WebTestCase
{
    public function testGetAnswers()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/v1/answer',
            TestUtils::getHeader(),
            [],
            TestUtils::getApiAuthWithUserAuth()
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('answers', $content);
    }

    public function testPostAnswersWrongJsonRequest()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/answer',
            TestUtils::getHeader(),
            [],
            TestUtils::getApiAuthWithUserAuth(),
            'Not valid json request'
        );

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());

        $expected = '{"ok":false,"error":"Body with valid json and answers array required."}';
        $content = $response->getContent();
        $this->assertSame($expected, $content, 'An error message should be delivered.');
    }

    public function testPostAnswersWrongElement()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/answer',
            TestUtils::getHeader(),
            [],
            TestUtils::getApiAuthWithUserAuth(),
            TestUtils::getWrongAnswerData()
        );

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertFalse($content['ok'], 'Ok should be false when posting invalid data.');
        $this->assertSame('Answer element not valid.', $content['error']);
    }

    public function testPostAnswers()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/answer',
            TestUtils::getHeader(),
            [],
            TestUtils::getApiAuthWithUserAuth(),
            TestUtils::getCorrectAnswerData()
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertTrue($content['ok'], 'Ok should be false when posting invalid data.');

        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->assertNull(TestUtils::removeLastAnswersData($entityManager));
    }
}

