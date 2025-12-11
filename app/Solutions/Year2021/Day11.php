<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\GridHelper;
use App\Solutions\Support\Helpers\InputParser;

class Day11 extends Solution
{
    /**
     * Day 11 Part 1
     */
    public function partOne(int $steps = 100): string|int|null
    {
        $octopuses = InputParser::integerGrid($this->input);

        [$maxY, $maxX] = GridHelper::dimensions($octopuses);
        $totalFlashes = 0;
        for ($step = 1; $step <= $steps; $step++) {
            $flash = true;
            $flashed = [];

            for ($y = 0; $y < $maxY; $y++) {
                for ($x = 0; $x < $maxX; $x++) {
                    $octopuses[$y][$x]++;
                }
            }

            while ($flash) {
                $flash = false;
                for ($y = 0; $y < $maxY; $y++) {
                    for ($x = 0; $x < $maxX; $x++) {
                        if ($octopuses[$y][$x] > 9 && !array_key_exists("$y,$x", $flashed)) {
                            $flash = true;
                            $flashed["$y,$x"] = true;
                            $this->flash($y, $x, $octopuses, $totalFlashes);
                        }
                    }
                }
            }

            foreach (array_keys($flashed) as $octopus) {
                [$y, $x] = InputParser::csvIntegers($octopus);
                $octopuses[$y][$x] = 0;
            }
        }

        return $totalFlashes;
    }

    /**
     * Day 11 Part 2
     */
    public function partTwo(): string|int|null
    {
        $octopuses = InputParser::integerGrid($this->input);

        [$maxY, $maxX] = GridHelper::dimensions($octopuses);
        $step = 0;

        while (true) {
            $step++;
            $flash = true;
            $flashed = [];

            for ($y = 0; $y < $maxY; $y++) {
                for ($x = 0; $x < $maxX; $x++) {
                    $octopuses[$y][$x]++;
                }
            }

            while ($flash) {
                $flash = false;
                for ($y = 0; $y < $maxY; $y++) {
                    for ($x = 0; $x < $maxX; $x++) {
                        if ($octopuses[$y][$x] > 9 && !array_key_exists("$y,$x", $flashed)) {
                            $flash = true;
                            $flashed["$y,$x"] = true;
                            $this->flash($y, $x, $octopuses);
                        }
                    }
                }
            }

            foreach (array_keys($flashed) as $octopus) {
                [$y, $x] = InputParser::csvIntegers($octopus);
                $octopuses[$y][$x] = 0;
            }

            // Check if all octopuses flashed (all synchronized)
            if (count($flashed) === $maxY * $maxX) {
                return $step;
            }
        }
    }

    private function flash(int $y, int $x, array &$octopuses, int &$totalFlashes = 0): void
    {
        $totalFlashes++;

        foreach (GridHelper::allNeighbors($y, $x) as [$dy, $dx]) {
            if (GridHelper::inBounds($octopuses, $dy, $dx)) {
                $octopuses[$dy][$dx]++;
            }
        }
    }
}
