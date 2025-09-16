<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;

class Day01 extends Solution
{
    /**
     * Day 01 Part 1
     */
    public function partOne(): string|int|null
    {
        $numbers = array_map('intval', explode("\n", $this->input));
        $count = count($numbers);
        $times = 0;

        for ($i = 1; $i < $count; $i++) {
            if ($numbers[$i] > $numbers[$i - 1]) {
                $times++;
            }
        }

        return $times;
    }

    /**
     * Day 01 Part 2
     */
    public function partTwo(): string|int|null
    {
        $numbers = array_map('intval', explode("\n", $this->input));
        $count = count($numbers);
        $times = 0;

        for ($i = 3; $i < $count; $i++) {
            if ($numbers[$i] > $numbers[$i - 3]) {
                $times++;
            }
        }

        return $times;
    }
}
