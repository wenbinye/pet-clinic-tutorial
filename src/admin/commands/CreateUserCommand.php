<?php

namespace winwin\petClinic\admin\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "console")
            ->setName('create:user')
            // the short description shown while running "php console list"
            ->setDescription('Creates a new user.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the new user')
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'The password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $password = $input->getOption('password');
        $output->writeln("<info>create user '{$name}' with password '{$password}'</info>");
    }
}
