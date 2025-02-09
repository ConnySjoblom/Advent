<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;
use App\Solutions\Support\IntcodeComputer;
use Exception;

class Day05 extends Solution
{
    /**
     * Day 05 Part 1
     * @throws Exception
     */
    public function partOne(int $input = 1): string|int|null
    {
        $computer = new IntcodeComputer(trim($this->input));
        $computer->setInput($input);

        $output = 0;
        while ($output == 0) {
            $output = $computer->run();
        }

        return $output;
    }

    /**
     * Day 05 Part 2
     * @throws Exception
     */
    public function partTwo(int $input = 5): string|int|null
    {
        $computer = new IntcodeComputer(trim($this->input));
        $computer->setInput($input);

        $output = 0;
        while ($output == 0) {
            $output = $computer->run();
        }

        return $output;
    }
}
