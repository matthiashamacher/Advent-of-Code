<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-one', 'Advent of Code 2022 - Day One')]
class DayOneCommand extends AbstractCommand
{
    protected const DAY = 1;

    protected const DATE = '01.12.2022';

    protected function partOne(array $input): int
    {
        $calories    = 0;
        $maxCalories = 0;

        foreach ($input as $calorie) {
            if (empty($calorie) === true) {
                if ($maxCalories === 0) {
                    $maxCalories = $calories;
                    $calories    = 0;

                    continue;
                }

                if ($calories > $maxCalories) {
                    $maxCalories = $calories;
                }

                $calories = 0;

                continue;
            }

            $calories += (int) $calorie;
        }

        return $maxCalories;
    }

    protected function partTwo(array $input): int
    {
        $calories = 0;
        $totalCalories = [];

        foreach ($input as $calorie) {
            if (empty($calorie) === true) {
                $totalCalories[] = $calories;
                $calories = 0;

                continue;
            }

            $calories += (int) $calorie;
        }

        $totalCalories[] = $calories;

        rsort($totalCalories);

        return $totalCalories[0] + $totalCalories[1] + $totalCalories[2];
    }
}
