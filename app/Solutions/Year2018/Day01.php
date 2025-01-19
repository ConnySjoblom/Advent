<?php

namespace App\Solutions\Year2018;

use App\Solutions\Solution;

class Day01 extends Solution
{
    /**
     * Day 01 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = explode("\n", $this->input);

        $answer = 0;
        foreach ($input as $value) {
            $answer += intval($value);
        }

        return $answer;
    }

    /**
     * Day 01 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = explode("\n", $this->input);

        $answer = 0;
        $frequencies = [$answer];

        while (true) {
            foreach ($input as $value) {
                $answer += intval($value);

                if (in_array($answer, $frequencies)) {
                    return $answer;
                }

                $frequencies[] = $answer;
            }
        }
    }
}
