<?php

namespace FeBrauer\TYPO3Installer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class LaunchCommand extends Command
{
    protected static $defaultName = 'launch';

    protected function configure()
    {
        $this->setDescription('Launch a new TYPO3 project.')
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the project');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int // Updated to include : int return type
    {
        // Predefined TYPO3 versions
        $versions = ['12.4', '12.3', '12.2', '12.1', '12.0'];

        // Ask for TYPO3 version
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Please select the TYPO3 version',
            $versions,
            0
        );
        $question->setErrorMessage('Version %s is invalid.');

        $version = $helper->ask($input, $output, $question);
        $output->writeln('You have just selected: ' . $version);

        // Ask for the project name (if not provided as an argument)
        $projectName = $input->getArgument('name');
        if (!$projectName) {
            $question = new \Symfony\Component\Console\Question\Question('Please enter the project name: ');
            $projectName = $helper->ask($input, $output, $question);
        }

        $output->writeln('Project name: ' . $projectName);

        // Run the composer
    }
}