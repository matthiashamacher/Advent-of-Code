<?php

namespace App\Command\Year2021;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2021:day-one', 'Advent of Code 2021 - Day One')]
class DayOneCommand extends AbstractCommand
{
    protected const DAY = 1;

    protected const DATE = '01.12.2021';

    protected function partOne(array $input): int
    {
        // go through the input and increase the counter if the previous number is lower except for the first number

        $counter = 0;
        $previous = null;
        foreach ($input as $number) {
            if ($previous === null) {
                $previous = $number;
                continue;
            }

            if ($number > $previous) {
                $counter++;
            }

            $previous = $number;
        }

        return $counter;
    }

    protected function partTwo(array $input): int
    {
        $counter = 0;
        $previous = null;

        foreach ($input as $index => $number) {
            // break if the index after the next one does not exist
            if (isset($input[$index + 2]) === false) {
                break;
            }

            // create a sum of the next three entries
            $sum = $number + $input[$index + 1] + $input[$index + 2];

            // if previous is null set the sum and continue
            if ($previous === null) {
                $previous = $sum;
                continue;
            }

            // if the sum is higher than the previous sum increase the counter
            if ($sum > $previous) {
                $counter++;
            }

            // set the previous sum to the current sum
            $previous = $sum;
        }

        return $counter;
    }
}
