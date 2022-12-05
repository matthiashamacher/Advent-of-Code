<?php

namespace App\Command\Year2022;

use App\Command\AbstractCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('2022:day-five', 'Advent of Code 2022 - Day Five')]
class DayFiveCommand extends AbstractCommand
{
    protected const DAY = 5;

    protected const DATE = '05.12.2022';

    protected function partOne(array $input): string
    {
        [$stacks, $moves] = $this->getStackConfigurationAndMoves($input);

        foreach ($moves as $move) {
            for ($i = 0; $i < $move['amount']; $i++) {
                $stacks[$move['to']][] = end($stacks[$move['from']]);
                array_pop($stacks[$move['from']]);
            }
        }

        $upperMostCrates = $this->getUpperMostCrates($stacks);

        return implode($upperMostCrates);
    }

    protected function partTwo(array $input): string
    {
        [$stacks, $moves] = $this->getStackConfigurationAndMoves($input);

        foreach ($moves as $move) {
            $crates = array_splice($stacks[$move['from']], -$move['amount']);
            $stacks[$move['to']] = array_merge($stacks[$move['to']], $crates);
        }

        $upperMostCrates = $this->getUpperMostCrates($stacks);

        return implode($upperMostCrates);
    }

    private function getStackConfigurationAndMoves(array $input): array
    {
        $stackConfiguration = [];
        $moveInput = [];

        $separator = array_search('', $input);

        $stacks = explode(' ', $input[$separator - 1]);
        $stacks = array_filter(array_map(fn($stack) => (int) $stack, $stacks), fn($stack) => $stack > 0);

        foreach ($input as $key => $row) {
            if ($key === $separator - 1) {
                unset($input[$key], $input[$key + 1]);

                $moveInput = $input;
                break;
            }

            $crateInput = explode(' ', $row);

            foreach ($stacks as $stack) {
                if (empty($crateInput) === true) {
                    $stackConfiguration[$stack][] = '';

                    continue;
                }

                foreach ($crateInput as $crateKey => $value) {
                    if (empty($value) === true && empty($crateInput[$crateKey + 1]) === true && empty($crateInput[$crateKey + 2]) === true) {
                        $stackConfiguration[$stack][] = '';

                        unset($crateInput[$crateKey], $crateInput[$crateKey + 1], $crateInput[$crateKey + 2]);

                        if (array_key_exists($crateKey + 3, $crateInput) === true && empty($crateInput[$crateKey + 3]) === true) {
                            unset($crateInput[$crateKey + 3]);
                        }

                        break;
                    }

                    $value = ltrim($value, '[');
                    $value = rtrim($value, ']');

                    $stackConfiguration[$stack][] = $value;

                    unset($crateInput[$crateKey]);

                    if (array_key_exists($crateKey + 1, $crateInput) === true && empty($crateInput[$crateKey + 1]) === true) {
                        unset($crateInput[$crateKey + 1]);
                    }

                    break;
                }
            }

            unset($input[$key]);
        }

        $stackConfiguration = array_map(
            fn($stack) => array_reverse(array_filter($stack, fn($crate) => $crate !== '')),
            $stackConfiguration
        );

        $moves = array_values(
            array_map(
                function ($move) {
                    $moveParts = explode(' ', $move);

                    return [
                        'amount' => (int) $moveParts[1],
                        'from' => (int) $moveParts[3],
                        'to' => (int) $moveParts[5]
                    ];
                },
                $moveInput
            )
        );

        return [
            $stackConfiguration,
            $moves,
        ];
    }

    private function getUpperMostCrates(array $stacks): array
    {
        $upperMostCrates = [];

        foreach ($stacks as $crates) {
            $upperMostCrates[] = end($crates);
        }

        return $upperMostCrates;
    }
}
