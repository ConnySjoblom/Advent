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

        return sprintf('%d', $answer);
    }

    /**
     * Day 01 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = explode("\n", $this->input);

        // $input = explode(", ", "+1, -1");
        // $input = explode(", ", "+3, +3, +4, -2, -4");
        // $input = explode(", ", "-6, +3, +8, +5, -6");
        // $input = explode(", ", "+7, +7, -2, -7, -4");

        $answer = 0;
        $frequencies = [$answer];

        while (true) {
            foreach ($input as $value) {
                $answer += intval($value);

                if (in_array($answer, $frequencies)) {
                    return sprintf('%d', $answer);
                }

                $frequencies[] = $answer;
            }
        }
    }
}
