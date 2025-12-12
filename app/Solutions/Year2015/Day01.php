<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day01 extends Solution
{
    /**
     * Day 01 Part 1
     */
    public function partOne(): string|int|null
    {
        $up = substr_count($this->input, '(');
        $down = substr_count($this->input, ')');

        return $up - $down;
    }

    /**
     * Day 01 Part 2
     */
    public function partTwo(): string|int|null
    {
        $floor = 0;
        $length = strlen($this->input);

        for ($i = 0; $i < $length; $i++) {
            $floor += $this->input[$i] === '(' ? 1 : -1;

            if ($floor < 0) {
                return $i + 1;
            }
        }

        return null;
    }
}
