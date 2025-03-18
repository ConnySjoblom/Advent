<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;
use App\Solutions\Support\IntcodeComputer;

class Day13 extends Solution
{
    /**
     * Day 13 Part 1
     */
    public function partOne(): string|int|null
    {
        $screen = [];
        $computer = new IntcodeComputer($this->input);

        do {
            $screen[sprintf(
                '%s,%s',
                $computer->run(),
                $computer->run()
            )] = $output = intval($computer->run());
        } while (
            $output != -2
        );

        return array_count_values($screen)[2];
    }

    /**
     * Day 13 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }
}
