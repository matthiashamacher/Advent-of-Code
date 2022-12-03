<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-three', 'Advent of Code 2022 - Day Three')]
class DayThreeCommand extends AbstractCommand
{
    protected const DAY = 3;

    protected const DATE = '03.12.2022';

    protected function partOne(array $input): int
    {
        $prioritySum = 0;
        $alphabet    = array_merge(range('a', 'z'), range('A', 'Z'));

        foreach ($input as $rucksack) {
            $splitNumber       = strlen($rucksack) / 2;
            $firstCompartment  = str_split(substr($rucksack, 0, $splitNumber));
            $secondCompartment = str_split(substr($rucksack, $splitNumber));
            $sameChars         = array_intersect($firstCompartment, $secondCompartment);

            $letter = reset($sameChars);
            $key    = array_search($letter, $alphabet, true);

            $prioritySum += $key + 1;
        }

        return $prioritySum;
    }

    protected function partTwo(array $input): int
    {
        $prioritySum = 0;
        $alphabet    = array_merge(range('a', 'z'), range('A', 'Z'));

        $groups = array_chunk($input, 3);

        foreach ($groups as $group) {
            $firstCompartment  = str_split($group[0]);
            $secondCompartment = str_split($group[1]);
            $thirdCompartment  = str_split($group[2]);

            $sameChars = array_intersect($firstCompartment, $secondCompartment, $thirdCompartment);

            $letter = reset($sameChars);
            $key    = array_search($letter, $alphabet, true);

            $prioritySum += $key + 1;
        }

        return $prioritySum;
    }
}
