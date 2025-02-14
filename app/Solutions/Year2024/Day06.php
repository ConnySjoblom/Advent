<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;

class Day06 extends Solution
{
    /**
     * Day 06 Part 1
     */
    public function partOne(): string|int|null
    {
        $directions = [
            [-1, 0],
            [0, 1],
            [1, 0],
            [0, -1],
        ];
        $map = str($this->input)
            ->explode("\n")
            ->map(fn ($line) => str_split($line))
            ->toArray();

        $x = 0;
        $y = 0;
        foreach ($map as $i => $row) {
            foreach ($row as $j => $column) {
                if ($column === '^') {
                    $y = $i;
                    $x = $j;
                }
            }
        }

        $safe = true;
        $visited = [];
        while ($safe) {
            $dy = $y + $directions[0][0];
            $dx = $x + $directions[0][1];

            $visited[] = "$y,$x";

            if (
                $dy >= count($map) || $dy < 0
                || $dx >= count($map[0]) || $dx < 0
            ) {
                $safe = false;
                continue;
            }

            if ($map[$dy][$dx] == '#') {
                $directions[] = array_shift($directions);
                continue;
            }

            $y = $dy;
            $x = $dx;
        }

        return count(array_unique($visited));
    }

    /**
     * Day 06 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }
}
