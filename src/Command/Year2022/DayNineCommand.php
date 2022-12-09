<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-nine', 'Advent of Code 2022 - Day Nine')]
class DayNineCommand extends AbstractCommand
{
    protected const DAY = 9;

    protected const DATE = '09.12.2022';

    protected function partOne(array $input): int
    {
        $previousTail[0][0] = 1;
        $headPosition = [0,0];
        $tailPosition = [0,0];

        foreach ($input as $motion) {
            $direction = substr($motion, 0, 1);
            $distance = substr($motion, 1);

            for ($i = 0; $i < $distance; $i++) {
                if ($direction === "D") {
                    $headPosition = [$headPosition[0], $headPosition[1] - 1];

                    if ($headPosition[1] <= $tailPosition[1] - 2) {
                        $tailPosition = [$tailPosition[0], $tailPosition[1] - 1];

                        if ($headPosition[0] !== $tailPosition[0]) {
                            $tailPosition = [$headPosition[0], $tailPosition[1]];
                        }
                    }
                }

                if ($direction === "U") {
                    $headPosition = [$headPosition[0], $headPosition[1] + 1];

                    if ($headPosition[1] >= $tailPosition[1] + 2) {
                        $tailPosition = [$tailPosition[0], $tailPosition[1] + 1];

                        if ($headPosition[0] !== $tailPosition[0]) {
                            $tailPosition = [$headPosition[0], $tailPosition[1]];
                        }
                    }
                }

                if ($direction === "L") {
                    $headPosition = [$headPosition[0] - 1, $headPosition[1]];

                    if ($headPosition[0] <= $tailPosition[0] - 2) {
                        $tailPosition = [$tailPosition[0] - 1, $tailPosition[1]];

                        if ($headPosition[1] !== $tailPosition[1]) {
                            $tailPosition = [$tailPosition[0], $headPosition[1]];
                        }
                    }
                }

                if ($direction === "R") {
                    $headPosition = [$headPosition[0] + 1, $headPosition[1]];

                    if ($headPosition[0] >= $tailPosition[0] + 2) {
                        $tailPosition = [$tailPosition[0] + 1, $tailPosition[1]];

                        if ($headPosition[1] !== $tailPosition[1]) {
                            $tailPosition = [$tailPosition[0], $headPosition[1]];
                        }
                    }
                }

                $previousTail[$tailPosition[0]][$tailPosition[1]] = 1;
            }

        }

        return array_sum(array_map("count", $previousTail));
    }

    protected function partTwo(array $input): int
    {
        $previousTail[0][0] = 1;
        $bodyParts          = array_fill(0, 10, ["x" => 0, "y" => 0]);

        foreach ($input as $motion) {
            $direction = substr($motion, 0, 1);
            $distance = substr($motion, 1);

            for ($i = 0; $i < $distance; $i++) {
                $bodyParts[0]["y"] += $direction === "U" ? 1 : ($direction === "D" ? -1 : 0);
                $bodyParts[0]["x"] += $direction === "R" ? 1 : ($direction === "L" ? -1 : 0);

                for ($j = 1; $j < count($bodyParts); $j++) {
                    if (abs($bodyParts[$j - 1]["y"] - $bodyParts[$j]["y"]) > 1 && abs($bodyParts[$j - 1]["x"] - $bodyParts[$j]["x"]) > 1) {
                        $bodyParts[$j]["x"] += ($bodyParts[$j - 1]["x"] <=> $bodyParts[$j]["x"]);
                        $bodyParts[$j]["y"] += ($bodyParts[$j - 1]["y"] <=> $bodyParts[$j]["y"]);

                        continue;
                    }

                    if (abs($bodyParts[$j - 1]["y"] - $bodyParts[$j]["y"]) > 1) {
                        $bodyParts[$j]["x"] = $bodyParts[$j - 1]["x"];
                        $bodyParts[$j]["y"] += ($bodyParts[$j - 1]["y"] <=> $bodyParts[$j]["y"]);
                    }

                    if (abs($bodyParts[$j - 1]["x"] - $bodyParts[$j]["x"]) > 1) {
                        $bodyParts[$j]["y"] = $bodyParts[$j - 1]["y"];
                        $bodyParts[$j]["x"] += ($bodyParts[$j - 1]["x"] <=> $bodyParts[$j]["x"]);
                    }
                }

                $previousTail[end($bodyParts)["x"]][end($bodyParts)["y"]] = 1;
            }
        }

        return array_sum(array_map("count", $previousTail));
    }
}
