<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;

class Day04 extends Solution
{
    /**
     * Day 04 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = collect(explode("\n", $this->input))
            ->map(fn ($line) => str_split($line))
            ->toArray();

        $directions = [
            [-1, -1], [-1, 0], [-1, 1], [0, -1],
            [0, 1], [1, -1], [1, 0], [1, 1]
        ];

        $xPositions = [];
        for ($i = 0; $i < count($input); $i++) {
            for ($j = 0; $j < count($input[0]); $j++) {
                if ($input[$i][$j] == 'X') {
                    $xPositions[] = [$i, $j];
                }
            }
        }

        $xmasCount = 0;
        foreach ($xPositions as $xPosition) {
            foreach ($directions as $direction) {
                $x = $xPosition[0];
                $y = $xPosition[1];

                $word = 'X';
                for ($i = 0; $i < 3; $i++) {
                    $x += $direction[0];
                    $y += $direction[1];

                    if (
                        $x >= 0 && $x < count($input)
                        && $y >= 0 && $y < count($input[0])
                    ) {
                        $word .= $input[$x][$y];
                    }
                }

                if ($word == 'XMAS') {
                    $xmasCount++;
                }
            }
        }

        return $xmasCount;
    }

    /**
     * Day 04 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = collect(explode("\n", $this->input))
            ->map(fn ($line) => str_split($line))
            ->toArray();

        $aPositions = [];
        for ($i = 0; $i < count($input); $i++) {
            for ($j = 0; $j < count($input[0]); $j++) {
                if ($input[$i][$j] == 'A') {
                    $aPositions[] = [$i, $j];
                }
            }
        }

        $xmasCount = 0;
        foreach ($aPositions as $aPosition) {
            $x = $aPosition[0];
            $y = $aPosition[1];

            if (
                $x - 1 >= 0 && $y - 1 >= 0
                && $x + 1 < count($input) && $y + 1 < count($input[0])
            ) {
                $a = $input[$x - 1][$y - 1]
                    . $input[$x][$y]
                    . $input[$x + 1][$y + 1];

                $b = $input[$x - 1][$y + 1]
                    . $input[$x][$y]
                    . $input[$x + 1][$y - 1];

                if (
                    ($a == 'MAS' || strrev($a) == 'MAS')
                    && ($b == 'MAS' || strrev($b) == 'MAS')
                ) {
                    $xmasCount++;
                }
            }
        }

        return $xmasCount;
    }
}
