<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:line-output', description: 'Command to return a string with the value "Hello {variable}"')]
final class LineOutputCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('variable', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $variable = $input->getArgument('variable');

        try {
            while (true) {
                $output->writeln(sprintf('Hello %s', $variable));
                sleep(1);
            }
        } catch (\Throwable $e) {
            $output->writeln(sprintf('Error: %s', $e->getMessage()));

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}