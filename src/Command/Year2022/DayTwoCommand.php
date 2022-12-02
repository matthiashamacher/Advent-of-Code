<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-two', 'Advent of Code 2022 - Day Two')]
class DayTwoCommand extends AbstractCommand
{
    protected const DAY = 2;

    protected const DATE = '02.12.2022';

    private const ROCK = 'A';
    private const PAPER = 'B';
    private const SCISSORS = 'C';

    protected function partOne(array $input): int
    {
        $scores = [
            'X' => 1,
            'Y' => 2,
            'Z' => 3,
        ];

        $resultScores = [
            self::ROCK => [
                'X' => 3,
                'Y' => 6,
                'Z' => 0,
            ],
            self::PAPER => [
                'X' => 0,
                'Y' => 3,
                'Z' => 6,
            ],
            self::SCISSORS => [
                'X' => 6,
                'Y' => 0,
                'Z' => 3,
            ],
        ];

        $totalScore = 0;

        foreach ($input as $round) {
            [$opponent, $myself] = explode(' ', $round);

            $moveScore = $scores[$myself];
            $resultScore = $resultScores[$opponent][$myself];

            $totalScore += $moveScore + $resultScore;
        }

        return $totalScore;
    }

    protected function partTwo(array $input): int
    {
        $scores = [
            self::ROCK     => 1,
            self::PAPER    => 2,
            self::SCISSORS => 3,
        ];

        $resultScores = [
            'X' => 0,
            'Y' => 3,
            'Z' => 6,
        ];

        $moveMapping = [
            self::ROCK     => [
                'X' => self::SCISSORS,
                'Y' => self::ROCK,
                'Z' => self::PAPER,
            ],
            self::PAPER    => [
                'X' => self::ROCK,
                'Y' => self::PAPER,
                'Z' => self::SCISSORS,
            ],
            self::SCISSORS => [
                'X' => self::PAPER,
                'Y' => self::SCISSORS,
                'Z' => self::ROCK,
            ],
        ];

        $resultScore = 0;

        foreach ($input as $round) {
            [$opponent, $result] = explode(' ', $round);

            $move = $moveMapping[$opponent][$result];

            $resultScore += $scores[$move] + $resultScores[$result];
        }

        return $resultScore;
    }
}
