<?php

namespace App\Test\Functional\Controller\Api;

use App\Tests\TestEnv\TestUtils;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionControllerTest extends WebTestCase
{
    public function testQuestions()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/v1/question',
            TestUtils::getHeader(),
            [],
            TestUtils::getApiAuthWithUserAuth()
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('questionnaires', $content);
    }

    public function testQuestionsNoneMatch()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/v1/question',
            TestUtils::getHeader(),
            [],
            [
                'PHP_AUTH_USER' => 'api',
                'PHP_AUTH_PW' => 'api',
                'HTTP_USER_AUTH' => '1105_650d143a9495d0bd22006a0b5d305b6897eb75c74dcf44990fb67598246c3b8d',
                'HTTP_IF_NONE_MATCH' => '1580724532'
            ]
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('questionnaires', $content);
    }

    public function testQuestionsWrongNoneMatch()
    {
        $noneMatch = TestUtils::updateMaxDate();
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/v1/question',
            TestUtils::getHeader(),
            [],
            [
                'PHP_AUTH_USER' => 'api',
                'PHP_AUTH_PW' => 'api',
                'HTTP_USER_AUTH' => '1105_650d143a9495d0bd22006a0b5d305b6897eb75c74dcf44990fb67598246c3b8d',
                'HTTP_IF_NONE_MATCH' => $noneMatch
            ]
        );

        $response = $client->getResponse();
        $this->assertEquals(304, $response->getStatusCode());

        $content = $response->getContent();
        $this->assertSame('', $content, 'The body should be empty on correct ETag');
    }
}

