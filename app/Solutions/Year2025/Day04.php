<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\GridHelper;
use App\Solutions\Support\Helpers\InputParser;

class Day04 extends Solution
{
    /**
     * Day 04 Part 1
     */
    public function partOne(): string|int|null
    {

        $grid = InputParser::grid($this->input);
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
        $grid = InputParser::grid($this->input);

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
        $rolls = 0;
        foreach (GridHelper::allNeighbors($y, $x) as [$newY, $newX]) {
            if (GridHelper::get($grid, $newY, $newX) === '@') {
                $rolls++;
            }
        }

        return $rolls;
    }
}
