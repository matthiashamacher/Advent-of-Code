<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-six', 'Advent of Code 2022 - Day Six')]
class DaySixCommand extends AbstractCommand
{
    protected const DAY = 6;

    protected const DATE = '06.12.2022';

    protected function partOne(array $input): int
    {
        $chars = 0;

        $input = reset($input);

        $letters = str_split($input);

        foreach ($letters as $key => $letter) {
            $chunk = [
                $letter,
                $letters[$key + 1],
                $letters[$key + 2],
                $letters[$key + 3],
            ];

            $unique = array_unique($chunk);

            if (count($unique) === 4) {
                $chars += 4;

                break;
            }

            $chars++;
        }

        return $chars;
    }

    protected function partTwo(array $input): int
    {
        $chars = 0;

        $input = reset($input);

        $letters = str_split($input);

        foreach ($letters as $key => $letter) {
            $chunk = [
                $letter,
                $letters[$key + 1],
                $letters[$key + 2],
                $letters[$key + 3],
                $letters[$key + 4],
                $letters[$key + 5],
                $letters[$key + 6],
                $letters[$key + 7],
                $letters[$key + 8],
                $letters[$key + 9],
                $letters[$key + 10],
                $letters[$key + 11],
                $letters[$key + 12],
                $letters[$key + 13],
            ];

            $unique = array_unique($chunk);

            if (count($unique) === 14) {
                $chars += 14;

                break;
            }

            $chars++;
        }

        return $chars;
    }
}
