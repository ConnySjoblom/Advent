<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day02 extends Solution
{
    /**
     * Day 02 Part 1
     */
    public function partOne(): ?string
    {
        $input = explode("\n", $this->input);

        $wrapper = 0;
        foreach ($input as $present) {
            $size = explode('x', $present);
            sort($size, SORT_NUMERIC);

            $paper = (2 * $size[0] * $size[1]) + (2 * $size[1] * $size[2]) + (2 * $size[2] * $size[0]);

            $wrapper += ($paper + (array_shift($size) * array_shift($size)));
        }

        return $wrapper;
    }

    /**
     * Day 02 Part 2
     */
    public function partTwo(): ?string
    {
        $input = explode("\n", $this->input);

        $ribbon = 0;
        foreach ($input as $present) {
            $size = explode('x', $present);
            sort($size, SORT_NUMERIC);

            $ribbon += ($size[0] * 2) + ($size[1] * 2);
            $ribbon += ($size[0] * $size[1] * $size[2]);
        }

        return $ribbon;
    }
}
