<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;
use App\Solutions\Support\IntcodeComputer;

class Day09 extends Solution
{
    /**
     * Day 09 Part 1
     */
    public function partOne(int $input = 1): string|int|null
    {
        $computer = new IntcodeComputer($this->input);
        $computer->setInput($input);

        return $computer->run();
    }

    /**
     * Day 09 Part 2
     */
    public function partTwo(int $input = 2): string|int|null
    {
        $computer = new IntcodeComputer($this->input);
        $computer->setInput($input);

        return $computer->run();
    }
}
