<?php

namespace App\Tests\TestEnv;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class WebBaseTestCase
 * @package App\Tests\TestEnv
 */
class WebBaseTestCase extends WebTestCase
{
    /**
     * @param $expected
     * @param $actual
     */
    public function assertHasAttributes($expected, $actual)
    {
        $diff = array_diff($expected, array_keys($actual));
        $message = 'Missing keys: '
            . json_encode(array_values($diff))
            . ' Actual keys: '
            . json_encode(array_keys($actual));
        $this->assertEmpty($diff, $message);
    }
}

