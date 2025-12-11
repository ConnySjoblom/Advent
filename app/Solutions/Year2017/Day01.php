<?php

namespace App\Solutions\Year2017;

use App\Solutions\Solution;

class Day01 extends Solution
{
    /**
     * Day 01 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = array_map('intval', str_split(trim($this->input)));

        $sum = 0;
        for ($i = 0; $i < count($input); $i++) {
            $a = $input[$i];
            $b = $input[($i + 1) % count($input)];

            if ($a === $b) {
                $sum += $a;
            }
        }

        return $sum;
    }

    /**
     * Day 01 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = array_map('intval', str_split(trim($this->input)));

        $sum = 0;
        for ($i = 0; $i < count($input); $i++) {
            $a = $input[$i];
            $b = $input[($i + (count($input) / 2)) % count($input)];

            if ($a === $b) {
                $sum += $a;
            }
        }

        return $sum;
    }
}
