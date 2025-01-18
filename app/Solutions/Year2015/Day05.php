<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day05 extends Solution
{
    /**
     * Day 05 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = explode("\n", $this->input);

        $nice = 0;
        foreach ($input as $string) {
            if (
                str_contains($string, 'ab') ||
                str_contains($string, 'cd') ||
                str_contains($string, 'pq') ||
                str_contains($string, 'xy')
            ) {
                continue;
            }

            if (! preg_match('/(.)\1/', $string)) {
                continue;
            }

            if (! preg_match('/^.*[aeiou].*[aeiou].*[aeiou].*$/', $string)) {
                continue;
            }

            $nice++;
        }

        return $nice;
    }

    /**
     * Day 05 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = explode("\n", $this->input);

        $nice = 0;
        foreach ($input as $string) {
            if (! preg_match('/(..).*\1/', $string)) {
                continue;
            }

            if (! preg_match('/(.).\1/', $string)) {
                continue;
            }

            $nice++;
        }

        return $nice;
    }
}
