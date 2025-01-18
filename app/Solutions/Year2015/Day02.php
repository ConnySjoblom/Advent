<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day02 extends Solution
{
    /**
     * Day 02 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = explode("\n", $this->input);

        $wrapper = 0;
        foreach ($input as $present) {
            $size = explode('x', $present);
            sort($size, SORT_NUMERIC);

            $paper =
                (2 * intval($size[0]) * intval($size[1]))
                + (2 * intval($size[1]) * intval($size[2]))
                + (2 * intval($size[2]) * intval($size[0]));

            $wrapper += ($paper + intval(array_shift($size)) * intval(array_shift($size)));
        }

        return $wrapper;
    }

    /**
     * Day 02 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = explode("\n", $this->input);

        $ribbon = 0;
        foreach ($input as $present) {
            $size = explode('x', $present);
            sort($size, SORT_NUMERIC);

            $ribbon += (intval($size[0]) * 2) + (intval($size[1]) * 2);
            $ribbon += (intval($size[0]) * intval($size[1]) * intval($size[2]));
        }

        return $ribbon;
    }
}
