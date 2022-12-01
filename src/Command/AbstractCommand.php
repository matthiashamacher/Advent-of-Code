<?php

namespace App\Command;

use DateTimeImmutable;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Stopwatch\Stopwatch;

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
        )->addOption(
            'retry',
            'r',
            InputOption::VALUE_NONE,
            'Retry the last run'
        )->addOption(
            'commit',
            'c',
            InputOption::VALUE_NONE,
            'Commit the time to complete the part'
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
                'Please save the example input (test.txt) and puzzle input (input.txt) in the folder: ../../input/%d/%d',
                $date->format('Y'),
                static::DAY
            )
        );

        $partOne = $input->getOption('partOne');
        $partTwo = $input->getOption('partTwo');
        $retry   = $input->getOption('retry');
        $commit  = $input->getOption('commit');
        $full    = $partOne === false && $partTwo === false;

        $inputData = $this->getInputData($input->getOption('test'), $date->format('Y'));

        $statsFile = sprintf(
            '%s/../../stats/%s/day%s.json',
            __DIR__,
            $date->format('Y'),
            static::DAY
        );

        $fileSystem = new Filesystem();
        $file       = file_get_contents($statsFile);
        $stats      = [
            'start'      => time(),
            'partOne'    => [
                'executionTime' => 0,
                'memoryUsage'   => 0,
                'end'           => 0,
                'retries'       => 0,
            ],
            'partTwo'    => [
                'executionTime' => 0,
                'memoryUsage'   => 0,
                'end'           => 0,
                'retries'       => 0,
            ],
            'timeNeeded' => [
                'partOne' => 0,
                'partTwo' => 0,
            ],
        ];

        if ($file !== false) {
            $stats = json_decode($file, true);
        }

        if ($partOne === true || $full === true) {
            $io->section('Part One');

            $stopwatch = new Stopwatch();
            $stopwatch->start('partOne');

            $resultPartOne = $this->partOne($inputData);

            $event = $stopwatch->stop('partOne');
            $stats['partOne']['executionTime'] = $event->getDuration();
            $stats['partOne']['memoryUsage'] = $event->getMemory();

            if ($retry === true) {
                $stats['partOne']['retries']++;
            }

            if ($commit === true) {
                $stats['partOne']['end'] = time();
            }

            $io->success(
                sprintf(
                    'The result of part one is: %s',
                    $resultPartOne
                )
            );
        }

        $io->newLine();

        if ($partTwo === true || $full === true) {
            $io->section('Part Two');

            $stopwatch = new Stopwatch();
            $stopwatch->start('partTwo');

            $resultPartTwo = $this->partTwo($inputData);

            $event = $stopwatch->stop('partTwo');
            $stats['partTwo']['executionTime'] = $event->getDuration();
            $stats['partTwo']['memoryUsage'] = $event->getMemory();

            if ($retry === true) {
                $stats['partTwo']['retries']++;
            }

            if ($commit === true) {
                $stats['partTwo']['end'] = time();
            }

            $io->success(
                sprintf(
                    'The result of part two is: %s',
                    $resultPartTwo
                )
            );
        }

        $fileSystem->dumpFile($statsFile, json_encode($stats, JSON_PRETTY_PRINT));

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