<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-twelve', 'Advent of Code 2022 - Day Twelve')]
class DayTwelveCommand extends AbstractCommand
{
    protected const DAY = 12;

    protected const DATE = '12.12.2022';

    protected function partOne(array $input): int
    {
        [$heightMap, $start, $end] = $this->parseInput($input);

        // Get start row and col
        $statRow = array_keys($start)[0];
        $statCol = array_values($start)[0];

        // Get end row and col
        $endRow = array_keys($end)[0];
        $endCol = array_values($end)[0];

        // Replace special chars of start and end
        $heightMap[$statRow][$statCol] = 'a';
        $heightMap[$endRow][$endCol]   = 'z';

        // Find the shortest paths
        $shortestPaths = $this->findShortestPaths($heightMap, $endRow, $endCol);

        return $shortestPaths[$statRow][$statCol];
    }

    protected function partTwo(array $input): int
    {
        [$heightMap, $start, $end] = $this->parseInput($input);

        $shortestPaths = $this->findShortestPaths($heightMap, array_keys($end)[0], array_values($end)[0]);

        $min = PHP_INT_MAX;

        foreach ($heightMap as $y => $row) {
            foreach ($row as $x => $height) {
                if ($height === 'a') {
                    $min = min($min, $shortestPaths[$y][$x]);
                }
            }
        }

        return $min;
    }

    private function parseInput(array $input): array
    {
        $heightMap = array_map(
            fn(string $line) => str_split($line),
            $input
        );

        // Find S in multidimensional array
        $start = array_filter(array_map(fn(array $row) => array_search('S', $row), $heightMap), fn($value) => $value !== false);

        // Find E in multidimensional array
        $end = array_filter(array_map(fn(array $row) => array_search('E', $row), $heightMap), fn($value) => $value !== false);

        return [
            $heightMap,
            $start,
            $end
        ];
    }

    private function findShortestPaths(array $heightMap, int $endRow, int $endCol): array
    {
        $visited = array_map(
            fn (array $row) => array_map(
                fn (string $col) => false,
                $row
            ),
            $heightMap
        );

        $shortestPaths = array_map(
            fn (array $row) => array_map(
                fn (string $col) => PHP_INT_MAX,
                $row
            ),
            $heightMap
        );

        $shortestPaths[$endRow][$endCol] = 0;

        $queue = [[$endRow, $endCol]];

        while (!empty($queue)) {
            $current = array_shift($queue);
            $currentRow = $current[0];
            $currentCol = $current[1];

            $visited[$currentRow][$currentCol] = true;

            $neighbours = [
                [$currentRow - 1, $currentCol],
                [$currentRow + 1, $currentCol],
                [$currentRow, $currentCol - 1],
                [$currentRow, $currentCol + 1],
            ];

            $currentHeight = array_search($heightMap[$currentRow][$currentCol], range('a', 'z'));

            foreach ($neighbours as $neighbour) {
                $neighbourRow = $neighbour[0];
                $neighbourCol = $neighbour[1];

                if ($neighbourRow < 0 || $neighbourRow >= count($heightMap)) {
                    continue;
                }

                if ($neighbourCol < 0 || $neighbourCol >= count($heightMap[$neighbourRow])) {
                    continue;
                }

                $neighbourHeight = array_search($heightMap[$neighbourRow][$neighbourCol], range('a', 'z'));

                if ($currentHeight >= $neighbourHeight - 1) {
                    $shortestDist = $shortestPaths[$neighbourRow][$neighbourCol] + 1;
                    $currentShortestDist = $shortestPaths[$currentRow][$currentCol];
                    $shortestPaths[$currentRow][$currentCol] = min($currentShortestDist, $shortestDist);
                }

                if ($visited[$neighbourRow][$neighbourCol] === false && $currentHeight <= $neighbourHeight + 1) {
                    $queue[] = [$neighbourRow, $neighbourCol];
                    $visited[$neighbourRow][$neighbourCol] = true;
                }
            }
        }

        return $shortestPaths;
    }
}
