<?php

namespace App\Solutions\Year2020;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day01 extends Solution
{
    /**
     * Day 01 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = InputParser::integers($this->input);

        for ($i = 0; $i < count($input); $i++) {
            for ($j = 0; $j < count($input); $j++) {
                if ($i == $j) {
                    continue;
                }

                if ($input[$i] + $input[$j] == 2020) {
                    return $input[$i] * $input[$j];
                }
            }
        }

        return null;
    }

    /**
     * Day 01 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = InputParser::integers($this->input);

        for ($i = 0; $i < count($input); $i++) {
            for ($j = 0; $j < count($input); $j++) {
                for ($k = 0; $k < count($input); $k++) {
                    if ($i == $j || $j == $k || $k == $i) {
                        continue;
                    }

                    if ($input[$i] + $input[$j] + $input[$k] == 2020) {
                        return $input[$i] * $input[$j] * $input[$k];
                    }
                }
            }
        }

        return null;
    }
}
