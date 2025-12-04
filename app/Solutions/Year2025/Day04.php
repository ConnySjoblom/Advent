<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;

class Day04 extends Solution
{
    /**
     * Day 04 Part 1
     */
    public function partOne(): string|int|null
    {

        $grid = array_map('str_split', explode("\n", $this->input));
        $accessible = 0;

        foreach ($grid as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell == '@') {
                    $adjacentRolls = $this->countAdjacentRolls($grid, $y, $x);
                    if ($adjacentRolls < 4) {
                        $accessible++;
                    }
                }
            }
        }

        return $accessible;
    }

    /**
     * Day 04 Part 2
     */
    public function partTwo(): string|int|null
    {
        $grid = array_map('str_split', explode("\n", $this->input));

        $removed = 0;
        $wasRemoved = true;
        while ($wasRemoved) {
            $newGrid = $grid;
            $wasRemoved = false;
            foreach ($grid as $y => $row) {
                foreach ($row as $x => $cell) {
                    if ($cell == '@') {
                        $adjacentRolls = $this->countAdjacentRolls($grid, $y, $x);
                        if ($adjacentRolls < 4) {
                            $removed++;
                            $wasRemoved = true;
                            $newGrid[$y][$x] = '.';
                        }
                    }
                }
            }

            $grid = $newGrid;
        }


        return $removed;
    }

    private function countAdjacentRolls(array $grid, int $y, int $x): int
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

        $rolls = 0;
        foreach ($directions as [$dx, $dy]) {
            $newX = $x + $dx;
            $newY = $y + $dy;

            if (isset($grid[$newY][$newX])) {
                if ($grid[$newY][$newX] == '@') {
                    $rolls++;
                }
            }
        }

        return $rolls;
    }
}
