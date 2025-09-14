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
            [$direction, $value] = sscanf($command, '%s %d');

            match ($direction) {
                'forward' => $horizontal += $value,
                'down' => $depth += $value,
                'up' => $depth -= $value,
            };
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
            [$direction, $value] = sscanf($command, '%s %d');

            match ($direction) {
                'forward' => [
                    $horizontal += $value,
                    $depth += $value * $aim
                ],
                'down' => $aim += $value,
                'up' => $aim -= $value,
            };
        }

        return $horizontal * $depth;
    }
}
