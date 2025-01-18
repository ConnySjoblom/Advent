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
        $movement = str_split($this->input);

        $floor = 0;
        foreach ($movement as $i => $change) {
            switch ($change) {
                case '(':
                    $floor++;
                    break;
                case ')':
                    $floor--;
                    break;
            }

            if ($floor < 0) {
                return $i + 1;
            }
        }

        return null;
    }
}
