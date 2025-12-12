<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;

class Day12 extends Solution
{
    /**
     * Day 12 Part 1
     */
    public function partOne(): string|int|null
    {
        $this->input = <<<INPUT
0:
###
##.
##.

1:
###
##.
.##

2:
.##
###
##.

3:
##.
###
##.

4:
###
#..
###

5:
###
.#.
###

4x4: 0 0 0 0 2 0
12x5: 1 0 1 0 2 2
12x5: 1 0 1 0 3 2
INPUT;

        $input = explode("\n\n", $this->input);
        $areas_raw = explode("\n", array_pop($input));

        $areas = [];
        foreach ($areas_raw as $raw) {
            $presents = explode(' ', $raw);

            $areas[] = [
                'size' => explode('x', substr(array_shift($presents), 0, -1)),
                'presents' => $presents,
            ];
        }

        $presents = [];
        foreach ($input as $present_raw) {
            $present_raw = explode("\n", $present_raw);
            array_shift($present_raw);
            $presents[] = array_map('str_split', $present_raw);
        }

        foreach ($areas as [$width, $height]) {
            $
        }

        return null;
    }

    /**
     * Day 12 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }
}
