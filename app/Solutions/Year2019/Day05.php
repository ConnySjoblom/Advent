<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;
use App\Solutions\Support\IntcodeComputer;
use Exception;

class Day05 extends Solution
{
    public array $output = [];

    /**
     * Day 05 Part 1
     * @throws Exception
     */
    public function partOne(int $input = 5): string|int|null
    {
        $computer = new IntcodeComputer(trim($this->input));
        $computer->setInput($input);
        $computer->run();

        $this->output = $computer->getOutput();

        return array_pop($this->output);
    }

    /**
     * Day 05 Part 2
     * @throws Exception
     */
    public function partTwo(int $input = 5): string|int|null
    {
        $computer = new IntcodeComputer(trim($this->input));
        $computer->setInput($input);
        $computer->run();

        $this->output = $computer->getOutput();

        return array_pop($this->output);
    }
}
