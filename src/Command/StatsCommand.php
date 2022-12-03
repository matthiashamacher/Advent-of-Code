<?php

namespace App\Command;

use DateTimeImmutable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand('app:stats', 'Calculate time needed and update README.md')]
class StatsCommand extends Command
{
    protected function configure()
    {
        $this->addArgument(
            'day',
            InputArgument::REQUIRED,
            'Day to calculate',
        )->addArgument(
            'year',
            InputArgument::REQUIRED,
            'Year to calculate',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Stats calculation');

        $day  = $input->getArgument('day');
        $year = $input->getArgument('year');

        $io->info('Calculating day ' . $day . ' of ' . $year);

        $file = file_get_contents(
            sprintf(
                '%s/../../stats/%s/day%s.json',
                __DIR__,
                $year,
                $day
            )
        );

        if ($file === false) {
            $io->error('File not found');

            return Command::FAILURE;
        }

        $data = json_decode($file, true);

        $startTime = $data['start'];

        if ($data['partOne']['end'] !== 0) {
            $endPartOne = $data['partOne']['end'];

            $data['timeNeeded']['partOne'] = ($endPartOne - $startTime);
        }

        if ($data['partTwo']['end'] !== 0) {
            $endPartTwo = $data['partTwo']['end'];

            $data['timeNeeded']['partTwo'] = (($endPartTwo - $startTime) - $data['timeNeeded']['partOne']);
        }

        $fileSystem = new Filesystem();
        $fileSystem->dumpFile(
            sprintf(
                '%s/../../stats/%s/day%s.json',
                __DIR__,
                $year,
                $day
            ),
            json_encode($data, JSON_PRETTY_PRINT)
        );

        $statsMarkdown = sprintf(
            '| %d | %d | %s ms | %s MB | %s m | %s | %s ms | %s MB | %s m | %s |
',
            $year,
            $day,
            $data['partOne']['executionTime'],
            (int) (($data['partOne']['memoryUsage'] / 1024) / 1024),
            (int) ($data['timeNeeded']['partOne'] / 60),
            $data['partOne']['retries'],
            $data['partTwo']['executionTime'],
            (int) (($data['partTwo']['memoryUsage'] / 1024) / 1024),
            (int) ($data['timeNeeded']['partTwo'] / 60),
            $data['partTwo']['retries']
        );


        $readMe = sprintf(
            '%s/../../README.md',
            __DIR__
        );

        $fileSystem->appendToFile($readMe, $statsMarkdown);

        $io->success('Stats calculated');

        return Command::SUCCESS;
    }
}