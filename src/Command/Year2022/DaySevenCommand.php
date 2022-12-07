<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-seven', 'Advent of Code 2022 - Day Seven')]
class DaySevenCommand extends AbstractCommand
{
    protected const DAY = 7;

    protected const DATE = '07.12.2022';

    protected function partOne(array $input): int
    {
        $directoryStructure  = $this->parseInput($input);
        $directoryStorageSum = 0;

        foreach ($directoryStructure as $directory) {
            if ($directory <= 100000) {
                $directoryStorageSum += $directory;
            }
        }

        return $directoryStorageSum;
    }

    protected function partTwo(array $input): int
    {
        $directoryStructure  = $this->parseInput($input);
        $directoryStorageSum = 70000000;
        $space               = 70000000 - $directoryStructure[""];
        $neededStorage       = 30000000 - $space;

        foreach ($directoryStructure as $directory) {
            if ($directory >= $neededStorage && $directory < $directoryStorageSum) {
                $directoryStorageSum = $directory;
            }
        }

        return $directoryStorageSum;
    }

    private function parseInput(array $input): array
    {
        $dirs = [];
        $cd   = [];

        foreach($input as $line) {
            if ($line === "$ cd /") {
                $cd = [""];

                continue;
            }

            if (preg_match("#cd ([a-z]+)#", $line, $matches)) {
                $cd[] = $matches[1];

                continue;
            }

            $key = implode('/', $cd);

            if (array_key_exists($key, $dirs) === false) {
                $dirs[$key] = 0;
            }

            if (preg_match("#([0-9]+) ([a-z\.]+)#", $line, $matches)) {
                $dirs[$key] += $matches[1];
            }

            if ($line === "$ cd ..") {
                $currentDir = $dirs[$key];

                array_pop($cd);

                $parentKey = implode('/', $cd);

                if (array_key_exists($parentKey, $dirs) === false) {
                    $dirs[$parentKey] = 0;
                }

                $dirs[$parentKey] += $currentDir;
            }
        }

        while (count($cd) > 1) {
            $key = implode('/', $cd);

            if (array_key_exists($key, $dirs) === false) {
                $dirs[$key] = 0;
            }

            $currentDir = $dirs[$key];

            array_pop($cd);

            $parentKey = implode('/', $cd);

            if (array_key_exists($parentKey, $dirs) === false) {
                $dirs[$parentKey] = 0;
            }

            $dirs[$parentKey] += $currentDir;
        }

        return $dirs;
    }
}
