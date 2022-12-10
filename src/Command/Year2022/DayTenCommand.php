<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-ten', 'Advent of Code 2022 - Day Ten')]
class DayTenCommand extends AbstractCommand
{
    protected const DAY = 10;

    protected const DATE = '10.12.2022';

    protected function partOne(array $input): int
    {
        $cycle             = 0;
        $x                 = 1;
        $signalStrengthSum = 0;

        foreach ($input as $instruction) {
            if ($instruction === "noop") {
                $cycle++;

                if ($cycle === 20 || ($cycle - 20) % 40 === 0) {
                    $signalStrengthSum += ($cycle * $x);
                }

                continue;
            }

            $data  = explode(" ", $instruction);
            $value = $data[1];
            $cycle++;

            if ($cycle === 20 || ($cycle - 20) % 40 === 0) {
                $signalStrengthSum += ($cycle * $x);
            }

            $cycle++;

            if ($cycle === 20 || ($cycle - 20) % 40 === 0) {
                $signalStrengthSum += ($cycle * $x);
            }

            $x += (int) $value;
        }

        return $signalStrengthSum;
    }

    protected function partTwo(array $input): array
    {
        $x     = 1;
        $crt   = [];
        $row   = 0;
        $col   = 0;

        foreach ($input as $instruction) {
            if ($instruction === "noop") {
                $crt[$row][$col] = '.';

                if ($x === $col || $x + 1 === $col || $x - 1 === $col) {
                    $crt[$row][$col] = '#';
                }

                $col++;

                if ($col === 40) {
                    $row++;
                    $col = 0;
                }

                continue;
            }


            $data  = explode(" ", $instruction);
            $value = $data[1];

            $crt[$row][$col] = '.';

            if ($x === $col || $x + 1 === $col || $x - 1 === $col) {
                $crt[$row][$col] = '#';
            }

            $col++;

            if ($col === 40) {
                $row++;
                $col = 0;
            }

            $crt[$row][$col] = '.';

            if ($x === $col || $x + 1 === $col || $x - 1 === $col) {
                $crt[$row][$col] = '#';
            }

            $col++;

            if ($col === 40) {
                $row++;
                $col = 0;
            }

            $x += (int) $value;
        }

        return $crt;
    }
}
