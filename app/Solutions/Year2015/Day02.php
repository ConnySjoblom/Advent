<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day02 extends Solution
{
    /**
     * Day 02 Part 1
     */
    public function partOne(): string|int|null
    {
        $lines = InputParser::lines($this->input);

        $wrapper = 0;
        foreach ($lines as $present) {
            $dimensions = InputParser::extractIntegers($present);
            sort($dimensions);

            $paper = 2 * $dimensions[0] * $dimensions[1]
                + 2 * $dimensions[1] * $dimensions[2]
                + 2 * $dimensions[2] * $dimensions[0];

            $wrapper += $paper + $dimensions[0] * $dimensions[1];
        }

        return $wrapper;
    }

    /**
     * Day 02 Part 2
     */
    public function partTwo(): string|int|null
    {
        $lines = InputParser::lines($this->input);

        $ribbon = 0;
        foreach ($lines as $present) {
            $dimensions = InputParser::extractIntegers($present);
            sort($dimensions);

            $ribbon += 2 * $dimensions[0] + 2 * $dimensions[1];
            $ribbon += $dimensions[0] * $dimensions[1] * $dimensions[2];
        }

        return $ribbon;
    }
}
