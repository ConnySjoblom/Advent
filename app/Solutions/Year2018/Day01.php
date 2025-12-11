<?php

namespace App\Solutions\Year2018;

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

        $answer = 0;
        foreach ($input as $value) {
            $answer += $value;
        }

        return $answer;
    }

    /**
     * Day 01 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = InputParser::integers($this->input);

        $answer = 0;
        $frequencies = [$answer];

        while (true) {
            foreach ($input as $value) {
                $answer += $value;

                if (in_array($answer, $frequencies)) {
                    return $answer;
                }

                $frequencies[] = $answer;
            }
        }
    }
}
