<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GeneratePasswordHashCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:generate-password-hash';

    protected function configure()
    {
        $this
            ->setDescription('A CLI command to generate password hash')
            ->addArgument('string', InputArgument::OPTIONAL, 'Input')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $string = $input->getArgument('string');

        if ($string) {
            $hash = password_hash($string, PASSWORD_BCRYPT, ['cost' => 13]);
            $io->success(sprintf('Your password hash: %s', $hash));
        }

        return 0;
    }
}

