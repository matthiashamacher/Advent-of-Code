<?php

namespace App\Command;

use DateTimeImmutable;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class AbstractCommand extends Command
{
    protected const DAY = 0;
    protected const DATE = '2022-12-24';

    public function configure()
    {
        $this->addOption(
            'partOne',
            '1',
            InputOption::VALUE_NONE,
            'Only run part one'
        )->addOption(
            'partTwo',
            '2',
            InputOption::VALUE_NONE,
            'Only run part two'
        )->addOption(
            'test',
            't',
            InputOption::VALUE_NONE,
            'Run the test input'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $date = new DateTimeImmutable(static::DATE);

        $io->title(
            sprintf(
                'Advent of Code %d - Day %d - Date: %s',
                $date->format('Y'),
                static::DAY,
                $date->format('d.m.Y')
            )
        );

        $io->info(
            sprintf(
                'Puzzle Link: https://adventofcode.com/%d/day/%d',
                $date->format('Y'),
                static::DAY
            )
        );

        $io->info(
            sprintf(
                'Please save the exmaple input (test.txt) and puzzle input (input.txt) in the folder: ../../input/%d/%d',
                $date->format('Y'),
                static::DAY
            )
        );

        $partOne = $input->getOption('partOne');
        $partTwo = $input->getOption('partTwo');
        $full    = $partOne === false && $partTwo === false;

        $inputData = $this->getInputData($input->getOption('test'), $date->format('Y'));

        if ($partOne === true || $full === true) {
            $io->section('Part One');
            $io->success(
                sprintf(
                    'The result of part one is: %s',
                    $this->partOne($inputData)
                )
            );
        }

        $io->newLine();

        if ($partTwo === true || $full === true) {
            $io->section('Part Two');
            $io->success(
                sprintf(
                    'The result of part two is: %s',
                    $this->partTwo($inputData)
                )
            );
        }

        return Command::SUCCESS;
    }

    protected function partOne(array $input): int
    {
        throw new RuntimeException('Part One is not yet implemented');
    }

    protected function partTwo(array $input): int
    {
        throw new RuntimeException('Part Two is not yet implemented');
    }

    private function getInputData(bool $test, string $year): array
    {
        $input = file_get_contents(
            sprintf(
                '%s/../../input/%d/%s/%s.txt',
                __DIR__,
                $year,
                static::DAY,
                $test === true ? 'test' : 'input'
            )
        );

        return explode(PHP_EOL, $input);
    }
}