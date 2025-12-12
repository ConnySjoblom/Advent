<?php

namespace App\Solutions\Year2017;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day07 extends Solution
{
    /**
     * Day 07 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = InputParser::lines($this->input);

        $programs = [];
        $allChildren = [];
        foreach ($input as $line) {
            $parts = explode(' -> ', $line);

            $programs[] = str($parts[0])->match('/(.*) /')->toString();
            $children = array_key_exists(1, $parts) ? explode(', ', $parts[1]) : [];

            $allChildren = array_merge($allChildren, $children);
        }

        return array_values(array_diff($programs, $allChildren))[0];
    }

    /**
     * Day 07 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }
}
