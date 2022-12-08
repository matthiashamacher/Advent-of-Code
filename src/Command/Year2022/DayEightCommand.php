<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-eight', 'Advent of Code 2022 - Day Eight')]
class DayEightCommand extends AbstractCommand
{
    protected const DAY = 8;

    protected const DATE = '08.12.2022';

    protected function partOne(array $input): int
    {
        $rows = count($input);
        $cols = strlen($input[0]);

        $visible = ($rows + $cols) * 2 - 4;

        $input = array_map(
            fn($row) => str_split($row),
            $input
        );

        for ($i = 1; $i < $rows - 1; $i++) {
            for ($j = 1; $j < $cols - 1; $j++) {
                $top = false;
                $left = false;
                $right = false;
                $bottom = false;
                $treeSize = (int)$input[$i][$j];

                for ($row = $i - 1; $row >= 0; $row--) {
                    $newTreeSize = (int)$input[$row][$j];

                    if ($newTreeSize >= $treeSize) {
                        $top = true;
                        break;
                    }
                }

                for ($row = $i + 1; $row < $rows; $row++) {
                    $newTreeSize = (int)$input[$row][$j];

                    if ($newTreeSize >= $treeSize) {
                        $bottom = true;
                        break;
                    }
                }

                for ($col = $j - 1; $col >= 0; $col--) {
                    $newTreeSize = (int)$input[$i][$col];

                    if ($newTreeSize >= $treeSize) {
                        $left = true;
                        break;
                    }
                }

                for ($col = $j + 1; $col < $cols; $col++) {
                    $newTreeSize = (int)$input[$i][$col];

                    if ($newTreeSize >= $treeSize) {
                        $right = true;
                        break;
                    }
                }

                if ($top && $left && $right && $bottom) {
                    continue;
                }

                $visible++;
            }
        }

        return $visible;
    }

    protected function partTwo(array $input): int
    {
        $highestScenicScore = 0;

        $rows = count($input);
        $cols = strlen($input[0]);

        $input = array_map(
            fn ($row) => str_split($row),
            $input
        );

        for ($r = 0; $r < $rows; $r++) {
            for ($c = 0; $c < $cols; $c++) {
                $scenicScore = 0;
                $top         = 0;
                $bottom      = 0;
                $left        = 0;
                $right       = 0;
                $treeSize    = (int)$input[$r][$c];

                if ($r > 0) {
                    for ($row = $r - 1; $row >= 0; $row--) {
                        $newTreeSize = (int)$input[$row][$c];

                        $top += 1;

                        if ($newTreeSize >= $treeSize) {
                            break;
                        }
                    }
                }

                $scenicScore = $top;

                for ($row = $r + 1; $row < $rows; $row++) {
                    $newTreeSize = (int)$input[$row][$c];

                    $bottom += 1;

                    if ($newTreeSize >= $treeSize) {
                        break;
                    }
                }

                $scenicScore *= $bottom;

                if ($c > 0) {
                    for ($col = $c - 1; $col >= 0; $col--) {
                        $newTreeSize = (int)$input[$r][$col];

                        $left += 1;

                        if ($newTreeSize >= $treeSize) {
                            break;
                        }
                    }
                }

                $scenicScore *= $left;

                for ($col = $c + 1; $col < $cols; $col++) {
                    $newTreeSize = (int)$input[$r][$col];

                    $right += 1;

                    if ($newTreeSize >= $treeSize) {
                        break;
                    }
                }

                $scenicScore *= $right;

                if ($highestScenicScore < $scenicScore) {
                    $highestScenicScore = $scenicScore;
                }
            }
        }

        return $highestScenicScore;
    }
}
