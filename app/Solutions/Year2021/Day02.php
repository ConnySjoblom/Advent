<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;

class Day02 extends Solution
{
    /**
     * Day 02 Part 1
     */
    public function partOne(): string|int|null
    {
        $horizontal = 0;
        $depth = 0;

        foreach (explode("\n", $this->input) as $command) {
            [$direction, $value] = explode(' ', $command);

            switch ($direction) {
                case 'forward':
                    $horizontal += (int)$value;
                    break;
                case 'down':
                    $depth += (int)$value;
                    break;
                case 'up':
                    $depth -= (int)$value;
                    break;
            }
        }

        return $horizontal * $depth;
    }

    /**
     * Day 02 Part 2
     */
    public function partTwo(): string|int|null
    {
        $horizontal = 0;
        $depth = 0;
        $aim = 0;

        foreach (explode("\n", $this->input) as $command) {
            [$direction, $value] = explode(' ', $command);

            switch ($direction) {
                case 'forward':
                    $horizontal += (int)$value;
                    $depth += (int)$value * $aim;
                    break;
                case 'down':
                    $aim += (int)$value;
                    break;
                case 'up':
                    $aim -= (int)$value;
                    break;
            }
        }

        return $horizontal * $depth;
    }
}
