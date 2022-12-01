Advent of Code
==============

This repository contains my solutions to the [Advent of Code](https://adventofcode.com/) puzzles.

It contains a command for each day for each year that can be run with `bin/console 2021:day-one` for example.

The command `bin/console app:create-day` creates a new command file which is prepared for the next day.

## Executing the command for a day

The base command will always run **both** parts of the puzzle with the **real** puzzle input.

If only one part should be executed the following options can be used:

Part one: `-1` or `--partOne`  
Part two: `-2` or `--partTwo`

If the command should use the example input the `-t` or `--test` option can be used.

## Creating a new day

To create a new day the `bin/console app:create-day` command can be used. It has the required argument day which
defines the day of the puzzle.

Optionally a date can be provided as second argument. Then that date will be used as the date of the puzzle otherwise the 
current date will be used.