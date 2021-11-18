<?php

namespace App\Tests\Unit\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GeneratePasswordHashCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:generate-password-hash');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['string' => 'testing']);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('password', $output);
    }
}

