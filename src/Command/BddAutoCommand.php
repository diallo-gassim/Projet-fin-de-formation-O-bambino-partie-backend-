<?php

namespace App\Command;

use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'bdd-auto',
    description: 'Add a short description for your command',
)]
class BddAutoCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $process = new Process(['php', 'bin/console', 'doctrine:schema:drop', '--full-database', '--force']);
        $process->run();
        if (!$process->isSuccessful()) {
        throw new \RuntimeException($process->getErrorOutput());
        }
        $output->writeln($process->getOutput());


        
        $process = Process::fromShellCommandline('rm -rf migrations/*');
        $process->run();
        if (!$process->isSuccessful()) {
        throw new \RuntimeException($process->getErrorOutput());
        }
        $output->writeln($process->getOutput());

        $process = new Process(['php', 'bin/console', 'make:migration']);
        $process->run();
        if (!$process->isSuccessful()) {
        throw new \RuntimeException($process->getErrorOutput());
        }
        $output->writeln($process->getOutput());

        $process = new Process(['php', 'bin/console', 'doctrine:migrations:migrate']);
        $process->setInput("yes\n");
        $process->run();
        if (!$process->isSuccessful()) {
        throw new \RuntimeException($process->getErrorOutput());
        }
        $output->writeln($process->getOutput());

        $process = new Process(['php', 'bin/console', 'doctrine:fixtures:load']);
        $process->setInput("yes\n");
        $process->run();
        if (!$process->isSuccessful()) {
        throw new \RuntimeException($process->getErrorOutput());
        }
        $output->writeln($process->getOutput());

        
        
        // Affichez la sortie de la commande
        $output->write($process->getOutput());
        
        $output->writeln('created by jérém :)');

        return Command::SUCCESS;
    }
}
