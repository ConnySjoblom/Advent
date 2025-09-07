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
        $times = 0;
        $input = array_map('intval', explode("\n", $this->input));

        for ($i = 1; $i < count($input); $i++) {
            if ($input[$i] > $input[$i - 1]) {
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
        $times = 0;
        $input = array_map('intval', explode("\n", $this->input));
        $memory = PHP_INT_MAX;

        for ($i = 2; $i < count($input); $i++) {
            $sum = $input[$i] + $input[$i - 1] + $input[$i - 2];

            if ($memory < $sum) {
                $times++;
            }

            $memory = $sum;
        }

        return $times;
    }
}
