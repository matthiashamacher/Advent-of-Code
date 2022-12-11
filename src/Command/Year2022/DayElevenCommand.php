<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-eleven', 'Advent of Code 2022 - Day Eleven')]
class DayElevenCommand extends AbstractCommand
{
    protected const DAY = 11;

    protected const DATE = '11.12.2022';

    protected function partOne(array $input): int
    {
        $monkeys        = $this->parseInput($input);
        $inspectedItems = array_fill(0, count($monkeys), 0);

        for ($round = 0; $round < 20; $round++) {
            foreach ($monkeys as $monkeyNumber => &$monkey) {
                foreach ($monkey['items'] as $itemKey => $item) {
                    $itemNumber = $item;
                    $operationValue = $monkey['operation']['value'];

                    if ($operationValue === 'old') {
                        $operationValue = $itemNumber;
                    }

                    switch ($monkey['operation']['operator']) {
                        case '*':
                            $itemNumber *= $operationValue;
                            break;
                        case '+':
                            $itemNumber += $operationValue;
                            break;
                    }

                    $itemNumber = (int) floor($itemNumber / 3);
                    $test       = $itemNumber % $monkey['test']['amount'];

                    if ($test === 0) {
                        $monkeys[$monkey['test']['true']]['items'][] = $itemNumber;
                    }

                    if ($test !== 0) {
                        $monkeys[$monkey['test']['false']]['items'][] = $itemNumber;
                    }

                    unset($monkeys[$monkeyNumber]['items'][$itemKey]);
                    $inspectedItems[$monkeyNumber]++;
                }
            }
        }

        rsort($inspectedItems);
        $inspectedItems = array_values($inspectedItems);

        return $inspectedItems[0] * $inspectedItems[1];

    }

    protected function partTwo(array $input): int
    {
        $monkeys        = $this->parseInput($input);
        $inspectedItems = array_fill(0, count($monkeys), 0);
        $mod            = array_product(
            array_map(
                fn($monkey) => $monkey['test']['amount'],
                $monkeys
            )
        );

        for ($round = 0; $round < 10000; $round++) {
            foreach ($monkeys as $monkeyNumber => &$monkey) {
                foreach ($monkey['items'] as $itemKey => $item) {
                    $itemNumber = $item;
                    $operationValue = $monkey['operation']['value'];

                    if ($operationValue === 'old') {
                        $operationValue = $itemNumber;
                    }

                    switch ($monkey['operation']['operator']) {
                        case '*':
                            $itemNumber = (int) ($itemNumber * (int) $operationValue);
                            break;
                        case '+':
                            $itemNumber = (int) ($itemNumber + (int) $operationValue);
                            break;
                    }

                    $itemNumber %= $mod;
                    $test = $itemNumber % $monkey['test']['amount'];

                    if ($test === 0) {
                        $monkeys[$monkey['test']['true']]['items'][] = $itemNumber;
                    }

                    if ($test !== 0) {
                        $monkeys[$monkey['test']['false']]['items'][] = $itemNumber;
                    }

                    unset($monkeys[$monkeyNumber]['items'][$itemKey]);
                    $inspectedItems[$monkeyNumber]++;
                }
            }

            if ($round === 20 || $round % 1000 === 0) {
                dump("Round: $round", $inspectedItems);
            }
        }

        rsort($inspectedItems);
        $inspectedItems = array_values($inspectedItems);

        return $inspectedItems[0] * $inspectedItems[1];
    }

    private function parseInput(array $input): array
    {
        $monkeys = [];
        $monkey  = 0;

        foreach ($input as $line) {
            if (empty($line) === true) {
                $monkey++;
                continue;
            }

            if (preg_match("#Monkey [0-9]+:#", $line)){
                continue;
            }

            if (preg_match("#Starting items: ([0-9, ]+)#", $line, $matches)) {
                $items = array_map("intval", explode(', ', $matches[1]));
                $monkeys[$monkey]['items'] = $items;

                continue;
            }

            if (preg_match("#Operation: new = old ([\*\+\-\/]) ([0-9old]+)#", $line, $matches)) {
                $monkeys[$monkey]['operation'] = [
                    'operator' => $matches[1],
                    'value'    => $matches[2],
                ];

                continue;
            }

            if (preg_match("#Test: divisible by ([0-9]+)#", $line, $matches)) {
                $monkeys[$monkey]['test']['amount'] = (int) $matches[1];

                continue;
            }

            if (preg_match("#If (true|false): throw to monkey ([0-9])#", $line, $matches)) {
                $monkeys[$monkey]['test'][$matches[1]] = (int) $matches[2];
            }
        }

        return $monkeys;
    }


}
