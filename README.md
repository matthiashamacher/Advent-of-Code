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
If the stats should be saved the `-c` or `--commit` option can be used.  
If the retries should be increased the `-r` or `--retries` option can be used.

## Creating a new day

To create a new day the `bin/console app:create-day` command can be used. It has the required argument day which
defines the day of the puzzle.

Optionally a date can be provided as second argument. Then that date will be used as the date of the puzzle otherwise the 
current date will be used.


## Statistics

| Year | Day | Execution Time<br/>Part 1 | Memory Usage<br/>Part 1 | Time to solve<br/>Part 1 | Retries<br/>Part 1 | Execution Time<br/>Part 2 | Memory Usage<br/>Part 2 | Time to solve<br/>Part 2 | Retries<br/>Part 2 |
|------|-----|---------------------------|-------------------------|--------------------------|--------------------|---------------------------|-------------------------|--------------------------|--------------------|
| 2022 | 1   | 0 ms                      | 0 MB                    | 0 m                      | 0                  | 0 ms                      | 8 MB                    | 0 m                      | 1                  |
| 2022 | 2   | 0 ms                      | 20 MB                   | 7 m                      | 0                  | 0 ms                      | 8 MB                    | 10 m                     | 0                  |
| 2022 | 3   | 0 ms                      | 8 MB                    | 11 m                     | 0                  | 0 ms                      | 8 MB                    | 3 m                      | 0                  |
| 2022 | 4   | 13 ms                     | 8 MB                    | 8 m                      | 0                  | 8 ms                      | 8 MB                    | 14 m                     | 0                  |
| 2022 | 5   | 0 ms                      | 8 MB                    | 66 m                     | 0                  | 0 ms                      | 8 MB                    | 22 m                     | 0                  |
| 2022 | 6   | 0 ms                      | 8 MB                    | 9 m                      | 0                  | 1 ms                      | 8 MB                    | 1 m                      | 0                  |
| 2022 | 7   | 0 ms                      | 8 MB                    | 0 m                      | 0                  | 0 ms                      | 8 MB                    | 0 m                      | 0                  |
| 2022 | 8   | 4 ms                      | 8 MB                    | 60 m                     | 0                  | 5 ms                      | 8 MB                    | 15 m                     | 0                  |
| 2022 | 9   | 2 ms                      | 8 MB                    | 55 m                     | 1                  | 21 ms                     | 8 MB                    | 105 m                    | 0                  |
| 2022 | 10  | 0 ms                      | 8 MB                    | 20 m                     | 0                  | 0 ms                      | 8 MB                    | 30 m                     | 0                  |
| 2022 | 11  | 0 ms                      | 8 MB                    | 42 m                     | 0                  | 125 ms                    | 8 MB                    | 35 m                     | 0                  |
| 2022 | 12  | 5 ms                      | 8 MB                    | 42 m                     | 0                  | 5 ms                      | 8 MB                    | 10 m                     | 0                  |
