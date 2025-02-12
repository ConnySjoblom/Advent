<?php

namespace App\Solutions\Year2017;

use App\Solutions\Solution;

class Day03 extends Solution
{
    /**
     * Day 03 Part 1
     */
    public function partOne(): string|int|null
    {
        $max = intval($this->input);

        $size = intval(ceil(sqrt($max)));
        $spiral = array_fill(0, $size, array_fill(0, $size, 0));
        $directions = [[0, 1], [1, 0], [0, -1], [-1, 0]];

        $x = $y = intval(floor($size / 2));

        $num = 1;
        $step = 1;

        $positions = [];

        while ($num <= $max) {
            for ($i = 0; $i < 2; $i++) {
                $directions[] = array_shift($directions);

                for ($j = 0; $j < $step; $j++) {
                    if ($num > $max) {
                        break;
                    }

                    $spiral[$x][$y] = $num;
                    $positions[$num] = [$x, $y];

                    $x += $directions[0][0];
                    $y += $directions[0][1];

                    $num++;
                }
            }
            $step++;
        }

        return abs($positions[1][0] - end($positions)[0]) + abs($positions[1][1] - end($positions)[1]);
    }

    /**
     * Day 03 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }
}
