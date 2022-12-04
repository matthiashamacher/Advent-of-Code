<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-four', 'Advent of Code 2022 - Day Four')]
class DayFourCommand extends AbstractCommand
{
    protected const DAY = 4;

    protected const DATE = '04.12.2022';

    protected function partOne(array $input): int
    {
        $fullyContainsPairs = 0;

        foreach ($input as $pair) {
            [$elvOne, $elvTwo] = explode(',', $pair);
            [$elvOneStart, $elvOneEnd] = explode('-', $elvOne);
            [$elvTwoStart, $elvTwoEnd] = explode('-', $elvTwo);

            $sectionsElvOne = range($elvOneStart, $elvOneEnd);
            $sectionsElvTwo = range($elvTwoStart, $elvTwoEnd);

            if (count(array_intersect($sectionsElvOne, $sectionsElvTwo)) === count($sectionsElvTwo)
                || count(array_intersect($sectionsElvOne, $sectionsElvTwo)) === count($sectionsElvOne)
            ) {
                $fullyContainsPairs++;
            }
        }

        return $fullyContainsPairs;
    }

    protected function partTwo(array $input): int
    {
        $overlappingPairs = 0;

        foreach ($input as $key => $pair) {
            [$elvOne, $elvTwo] = explode(',', $pair);
            [$elvOneStart, $elvOneEnd] = explode('-', $elvOne);
            [$elvTwoStart, $elvTwoEnd] = explode('-', $elvTwo);

            $sectionsElvOne = range($elvOneStart, $elvOneEnd);
            $sectionsElvTwo = range($elvTwoStart, $elvTwoEnd);

            if (count(array_intersect($sectionsElvOne, $sectionsElvTwo)) > 0) {
                $overlappingPairs++;
            }
        }

        return $overlappingPairs;
    }
}
