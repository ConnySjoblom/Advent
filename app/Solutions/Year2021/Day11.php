<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;

class Day11 extends Solution
{
    /**
     * Day 11 Part 1
     */
    public function partOne(int $steps = 100): string|int|null
    {
        $octopuses = array_map(fn ($row) => str_split($row), explode("\n", $this->input));

        $maxY = count($octopuses);
        $maxX = count($octopuses[0]);
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
                [$y, $x] = explode(',', $octopus);
                $octopuses[$y][$x] = 0;
            }

            if ($step == 0) {
                // Debug write
                for ($y = 0; $y < $maxY; $y++) {
                    for ($x = 0; $x < $maxX; $x++) {
                        echo $octopuses[$y][$x];
                    }
                    echo "\n";
                }
                die();
            }
        }

        return $totalFlashes;
    }

    /**
     * Day 11 Part 2
     */
    public function partTwo(): string|int|null
    {
        $octopuses = array_map(fn ($row) => str_split($row), explode("\n", $this->input));

        $maxY = count($octopuses);
        $maxX = count($octopuses[0]);
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
                [$y, $x] = explode(',', $octopus);
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
        $directions = [
            [0, -1],   // Up
            [1, -1],   // Up-Right
            [1, 0],    // Right
            [1, 1],    // Down-Right
            [0, 1],    // Down
            [-1, 1],   // Down-Left
            [-1, 0],   // Left
            [-1, -1],  // Up-Left
        ];

        $totalFlashes++;

        foreach ($directions as $direction) {
            $dx = $x + $direction[0];
            $dy = $y + $direction[1];
            if (isset($octopuses[$dy][$dx])) {
                $octopuses[$dy][$dx]++;
            }
        }
    }
}
